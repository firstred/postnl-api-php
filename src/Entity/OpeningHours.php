<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Entity;

use ArrayAccess;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Attribute\SerializableStringArrayProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Iterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use stdClass;
use TypeError;
use function is_numeric;
use function is_string;

/**
 * @since 1.0.0
 */
class OpeningHours extends AbstractEntity implements ArrayAccess, Iterator
{
    private int $currentDay = 0;

    /** @var string[]|null $Monday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Monday = null;

    /** @var string[]|null $Tuesday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Tuesday = null;

    /** @var string[]|null $Wednesday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Wednesday = null;

    /** @var string[]|null $Thursday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Thursday = null;

    /** @var string[]|null $Friday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Friday = null;

    /** @var string[]|null $Saturday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Saturday = null;

    /** @var string[]|null $Sunday */
    #[SerializableProperty(isArray: true, namespace: SoapNamespace::Domain, type: 'string')]
    protected array|null $Sunday = null;

    /**
     * @param array|null $Monday
     * @param array|null $Tuesday
     * @param array|null $Wednesday
     * @param array|null $Thursday
     * @param array|null $Friday
     * @param array|null $Saturday
     * @param array|null $Sunday
     */
    public function __construct(
        /** @param string[]|null $Monday */
        array|null $Monday = null,
        /** @param string[]|null $Tuesday */
        array|null $Tuesday = null,
        /** @param string[]|null $Wednesday */
        array|null $Wednesday = null,
        /** @param string[]|null $Thursday */
        array|null $Thursday = null,
        /** @param string[]|null $Friday */
        array|null $Friday = null,
        /** @param string[]|null $Saturday */
        array|null $Saturday = null,
        /** @param string[]|null $Sunday */
        array|null $Sunday = null,
    ) {
        parent::__construct();

        $this->setMonday(Monday: $Monday);
        $this->setTuesday(Tuesday: $Tuesday);
        $this->setWednesday(Wednesday: $Wednesday);
        $this->setThursday(Thursday: $Thursday);
        $this->setFriday(Friday: $Friday);
        $this->setSaturday(Saturday: $Saturday);
        $this->setSunday(Sunday: $Sunday);
    }

    /**
     * @return array|null
     */
    public function getMonday(): array|null
    {
        return $this->Monday;
    }

