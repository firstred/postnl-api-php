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

use DateTimeInterface;
use Firstred\PostNL\Exception\NotImplementedException;
use Psr\Cache\CacheItemInterface;

/**
 * @since 2.0.0
 */
class MemoryClockAwareCacheItem implements CacheItemInterface
{
    public DateTimeInterface $expiresAt;

    /**
     * @param string     $key
     * @param mixed|null $value
     */
    public function __construct(
        private readonly string $key,
        private mixed $value = null,
    ) {
    }

    /**
     * Returns the key for the current cache item.
     *
     * The key is loaded by the Implementing Library, but should be available to
     * the higher level callers when needed.
     *
     * @return string the key string for this cache item
     *
     * @since 2.0.0
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Retrieves the value of the item from the cache associated with this object's key.
     *
     * The value returned must be identical to the value originally stored by set().
     *
     * If isHit() returns false, this method MUST return null. Note that null
     * is a legitimate cached value, so the isHit() method SHOULD be used to
     * differentiate between "null value was found" and "no value was found."
     *
     * @return mixed the value corresponding to this cache item's key, or null if not found
     *
     * @since 2.0.0
     */
    public function get(): mixed
    {
        if (!isset($this->value)) {
            return null;
        }

        return $this->value;
    }

    /**
     * Confirms if the cache item lookup resulted in a cache hit.
     *
     * Note: This method MUST NOT have a race condition between calling isHit()
     * and calling get().
     *
     * @return bool True if the request resulted in a cache hit. False otherwise.
     *
     * @since 2.0.0
     */
    public function isHit(): bool
    {
        return isset($this->value);
    }

    /**
     * Sets the value represented by this cache item.
     *
     * The $value argument may be any item that can be serialized by PHP,
     * although the method of serialization is left up to the Implementing
     * Library.
     *
     * @param mixed $value the serializable value to be stored
     *
     * @return static the invoked object
     *
     * @since 2.0.0
     * @since 2.0.0
     */
    public function set(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Sets the expiration time for this cache item.
     *
     * @param ?DateTimeInterface $expiration The point in time after which the item MUST be considered expired.
     *                                       If null is passed explicitly, a default value MAY be used. If none is set,
     *                                       the value should be stored permanently or for as long as the
     *                                       implementation allows.
     *
     * @return static the called object
     *
     * @since 2.0.0
     */
    public function expiresAt(?DateTimeInterface $expiration): static
    {
        $this->expiresAt = $expiration;

        return $this;
    }

    /**
     * Sets the expiration time for this cache item.
     *
     * @param int|\DateInterval|null $time The period of time from the present after which the item MUST be considered
     *                                     expired. An integer parameter is understood to be the time in seconds until
     *                                     expiration. If null is passed explicitly, a default value MAY be used.
     *                                     If none is set, the value should be stored permanently or for as long as the
     *                                     implementation allows.
     *
     * @return static The called object
     *
     * @throws NotImplementedException
     *
     * @since 2.0.0
     */
    public function expiresAfter(\DateInterval|int|null $time): static
    {
        throw new NotImplementedException();
    }
}
