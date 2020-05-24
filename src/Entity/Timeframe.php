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
final class Timeframe extends AbstractEntity implements TimeframeInterface
{
    /**
     * Timeframe date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $date;

    /**
     * From.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 14:00:00
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $from;

    /**
     * To.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $to;

    /**
     * Options.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null
     *
     * @since   1.0.0
     */
    private $options;

    /**
     * Code.
     *
     * @pattern ^.{0,35}$
     *
     * @example 02
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $code;

    /**
     * Description.
     *
     * @pattern ^.{0,35}$
     *
     * @example Middag
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $description;

    /**
     * Shipping date property as returned by the Checkout API.
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $shippingDate;

    /**
     * Get date.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$date
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Set date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @param string|null $date
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Timeframe::$date
     */
    public function setDate(?string $date): TimeframeInterface
    {
        $this->date = $this->validate->date($date);

        return $this;
    }

    /**
     * Get from.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$from
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * Set from.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 14:00:00
     *
     * @param string|null $from
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     Timeframe::$from
     */
    public function setFrom(?string $from): TimeframeInterface
    {
        $this->from = $this->validate->time($from);

        return $this;
    }

    /**
     * Get to.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$to
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * Set to.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @param string|null $to
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     Timeframe::$to
     */
    public function setTo(?string $to): TimeframeInterface
    {
        $this->to = $this->validate->time($to);

        return $this;
    }

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Timeframe::$options
     */
    public function setOptions(?array $options): TimeframeInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @pattern ^.{0,35}$
     *
     * @example 02
     *
     * @param string|null $code
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Timeframe::$code
     */
    public function setCode(?string $code): TimeframeInterface
    {
        $this->code = $this->validate->genericString($code);

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Timeframe::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @pattern ^.{0,35}$
     *
     * @example Middag
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     Timeframe::$description
     */
    public function setDescription(?string $description): TimeframeInterface
    {
        $this->description = $this->validate->genericString($description);

        return $this;
    }

    /**
     * Get shipping date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Timeframe::$shippingDate
     */
    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    /**
     * Set shipping date.
     *
     * @example 03-07-2019
     *
     * @param string|null $shippingDate
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @return static
     *
     * @since   2.0.0
     * @see     Timeframe::$shippingDate
     */
    public function setShippingDate(?string $shippingDate): TimeframeInterface
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }
}
