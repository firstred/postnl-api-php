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

namespace Firstred\PostNL\Entity\Response;

use ArrayAccess;
use Countable;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\LocationInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Iterator;

/**
 * Class FindNearestLocationsResponse.
 */
final class FindNearestLocationsResponse extends AbstractResponse implements Iterator, ArrayAccess, Countable
{
    /**
     * Iterator index.
     *
     * @var int
     *
     * @since 2.0.0
     */
    private $index = 0;

    /**
     * Locations.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var LocationInterface[]
     *
     * @since   1.0.0
     */
    private $locations = [];

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function jsonSerialize(): array
    {
        $json = [
            'GetLocationsResult' => [
                'ResponseLocation' => $this->locations,
            ],
        ];
        if (!empty($this->warnings)) {
            $json['Warnings'] = $this->warnings;
        }
        if (!empty($this->errors)) {
            $json['Errors'] = $this->errors;
        }

        return $json;
    }

    /**
     * Deserialize JSON.
     *
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @param array $json JSON as associative array
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since        2.0.0
     */
    public static function jsonDeserialize(array $json)
    {
        $object = new static();
        if (isset($json['FindNearestLocationsResponse'])) {
            if (isset($json['FindNearestLocationsResponse']['GetLocationsResult']['ResponseLocation'])) {
                foreach ($json['FindNearestLocationsResponse']['GetLocationsResult']['ResponseLocation'] as $location) {
                    $object[] = Location::jsonDeserialize(['Location' => $location]);
                }
            }
            static::processWarningsAndErrors($object, $json['FindNearestLocationsResponse']);
        }

        return $object;
    }

    /**
     * Get locations.
     *
     * @return LocationInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Location
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    /**
     * Set locations.
     *
     * @pattern N/A
     *
     * @param LocationInterface[]|null $responseLocations
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Location
     */
    public function setLocations(?array $responseLocations = null): FindNearestLocationsResponse
    {
        if (!empty($responseLocations) && !array_values($responseLocations)[0] instanceof Location) {
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid Location array given', __CLASS__, __METHOD__));
        }

        $this->locations = $responseLocations;

        return $this;
    }

    /**
     * Return the current element.
     *
     * @see  https://php.net/manual/en/iterator.current.php
     *
     * @return LocationInterface
     *
     * @since 2.0.0
     */
    public function current(): LocationInterface
    {
        return $this->locations[$this->index];
    }

    /**
     * Move forward to next element.
     *
     * @see  https://php.net/manual/en/iterator.next.php
     *
     * @return void any returned value is ignored
     *
     * @since 2.0.0
     */
    public function next()
    {
        if ($this->offsetExists($this->index + 1)) {
            ++$this->index;
        }
    }

    /**
     * Return the key of the current element.
     *
     * @see  https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     *
     * @since 2.0.0
     */
    public function key()
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->index;
    }

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
    public function valid(): bool
    {
        return isset($this->locations[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see  https://php.net/manual/en/iterator.rewind.php
     *
     * @return void any returned value is ignored
     *
     * @since 2.0.0
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

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
    public function offsetExists($offset): bool
    {
        return isset($this->locations[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed can return all value types
     *
     * @since 2.0.0
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->locations[$offset];
        }

        return null;
    }

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
    public function offsetSet($offset, $value): void
    {
        if (!is_null($offset)) {
            $this->locations[$offset] = $value;
        } else {
            $this->locations[] = $value;
        }
    }

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
    public function offsetUnset($offset): void
    {
        unset($this->locations[$offset]);
    }

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
    public function count(): int
    {
        return count($this->locations);
    }
}
