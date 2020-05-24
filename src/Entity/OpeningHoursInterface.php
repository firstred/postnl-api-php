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
interface OpeningHoursInterface extends EntityInterface
{
    /**
     * Get Monday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$monday
     */
    public function getMonday(): array;

    /**
     * Set Monday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $monday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$monday
     */
    public function setMonday(array $monday): OpeningHoursInterface;

    /**
     * Get Tuesday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$tuesday
     */
    public function getTuesday(): array;

    /**
     * Set Tuesday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $tuesday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$tuesday
     */
    public function setTuesday(array $tuesday): OpeningHoursInterface;

    /**
     * Get Wednesday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$wednesday
     */
    public function getWednesday(): array;

    /**
     * Set Wednesday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $wednesday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$wednesday
     */
    public function setWednesday(array $wednesday): OpeningHoursInterface;

    /**
     * Get Thursday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$thursday
     */
    public function getThursday(): array;

    /**
     * Set Thursday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $thursday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$thursday
     */
    public function setThursday(array $thursday): OpeningHoursInterface;

    /**
     * Get Friday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$friday
     */
    public function getFriday(): array;

    /**
     * Set Friday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $friday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$friday
     */
    public function setFriday(array $friday): OpeningHoursInterface;

    /**
     * Get Saturday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$saturday
     */
    public function getSaturday(): array;

    /**
     * Set Saturday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $saturday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$saturday
     */
    public function setSaturday(array $saturday): OpeningHoursInterface;

    /**
     * Get Sunday.
     *
     * @return string[]
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   OpeningHours::$sunday
     */
    public function getSunday(): array;

    /**
     * Set Sunday.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string[] $sunday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 08:00-17:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     OpeningHours::$sunday
     */
    public function setSunday(array $sunday): OpeningHoursInterface;
}
