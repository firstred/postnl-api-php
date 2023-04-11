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

namespace Firstred\PostNL\Service;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\Cache\CacheableRequestEntityInterface;
use Firstred\PostNL\Cache\CacheableServiceInterface;
use Firstred\PostNL\Clock\ClockAwareTrait;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class AbstractService.
 *
 * @since 2.0.0
 *
 * @internal
 */
abstract class AbstractCacheableService extends AbstractService implements CacheableServiceInterface
{
    use ClockAwareTrait;

    /**
     * TTL for the cache.
     *
     * `null` disables the cache
     * `int` is the TTL in seconds
     * Any `DateTime` will be used as the exact date/time at which to expire the data (auto calculate TTL)
     * A `DateInterval` can be used as well to set the TTL
     *
     * @var int|DateTimeInterface|DateInterval|null
     */
    protected int|DateTimeInterface|DateInterval|null $ttl;

    /**
     * The [PSR-6](https://www.php-fig.org/psr/psr-6/) CacheItemPoolInterface.
     *
     * Use a caching library that implements [PSR-6](https://www.php-fig.org/psr/psr-6/) and you'll be good to go
     * `null` disables the cache
     *
     * @var CacheItemPoolInterface|null
     */
    protected ?CacheItemPoolInterface $cache;

    /**
     * @param HiddenString                            $apiKey
     * @param bool                                    $sandbox
     * @param HttpClientInterface                     $httpClient
     * @param RequestFactoryInterface                 $requestFactory
     * @param StreamFactoryInterface                  $streamFactory
     * @param CacheItemPoolInterface|null             $cache
     * @param DateInterval|DateTimeInterface|int|null $ttl
     */
    public function __construct(
        HiddenString $apiKey,
        bool $sandbox,
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        CacheItemPoolInterface $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null
    ) {
        $this->cache = $cache;
        $this->ttl = $ttl;

        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            httpClient: $httpClient,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
        );
    }

    /**
     * Retrieve a cached item.
     *
     * @param CacheableRequestEntityInterface $cacheableRequestEntity
     *
     * @return CacheItemInterface|null
     *
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveCachedResponseItem(CacheableRequestEntityInterface $cacheableRequestEntity): ?CacheItemInterface
    {
        $item = null;
        if ($this->cache instanceof CacheItemPoolInterface && !is_null(value: $this->ttl)) {
            $item = $this->cache->getItem(key: $cacheableRequestEntity->getCacheKey());
        }

        return $item;
    }

    /**
     * Cache an item.
     *
     * @param CacheItemInterface $item
     *
     * @return bool
     *
     * @since 2.0.0
     */
    public function cacheResponseItem(CacheItemInterface $item): bool
    {
        if (is_int(value: $this->ttl)) {
            $item->expiresAt(
                expiration: $this->clock->now()->add(
                    interval: new DateInterval(duration: "PT{$this->ttl}S"),
                ),
            );
        } elseif ($this->ttl instanceof DateInterval) {
            $item->expiresAt(expiration: $this->getClock()->now()->add(interval: $this->ttl));
        } elseif ($this->ttl instanceof DateTimeInterface) {
            $item->expiresAt(expiration: $this->ttl);
        } else {
            $item->expiresAt(expiration: null);
        }

        return $this->cache->save(item: $item);
    }

    /**
     * Delete an item from cache.
     *
     * @param CacheItemInterface $item
     *
     * @return bool
     *
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 2.0.0
     */
    public function removeCachedResponseItem(CacheItemInterface $item): bool
    {
        return $this->cache->deleteItem(key: $item->getKey());
    }

    /**
     * @return DateInterval|DateTimeInterface|int|null
     *
     * @since 1.2.0
     */
    public function getTtl(): DateInterval|DateTimeInterface|int|null
    {
        return $this->ttl;
    }

    /**
     * @param DateInterval|DateTimeInterface|int|null $ttl
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setTtl(DateInterval|DateTimeInterface|int|null $ttl = null): static
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return CacheItemPoolInterface|null
     *
     * @since 1.2.0
     */
    public function getCache(): ?CacheItemPoolInterface
    {
        return $this->cache;
    }

    /**
     * @param CacheItemPoolInterface|null $cache
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setCache(?CacheItemPoolInterface $cache = null): static
    {
        $this->cache = $cache;

        return $this;
    }
}