    /**
     * @param array|null $Monday
     *
     * @return OpeningHours
     */
    public function setMonday(array|null $Monday): static
    {
        $this->Monday = $Monday;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getTuesday(): array|null
    {
        return $this->Tuesday;
    }

    /**
     * @param array|null $Tuesday
     *
     * @return OpeningHours
     */
    public function setTuesday(array|null $Tuesday): static
    {
        $this->Tuesday = $Tuesday;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getWednesday(): array|null
    {
        return $this->Wednesday;
    }

    /**
     * @param array|null $Wednesday
     *
     * @return OpeningHours
     */
    public function setWednesday(array|null $Wednesday): static
    {
        $this->Wednesday = $Wednesday;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getThursday(): array|null
    {
        return $this->Thursday;
    }

    /**
     * @param array|null $Thursday
     *
     * @return OpeningHours
     */
    public function setThursday(array|null $Thursday): static
    {
        $this->Thursday = $Thursday;

        return $this;
    }

    /**
     * @return array|string|null
     */
    public function getFriday(): array|string|null
    {
        return $this->Friday;
    }

    /**
     * @param array|null $Friday
     *
     * @return OpeningHours
     */
    public function setFriday(array|null $Friday): static
    {
        $this->Friday = $Friday;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSaturday(): array|null
    {
        return $this->Saturday;
    }

    /**
     * @param array|null $Saturday
     *
     * @return OpeningHours
     */
    public function setSaturday(array|null $Saturday): static
    {
        $this->Saturday = $Saturday;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSunday(): array|null
    {
        return $this->Sunday;
    }

    /**
     * @param array|null $Sunday
     *
     * @return OpeningHours
     */
    public function setSunday(array|null $Sunday): static
    {
        $this->Sunday = $Sunday;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return OpeningHours
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws NotSupportedException
     * @since 1.0.0
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        if (!isset($json->OpeningHours)) {
            return parent::jsonDeserialize(json: $json);
        }

        $openingHours = self::create();
        foreach (
            [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday',
            ] as $day
        ) {
            $openingHours->$day = [];
            if (!isset($json->OpeningHours->$day)) {
                continue;
            }

            if (is_array(value: $json->OpeningHours->$day)) {
                foreach ($json->OpeningHours->$day as $item) {
                    if (isset($item->string)) {
                        $openingHours->{$day}[] = $item->string;
                    } elseif (is_string(value: $item)) {
                        $openingHours->{$day}[] = $item;
                    } elseif (is_array(value: $item)) {
                        $openingHours->$day = array_merge($openingHours->$day, $item);
                    } else {
                        throw new NotSupportedException(message: 'Unable to parse opening hours');
                    }
                }
            } elseif (isset($json->OpeningHours->$day->string)) {
                $openingHours->{$day}[] = $json->OpeningHours->$day->string;
            } elseif (is_string(value: $json->OpeningHours->$day)) {
                $openingHours->{$day}[] = $json->OpeningHours->$day;
            }

            $openingHoursIterator = new RecursiveIteratorIterator(iterator: new RecursiveArrayIterator(array: $openingHours->$day));
            $newTimes = [];
            foreach ($openingHoursIterator as $time) {
                if (!is_string(value: $time)) {
                    throw new NotSupportedException(message: 'Unable to parse opening hours');
                }
                $timeParts = explode(separator: '-', string: $time);
                if (2 !== count(value: $timeParts)) {
                    throw new NotSupportedException(message: "Unable to handle time format $time");
                }

                foreach ($timeParts as &$timePart) {
                    if (preg_match(pattern: '~^(([0-1][0-9]|2[0-3]):[0-5][0-9])$~', subject: $timePart)) {
                        $timePart = "$timePart:00";
                    } elseif (!preg_match(pattern: '~^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$~', subject: $timePart)) {
                        throw new NotSupportedException(message: "Unable to handle time format $time");
                    }
                }
                $newTimes[] = implode(separator: '-', array: $timeParts);
            }
            $openingHours->$day = $newTimes;
        }

        return $openingHours;
    }

    /**
     * @return array{Monday: string[], Tuesday: string[], Wednesday: string[], Thursday: string[], Friday: string[], Saturday: string[], Sunday: string[]}
     */
    public function toArray(): array
    {
        $array = [];
        foreach (array_keys(array: $this->getSerializableProperties()) as $property) {
            if (isset($this->$property)) {
                $array[$property] = $this->$property;
            }
        }

        return $array;
    }

    /**
     * @since 1.2.0
     */
    public function offsetExists(mixed $offset): bool
    {
        if (!is_string(value: $offset)) {
            throw new TypeError(message: 'Expected a string');
        }

        // Access as $openingHours['Monday']
        return isset($this->$offset);
    }

    /**
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function offsetGet(mixed $offset): mixed
    {
        // Always return an array when accessing this object as an array
        if ($this->offsetExists(offset: $offset)) {
            $timeframes = $this->$offset;
            if (null === $timeframes) {
                return [];
            }

            return $timeframes;
        }

        if (is_int(value: $offset) || is_float(value: $offset) || is_string(value: $offset)) {
            throw new InvalidArgumentException(message: "Given offset $offset does not exist");
        }

        throw new InvalidArgumentException(message: "Given offset does not exist");
    }

    /**
     * @since 1.2.0
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($this->offsetExists(offset: $offset)) {
            $this->{"set$offset"}($value);
        }
    }

    /**
     * @since 1.2.0
     */
    public function offsetUnset(mixed $offset): void
    {
        if ($this->offsetExists(offset: $offset)) {
            unset($this->$offset);
        }
    }

    /**
     * @return mixed
     *
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function current(): mixed
    {
        if (!$this->valid()) {
            throw new InvalidArgumentException(message: 'Offset does not exist');
        }

        return $this->{"get".static::findCurrentDayString(currentDay: $this->currentDay)}();
    }

    /**
     * @since 1.2.0
     */
    public function next(): void
    {
        ++$this->currentDay;
    }

    /**
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    #[\ReturnTypeWillChange]
    public function key(): string
    {
        return static::findCurrentDayString(currentDay: $this->currentDay);
    }

    /**
     * @return bool
     *
     * @since 1.2.0
     */
    public function valid(): bool
    {
        try {
            static::findCurrentDayString(currentDay: $this->currentDay);

            return true;
        } catch (InvalidArgumentException|NotSupportedException) {
            return false;
        }
    }

    /**
     * @since 1.2.0
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->currentDay = 0;
    }

    /**
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    private static function findCurrentDayString(string|int $currentDay): string
    {
        if (!is_numeric(value: $currentDay)) {
            throw new NotSupportedException(message: "Given current day is not a number");
        }

        $days = array_keys(array: static::$defaultProperties['Barcode']);

        if (!isset($days)) {
            throw new InvalidArgumentException(message: 'Invalid current day offset');
        }

        return $days[$currentDay];
    }
}
