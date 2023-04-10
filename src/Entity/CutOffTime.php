<?php

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Exception\ServiceNotSetException;

/**
 * @since 1.0.0
 */
class CutOffTime extends AbstractEntity
{
    /** @var string|null $Day */
    #[SerializableProperty(type: 'string')]
    protected ?string $Day = null;

    /** @var string|null $Time */
    #[SerializableProperty(type: 'string')]
    protected ?string $Time = null;

    /** @var bool|null $Available */
    #[SerializableProperty(type: 'bool')]
    protected ?bool $Available = null;

    /**
     * @param string|null $Day
     * @param string|null $Time
     * @param bool|null   $Available
     */
    public function __construct(?string $Day = null, ?string $Time = null, ?bool $Available = null)
    {
        parent::__construct();

        $this->setDay(Day: $Day);
        $this->setTime(Time: $Time);
        $this->setAvailable(Available: $Available);
    }

    /**
     * @return string|null
     */
    public function getDay(): ?string
    {
        return $this->Day;
    }

    /**
     * @param string|null $Day
     *
     * @return static
     */
    public function setDay(?string $Day): static
    {
        $this->Day = $Day;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->Time;
    }

    /**
     * @param string|null $Time
     *
     * @return static
     */
    public function setTime(?string $Time): static
    {
        $this->Time = $Time;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailable(): ?bool
    {
        return $this->Available;
    }

    /**
     * @param bool|null $Available
     *
     * @return static
     */
    public function setAvailable(?bool $Available): static
    {
        $this->Available = $Available;

        return $this;
    }
}
