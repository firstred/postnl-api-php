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
 * Class CutOffTime.
 */
interface CutOffTimeInterface extends EntityInterface
{
    /**
     * Get the day of the week.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   CutOffTime::$day
     */
    public function getDay(): ?string;

    /**
     * Set the day of the week.
     *
     * @pattern ^\d{2}$
     *
     * @param string|int|float|null $dayOfTheWeek
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 02
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     CutOffTime::$day
     */
    public function setDay($dayOfTheWeek): CutOffTimeInterface;

    /**
     * Get cut-off time.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   CutOffTime::$time
     */
    public function getTime(): ?string;

    /**
     * Set cut-off time.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $time
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 14:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     CutOffTime::$time
     */
    public function setTime(?string $time): CutOffTimeInterface;

    /**
     * Get availability status.
     *
     * @return bool|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   CutOffTime::$available
     */
    public function getAvailable(): ?bool;

    /**
     * Set availability status.
     *
     * @pattern N/A
     *
     * @param bool|null $available
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     CutOffTime::$available
     */
    public function setAvailable(?bool $available): CutOffTimeInterface;

    /**
     * Get type.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CutOffTime::$type
     */
    public function getType(): ?string;

    /**
     * Set type.
     *
     * @pattern ^?(?:Regular|Sameday)$
     *
     * @param string|null $type
     *
     * @return static
     *
     * @example Sameday
     *
     * @since   2.0.0
     * @see     CutOffTime::$type
     */
    public function setType(?string $type): CutOffTimeInterface;
}
