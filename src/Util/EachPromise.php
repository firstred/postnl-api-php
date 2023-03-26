<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
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

use Exception;
use Http\Promise\Promise;
use Iterator;

/**
 * Represents a promise that iterates over many promises and invokes
 * side-effect functions in the process.
 *
 * @internal
 */
class EachPromise
{
    const PENDING = 'pending';
    const FULFILLED = 'fulfilled';
    const REJECTED = 'rejected';

    private $pending = [];

    /** @var Iterator */
    private $iterable;

    /** @var callable|int */
    private $concurrency;

    /** @var callable */
    private $onFulfilled;

    /** @var callable */
    private $onRejected;

    /** @var Promise */
    private $aggregate;

    /** @var bool */
    private $mutex;

    /**
     * Configuration hash can include the following key value pairs:.
     *
     * - fulfilled: (callable) Invoked when a promise fulfills. The function
     *   is invoked with three arguments: the fulfillment value, the index
     *   position from the iterable list of the promise, and the aggregate
     *   promise that manages all of the promises. The aggregate promise may
     *   be resolved from within the callback to short-circuit the promise.
     * - rejected: (callable) Invoked when a promise is rejected. The
     *   function is invoked with three arguments: the rejection reason, the
     *   index position from the iterable list of the promise, and the
     *   aggregate promise that manages all of the promises. The aggregate
     *   promise may be resolved from within the callback to short-circuit
     *   the promise.
     * - concurrency: (integer) Pass this configuration option to limit the
     *   allowed number of outstanding concurrently executing promises,
     *   creating a capped pool of promises. There is no limit by default.
     *
     * @param mixed $iterable promises or values to iterate
     * @param array $config   Configuration options
     */
    public function __construct($iterable, array $config = [])
    {
        $this->iterable = PromiseTool::iterFor($iterable);

        if (isset($config['concurrency'])) {
            $this->concurrency = $config['concurrency'];
        }

        if (isset($config['fulfilled'])) {
            $this->onFulfilled = $config['fulfilled'];
        }

        if (isset($config['rejected'])) {
            $this->onRejected = $config['rejected'];
        }
    }

    /**
     * @return Promise
     */
    public function promise()
    {
        if ($this->aggregate) {
            return $this->aggregate;
        }

        try {
            $this->createPromise();
            $this->iterable->rewind();
            $this->refillPending();
        } catch (Exception $e) {
            $this->aggregate->reject($e);
        }

        return $this->aggregate;
    }

    /**
     * @return void
     */
    private function createPromise()
    {
        $this->mutex = false;
        $this->aggregate = new PendingPromise(
            function () {
                reset($this->pending);
                if (empty($this->pending) && !$this->iterable->valid()) {
                    $this->aggregate->resolve(null);

                    return;
                }

                // Consume a potentially fluctuating list of promises while
                // ensuring that indexes are maintained (precluding array_shift).
                while ($promise = current($this->pending)) {
                    next($this->pending);
                    $promise->wait();
                    if ($this->aggregate->getState() !== static::PENDING) {
                        return;
                    }
                }
            }
        );

        // Clear the references when the promise is resolved.
        $clearFn = function () {
            $this->iterable = $this->concurrency = $this->pending = null;
            $this->onFulfilled = $this->onRejected = null;
        };

        $this->aggregate->then($clearFn, $clearFn);
    }

    /**
     * @return void
     */
    private function refillPending()
    {
        if (!$this->concurrency) {
            // Add all pending promises.
            while ($this->addPending() && $this->advanceIterator()) {
            }

            return;
        }

        // Add only up to N pending promises.
        $concurrency = is_callable($this->concurrency)
            ? call_user_func($this->concurrency, count($this->pending))
            : $this->concurrency;
        $concurrency = max($concurrency - count($this->pending), 0);
        // Concurrency may be set to 0 to disallow new promises.
        if (!$concurrency) {
            return;
        }
        // Add the first pending promise.
        $this->addPending();
        // Note this is special handling for concurrency=1 so that we do
        // not advance the iterator after adding the first promise. This
        // helps work around issues with generators that might not have the
        // next value to yield until promise callbacks are called.
        while (--$concurrency
            && $this->advanceIterator()
            && $this->addPending()) {
        }
    }

    /**
     * @return bool
     */
    private function addPending()
    {
        if (!$this->iterable || !$this->iterable->valid()) {
            return false;
        }

        $promise = PromiseTool::promiseFor($this->iterable->current());
        $idx = $this->iterable->key();

        $this->pending[$idx] = $promise->then(
            function ($value) use ($idx) {
                if ($this->onFulfilled) {
                    call_user_func(
                        $this->onFulfilled,
                        $value,
                        $idx,
                        $this->aggregate
                    );
                }
                $this->step($idx);
            },
            function ($reason) use ($idx) {
                if ($this->onRejected) {
                    call_user_func(
                        $this->onRejected,
                        $reason,
                        $idx,
                        $this->aggregate
                    );
                }
                $this->step($idx);
            }
        );

        return true;
    }

    /**
     * @return bool
     */
    private function advanceIterator()
    {
        // Place a lock on the iterator so that we ensure to not recurse,
        // preventing fatal generator errors.
        if ($this->mutex) {
            return false;
        }

        $this->mutex = true;

        try {
            $this->iterable->next();
            $this->mutex = false;

            return true;
        } catch (Throwable $e) {
            $this->aggregate->reject($e);
            $this->mutex = false;

            return false;
        }
    }

    /**
     * @param mixed $idx
     */
    private function step($idx)
    {
        // If the promise was already resolved, then ignore this step.
        if ($this->aggregate->getState() !== static::PENDING) {
            return;
        }

        unset($this->pending[$idx]);

        // Only refill pending promises if we are not locked, preventing the
        // EachPromise to recursively invoke the provided iterator, which
        // cause a fatal error: "Cannot resume an already running generator"
        if ($this->advanceIterator() && !$this->checkIfFinished()) {
            // Add more pending promises if possible.
            $this->refillPending();
        }
    }

    /**
     * @return bool
     */
    private function checkIfFinished()
    {
        if (!$this->pending && !$this->iterable->valid()) {
            // Resolve the promise if there's nothing left to do.
            $this->aggregate->resolve(null);

            return true;
        }

        return false;
    }
}
