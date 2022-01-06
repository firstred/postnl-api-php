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

namespace Firstred\PostNL\Entity;

use ArrayAccess;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Iterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use stdClass;
use function is_numeric;
use function is_string;

/**
 * Class OpeningHours.
 *
 * @method array|null  getMonday()
 * @method array|null  getTuesday()
 * @method array|null  getWednesday()
 * @method array|null  getThursday()
 * @method array|null  getFriday()
 * @method array|null  getSaturday()
 * @method array|null  getSunday()
 * @method OpeningHours setMonday(string|array|null $Monday = null)
 * @method OpeningHours setTuesday(string|array|null $Tuesday = null)
 * @method OpeningHours setWednesday(string|array|null $Wednesday = null)
 * @method OpeningHours setThursday(string|array|null $Thursday = null)
 * @method OpeningHours setFriday(string|array|null $Friday = null)
 * @method OpeningHours setSaturday(string|array|null $Saturday = null)
 * @method OpeningHours setSunday(string|array|null $Sunday = null)
 *
 * @since 1.0.0
 */
class OpeningHours extends AbstractEntity implements ArrayAccess, Iterator
{
    private $currentDay = 0;

    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode'        => [
            'Monday'    => BarcodeService::DOMAIN_NAMESPACE,
            'Tuesday'   => BarcodeService::DOMAIN_NAMESPACE,
            'Wednesday' => BarcodeService::DOMAIN_NAMESPACE,
            'Thursday'  => BarcodeService::DOMAIN_NAMESPACE,
            'Friday'    => BarcodeService::DOMAIN_NAMESPACE,
            'Saturday'  => BarcodeService::DOMAIN_NAMESPACE,
            'Sunday'    => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Monday'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Tuesday'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Wednesday' => ConfirmingService::DOMAIN_NAMESPACE,
            'Thursday'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Friday'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Saturday'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Sunday'    => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Monday'    => LabellingService::DOMAIN_NAMESPACE,
            'Tuesday'   => LabellingService::DOMAIN_NAMESPACE,
            'Wednesday' => LabellingService::DOMAIN_NAMESPACE,
            'Thursday'  => LabellingService::DOMAIN_NAMESPACE,
            'Friday'    => LabellingService::DOMAIN_NAMESPACE,
            'Saturday'  => LabellingService::DOMAIN_NAMESPACE,
            'Sunday'    => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Monday'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Tuesday'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Wednesday' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Thursday'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Friday'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Saturday'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Sunday'    => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Monday'    => LocationService::DOMAIN_NAMESPACE,
            'Tuesday'   => LocationService::DOMAIN_NAMESPACE,
            'Wednesday' => LocationService::DOMAIN_NAMESPACE,
            'Thursday'  => LocationService::DOMAIN_NAMESPACE,
            'Friday'    => LocationService::DOMAIN_NAMESPACE,
            'Saturday'  => LocationService::DOMAIN_NAMESPACE,
            'Sunday'    => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Monday'    => TimeframeService::DOMAIN_NAMESPACE,
            'Tuesday'   => TimeframeService::DOMAIN_NAMESPACE,
            'Wednesday' => TimeframeService::DOMAIN_NAMESPACE,
            'Thursday'  => TimeframeService::DOMAIN_NAMESPACE,
            'Friday'    => TimeframeService::DOMAIN_NAMESPACE,
            'Saturday'  => TimeframeService::DOMAIN_NAMESPACE,
            'Sunday'    => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|array|null */
    protected $Monday = null;
    /** @var string|array|null */
    protected $Tuesday = null;
    /** @var string|array|null */
    protected $Wednesday = null;
    /** @var string|array|null */
    protected $Thursday = null;
    /** @var string|array|null */
    protected $Friday = null;
    /** @var string|array|null */
    protected $Saturday = null;
    /** @var string|array|null */
    protected $Sunday = null;
    // @codingStandardsIgnoreEnd

    /**
     * OpeningHours constructor.
     *
     * @param string|array|null $Monday
     * @param string|array|null $Tuesday
     * @param string|array|null $Wednesday
     * @param string|array|null $Thursday
     * @param string|array|null $Friday
     * @param string|array|null $Saturday
     * @param string|array|null $Sunday
     */
    public function __construct(
        $Monday = null,
        $Tuesday = null,
        $Wednesday = null,
        $Thursday = null,
        $Friday = null,
        $Saturday = null,
        $Sunday = null
    ) {
        parent::__construct();

        $this->setMonday($Monday);
        $this->setTuesday($Tuesday);
        $this->setWednesday($Wednesday);
        $this->setThursday($Thursday);
        $this->setFriday($Friday);
        $this->setSaturday($Saturday);
        $this->setSunday($Sunday);
    }

