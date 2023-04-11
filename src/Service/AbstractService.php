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
use Firstred\PostNL\HttpClient\HttpClientInterface;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use ReflectionClass;

/**
 * Class AbstractService.
 *
 * @since 1.0.0
 *
 * @internal
 */
abstract class AbstractService
{
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
    private int|DateTimeInterface|DateInterval|null $ttl;

    /**
     * The [PSR-6](https://www.php-fig.org/psr/psr-6/) CacheItemPoolInterface.
     *
     * Use a caching library that implements [PSR-6](https://www.php-fig.org/psr/psr-6/) and you'll be good to go
     * `null` disables the cache
     *
     * @var CacheItemPoolInterface|null
     */
    private ?CacheItemPoolInterface $cache;

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
        protected HiddenString             $apiKey,
        private bool                       $sandbox,
        private HttpClientInterface        $httpClient,
        private RequestFactoryInterface    $requestFactory,
        private StreamFactoryInterface     $streamFactory,
        CacheItemPoolInterface             $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null
    ) {
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * Retrieve a cached item.
     *
     * @param string $uuid
     *
     * @return CacheItemInterface|null
     *
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function retrieveCachedItem(string $uuid): ?CacheItemInterface
    {
        $reflection = new ReflectionClass(objectOrClass: $this);
        $uuid = strtolower(string: substr(string: $reflection->getShortName(), offset: 0, length: strlen(string: $reflection->getShortName()) - 7));
        $item = null;
        if ($this->cache instanceof CacheItemPoolInterface && !is_null(value: $this->ttl)) {
            $item = $this->cache->getItem(key: $uuid);
        }

        return $item;
    }

    /**
     * Cache an item.
     *
     * @param CacheItemInterface $item
     *
     * @since 1.0.0
     */
    public function cacheItem(CacheItemInterface $item): void
    {
        if ($this->ttl instanceof DateInterval || is_int(value: $this->ttl)) {
            // Reset expires at first -- it might have been set
            $item->expiresAt(expiration: null);
            // Then set the interval
            $item->expiresAfter(time: $this->ttl);
        } else {
            // Reset expires after first -- it might have been set
            $item->expiresAfter(time: null);
            // Then set the expiration time
            $item->expiresAt(expiration: $this->ttl);
        }

        $this->cache->save(item: $item);
    }

    /**
     * Delete an item from cache.
     *
     * @param CacheItemInterface $item
     *
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function removeCachedItem(CacheItemInterface $item): void
    {
        $this->cache->deleteItem(key: $item->getKey());
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

    /**
     * @param HiddenString $apiKey
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setApiKey(HiddenString $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return bool
     *
     * @since 2.0.0
     */
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * @param bool $sandbox
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setSandbox(bool $sandbox): static
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     *
     * @return AbstractService
     */
    public function setHttpClient(HttpClientInterface $httpClient): AbstractService
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return RequestFactoryInterface
     *
     * @since 2.0.0
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    /**
     * @param RequestFactoryInterface $requestFactory
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): static
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * @return StreamFactoryInterface
     *
     * @since 2.0.0
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    /**
     * @param StreamFactoryInterface $streamFactory
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): static
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }
}
