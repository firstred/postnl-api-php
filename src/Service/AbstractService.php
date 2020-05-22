<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\PostNL;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class AbstractService
 */
abstract class AbstractService
{
    /**
     * TTL for the cache
     *
     * `null` disables the cache
     * `int` is the TTL in seconds
     * Any `DateTime` will be used as the exact date/time at which to expire the data (auto calculate TTL)
     * A `DateInterval` can be used as well to set the TTL
     *
     * @var null|int|DateTimeInterface|DateInterval $ttl
     *
     * @since 1.0.0
     */
    public $ttl = null;

    /**
     * The [PSR-6](https://www.php-fig.org/psr/psr-6/) CacheItemPoolInterface
     *
     * Use a caching library that implements [PSR-6](https://www.php-fig.org/psr/psr-6/) and you'll be good to go
     * `null` disables the cache
     *
     * @var null|CacheItemPoolInterface
     *
     * @since 1.0.0
     */
    public $cache = null;

    /**
     * @var PostNL $postnl
     *
     * @since 1.0.0
     */
    protected $postnl;

    /**
     * AbstractService constructor.
     *
     * @param PostNL                                  $postnl PostNL instance
     * @param null|CacheItemPoolInterface             $cache
     * @param null|int|DateTimeInterface|DateInterval $ttl
     */
    public function __construct($postnl, $cache = null, $ttl = null)
    {
        $this->postnl = $postnl;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     *
     * @throws CifErrorException
     * @throws CifDownException
     *
     * @since 1.0.0
     * @since 2.0.0 Introduce ResponseInterface, CifErrorException and CifDownException
     */
    public static function validateResponse(ResponseInterface $response): bool
    {
        $body = @json_decode((string) $response->getBody(), true);
        if (!empty($body['Error']['ErrorMsg'])) {
            throw new CifErrorException($body['Error']['ErrorMsg'], $body['Error']['ErrorNumber'] ?: 0, null, null, $response);
        }
        if (!empty($body['fault']['faultstring'])) {
            throw new CifDownException($body['fault']['faultstring'], $body['fault']['detail']['errorcode'] ?: '', null, null, $response);
        }
        if (empty($body)) {
            throw new CifDownException('Empty response body', 0, null, null, $response);
        }

        return true;
    }

    /**
     * Retrieve a cached item
     *
     * @param string $uuid
     *
     * @return null|CacheItemInterface
     *
     * @since 1.0.0
     */
    public function retrieveCachedItem($uuid)
    {
        // An integer cache key means it should not be cached
        if (is_int($uuid)) {
            return null;
        }

        try {
            $reflection = new ReflectionClass($this);
        } catch (ReflectionException $exception) {
            return null;
        }
        $uuid .= strtolower(substr($reflection->getShortName(), 0, mb_strlen($reflection->getShortName()) - 7));
        $item = null;
        if ($this->cache instanceof CacheItemPoolInterface && !is_null($this->ttl)) {
            try {
                $item = $this->cache->getItem($uuid);
            } catch (InvalidArgumentException $e) {
            }
        }

        return $item;
    }

    /**
     * @param CacheItemInterface $item
     */
    public function cacheItem(CacheItemInterface $item)
    {
        if ($this->ttl instanceof DateInterval || is_int($this->ttl)) {
            // Reset expires at first -- it might have been set
            $item->expiresAt(null);
            // Then set the interval
            $item->expiresAfter($this->ttl);
        } else {
            // Reset expires after first -- it might have been set
            $item->expiresAfter(null);
            // Then set the expiration time
            $item->expiresAt($this->ttl);
        }

        $this->cache->save($item);
    }
}
