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
 * Class Timeframe.
 */
interface TimeframeInterface extends EntityInterface
{
    /**
     * Get date.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$date
     */
    public function getDate(): ?string;

    /**
     * Set date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $date
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Timeframe::$date
     */
    public function setDate(?string $date): TimeframeInterface;

    /**
     * Get from.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$from
     */
    public function getFrom(): ?string;

    /**
     * Set from.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @param string|null $from
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 14:00:00
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     Timeframe::$from
     */
    public function setFrom(?string $from): TimeframeInterface;

    /**
     * Get to.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$to
     */
    public function getTo(): ?string;

    /**
     * Set to.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @param string|null $to
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 16:30:00
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     Timeframe::$to
     */
    public function setTo(?string $to): TimeframeInterface;

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$options
     */
    public function getOptions(): ?array;

    /**
     * Set options.
     *
     * @pattern N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Timeframe::$options
     */
    public function setOptions(?array $options): TimeframeInterface;

    /**
     * Get code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$code
     */
    public function getCode(): ?string;

    /**
     * Set code.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $code
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Timeframe::$code
     */
    public function setCode(?string $code): TimeframeInterface;

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$description
     */
    public function getDescription(): ?string;

    /**
     * Set description.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Middag
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     Timeframe::$description
     */
    public function setDescription(?string $description): TimeframeInterface;

    /**
     * Get shipping date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Timeframe::$shippingDate
     */
    public function getShippingDate(): ?string;

    /**
     * Set shipping date.
     *
     * @param string|null $shippingDate
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @return static
     *
     * @example 03-07-2019
     *
     * @since   2.0.0
     * @see     Timeframe::$shippingDate
     */
    public function setShippingDate(?string $shippingDate): TimeframeInterface;
}
