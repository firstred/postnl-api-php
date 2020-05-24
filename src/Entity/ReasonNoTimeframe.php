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
 * Class ReasonNoTimeframe.
 */
final class ReasonNoTimeframe extends AbstractEntity implements ReasonNoTimeframeInterface
{
    /**
     * Reason code.
     *
     * @pattern ^\d{2}$
     *
     * @example 02
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $code;

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
     * Detailed reason.
     *
     * @pattern ^.{0,95}$
     *
     * @example Dag uitgesloten van tijdvak
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $description;

    /**
     * Timeframe options.
     *
     * @pattern ^.{0,35}$
     *
     * @example Afternoon
     *
     * @var string[]|null
     *
     * @since   1.0.0
     */
    private $options;

    /**
     * From.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
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
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @var string|null
     *
     * @since   1.0.0
     */
    private $to;

    /**
     * Get code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @pattern ^\d{2}$
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
     * @see     ReasonNoTimeframe::$code
     */
    public function setCode(?string $code): ReasonNoTimeframeInterface
    {
        $this->code = $this->validate->numericType($code);

        return $this;
    }

    /**
     * Get date.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$date
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
     * @see     ReasonNoTimeframe::$date
     */
    public function setDate(?string $date): ReasonNoTimeframeInterface
    {
        $this->date = $this->validate->date($date);

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @pattern ^.{0,95}$
     *
     * @example Dag uitgesloten van tijdvak
     *
     * @param string|null $description
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ReasonNoTimeframe::$description
     */
    public function setDescription(?string $description): ReasonNoTimeframeInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options.
     *
     * @pattern ^.{0,35}$
     *
     * @example Afternoon
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ReasonNoTimeframe::$options
     */
    public function setOptions(?array $options): ReasonNoTimeframeInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get from.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$from
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * Set from.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @param string|null $from
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     ReasonNoTimeframe::$from
     *                                  .
     */
    public function setFrom(?string $from): ReasonNoTimeframeInterface
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
     * @see   ReasonNoTimeframe::$to
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * Set to.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @param string|null $to
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ReasonNoTimeframe::$to
     */
    public function setTo(?string $to): ReasonNoTimeframeInterface
    {
        $this->to = $this->validate->time($to);

        return $this;
    }
}
