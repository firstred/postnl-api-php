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

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class OpeningHours.
 */
final class OpeningHours extends AbstractEntity implements OpeningHoursInterface
{
    /**
     * Monday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $monday = [];

    /**
     * Tuesday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $tuesday = [];

    /**
     * Wednesday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $wednesday = [];

    /**
     * Thursday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $thursday = [];

    /**
     * Friday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $friday = [];

    /**
     * Saturday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $saturday = [];

    /**
     * Sunday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var array
     *
     * @since   1.0.0
     */
    private $sunday = [];

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
        if (isset($json['OpeningHours'])) {
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                if (isset($json['OpeningHours'][$day]['string'])) {
                    $object->{"set$day"}(is_array($json['OpeningHours'][$day]['string']) ? $json['OpeningHours'][$day]['string'] : [$json['OpeningHours'][$day]['string']]);
                }
            }
        }

        return $object;
    }

    /**
     * Get Monday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$monday
     */
    public function getMonday(): array
    {
        return $this->monday;
    }

    /**
     * Set Monday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $monday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$monday
     */
    public function setMonday(array $monday): OpeningHoursInterface
    {
        $this->monday = [];
        foreach ($monday as $openingHour) {
            $this->monday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }

    /**
     * Get Tuesday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$tuesday
     */
    public function getTuesday(): array
    {
        return $this->tuesday;
    }

    /**
     * Set Tuesday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $tuesday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$tuesday
     */
    public function setTuesday(array $tuesday): OpeningHoursInterface
    {
        $this->tuesday = [];
        foreach ($tuesday as $openingHour) {
            $this->tuesday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }

    /**
     * Get Wednesday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$wednesday
     */
    public function getWednesday(): array
    {
        return $this->wednesday;
    }

    /**
     * Set Wednesday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $wednesday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$wednesday
     */
    public function setWednesday(array $wednesday): OpeningHoursInterface
    {
        $this->wednesday = [];
        foreach ($wednesday as $openingHour) {
            $this->wednesday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }

    /**
     * Get Thursday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$thursday
     */
    public function getThursday(): array
    {
        return $this->thursday;
    }

    /**
     * Set Thursday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $thursday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$thursday
     */
    public function setThursday(array $thursday): OpeningHoursInterface
    {
        $this->thursday = [];
        foreach ($thursday as $openingHour) {
            $this->thursday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }

    /**
     * Get Friday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$friday
     */
    public function getFriday(): array
    {
        return $this->friday;
    }

    /**
     * Set Friday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $friday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$friday
     */
    public function setFriday(array $friday): OpeningHoursInterface
    {
        $this->friday = [];
        foreach ($friday as $openingHour) {
            $this->friday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }

    /**
     * Get Saturday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$saturday
     */
    public function getSaturday(): array
    {
        return $this->saturday;
    }

    /**
     * Set Saturday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $saturday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$saturday
     */
    public function setSaturday(array $saturday): OpeningHoursInterface
    {
        $this->saturday = [];
        foreach ($saturday as $openingHour) {
            $this->saturday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }

    /**
     * Get Sunday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$sunday
     */
    public function getSunday(): array
    {
        return $this->sunday;
    }

    /**
     * Set Sunday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $sunday
     *
     * @return OpeningHoursInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$sunday
     */
    public function setSunday(array $sunday): OpeningHoursInterface
    {
        $this->sunday = [];
        foreach ($sunday as $openingHour) {
            $this->sunday[] = $this->validate->timeRangeShort($openingHour);
        }

        return $this;
    }
}
