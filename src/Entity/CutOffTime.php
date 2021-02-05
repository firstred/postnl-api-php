<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class CutOffTime.
 */
class CutOffTime extends SerializableObject
{
    public const MONDAY = 0;
    public const TUESDAY = 1;
    public const WEDNESDAY = 2;
    public const THURSDAY = 3;
    public const FRIDAY = 4;
    public const SATURDAY = 5;
    public const SUNDAY = 6;

    /**
     * CutOffTime constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param int|null    $Day
     * @param string|null $Time
     * @param bool|null   $Available
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType,

        #[ExpectedValues(values: [self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY])]
        protected int|null $Day = null,
        protected string|null $Time = null,
        protected bool|null $Available = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setDay(Day: $Day);
        $this->setTime(Time: $Time);
        $this->setAvailable(Available: $Available);
    }

    #[ExpectedValues(values: [self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY])]
    /**
     * @return int|null
     */
    public function getDay(): int|null
    {
        return $this->Day;
    }

    /**
     * @param int|null $Day
     *
     * @return static
     */
    public function setDay(
        #[ExpectedValues(values: [self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY])]
        int|null $Day = null,
    ): static {
        $this->Day = $Day;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime(): string|null
    {
        return $this->Time;
    }

    /**
     * @param string|null $Time
     *
     * @return static
     */
    public function setTime(string|null $Time = null): static
    {
        $this->Time = $Time;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailable(): bool|null
    {
        return $this->Available;
    }

    /**
     * @param bool|null $Available
     *
     * @return static
     */
    public function setAvailable(bool|null $Available = null): static
    {
        $this->Available = $Available;

        return $this;
    }
}
