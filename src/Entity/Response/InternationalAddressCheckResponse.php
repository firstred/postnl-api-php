<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\ValidatedAddress;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class BasicInternationalAddressCheckResponse
 */
class InternationalAddressCheckResponse extends AbstractResponse
{
    /**
     * Iterator index
     *
     * @var int $index
     *
     * @since 2.0.0
     */
    private $index = 0;

    /**
     * Validated addresses
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var ValidatedAddress[] $addresses
     *
     * @since   1.0.0
     */
    protected $addresses = [];

    /**
     * BasicInternationalAddressCheckResponse constructor.
     *
     * @param ValidatedAddress[] $addresses
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function __construct(array $addresses = [])
    {
        parent::__construct();

        $this->setAddresses($addresses);
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function jsonSerialize(): array
    {
        return $this->addresses;
    }

    /**
     * Deserialize JSON
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
        if (isset($json['BasicInternationalAddressCheckResponse'])) {
            foreach ($json['BasicInternationalAddressCheckResponse'] as $key => $address) {
                if (is_numeric($key)) {
                    continue;
                }
                ValidatedAddress::jsonDeserialize(['ValidatedAddress' => $address]);
            }
        }

        return $object;
    }

    /**
     * Get addresses
     *
     * @return ValidatedAddress[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ValidatedAddress
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * Set validated addresses
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param ValidatedAddress[]|null $addresses
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     ValidatedAddress
     */
    public function setAddresses(?array $addresses = null): InternationalAddressCheckResponse
    {
        if (!empty($addresses) && !array_values($addresses)[0] instanceof ValidatedAddress) {
            throw new InvalidArgumentException(sprintf("%s::%s - Invalid ValidatedAddress array given", __CLASS__, __METHOD__));
        }

        $this->addresses = $addresses;

        return $this;
    }

    /**
     * Return the current element
     *
     * @link  https://php.net/manual/en/iterator.current.php
     *
     * @return ValidatedAddress
     *
     * @since 2.0.0
     */
    public function current(): ValidatedAddress
    {
        return $this->addresses[$this->index];
    }

    /**
     * Move forward to next element
     *
     * @link  https://php.net/manual/en/iterator.next.php
     *
     * @return void Any returned value is ignored.
     *
     * @since 2.0.0
     */
    public function next()
    {
        if ($this->offsetExists($this->index + 1)) {
            $this->index++;
        }
    }

    /**
     * Return the key of the current element
     *
     * @link  https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure.
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
     * Checks if current position is valid
     *
     * @link  https://php.net/manual/en/iterator.valid.php
     *
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     *
     * @since 2.0.0
     */
    public function valid(): bool
    {
        return isset($this->addresses[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  https://php.net/manual/en/iterator.rewind.php
     *
     * @return void Any returned value is ignored.
     *
     * @since 2.0.0
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Whether a offset exists
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 2.0.0
     */
    public function offsetExists($offset): bool
    {
        return isset($this->addresses[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     *
     * @since 2.0.0
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->addresses[$offset];
        }

        return null;
    }

    /**
     * Offset to set
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetset.php
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
            $this->addresses[$offset] = $value;
        } else {
            $this->addresses[] = $value;
        }
    }

    /**
     * Offset to unset
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
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
        unset($this->addresses[$offset]);
    }

    /**
     * Count elements of an object
     *
     * @link  https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     *
     * @since 2.0.0
     */
    public function count(): int
    {
        return count($this->addresses);
    }
}
