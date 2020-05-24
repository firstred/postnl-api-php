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
 * Class Expectation.
 */
final class Expectation extends AbstractEntity implements ExpectationInterface
{
    /**
     * ETA from.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 14:00:00
     *
     * @var string|null
     *
     * @since 1.0.0
     */
    private $ETAFrom;

    /**
     * ETA to.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @var string|null
     *
     * @since 1.0.0
     */
    private $ETATo;

    /**
     * Get ETA from.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Expectation::$ETAFrom
     */
    public function getETAFrom(): ?string
    {
        return $this->ETAFrom;
    }

    /**
     * Set ETA from.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $ETAFrom
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 14:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Expectation::$ETAFrom
     */
    public function setETAFrom(?string $ETAFrom): ExpectationInterface
    {
        $this->ETAFrom = $this->validate->time($ETAFrom);

        return $this;
    }

    /**
     * Get ETA to.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Expectation::$ETATo
     */
    public function getETATo(): ?string
    {
        return $this->ETATo;
    }

    /**
     * Set ETA to.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $ETATo
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 16:30:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Expectation::$ETATo
     */
    public function setETATo(?string $ETATo): ExpectationInterface
    {
        $this->ETATo = $this->validate->time($ETATo);

        return $this;
    }
}
