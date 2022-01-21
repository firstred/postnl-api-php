<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

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

use ArrayIterator;
use Exception;
use Firstred\PostNL\Exception\Promise\AggregateException;
use Firstred\PostNL\Exception\Promise\RejectionException;
use Http\Promise\FulfilledPromise;
use Http\Promise\Promise;
use Http\Promise\RejectedPromise;
use Iterator;

/**
 * Class PromiseTool.
 */
class PromiseTool
{
    /**
     * Get the global task queue used for promise resolution.
     *
     * This task queue MUST be run in an event loop in order for promises to be
     * settled asynchronously. It will be automatically run when synchronously
     * waiting on a promise.
     *
     * <code>
     * while ($eventLoop->isRunning()) {
     *     queue()->run();
     * }
     * </code>
     *
     * @param TaskQueue $assign optionally specify a new queue instance
     *
     * @return TaskQueue
     */
    public static function queue(TaskQueue $assign = null)
    {
        static $queue;

        if ($assign) {
            $queue = $assign;
        } elseif (!$queue) {
            $queue = new TaskQueue();
        }

        return $queue;
    }

    /**
     * Adds a function to run in the task queue when it is next `run()` and returns
     * a promise that is fulfilled or rejected with the result.
     *
     * @param callable $task task function to run
     *
     * @return Promise
     */
    public static function task(callable $task)
    {
        $queue = static::queue();
        $promise = new PendingPromise([$queue, 'run']);
        $queue->add(
            function () use ($task, $promise) {
                try {
                    $promise->resolve($task());
                } catch (Throwable $e) {
                    $promise->reject($e);
                }
            }
        );

        return $promise;
    }

    /**
     * Creates a promise for a value if the value is not a promise.
     *
     * @param mixed $value promise or value
     *
     * @return Promise
     */
    public static function promiseFor($value)
    {
        if ($value instanceof Promise) {
            return $value;
        }

        if (method_exists($value, 'then')) {
            $wfn = method_exists($value, 'wait') ? [$value, 'wait'] : null;
            $cfn = method_exists($value, 'cancel') ? [$value, 'cancel'] : null;
            $promise = new PendingPromise($wfn, $cfn);
            $value->then([$promise, 'resolve'], [$promise, 'reject']);

            return $promise;
        }

        return new FulfilledPromise($value);
    }

    /**
     * Creates a rejected promise for a reason if the reason is not a promise. If
     * the provided reason is a promise, then it is returned as-is.
     *
     * @param mixed $reason promise or reason
     *
     * @return Promise
     */
    public static function rejectionFor($reason)
    {
        if ($reason instanceof Promise) {
            return $reason;
        }

        return new RejectedPromise($reason);
    }

    /**
     * Create an exception for a rejected promise value.
     *
     * @param mixed $reason
     *
     * @return Throwable
     */
    public static function exceptionFor($reason)
    {
        return $reason instanceof Throwable ? $reason : new RejectionException($reason);
    }

    /**
     * Returns an iterator for the given value.
     *
     * @param mixed $value
     *
     * @return Iterator
     */
    public static function iterFor($value)
    {
        if ($value instanceof Iterator) {
            return $value;
        }
        if (is_array($value)) {
            return new ArrayIterator($value);
        }

        return new ArrayIterator([$value]);
    }

    /**
     * Synchronously waits on a promise to resolve and returns an inspection state
     * array.
     *
     * Returns a state associative array containing a "state" key mapping to a
     * valid promise state. If the state of the promise is "fulfilled", the array
     * will contain a "value" key mapping to the fulfilled value of the promise. If
     * the promise is rejected, the array will contain a "reason" key mapping to
     * the rejection reason of the promise.
     *
     * @param Promise $promise promise or value
     *
     * @return array
     * @throws Exception
     */
    public static function inspect(Promise $promise)
    {
        try {
            return [
                'state' => Promise::FULFILLED,
                'value' => $promise->wait(),
            ];
        } catch (RejectionException $e) {
            return ['state' => Promise::REJECTED, 'reason' => $e->getReason()];
        } catch (Throwable $e) {
            return ['state' => Promise::REJECTED, 'reason' => $e];
        }
    }

