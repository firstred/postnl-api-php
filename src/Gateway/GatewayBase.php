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

declare(strict_types=1);

namespace Firstred\PostNL\Gateway;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\SerializableObject;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class GatewayBase.
 */
abstract class GatewayBase implements GatewayInterface
{
    /**
     * GatewayBase constructor.
     *
     * @param HttpClientInterface                     $httpClient
     * @param CacheItemPoolInterface|null             $cache
     * @param int|DateTimeInterface|DateInterval|null $ttl
     */
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
    ) {
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
     * @return static
     */
    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return CacheItemPoolInterface|null
     */
    public function getCache(): CacheItemPoolInterface|null
    {
        return $this->cache;
    }

    /**
     * @param CacheItemPoolInterface|null $cache
     *
     * @return static
     */
    public function setCache(CacheItemPoolInterface|null $cache = null): static
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return DateInterval|DateTimeInterface|int|null
     */
    public function getTtl(): DateInterval|DateTimeInterface|int|null
    {
        return $this->ttl;
    }

    /**
     * @param DateInterval|DateTimeInterface|int|null $ttl
     *
     * @return static
     */
    public function setTtl(DateInterval|DateTimeInterface|int|null $ttl = null): static
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return LoggerInterface|null
     */
    public function getLogger(): LoggerInterface|null
    {
        return $this->getHttpClient()->getLogger();
    }

    /**
     * @param LoggerInterface|null $logger
     *
     * @return static
     */
    public function setLogger(LoggerInterface|null $logger = null): static
    {
        $this->getHttpClient()->setLogger();

        return $this;
    }

    /**
     * @param SerializableObject $object
     * @param string             $cacheKey
     */
    protected function cacheItem(SerializableObject $object, string $cacheKey): void
    {
    }

    /**
     * @param string $cacheKey
     *
     * @return SerializableObject|null
     */
    protected function retrieveCachedItem(string $cacheKey): SerializableObject|null
    {
        // An empty cache key means it should not be cached
        if (!$cacheKey) {
            return null;
        }

        $item = null;
        $cache = $this->getCache();
        if ($cache instanceof CacheItemPoolInterface && !is_null(value: $this->getTtl())) {
            /** @psalm-suppress InvalidCatch */
            try {
                /** @var SerializableObject $item */
                $item = $cache->getItem(key: $cacheKey);
            } catch (InvalidArgumentException) {
            }
        }

        return $item;
    }
}
