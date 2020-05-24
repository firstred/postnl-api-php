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
 * Class OldStatus.
 */
final class OldStatus extends AbstractEntity implements OldStatusInterface
{
    /**
     * Timestamp.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 03-07-2019 08:00:00
     *
     * @var string|null
     *
     * @since   3.0.0
     */
    private $timeStamp;

    /**
     * Status code.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 7
     *
     * @var string|null
     *
     * @since   3.0.0
     */
    private $statusCode;

    /**
     * Status description.
     *
     * @pattern ^.{0,1000}$
     *
     * @example Zending afgeleverd
     *
     * @var string|null
     *
     * @since   3.0.0
     */
    private $statusDescription;

    /**
     * Phase code.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 4
     *
     * @var string|null
     *
     * @since   3.0.0
     */
    private $phaseCode;

    /**
     * Phase description.
     *
     * @pattern ^.{0,1000}$
     *
     * @example Afgeleverd
     *
     * @var string|null
     *
     * @since   3.0.0
     */
    private $phaseDescription;

    /**
     * Get timestamp.
     *
     * @return string|null
     *
     * @since 3.0.0
     * @see   Status::$timeStamp
     */
    public function getTimeStamp(): ?string
    {
        return $this->timeStamp;
    }

    /**
     * Set timestamp.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 03-07-2019 08:00:00
     *
     * @param string|null $timeStamp
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   3.0.0
     * @see     Status::$timeStamp
     */
    public function setTimeStamp(?string $timeStamp): StatusInterface
    {
        $this->timeStamp = $this->validate->dateTime($timeStamp);

        return $this;
    }

    /**
     * Get status code.
     *
     * @return string|null
     *
     * @since 3.0.0
     * @see   Status::$statusCode
     */
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * Set status code.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 7
     *
     * @param string|null $statusCode
     *
     * @return static
     *
     * @since   3.0.0
     * @see     Status::$statusCode
     */
    public function setStatusCode(?string $statusCode): StatusInterface
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get status description.
     *
     * @return string|null
     *
     * @since 3.0.0
     * @see   Status::$statusDescription
     */
    public function getStatusDescription(): ?string
    {
        return $this->statusDescription;
    }

    /**
     * Set status description.
     *
     * @pattern ^.{0,1000}$
     *
     * @example Zending afgeleverd
     *
     * @param string|null $statusDescription
     *
     * @return static
     *
     * @since   3.0.0
     * @see     Status::$statusDescription
     */
    public function setStatusDescription(?string $statusDescription): StatusInterface
    {
        $this->statusDescription = $statusDescription;

        return $this;
    }

    /**
     * Get phase code.
     *
     * @return string|null
     *
     * @since 3.0.0
     * @see   Status::$phaseCode
     */
    public function getPhaseCode(): ?string
    {
        return $this->phaseCode;
    }

    /**
     * Set phase code.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 4
     *
     * @param string|null $phaseCode
     *
     * @return static
     *
     * @since   3.0.0
     * @see     Status::$phaseCode
     */
    public function setPhaseCode(?string $phaseCode): StatusInterface
    {
        $this->phaseCode = $phaseCode;

        return $this;
    }

    /**
     * Get phase description.
     *
     * @return string|null
     *
     * @since 3.0.0
     * @see   Status::$phaseDescription
     */
    public function getPhaseDescription(): ?string
    {
        return $this->phaseDescription;
    }

    /**
     * Set phase description.
     *
     * @pattern ^.{0,1000}$
     *
     * @example Afgeleverd
     *
     * @param string|null $phaseDescription
     *
     * @return static
     *
     * @since   3.0.0
     * @see     Status::$phaseDescription
     */
    public function setPhaseDescription(?string $phaseDescription): StatusInterface
    {
        $this->phaseDescription = $phaseDescription;

        return $this;
    }
}