    /**
     * Waits on all of the provided promises, but does not unwrap rejected promises
     * as thrown exception.
     *
     * Returns an array of inspection state arrays.
     *
     * @param Promise[] $promises traversable of promises to wait upon
     *
     * @return array
     * @throws Exception
     * @throws Exception
     */
    public static function inspectAll($promises)
    {
        $results = [];
        foreach ($promises as $key => $promise) {
            $results[$key] = static::inspect($promise);
        }

        return $results;
    }

    /**
     * Waits on all of the provided promises and returns the fulfilled values.
     *
     * Returns an array that contains the value of each promise (in the same order
     * the promises were provided). An exception is thrown if any of the promises
     * are rejected.
     *
     * @param mixed $promises iterable of Promise objects to wait on
     *
     * @return array
     *
     * @throws Exception on error
     * @throws Throwable on error in PHP >=7
     */
    public static function unwrap($promises)
    {
        $results = [];
        foreach ($promises as $key => $promise) {
            $results[$key] = $promise->wait();
        }

        return $results;
    }

    /**
     * Given an array of promises, return a promise that is fulfilled when all the
     * items in the array are fulfilled.
     *
     * The promise's fulfillment value is an array with fulfillment values at
     * respective positions to the original array. If any promise in the array
     * rejects, the returned promise is rejected with the rejection reason.
     *
     * @param mixed $promises  promises or values
     * @param bool  $recursive - If true, resolves new promises that might have been added to the stack during its own resolution
     *
     * @return Promise
     */
    public static function all($promises, $recursive = false)
    {
        $results = [];
        $promise = static::each(
            $promises,
            function ($value, $idx) use (&$results) {
                $results[$idx] = $value;
            },
            function ($reason, $idx, Promise $aggregate) {
                $aggregate->reject($reason);
            }
        )->then(
            function () use (&$results) {
                ksort($results);

                return $results;
            }
        );

        if (true === $recursive) {
            $promise = $promise->then(
                function ($results) use ($recursive, &$promises) {
                    foreach ($promises as $promise) {
                        if (Promise::PENDING === $promise->getState()) {
                            return static::all($promises, $recursive);
                        }
                    }

                    return $results;
                }
            );
        }

        return $promise;
    }

    /**
     * Initiate a competitive race between multiple promises or values (values will
     * become immediately fulfilled promises).
     *
     * When count amount of promises have been fulfilled, the returned promise is
     * fulfilled with an array that contains the fulfillment values of the winners
     * in order of resolution.
     *
     * @param int   $count    total number of promises
     * @param mixed $promises promises or values
     *
     * @return Promise
     */
    public static function some($count, $promises)
    {
        $results = [];
        $rejections = [];

        return static::each(
            $promises,
            function ($value, $idx, Promise $p) use (&$results, $count) {
                if (Promise::PENDING !== $p->getState()) {
                    return;
                }
                $results[$idx] = $value;
                if (count($results) >= $count) {
                    $p->resolve(null);
                }
            },
            function ($reason) use (&$rejections) {
                $rejections[] = $reason;
            }
        )->then(
            function () use (&$results, &$rejections, $count) {
                if (count($results) !== $count) {
                    throw new AggregateException('Not enough promises to fulfill count', $rejections);
                }
                ksort($results);

                return array_values($results);
            }
        );
    }

    /**
     * Like some(), with 1 as count. However, if the promise fulfills, the
     * fulfillment value is not an array of 1 but the value directly.
     *
     * @param mixed $promises promises or values
     *
     * @return Promise
     */
    public static function any($promises)
    {
        return static::some(1, $promises)->then(
            function ($values) {
                return $values[0];
            }
        );
    }

