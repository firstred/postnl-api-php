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

namespace Firstred\PostNL\Cache;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\Clock\ClockAwareInterface;
use Firstred\PostNL\Service\ServiceInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * @since 2.0.0
 */
interface CacheableServiceInterface extends ServiceInterface, ClockAwareInterface
{
    /**
     * Cache an item.
     *
     * @param CacheItemInterface $item
     *
     * @since 2.0.0
     */
    public function cacheResponseItem(CacheItemInterface $item);

    /**
     * Retrieve a cached item.
     *
     * @param CacheableRequestEntityInterface $cacheableRequestEntity
     *
     * @return CacheItemInterface|null
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveCachedResponseItem(CacheableRequestEntityInterface $cacheableRequestEntity): ?CacheItemInterface;

    /**
     * Delete an item from cache.
     *
     * @param CacheItemInterface $item
     *
     * @since 2.0.0
     */
    public function removeCachedResponseItem(CacheItemInterface $item);

    /**
     * @return DateInterval|DateTimeInterface|int|null
     *
     * @since 1.2.0
     */
    public function getTtl(): DateInterval|DateTimeInterface|int|null;

    /**
     * @param DateInterval|DateTimeInterface|int|null $ttl
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setTtl(DateInterval|DateTimeInterface|int $ttl = null): static;

    /**
     * @return CacheItemPoolInterface|null
     *
     * @since 1.2.0
     */
    public function getCache(): ?CacheItemPoolInterface;

    /**
     * @param CacheItemPoolInterface|null $cache
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setCache(CacheItemPoolInterface $cache = null): static;
}