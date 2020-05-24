<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

/**
 * Class Locations.
 */
interface LocationsInterface extends EntityInterface
{
    /**
     * Get Locations.
     *
     * @return LocationInterface[]|null
     *
     * @since 2.0.0
     * @see   Location
     */
    public function getLocations(): ?array;

    /**
     * Set Locations.
     *
     * @pattern N/A
     *
     * @param LocationInterface[]|null $locations
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     Location
     */
    public function setLocations(?array $locations): LocationsInterface;

    /**
     * Serialize JSON.
     *
     * @return array
     *
     * @since 2.0.0
     */
    public function jsonSerialize(): array;

    /**
     * Return the current element.
     *
     * @see  https://php.net/manual/en/iterator.current.php
     *
     * @return mixed can return any type
     *
     * @since 2.0.0
     */
    public function current(): LocationInterface;

    /**
     * Move forward to next element.
     *
     * @see  https://php.net/manual/en/iterator.next.php
     *
     * @return void any returned value is ignored
     *
     * @since 2.0.0
     */
    public function next(): void;

    /**
     * Return the key of the current element.
     *
     * @see  https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     *
     * @since 2.0.0
     */
    public function key(): ?int;

    /**
     * Checks if current position is valid.
     *
     * @see  https://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     *
     * @since 2.0.0
     */
    public function valid(): bool;

    /**
     * Rewind the Iterator to the first element.
     *
     * @see  https://php.net/manual/en/iterator.rewind.php
     *
     * @return void any returned value is ignored
     *
     * @since 2.0.0
     */
    public function rewind();

    /**
     * Whether a offset exists.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     *
     * @since 2.0.0
     */
    public function offsetExists($offset): bool;

    /**
     * Offset to retrieve.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return LocationInterface|null
     *
     * @since 2.0.0
     */
    public function offsetGet($offset): ?LocationInterface;

    /**
     * Offset to set.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     *
     * @since 2.0.0
     */
    public function offsetSet($offset, $value): void;

    /**
     * Offset to unset.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     *
     * @since 2.0.0
     */
    public function offsetUnset($offset): void;

    /**
     * Count elements of an object.
     *
     * @see  https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     *             </p>
     *             <p>
     *             The return value is cast to an integer.
     *
     * @since 2.0.0
     */
    public function count();
}
