<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author    Michael Dekker <git@michaeldekker.nl>
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

/*
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

declare(strict_types=1);

namespace Firstred\PostNL\Misc;

use Exception;
use Http\Promise\Promise;
use LogicException;
use Throwable;

/**
 * Promises/A+ implementation that avoids recursion when possible.
 *
 * @see https://promisesaplus.com/
 */
class PendingPromise implements Promise
{
    /**
     * @var string
     */
    private string $state = self::PENDING;
    /**
     * @var null|string|\Throwable
     */
    private mixed $result;
    /**
     * @var null|callable
     */
    private mixed $cancelFn;
    /**
     * @var null|callable
     */
    private mixed $waitFn;
    /**
     * @var null|$this[]|mixed[]
     */
    private array|null $waitList = null;
    /**
     * @var callable[][]|$this[][]|null[][]|null|mixed[]
     */
    private array|null $handlers = [];

    /**
     * @param callable|null $waitFn   fn that when invoked resolves the promise
     * @param callable|null $cancelFn fn that when invoked cancels the promise
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
     * @return Promise|static
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null): Promise|PendingPromise
    {
        if (self::PENDING === $this->state) {
            /** @psalm-suppress UnsafeInstantiation */
            $p = new static(waitFn: null, cancelFn: [$this, 'cancel']);
            $this->handlers[] = [$p, $onFulfilled, $onRejected];
            $p->waitList = $this->waitList;
            $p->waitList[] = $this;

            return $p;
        }

        // Return a fulfilled promise and immediately invoke any callbacks.
        if (self::FULFILLED === $this->state) {
            return $onFulfilled
                ? PromiseTool::promiseFor(value: $this->result)->then(onFulfilled: $onFulfilled)
                : PromiseTool::promiseFor(value: $this->result);
        }

        // It's either cancelled or rejected, so return a rejected promise
        // and immediately invoke any callbacks.
        $rejection = PromiseTool::rejectionFor(reason: $this->result);

        return $onRejected ? $rejection->then(onRejected: $onRejected) : $rejection;
    }

    /**
     * @param callable $onRejected
     *
     * @return Promise|static
     */
    public function otherwise(callable $onRejected): PendingPromise|Promise
    {
        return $this->then(onRejected: $onRejected);
    }

    /**
     * @param bool $unwrap
     *
     * @return mixed
     * @throws Throwable
     */
    public function wait($unwrap = true): mixed
    {
        $this->waitIfPending();

        $inner = $this->result instanceof Promise
            ? $this->result->wait(unwrap: $unwrap)
            : $this->result;

        if ($unwrap) {
            if ($this->result instanceof Promise
                || self::FULFILLED === $this->state
            ) {
                return $inner;
            }
            // It's rejected so "unwrap" and throw an exception.
            /** @psalm-suppress InvalidThrow */
            throw PromiseTool::exceptionFor(reason: $inner);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    public function cancel(): void
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
                $this->reject(reason: $e);
            }
        }

        // Reject the promise only if it wasn't rejected in a then callback.
        /** @psalm-suppress RedundantCondition */
        if (self::PENDING === $this->state) {
            $this->reject(reason: new Exception(message: 'Promise has been cancelled'));
        }
    }

    /**
     * @param mixed $value
     */
    public function resolve(mixed $value): void
    {
        $this->settle(state: self::FULFILLED, value: $value);
    }

    /**
     * @param string|Throwable $reason
     */
    public function reject(string|Throwable $reason): void
    {
        $this->settle(state: self::REJECTED, value: $reason);
    }

    /**
     * @param string                      $state
     * @psalm-param string|Throwable|null $value
*/
    private function settle(string $state, string|Throwable|null $value): void
    {
        if (self::PENDING !== $this->state || !$value) {
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
        /** @var string $state */
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
        /** @psalm-var class-string|object $value */
        if (!method_exists(object_or_class: $value, method: 'then')) {
            $id = self::FULFILLED === $state ? 1 : 2;
            // It's a success, so resolve the handlers in the queue.
            PromiseTool::queue()->add(
                task: static function () use ($id, $value, $handlers) {
                    foreach ($handlers as $handler) {
                        self::callHandler(index: $id, value: $value, handler: $handler);
                    }
                }
            );
        } elseif ($value instanceof Promise
            && self::PENDING === $value->getState()
        ) {
            // We can just merge our handlers onto the next promise.
            /**
             * @noinspection PhpPossiblePolymorphicInvocationInspection
             * @psalm-suppress NoInterfaceProperties
             */
            $value->handlers = array_merge($value->handlers, $handlers);
        } elseif (!is_string(value: $value)) {
            // Resolve the handlers when the forwarded promise is resolved.
            $value->then(
                static function (mixed $value) use ($handlers): void {
                    foreach ($handlers as $handler) {
                        self::callHandler(index: 1, value: $value, handler: $handler);
                    }
                },
                static function (mixed $reason) use ($handlers): void {
                    foreach ($handlers as $handler) {
                        self::callHandler(index: 2, value: $reason, handler: $handler);
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
    private static function callHandler(int $index, mixed $value, array $handler): void
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
                $promise->resolve(value: $handler[$index]($value));
            } elseif (1 === $index) {
                // Forward resolution values as-is.
                $promise->resolve(value: $value);
            } else {
                // Forward rejections down the chain.
                $promise->reject(reason: $value);
            }
        } catch (Exception $reason) {
            $promise->reject(reason: $reason);
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
                reason: 'Cannot wait on a promise that has '
                .'no internal wait function. You must provide a wait '
                .'function when constructing the promise to be able to '
                .'wait on a promise.'
            );
        }

        PromiseTool::queue()->run();

        /** @psalm-suppress RedundantCondition */
        if (self::PENDING === $this->state) {
            $this->reject(reason: 'Invoking the wait callback did not resolve the promise');
        }
    }

    /**
     * @throws Exception
     */
    private function invokeWaitFn(): void
    {
        try {
            $wfn = $this->waitFn;
            $this->waitFn = null;
            $wfn(true);
        } catch (Exception $reason) {
            if (self::PENDING === $this->state) {
                // The promise has not been resolved yet, so reject the promise
                // with the exception.
                $this->reject(reason: $reason);
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
    private function invokeWaitList(): void
    {
        $waitList = $this->waitList;
        $this->waitList = null;

        foreach ($waitList ?? [] as $result) {
            /** @var PendingPromise $result */
            while (true) {
                $result->waitIfPending();

                if ($result->result instanceof PendingPromise) {
                    $result = $result->result;
                } else {
                    if ($result->result instanceof Promise) {
                        $result->result->wait(unwrap: false);
                    }
                    break;
                }
            }
        }
    }
}
