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
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class CutOffTime.
 */
class CutOffTime extends SerializableObject
{
    public const DAY_DEFAULT = '00';
    public const DAY_MONDAY = '01';
    public const DAY_TUESDAY = '02';
    public const DAY_WEDNESDAY = '03';
    public const DAY_THURSDAY = '04';
    public const DAY_FRIDAY = '05';
    public const DAY_SATURDAY = '06';
    public const DAY_SUNDAY = '07';

    public const TYPE_REGULAR = 'Regular';
    public const TYPE_SAMEDAY = 'Sameday';

    /**
     * @var string|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected string|null $Day = null;

    /**
     * @var bool|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected bool|null $Available = null;

    /**
     * @var string|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected string|null $Time = null;

    /**
     * @var string|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected string|null $Type = null;

    /**
     * CutOffTime constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $Day
     * @param bool|null   $Available
     * @param string|null $Time
     * @param string|null $Type
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = '',

        #[ExpectedValues(values: [self::DAY_DEFAULT, self::DAY_MONDAY, self::DAY_TUESDAY, self::DAY_WEDNESDAY, self::DAY_THURSDAY, self::DAY_FRIDAY, self::DAY_SATURDAY, self::DAY_SUNDAY])]
        string|null $Day = null,
        bool|null $Available = null,
        string|null $Time = null,
        #[ExpectedValues(values: [self::TYPE_REGULAR, self::TYPE_SAMEDAY])]
        string|null $Type = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setDay(Day: $Day);
        $this->setAvailable(Available: $Available);
        $this->setTime(Time: $Time);
        $this->setType(Type: $Type);
    }

    /**
     * @return string|null
     */
    #[ExpectedValues(values: [self::DAY_DEFAULT, self::DAY_MONDAY, self::DAY_TUESDAY, self::DAY_WEDNESDAY, self::DAY_THURSDAY, self::DAY_FRIDAY, self::DAY_SATURDAY, self::DAY_SUNDAY])]
    public function getDay(): string|null
    {
        return $this->Day;
    }

    /**
     * @param string|null $Day
     *
     * @return static
     */
    public function setDay(
        #[ExpectedValues(values: [self::DAY_DEFAULT, self::DAY_MONDAY, self::DAY_TUESDAY, self::DAY_WEDNESDAY, self::DAY_THURSDAY, self::DAY_FRIDAY, self::DAY_SATURDAY, self::DAY_SUNDAY])]
        string|null $Day = null,
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

    /**
     * @return string|null
     */
    public function getType(): string|null
    {
        return $this->Type;
    }

    /**
     * @param string|null $Type
     *
     * @return static
     */
    public function setType(string|null $Type = null): static
    {
        $this->Type = $Type;

        return $this;
    }
}
