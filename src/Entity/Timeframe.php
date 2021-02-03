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
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class Timeframe extends SerializableObject
{
    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $City = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $CountryCode = null;

    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected string|null $Date = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $EndDate = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $HouseNr = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $HouseNrExt = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected array|null $Options = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $PostalCode = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $Street = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected bool|null $SundaySorting = false;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $Interval = null;

    #[ResponseProp(optionalFor: [TimeframeServiceInterface::class])]
    protected string|null $Range = null;

    /** @psalm-var list<TimeframeTimeFrame>|null  */
    #[ResponseProp(requiredFor: [TimeframeServiceInterface::class])]
    protected array|null $Timeframes = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

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
        $this->setInterval(interaval: $Interval);
        $this->setRange(Range: $Range);
        $this->setTimeframes(Timeframes: $Timeframes);
    }

    public function getPostalCode(): string|null
    {
        return $this->PostalCode;
    }

    public function setPostalCode(string|null $PostalCode = null): static
    {
        if (is_null(value: $PostalCode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $PostalCode));
        }

        return $this;
    }

    public function getCity(): string|null
    {
        return $this->City;
    }

    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    public function getCountryCode(): string|null
    {
        return $this->CountryCode;
    }

    public function setCountryCode(string|null $CountryCode = null): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    public function getDate(): string|null
    {
        return $this->Date;
    }

    public function setDate(string|null $Date = null): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getEndDate(): string|null
    {
        return $this->EndDate;
    }

    public function setEndDate(string|null $EndDate = null): static
    {
        $this->EndDate = $EndDate;

        return $this;
    }

    public function getHouseNr(): string|null
    {
        return $this->HouseNr;
    }

    public function setHouseNr(string|null $HouseNr = null): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    public function getOptions(): array|null
    {
        return $this->Options;
    }

    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }

    public function getStreet(): string|null
    {
        return $this->Street;
    }

    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

        return $this;
    }

    public function getSundaySorting(): bool|null
    {
        return $this->SundaySorting;
    }

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

    public function getInterval(): string|null
    {
        return $this->Interval;
    }

    public function setInterval(string|null $interaval = null): static
    {
        $this->Interval = $interaval;

        return $this;
    }

    public function getRange(): string|null
    {
        return $this->Range;
    }

    public function setRange(string|null $Range = null): static
    {
        $this->Range = $Range;

        return $this;
    }

    public function getTimeframes(): array|null
    {
        return $this->Timeframes;
    }

    /**
     * @psalm-param list<TimeframeTimeFrame>|array{Timeframes: array<array-key, array>}|null $Timeframes
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
}
