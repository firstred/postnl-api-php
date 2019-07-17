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
 * Class CutOffTime
 */
class CutOffTime extends AbstractEntity
{
    /** @var string|null $day */
    protected $day;
    /** @var string|null $time */
    protected $time;
    /** @var bool|null $available */
    protected $available;

    /**
     * @param string $day
     * @param string $time
     * @param bool   $available
     */
    public function __construct($day = null, $time = null, $available = null)
    {
        parent::__construct();

        $this->setDay($day);
        $this->setTime($time);
        $this->setAvailable($available);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDay(): ?string
    {
        return $this->day;
    }

    /**
     * @param string|null $day
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDay(?string $day): CutOffTime
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string|null $time
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTime(?string $time): CutOffTime
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return bool|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    /**
     * @param bool|null $available
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAvailable(?bool $available): CutOffTime
    {
        $this->available = $available;

        return $this;
    }
}
