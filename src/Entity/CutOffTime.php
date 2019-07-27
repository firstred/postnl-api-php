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
 * Class CutOffTime
 */
class CutOffTime extends AbstractEntity
{
    /**
     * Day
     *
     * Number of the day of the week. 01 = Monday, 02 =
     * Tuesday, …, 07 = Sunday. It is also possible to use value 00 to specify a generic cut off time for all days.
     *
     * @pattern ^\d{2}$
     *
     * @example 02
     *
     * @var string|null $day
     *
     * @since 1.0.0
     */
    protected $day;

    /**
     * Time
     *
     * The cut off time for this day of week.
     * Format: H:i:s
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 14:00:00
     *
     * @var string|null $time
     *
     * @since 1.0.0
     */
    protected $time;

    /**
     * Available
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null $available
     *
     * @since 1.0.0
     */
    protected $available;

    /**
     * CutOffTime constructor.
     *
     * @param string $day
     * @param string $time
     * @param bool   $available
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct($day = null, $time = null, $available = null)
    {
        parent::__construct();

        $this->setDay($day);
        $this->setTime($time);
        $this->setAvailable($available);
    }

    /**
     * Get the day of the week
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CutOffTime::$day
     */
    public function getDay(): ?string
    {
        return $this->day;
    }

    /**
     * Set the day of the week
     *
     * @pattern ^\d{2}$
     *
     * @param string|int|float|null $dayOfTheWeek
     *
     * @return static
     *
     * @throws ReflectionException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @example 02
     *
     * @see     CutOffTime::$day
     */
    public function setDay($dayOfTheWeek): CutOffTime
    {
        $this->day = ValidateAndFix::dayOfTheWeek($dayOfTheWeek);

        return $this;
    }

    /**
     * Get cut-off time
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CutOffTime::$time
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * Set cut-off time
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $time
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 14:00:00
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CutOffTime::$time
     */
    public function setTime(?string $time): CutOffTime
    {
        $this->time = ValidateAndFix::time($time);

        return $this;
    }

    /**
     * Get availability status
     *
     * @return bool|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CutOffTime::$available
     */
    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    /**
     * Set availability status
     *
     * @pattern N/A
     *
     * @param bool|null $available
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CutOffTime::$available
     */
    public function setAvailable(?bool $available): CutOffTime
    {
        $this->available = $available;

        return $this;
    }
}
