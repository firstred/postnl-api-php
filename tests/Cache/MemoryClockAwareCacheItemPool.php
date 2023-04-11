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

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Cache;

use Firstred\PostNL\Clock\ClockAwareInterface;
use Firstred\PostNL\Clock\ClockAwareTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Clock\ClockInterface;

/**
 * @since 2.0.0
 */
class MemoryClockAwareCacheItemPool implements CacheItemPoolInterface, ClockAwareInterface
{
    use ClockAwareTrait;

    /** @var array<string, MemoryClockAwareCacheItem> */
    private array $items = [];

    /**
     * @param ClockInterface $clock
     */
    public function __construct(ClockInterface $clock)
    {
        $this->setClock(clock: $clock);
    }

    /**
     * Returns a Cache Item representing the specified key.
     *
     * This method must always return a CacheItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param string $key The key for which to return the corresponding Cache Item
     *
     * @return CacheItemInterface The corresponding Cache Item
     *
     * @throws InvalidArgumentException If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *                                  MUST be thrown
     *
     * @since 2.0.0
     */
    public function getItem(string $key): CacheItemInterface
    {
        if (isset($this->items[$key]) && $this->items[$key]->expiresAt > $this->getClock()->now()) {
            return $this->items[$key];
        }

        return new MemoryClockAwareCacheItem(key: $key);
    }

    /**
     * Returns a traversable set of cache items.
     *
     * @param iterable $keys An indexed array of keys of items to retrieve
     *
     * @return iterable A traversable collection of Cache Items keyed by the cache keys of
     *                  each item. A Cache item will be returned for each key, even if that
     *                  key is not found. However, if no keys are specified then an empty
     *                  traversable MUST be returned instead.
     *
     * @throws InvalidArgumentException If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *                                  MUST be thrown
     *
     * @since 2.0.0
     */
    public function getItems(iterable $keys = []): iterable
    {
        return $this->items;
    }

    /**
     * Confirms if the cache contains specified cache item.
     *
     * Note: This method MAY avoid retrieving the cached value for performance reasons.
     * This could result in a race condition with CacheItemInterface::get(). To avoid
     * such situation use CacheItemInterface::isHit() instead.
     *
     * @param string $key The key for which to check existence
     *
     * @return bool True if item exists in the cache, false otherwise
     *
     * @throws InvalidArgumentException If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *                                  MUST be thrown
     *
     * @since 2.0.0
     */
    public function hasItem(string $key): bool
    {
        return isset($this->items[$key]) && $this->items[$key]->expiresAt > $this->getClock()->now();
    }

    /**
     * Deletes all items in the pool.
     *
     * @return bool True if the pool was successfully cleared. False if there was an error.
     *
     * @since 2.0.0
     */
    public function clear(): bool
    {
        $this->items = [];

        return true;
    }

    /**
     * Removes the item from the pool.
     *
     * @param string $key The key to delete
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     *
     * @throws invalidArgumentException If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *                                  MUST be thrown
     *
     * @since 2.0.0
     */
    public function deleteItem(string $key): bool
    {
        unset($this->items[$key]);

        return true;
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param string[] $keys An array of keys that should be removed from the pool
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     *
     * @throws invalidArgumentException If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *                                  MUST be thrown
     *
     * @since 2.0.0
     */
    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            unset($this->items[$key]);
        }

        return true;
    }

    /**
     * Persists a cache item immediately.
     *
     * @param cacheItemInterface $item The cache item to save
     *
     * @return bool True if the item was successfully persisted. False if there was an error.
     *
     * @since 2.0.0
     */
    public function save(CacheItemInterface $item): bool
    {
        $this->items[$item->getKey()] = $item;

        return true;
    }

    /**
     * Sets a cache item to be persisted later.
     *
     * @param cacheItemInterface $item The cache item to save
     *
     * @return bool False if the item could not be queued or if a commit was attempted and failed. True otherwise.
     *
     * @since 2.0.0
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        return $this->save(item: $item);
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     *
     * @since 2.0.0
     */
    public function commit(): bool
    {
        return true;
    }

    /**
     * Cleans the cache by removing expired items.
     *
     * @return bool
     *
     * @since 2.0.0
     */
    public function clean(): bool
    {
        $now = $this->getClock()->now();
        foreach (array_keys(array: $this->items) as $index) {
            if ($this->items[$index]->expiresAt <= $now) {
                unset($this->items[$index]);
            }
        }

        return true;
    }
}