    /**
     * Returns a promise that is fulfilled when all of the provided promises have
     * been fulfilled or rejected.
     *
     * The returned promise is fulfilled with an array of inspection state arrays.
     *
     * @param mixed $promises promises or values
     *
     * @return Promise
     */
    public static function settle($promises)
    {
        $results = [];

        return static::each(
            $promises,
            function ($value, $idx) use (&$results) {
                $results[$idx] = ['state' => Promise::FULFILLED, 'value' => $value];
            },
            function ($reason, $idx) use (&$results) {
                $results[$idx] = ['state' => Promise::REJECTED, 'reason' => $reason];
            }
        )->then(
            function () use (&$results) {
                ksort($results);

                return $results;
            }
        );
    }

    /**
     * Given an iterator that yields promises or values, returns a promise that is
     * fulfilled with a null value when the iterator has been consumed or the
     * aggregate promise has been fulfilled or rejected.
     *
     * $onFulfilled is a function that accepts the fulfilled value, iterator
     * index, and the aggregate promise. The callback can invoke any necessary side
     * effects and choose to resolve or reject the aggregate promise if needed.
     *
     * $onRejected is a function that accepts the rejection reason, iterator
     * index, and the aggregate promise. The callback can invoke any necessary side
     * effects and choose to resolve or reject the aggregate promise if needed.
     *
     * @param mixed    $iterable    iterator or array to iterate over
     * @param callable $onFulfilled
     * @param callable $onRejected
     *
     * @return Promise
     */
    public static function each($iterable, callable $onFulfilled = null, callable $onRejected = null)
    {
        return (new EachPromise(
            $iterable,
            [
                'fulfilled' => $onFulfilled,
                'rejected'  => $onRejected,
            ]
        ))->promise();
    }

    /**
     * Like each, but only allows a certain number of outstanding promises at any
     * given time.
     *
     * $concurrency may be an integer or a function that accepts the number of
     * pending promises and returns a numeric concurrency limit value to allow for
     * dynamic a concurrency size.
     *
     * @param mixed        $iterable
     * @param int|callable $concurrency
     * @param callable     $onFulfilled
     * @param callable     $onRejected
     *
     * @return Promise
     */
    public static function eachLimit($iterable, $concurrency, callable $onFulfilled = null, callable $onRejected = null)
    {
        return (new EachPromise(
            $iterable,
            [
                'fulfilled'   => $onFulfilled,
                'rejected'    => $onRejected,
                'concurrency' => $concurrency,
            ]
        ))->promise();
    }

    /**
     * Like each_limit, but ensures that no promise in the given $iterable argument
     * is rejected. If any promise is rejected, then the aggregate promise is
     * rejected with the encountered rejection.
     *
     * @param mixed        $iterable
     * @param int|callable $concurrency
     * @param callable     $onFulfilled
     *
     * @return Promise
     */
    public static function eachLimitAll($iterable, $concurrency, callable $onFulfilled = null)
    {
        return static::eachLimit(
            $iterable,
            $concurrency,
            $onFulfilled,
            function ($reason, $idx, Promise $aggregate) {
                $aggregate->reject($reason);
            }
        );
    }

    /**
     * Returns true if a promise is fulfilled.
     *
     * @param Promise $promise
     *
     * @return bool
     */
    public static function isFulfilled(Promise $promise)
    {
        return Promise::FULFILLED === $promise->getState();
    }

    /**
     * Returns true if a promise is rejected.
     *
     * @param Promise $promise
     *
     * @return bool
     */
    public static function isRejected(Promise $promise)
    {
        return Promise::REJECTED === $promise->getState();
    }

    /**
     * Returns true if a promise is fulfilled or rejected.
     *
     * @param Promise $promise
     *
     * @return bool
     */
    public static function isSettled(Promise $promise)
    {
        return Promise::PENDING !== $promise->getState();
    }
}
