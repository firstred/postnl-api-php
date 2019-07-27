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
 * Class Timeframe
 */
class Timeframe extends AbstractEntity
{
    /**
     * Date
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
     * From
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
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
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 16:30:00
     *
     * @var string|null $to
     *
     * @since 1.0.0
     */
    protected $to;

    /**
     * Options
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null $options
     *
     * @since 1.0.0
     */
    protected $options;

    /**
     * Code
     *
     * @pattern ^.{0,35}$
     *
     * @example 02
     *
     * @var string|null $code
     *
     * @since 1.0.0
     */
    protected $code;

    /**
     * Description
     *
     * @pattern ^.{0,35}$
     *
     * @example Middag
     *
     * @var string|null $description
     *
     * @since 1.0.0
     */
    protected $description;

    /**
     * Timeframe constructor.
     *
     * @param string|null   $date
     * @param string|null   $from
     * @param string|null   $to
     * @param string[]|null $options
     * @param string|null   $code
     * @param string|null   $description
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function __construct(?string $date = null, ?string $from = null, ?string $to = null, array $options = null, ?string $code = null, ?string $description = null)
    {
        parent::__construct();

        $this->setDate($date);
        $this->setFrom($from);
        $this->setTo($to);
        $this->setOptions($options);
        $this->setCode($code);
        $this->setDescription($description);
    }

    /**
     * Get date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Timeframe::$date
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
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Timeframe::$date
     */
    public function setDate(?string $date): Timeframe
    {
        $this->date = ValidateAndFix::date($date);

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
     * @see   Timeframe::$from
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * Set from
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @param string|null $from
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 14:00:00
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     *
     * @see     Timeframe::$from
     */
    public function setFrom(?string $from): Timeframe
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
     * @see   Timeframe::$to
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * Set to
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
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
     * @since 2.0.0 Strict typing
     * @since   1.0.0
     *
     * @see     Timeframe::$to
     */
    public function setTo(?string $to): Timeframe
    {
        $this->to = ValidateAndFix::time($to);

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
     * @see   Timeframe::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @pattern N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Timeframe::$options
     */
    public function setOptions(?array $options): Timeframe
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Timeframe::$code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @pattern ^.{0,35}$
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
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     Timeframe::$code
     */
    public function setCode(?string $code): Timeframe
    {
        $this->code = ValidateAndFix::genericString($code);

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
     * @see   Timeframe::$description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $description
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example Middag
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     *
     * @see     Timeframe::$description
     */
    public function setDescription(?string $description): Timeframe
    {
        $this->description = ValidateAndFix::genericString($description);

        return $this;
    }
}
