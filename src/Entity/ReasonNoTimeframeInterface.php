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
interface ReasonNoTimeframeInterface extends EntityInterface
{
    /**
     * Get code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$code
     */
    public function getCode(): ?string;

    /**
     * Set code.
     *
     * @pattern ^\d{2}$
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
     * @see     ReasonNoTimeframe::$code
     */
    public function setCode(?string $code): ReasonNoTimeframeInterface;

    /**
     * Get date.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$date
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
     * @see     ReasonNoTimeframe::$date
     */
    public function setDate(?string $date): ReasonNoTimeframeInterface;

    /**
     * Get description.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$description
     */
    public function getDescription(): ?string;

    /**
     * Set description.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $description
     *
     * @return static
     *
     * @example Dag uitgesloten van tijdvak
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ReasonNoTimeframe::$description
     */
    public function setDescription(?string $description): ReasonNoTimeframeInterface;

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$options
     */
    public function getOptions(): ?array;

    /**
     * Set options.
     *
     * @pattern ^.{0,35}$
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @example Afternoon
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ReasonNoTimeframe::$options
     */
    public function setOptions(?array $options): ReasonNoTimeframeInterface;

    /**
     * Get from.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$from
     */
    public function getFrom(): ?string;

    /**
     * Set from.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $from
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 16:30:00
     *
     * @since   2.0.0 Strict typing
     * @since   1.0.0
     * @see     ReasonNoTimeframe::$from
     *                                  .
     */
    public function setFrom(?string $from): ReasonNoTimeframeInterface;

    /**
     * Get to.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   ReasonNoTimeframe::$to
     */
    public function getTo(): ?string;

    /**
     * Set to.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $to
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 16:30:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     ReasonNoTimeframe::$to
     */
    public function setTo(?string $to): ReasonNoTimeframeInterface;
}
