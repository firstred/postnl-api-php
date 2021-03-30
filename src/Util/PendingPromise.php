<?php

/**
 * Copyright (c) 2015 Michael Dowling, https://github.com/mtdowling <mtdowling@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Firstred\PostNL\Util;

use Exception;
use Http\Promise\Promise;
use LogicException;

/**
 * Promises/A+ implementation that avoids recursion when possible.
 *
 * @see https://promisesaplus.com/
 */
class PendingPromise implements Promise
{
    private $state = self::PENDING;
    private $result;
    private $cancelFn;
    private $waitFn;
    private $waitList;
    private $handlers = [];

    /**
     * @param callable $waitFn   fn that when invoked resolves the promise
     * @param callable $cancelFn fn that when invoked cancels the promise
     */
    public function __construct(callable $waitFn = null, callable $cancelFn = null)
    {
        $this->waitFn = $waitFn;
        $this->cancelFn = $cancelFn;
    }

    /**
     * @param callable|null $onFulfilled
     * @param callable|null $onRejected
     *
     * @return PendingPromise|Promise
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        if (self::PENDING === $this->state) {
            $p = new static(null, [$this, 'cancel']);
            $this->handlers[] = [$p, $onFulfilled, $onRejected];
            $p->waitList = $this->waitList;
            $p->waitList[] = $this;

            return $p;
        }

        // Return a fulfilled promise and immediately invoke any callbacks.
        if (self::FULFILLED === $this->state) {
            return $onFulfilled
                ? PromiseTool::promiseFor($this->result)->then($onFulfilled)
                : PromiseTool::promiseFor($this->result);
        }

        // It's either cancelled or rejected, so return a rejected promise
        // and immediately invoke any callbacks.
        $rejection = PromiseTool::rejectionFor($this->result);

        return $onRejected ? $rejection->then(null, $onRejected) : $rejection;
    }

    /**
     * @param callable $onRejected
     *
     * @return PendingPromise|Promise
     */
    public function otherwise(callable $onRejected)
    {
        return $this->then(null, $onRejected);
    }

    /**
     * @param bool $unwrap
     *
     * @return mixed|void
     *
     * @throws Exception
     */
    public function wait($unwrap = true)
    {
        $this->waitIfPending();

        $inner = $this->result instanceof Promise
            ? $this->result->wait($unwrap)
            : $this->result;

        if ($unwrap) {
            if ($this->result instanceof Promise
                || self::FULFILLED === $this->state
            ) {
                return $inner;
            }
            // It's rejected so "unwrap" and throw an exception.
            throw PromiseTool::exceptionFor($inner);
        }

        return;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return void
     */
    public function cancel()
    {
        if (self::PENDING !== $this->state) {
            return;
        }

        $this->waitFn = $this->waitList = null;

        if ($this->cancelFn) {
            $fn = $this->cancelFn;
            $this->cancelFn = null;
            try {
                $fn();
            } catch (Exception $e) {
                $this->reject($e);
            }
        }

        // Reject the promise only if it wasn't rejected in a then callback.
        if (self::PENDING === $this->state) {
            $this->reject(new Exception('Promise has been cancelled'));
        }
    }

    /**
     * @param mixed $value
     */
    public function resolve($value)
    {
        $this->settle(self::FULFILLED, $value);
    }

    /**
     * @param mixed $reason
     */
    public function reject($reason)
    {
        $this->settle(self::REJECTED, $reason);
    }

    /**
     * @param string $state
     * @param mixed  $value
     */
    private function settle($state, $value)
    {
        if (self::PENDING !== $this->state) {
            // Ignore calls with the same resolution.
            if ($state === $this->state && $value === $this->result) {
                return;
            }

            return;
        }

        if ($value === $this) {
            throw new LogicException('Cannot fulfill or reject a promise with itself');
        }

        // Clear out the state of the promise but stash the handlers.
        $this->state = $state;
        $this->result = $value;
        $handlers = $this->handlers;
        $this->handlers = null;
        $this->waitList = $this->waitFn = null;
        $this->cancelFn = null;

        if (!$handlers) {
            return;
        }

        // If the value was not a settled promise or a thenable, then resolve
        // it in the task queue using the correct ID.
        if (!method_exists($value, 'then')) {
            $id = self::FULFILLED === $state ? 1 : 2;
            // It's a success, so resolve the handlers in the queue.
            PromiseTool::queue()->add(
                static function () use ($id, $value, $handlers) {
                    foreach ($handlers as $handler) {
                        self::callHandler($id, $value, $handler);
                    }
                }
            );
        } elseif ($value instanceof Promise
            && self::PENDING === $value->getState()
        ) {
            // We can just merge our handlers onto the next promise.
            $value->handlers = array_merge($value->handlers, $handlers);
        } else {
            // Resolve the handlers when the forwarded promise is resolved.
            $value->then(
                static function ($value) use ($handlers) {
                    foreach ($handlers as $handler) {
                        self::callHandler(1, $value, $handler);
                    }
                },
                static function ($reason) use ($handlers) {
                    foreach ($handlers as $handler) {
                        self::callHandler(2, $reason, $handler);
                    }
                }
            );
        }
    }

    /**
     * Call a stack of handlers using a specific callback index and value.
     *
     * @param int   $index   1 (resolve) or 2 (reject)
     * @param mixed $value   value to pass to the callback
     * @param array $handler array of handler data (promise and callbacks)
     *
     * @return void returns the next group to resolve
     */
    private static function callHandler($index, $value, array $handler)
    {
        /** @var PendingPromise $promise */
        $promise = $handler[0];

        // The promise may have been cancelled or resolved before placing
        // this thunk in the queue.
        if (self::PENDING !== $promise->getState()) {
            return;
        }

        try {
            if (isset($handler[$index])) {
                $promise->resolve($handler[$index]($value));
            } elseif (1 === $index) {
                // Forward resolution values as-is.
                $promise->resolve($value);
            } else {
                // Forward rejections down the chain.
                $promise->reject($value);
            }
        } catch (Exception $reason) {
            $promise->reject($reason);
        }
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    private function waitIfPending()
    {
        if (self::PENDING !== $this->state) {
            return;
        }
        if ($this->waitFn) {
            $this->invokeWaitFn();
        } elseif ($this->waitList) {
            $this->invokeWaitList();
        } else {
            // If there's no wait function, then reject the promise.
            $this->reject(
                'Cannot wait on a promise that has '
                .'no internal wait function. You must provide a wait '
                .'function when constructing the promise to be able to '
                .'wait on a promise.'
            );
        }

        PromiseTool::queue()->run();

        if (self::PENDING === $this->state) {
            $this->reject('Invoking the wait callback did not resolve the promise');
        }
    }

    /**
     * @throws Exception
     */
    private function invokeWaitFn()
    {
        try {
            $wfn = $this->waitFn;
            $this->waitFn = null;
            $wfn(true);
        } catch (Exception $reason) {
            if (self::PENDING === $this->state) {
                // The promise has not been resolved yet, so reject the promise
                // with the exception.
                $this->reject($reason);
            } else {
                // The promise was already resolved, so there's a problem in
                // the application.
                throw $reason;
            }
        }
    }

    /**
     * @throws Exception
     */
    private function invokeWaitList()
    {
        $waitList = $this->waitList;
        $this->waitList = null;

        foreach ($waitList as $result) {
            /* @var PendingPromise $result */
            while (true) {
                $result->waitIfPending();

                if ($result->result instanceof PendingPromise) {
                    $result = $result->result;
                } else {
                    if ($result->result instanceof Promise) {
                        $result->result->wait(false);
                    }
                    break;
                }
            }
        }
    }
}
