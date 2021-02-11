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
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Timeframe
 */
class Timeframe extends SerializableObject
{
    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $City = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $CountryCode = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $Date = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $EndDate = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $HouseNr = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $HouseNrExt = null;

    /**
     * @var string[]|null
     */
    #[ResponseProp(
        requiredFor: [CheckoutServiceInterface::class],
        optionalFor: [TimeframeServiceInterface::class],
    )]
    protected array|null $Options = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $PostalCode = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $Street = null;

    /**
     * @var bool|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected bool|null $SundaySorting = false;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $Interval = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $Range = null;

    /**
     * @psalm-var list<TimeframeTimeFrame>|null
     * @var TimeframeTimeFrame[]|null
     */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class, CheckoutServiceInterface::class])]
    protected array|null $Timeframes = null;

    #[ResponseProp(requiredFor: [CheckoutServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $From = null;

    #[ResponseProp(requiredFor: [CheckoutServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $To = null;

    #[ResponseProp(requiredFor: [CheckoutServiceInterface::class, CheckoutServiceInterface::class])]
    protected string|null $ShippingDate = null;

    /**
     * Timeframe constructor.
     *
     * @param string           $service
     * @param string           $propType
     * @param string|null      $City
     * @param string|null      $CountryCode
     * @param string|null      $Date
     * @param string|null      $EndDate
     * @param string|null      $HouseNr
     * @param string|null      $HouseNrExt
     * @param array|null       $Options
     * @param string|null      $PostalCode
     * @param string|null      $Street
     * @param bool|string|null $SundaySorting
     * @param string|null      $Interval
     * @param string|null      $Range
     * @param array|null       $Timeframes
     * @param string|null      $From
     * @param string|null      $To
     * @param string|null      $ShippingDate
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service ,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $City = null,
        string|null $CountryCode = null,
        string|null $Date = null,
        string|null $EndDate = null,
        string|null $HouseNr = null,
        string|null $HouseNrExt = null,
        array|null $Options = null,
        string|null $PostalCode = null,
        string|null $Street = null,
        bool|string|null $SundaySorting = null,
        string|null $Interval = null,
        string|null $Range = null,
        /** @psalm-param list<TimeframeTimeFrame>|array|null */
        array|null $Timeframes = null,

        string|null $From = null,
        string|null $To = null,
        string|null $ShippingDate = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setCity(City: $City);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDate(Date: $Date);
        $this->setEndDate(EndDate: $EndDate);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setOptions(Options: $Options);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setStreet(Street: $Street);
        $this->setSundaySorting(SundaySorting: $SundaySorting);
        $this->setInterval(Interval: $Interval);
        $this->setRange(Range: $Range);
        $this->setTimeframes(Timeframes: $Timeframes);

        $this->setFrom(From: $From);
        $this->setTo(To: $To);
        $this->setShippingDate(ShippingDate: $ShippingDate);
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): string|null
    {
        return $this->PostalCode;
    }

    /**
     * @param string|null $PostalCode
     *
     * @return static
     */
    public function setPostalCode(string|null $PostalCode = null): static
    {
        if (is_null(value: $PostalCode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $PostalCode));
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): string|null
    {
        return $this->CountryCode;
    }

    /**
     * @param string|null $CountryCode
     *
     * @return static
     */
    public function setCountryCode(string|null $CountryCode = null): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): string|null
    {
        return $this->Date;
    }

    /**
     * @param string|null $Date
     *
     * @return static
     */
    public function setDate(string|null $Date = null): static
    {
        $this->Date = $Date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): string|null
    {
        return $this->EndDate;
    }

    /**
     * @param string|null $EndDate
     *
     * @return static
     */
    public function setEndDate(string|null $EndDate = null): static
    {
        $this->EndDate = $EndDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNr(): string|null
    {
        return $this->HouseNr;
    }

    /**
     * @param string|null $HouseNr
     *
     * @return static
     */
    public function setHouseNr(string|null $HouseNr = null): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): array|null
    {
        return $this->Options;
    }

    /**
     * @param array|null $Options
     *
     * @return static
     */
    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): string|null
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSundaySorting(): bool|null
    {
        return $this->SundaySorting;
    }

    /**
     * @param bool|string|null $SundaySorting
     *
     * @return static
     */
    public function setSundaySorting(bool|string|null $SundaySorting = null): static
    {
        if (is_string(value: $SundaySorting)) {
            $SundaySorting = match ($SundaySorting) {
                'true'  => true,
                'false' => false,
                default => null,
            };
        }

        $this->SundaySorting = $SundaySorting;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInterval(): string|null
    {
        return $this->Interval;
    }

    /**
     * @param string|null $Interval
     *
     * @return static
     */
    public function setInterval(string|null $Interval = null): static
    {
        $this->Interval = $Interval;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRange(): string|null
    {
        return $this->Range;
    }

    /**
     * @param string|null $Range
     *
     * @return static
     */
    public function setRange(string|null $Range = null): static
    {
        $this->Range = $Range;

        return $this;
    }

    /**
     * @return array|TimeframeTimeFrame[]|null
     */
    public function getTimeframes(): array|null
    {
        return $this->Timeframes;
    }

    /**
     * @param array|null $Timeframes
     * @psalm-param list<TimeframeTimeFrame>|array{Timeframes: array<array-key, array>}|null $Timeframes
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setTimeframes(array|null $Timeframes = null): static
    {
        if (!empty($Timeframes['Timeframes']) && !$Timeframes['Timeframes'] instanceof TimeframeTimeFrame) {
            $newTimeframes = [];
            foreach ($Timeframes['Timeframes'] as $idx => $timeframeTimeFrame) {
                $timeframeTimeFrame['service'] = $this->service;
                $timeframeTimeFrame['propType'] = $this->propType;
                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $timeframeTimeFrame['Timeframes'][$idx] = new TimeframeTimeFrame(...$timeframeTimeFrame);
            }
            $Timeframes = $newTimeframes;
        }

        $this->Timeframes = $Timeframes;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrom(): string|null
    {
        return $this->From;
    }

    /**
     * @param string|null $From
     *
     * @return static
     */
    public function setFrom(string|null $From = null): static
    {
        $this->From = $From;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTo(): string|null
    {
        return $this->To;
    }

    /**
     * @param string|null $To
     *
     * @return static
     */
    public function setTo(string|null $To = null): static
    {
        $this->To = $To;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingDate(): string|null
    {
        return $this->ShippingDate;
    }

    /**
     * @param string|null $ShippingDate
     *
     * @return static
     */
    public function setShippingDate(string|null $ShippingDate = null): static
    {
        $this->ShippingDate = $ShippingDate;
        return $this;
    }
}