    /**
     * Deserialize opening hours
     *
     * @param stdClass $json
     *
     * @return OpeningHours
     *
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public static function jsonDeserialize(stdClass $json)
    {
        if (!isset($json->OpeningHours)) {
            return parent::jsonDeserialize($json);
        }

        /** @var OpeningHours $openingHours */
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

            if (is_array($json->OpeningHours->$day)) {
                foreach ($json->OpeningHours->$day as $item) {
                    if (isset($item->string)) {
                        $openingHours->{$day}[] = $item->string;
                    } elseif (is_string($item)) {
                        $openingHours->{$day}[] = $item;
                    } elseif (is_array($item)) {
                        $openingHours->$day = array_merge($openingHours->$day, $item);
                    } else {
                        throw new NotSupportedException('Unable to parse opening hours');
                    }
                }
            } elseif (isset($json->OpeningHours->$day->string)) {
                $openingHours->{$day}[] = $json->OpeningHours->$day->string;
            } elseif (is_string($json->OpeningHours->$day)) {
                $openingHours->{$day}[] = $json->OpeningHours->$day;
            }

            $openingHoursIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($openingHours->$day));
            $newTimes = [];
            foreach ($openingHoursIterator as $time) {
                if (!is_string($time)) {
                    throw new NotSupportedException('Unable to parse opening hours');
                }
                $timeParts = explode('-', $time);
                if (2 !== count($timeParts)) {
                    throw new NotSupportedException("Unable to handle time format $time");
                }

                foreach ($timeParts as &$timePart) {
                    if (preg_match('~^(([0-1][0-9]|2[0-3]):[0-5][0-9])$~', $timePart)) {
                        $timePart = "$timePart:00";
                    } elseif (!preg_match('~^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$~', $timePart)) {
                        throw new NotSupportedException("Unable to handle time format $time");
                    }
                }
                $newTimes[] = implode('-', $timeParts);
            }
            $openingHours->$day = $newTimes;
        }

        return $openingHours;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach (array_keys(static::$defaultProperties['Barcode']) as $property) {
            if (isset($this->$property)) {
                $array[$property] = $this->$property;
            }
        }

        return $array;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     *
     * @since 1.2.0
     */
    public function offsetExists($offset)
    {
        // Access as $openingHours['Monday']
        return isset($this->$offset);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function offsetGet($offset)
    {
        // Always return an array when accessing this object as an array
        if ($this->offsetExists($offset)) {
            $timeframes = $this->$offset;
            if (null === $timeframes) {
                return [];
            }
            return $timeframes;
        }

        if (is_int($offset) || is_float($offset) || is_string($offset)) {
            throw new InvalidArgumentException("Given offset $offset does not exist");
        }

        throw new InvalidArgumentException("Given offset does not exist");
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @since 1.2.0
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $this->{"set$offset"}($value);
        }
    }

    /**
     * @param mixed $offset
     *
     * @since 1.2.0
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
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
    #[\ReturnTypeWillChange]
    public function current()
    {
        if (!$this->valid()) {
            throw new InvalidArgumentException('Offset does not exist');
        }

        return $this->{"get".static::findCurrentDayString($this->currentDay)}();
    }

    /**
     * @since 1.2.0
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        ++$this->currentDay;
    }

    /**
     * @return string
     *
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return static::findCurrentDayString($this->currentDay);
    }

    /**
     * @return bool
     *
     * @since 1.2.0
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        try {
            static::findCurrentDayString($this->currentDay);
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        } catch (NotSupportedException $e) {
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
     * @param mixed $currentDay
     *
     * @return string
     *
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    private static function findCurrentDayString($currentDay)
    {
        if (!is_numeric($currentDay)) {
            throw new NotSupportedException("Given current day is not a number");
        }

        $days = array_keys(static::$defaultProperties['Barcode']);

        if (!isset($days)) {
            throw new InvalidArgumentException('Invalid current day offset');
        }

        return $days[$currentDay];
    }
}
