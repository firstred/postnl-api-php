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
 * Class ReasonNoTimeframe
 */
class ReasonNoTimeframe extends AbstractEntity
{
    /**
     * Reason code
     *
     * @pattern ^\d{2}$
     *
     * @example 02
     *
     * @var string|null $code
     *
     * @since 1.0.0
     */
    protected $code;

    /**
     * Timeframe date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null $date
     *
     * @since 1.0.0
     */
    protected $date;

    /**
     * Detailed reason
     *
     * @pattern ^.{0,95}$
     *
     * @example Dag uitgesloten van tijdvak
     *
     * @var string|null $description
     *
     * @since 1.0.0
     */
    protected $description;

    /**
     * Timeframe options
     *
     * @pattern ^.{0,35}$
     *
     * @example Afternoon
     *
     * @var string[]|null $options
     *
     * @since 1.0.0
     */
    protected $options;

    /**
     * From
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 14:00:00
     *
     * @var string|null $from
     *
     * @since 1.0.0
     */
    protected $from;

    /**
     * To
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @var string|null $to
     *
     * @since 1.0.0
     */
    protected $to;

    /**
     * ReasonNoTimeframe constructor.
     *
     * @param string|null   $code
     * @param string|null   $date
     * @param string|null   $desc
     * @param string[]|null $options
     * @param string|null   $from
     * @param string|null   $to
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $code = null, ?string $date = null, ?string $desc = null, array $options = null, ?string $from = null, ?string $to = null)
    {
        parent::__construct();

        $this->setCode($code);
        $this->setDate($date);
        $this->setDescription($desc);
        $this->setOptions($options);
        $this->setFrom($from);
        $this->setTo($to);
    }

    /**
     * Get code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ReasonNoTimeframe::$code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @pattern ^\d{2}$
     *
     * @param string|null $code
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     ReasonNoTimeframe::$code
     */
    public function setCode(?string $code): ReasonNoTimeframe
    {
        $this->code = ValidateAndFix::numericType($code);

        return $this;
    }

    /**
     * Get date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ReasonNoTimeframe::$date
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $date
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 03-07-2019
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     ReasonNoTimeframe::$date
     */
    public function setDate(?string $date): ReasonNoTimeframe
    {
        $this->date = ValidateAndFix::date($date);

        return $this;
    }

    /**
     * Get description
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ReasonNoTimeframe::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example Dag uitgesloten van tijdvak
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     ReasonNoTimeframe::$description
     */
    public function setDescription(?string $description): ReasonNoTimeframe
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get options
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ReasonNoTimeframe::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @pattern ^.{0,35}$
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example Afternoon
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     ReasonNoTimeframe::$options
     */
    public function setOptions(?array $options): ReasonNoTimeframe
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get from
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ReasonNoTimeframe::$from
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * Set from
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $from
     *
     * @return static
     *
     * @throws ReflectionException
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     ReasonNoTimeframe::$from
     *                                  .
     * @example 16:30:00
     *
     */
    public function setFrom(?string $from): ReasonNoTimeframe
    {
        $this->from = ValidateAndFix::time($from);

        return $this;
    }

    /**
     * Get to
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   ReasonNoTimeframe::$to
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * Set to
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $to
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 16:30:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     ReasonNoTimeframe::$to
     */
    public function setTo(?string $to): ReasonNoTimeframe
    {
        $this->to = ValidateAndFix::time($to);

        return $this;
    }
}
