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

/**
 * Class ReasonNoTimeframe
 */
class ReasonNoTimeframe extends AbstractEntity
{
    /** @var string|null $code */
    protected $code;
    /** @var string|null $date */
    protected $date;
    /** @var string|null $description */
    protected $description;
    /** @var string[]|null $options */
    protected $options;
    /** @var string|null $from */
    protected $from;
    /** @var string|null $to */
    protected $to;

    /**
     * @param string|null   $code
     * @param string|null   $date
     * @param string|null   $desc
     * @param string[]|null $options
     * @param string|null   $from
     * @param string|null   $to
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCode(?string $code): ReasonNoTimeframe
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDate(?string $date): ReasonNoTimeframe
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDescription(?string $description): ReasonNoTimeframe
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param string[]|null $options
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOptions(?array $options): ReasonNoTimeframe
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @param string|null $from
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setFrom(?string $from): ReasonNoTimeframe
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * @param string|null $to
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTo(?string $to): ReasonNoTimeframe
    {
        $this->to = $to;

        return $this;
    }
}
