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

use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class OpeningHours
 */
class OpeningHours extends AbstractEntity
{
    /**
     * Monday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $monday
     *
     * @since 1.0.0
     */
    protected $monday = '';

    /**
     * Tuesday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $tuesday
     *
     * @since 1.0.0
     */
    protected $tuesday = '';

    /**
     * Wednesday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $wednesday
     *
     * @since 1.0.0
     */
    protected $wednesday = '';

    /**
     * Thursday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $thursday
     *
     * @since 1.0.0
     */
    protected $thursday = '';

    /**
     * Friday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $friday
     *
     * @since 1.0.0
     */
    protected $friday = '';

    /**
     * Saturday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $saturday
     *
     * @since 1.0.0
     */
    protected $saturday = '';

    /**
     * Sunday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 08:00-17:00
     *
     * @var string|null $sunday
     *
     * @since 1.0.0
     */
    protected $sunday = '';

    /**
     * OpeningHours constructor.
     *
     * @param string|null $monday
     * @param string|null $tuesday
     * @param string|null $wednesday
     * @param string|null $thursday
     * @param string|null $friday
     * @param string|null $saturday
     * @param string|null $sunday
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $monday = null, ?string $tuesday = null, ?string $wednesday = null, ?string $thursday = null, ?string $friday = null, ?string $saturday = null, ?string $sunday = null)
    {
        parent::__construct();

        $this->setMonday($monday);
        $this->setTuesday($tuesday);
        $this->setWednesday($wednesday);
        $this->setThursday($thursday);
        $this->setFriday($friday);
        $this->setSaturday($saturday);
        $this->setSunday($sunday);
    }

    /**
     * @return array
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function toArray(): array
    {
        $array = [];
        foreach (array_keys(get_class_vars(static::class)) as $property) {
            if (isset($this->{$property})) {
                $array[$property] = $this->{$property};
            }
        }

        return $array;
    }

    /**
     * Get Monday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$monday
     */
    public function getMonday(): ?string
    {
        return $this->monday;
    }

    /**
     * Set Monday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $monday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OpeningHours::$monday
     */
    public function setMonday(?string $monday): OpeningHours
    {
        $this->monday = ValidateAndFix::timeRangeShort($monday);

        return $this;
    }

    /**
     * Get Tuesday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$tuesday
     */
    public function getTuesday(): ?string
    {
        return $this->tuesday;
    }

    /**
     * Set Tuesday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $tuesday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OpeningHours::$tuesday
     */
    public function setTuesday(?string $tuesday): OpeningHours
    {
        $this->tuesday = ValidateAndFix::timeRangeShort($tuesday);

        return $this;
    }

    /**
     * Get Wednesday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$wednesday
     */
    public function getWednesday(): ?string
    {
        return $this->wednesday;
    }

    /**
     * Set Wednesday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $wednesday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OpeningHours::$wednesday
     */
    public function setWednesday(?string $wednesday): OpeningHours
    {
        $this->wednesday = ValidateAndFix::timeRangeShort($wednesday);

        return $this;
    }

    /**
     * Get Thursday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$thursday
     */
    public function getThursday(): ?string
    {
        return $this->thursday;
    }

    /**
     * Set Thursday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $thursday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OpeningHours::$thursday
     */
    public function setThursday(?string $thursday): OpeningHours
    {
        $this->thursday = ValidateAndFix::timeRangeShort($thursday);

        return $this;
    }

    /**
     * Get Friday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$friday
     */
    public function getFriday(): ?string
    {
        return $this->friday;
    }

    /**
     * Set Friday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $friday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     OpeningHours::$friday
     */
    public function setFriday(?string $friday): OpeningHours
    {
        $this->friday = ValidateAndFix::timeRangeShort($friday);

        return $this;
    }

    /**
     * Get Saturday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$saturday
     */
    public function getSaturday(): ?string
    {
        return $this->saturday;
    }

    /**
     * Set Saturday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $saturday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OpeningHours::$saturday
     */
    public function setSaturday(?string $saturday): OpeningHours
    {
        $this->saturday = ValidateAndFix::timeRangeShort($saturday);

        return $this;
    }

    /**
     * Get Sunday
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   OpeningHours::$sunday
     */
    public function getSunday(): ?string
    {
        return $this->sunday;
    }

    /**
     * Set Sunday
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $sunday
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     OpeningHours::$sunday
     */
    public function setSunday(?string $sunday): OpeningHours
    {
        $this->sunday = ValidateAndFix::timeRangeShort($sunday);

        return $this;
    }
}
