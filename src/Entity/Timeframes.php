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

namespace Firstred\PostNL\Entity;

use ArrayAccess;
use Countable;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Iterator;

/**
 * Class Timeframes
 */
class Timeframes extends AbstractEntity implements Iterator, ArrayAccess, Countable
{
    /**
     * @var int $index
     *
     * @since 2.0.0
     */
    private $index;

    /**
     * List of Timeframes
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Timeframe[] $timeframes
     *
     * @since   2.0.0
     */
    protected $timeframes = [];

    /**
     * Timeframes constructor.
     *
     * @param array $timeframes
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(array $timeframes = [])
    {
        parent::__construct();

        $this->setTimeframes($timeframes);
    }

    /**
     * Get Timeframes
     *
     * @return Timeframe[]|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   Timeframe
     */
    public function getTimeframes(): ?array
    {
        return $this->timeframes;
    }

    /**
     * Set Timeframes
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param Timeframe[]|null $timeframes
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     Timeframe
     */
    public function setTimeframes(?array $timeframes): Timeframes
    {
        $this->timeframes = $timeframes;

        return $this;
    }

    /**
     * Serialize JSON
     *
     * @return array
     *
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        // Group timeframes first
        $array = ['Timeframe' => []];
        foreach ($this->timeframes as $timeframe) {
            if (!isset($array['Timeframe'][$timeframe->getDate()])) {
                $array['Timeframe'][$timeframe->getDate()] = [
                    'Date'       => $timeframe->getDate(),
                    'Timeframes' => [
                        [
                            'From'    => $timeframe->getFrom(),
                            'Options' => $timeframe->getOptions(),
                            'To'      => $timeframe->getTo(),
                        ],
                    ],
                ];
            } else {
                $array['Timeframe'][$timeframe->getDate()]['Timeframes'][] = [
                    'From'    => $timeframe->getFrom(),
                    'Options' => $timeframe->getOptions(),
                    'To'      => $timeframe->getTo(),
                ];
            }
        }
        $array['Timeframe'] = array_values($array['Timeframe']);
        foreach ($array['Timeframe'] as &$timeframe) {
            if (count($timeframe['Timeframes']) === 1) {
                $timeframe['Timeframes'] = ['TimeframeTimeFrame' => $timeframe['Timeframes'][0]];
            } else {
                $timeframe['Timeframes'] = ['TimeframeTimeFrame' => $timeframe['Timeframes']];
            }
        }

        return $array;
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
        if (isset($json['Timeframes']['Timeframe'])) {
            if (isset($json['Timeframes']['Timeframe']['Date'])) {
                $mainframes = [$json['Timeframes']['Timeframe']];
            } else {
                $mainframes = $json['Timeframes']['Timeframe'];
            }
            foreach ($mainframes as $mainframe) {
                if (!isset($mainframe['Timeframes']['TimeframeTimeFrame'])) {
                    continue;
                }
                if (isset($mainframe['Timeframes']['TimeframeTimeFrame']['From'])) {
                    $object[] = Timeframe::jsonDeserialize(['TimeFrame' => ['Date' => $mainframe['Date']] + $mainframe['Timeframes']['TimeframeTimeFrame']]);
                } else {
                    foreach ($mainframe['Timeframes']['TimeframeTimeFrame'] as $timeframe) {
                        $object[] = Timeframe::jsonDeserialize(['Timeframe' => ['Date' => $mainframe['Date']] + $timeframe]);
                    }
                }
            }
        }

        return $object;
    }

    /**
     * Return the current element
     *
     * @link  https://php.net/manual/en/iterator.current.php
     *
     * @return mixed Can return any type.
     *
     * @since 2.0.0
     */
    public function current(): Timeframe
    {
        return $this->timeframes[$this->index];
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
    public function next(): void
    {
        if (isset($this->timeframes[$this->index + 1])) {
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
    public function key(): ?int
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
        return isset($this->timeframes[$this->index]);
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
    public function rewind()
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
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     *
     * @since 2.0.0
     */
    public function offsetExists($offset): bool
    {
        return isset($this->timeframes[$offset]);
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
     * @return Timeframe|null
     *
     * @since 2.0.0
     */
    public function offsetGet($offset): ?Timeframe
    {
        if ($this->offsetExists($offset)) {
            return $this->timeframes[$offset];
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
            $this->timeframes[$offset] = $value;
        } else {
            $this->timeframes[] = $value;
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
        unset($this->timeframes[$offset]);
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
    public function count()
    {
        return count($this->timeframes);
    }
}
