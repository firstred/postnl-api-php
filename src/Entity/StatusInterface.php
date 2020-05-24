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
 * Class Status.
 */
interface StatusInterface extends EntityInterface
{
    /**
     * Get timestamp.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Status::$timeStamp
     */
    public function getTimeStamp(): ?string;

    /**
     * Set timestamp.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $timeStamp
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 08:00:00
     *
     * @since   2.0.0 Strict typing
     * @see     Status::$timeStamp
     */
    public function setTimeStamp(?string $timeStamp): StatusInterface;

    /**
     * Get status code.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Status::$statusCode
     */
    public function getStatusCode(): ?string;

    /**
     * Set status code.
     *
     * @pattern ^\d{1,10}$
     *
     * @param string|null $statusCode
     *
     * @return static
     *
     * @example 7
     *
     * @since   2.0.0 Strict typing
     * @see     Status::$statusCode
     */
    public function setStatusCode(?string $statusCode): StatusInterface;

    /**
     * Get status description.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Status::$statusDescription
     */
    public function getStatusDescription(): ?string;

    /**
     * Set status description.
     *
     * @pattern ^.{0,1000}$
     *
     * @param string|null $statusDescription
     *
     * @return static
     *
     * @example Zending afgeleverd
     *
     * @since   2.0.0 Strict typing
     * @see     Status::$statusDescription
     */
    public function setStatusDescription(?string $statusDescription): StatusInterface;

    /**
     * Get phase code.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Status::$phaseCode
     */
    public function getPhaseCode(): ?string;

    /**
     * Set phase code.
     *
     * @pattern ^\d{1,10}$
     *
     * @param string|null $phaseCode
     *
     * @return static
     *
     * @example 4
     *
     * @since   2.0.0 Strict typing
     * @see     Status::$phaseCode
     */
    public function setPhaseCode(?string $phaseCode): StatusInterface;

    /**
     * Get phase description.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Status::$phaseDescription
     */
    public function getPhaseDescription(): ?string;

    /**
     * Set phase description.
     *
     * @pattern ^.{0,1000}$
     *
     * @param string|null $phaseDescription
     *
     * @return static
     *
     * @example Afgeleverd
     *
     * @since   2.0.0 Strict typing
     * @see     Status::$phaseDescription
     */
    public function setPhaseDescription(?string $phaseDescription): StatusInterface;
}
