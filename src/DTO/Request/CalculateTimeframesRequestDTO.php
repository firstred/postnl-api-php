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

namespace Firstred\PostNL\DTO\Request;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\ServiceInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use function implode;
use function is_numeric;
use function ltrim;

class CalculateTimeframesRequestDTO extends CacheableDTO
{
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $StartDate = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $EndDate = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected array|null $Options = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected bool|null $AllowSundaySorting = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $CountryCode = null;

    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected string|null $City = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $PostalCode = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $Street = null;

    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected int|null $HouseNumber = null;

    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected string|null $HouseNrExt = null;

    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected int|null $Interval = null;

    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected string|null $TimeframeRange = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = TimeframeServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        string|null $StartDate = null,
        string|null $EndDate = null,
        array|null $Options = null,
        bool|null $AllowSundaySorting = null,
        string|null $CountryCode = null,
        string|null $City = null,
        string|null $PostalCode = null,
        string|null $Street = null,
        int|string|null $HouseNumber = null,
        string|null $HouseNrExt = null,
        int|string|null $Interval = null,
        string|null $TimeframeRange = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setStartDate(StartDate: $StartDate);
        $this->setEndDate(EndDate: $EndDate);
        $this->setOptions(Options: $Options);
        $this->setAllowSundaySorting(AllowSundaySorting: $AllowSundaySorting);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setCity(City: $City);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setStreet(Street: $Street);
        $this->setHouseNumber(HouseNumber: $HouseNumber);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setInterval(Interval: $Interval);
        $this->setTimeframeRange(TimeframeRange: $TimeframeRange);
    }

    public function getStartDate(): string|null
    {
        return $this->StartDate;
    }

    public function setStartDate(string|null $StartDate = null): static
    {
        $this->StartDate = $StartDate;
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

    public function getOptions(): array|null
    {
        return $this->Options;
    }

    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;
        return $this;
    }

    public function getAllowSundaySorting(): bool|null
    {
        return $this->AllowSundaySorting;
    }

    public function setAllowSundaySorting(bool|null $AllowSundaySorting = null): static
    {
        $this->AllowSundaySorting = $AllowSundaySorting;
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

    public function getCity(): string|null
    {
        return $this->City;
    }

    public function setCity(string|null $City = null): static
    {
        $this->City = $City;
        return $this;
    }

    public function getPostalCode(): string|null
    {
        return $this->PostalCode;
    }

    public function setPostalCode(string|null $PostalCode = null): static
    {
        $this->PostalCode = $PostalCode;
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

    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setHouseNumber(int|string|null $HouseNumber = null): static
    {
        if (is_string(value: $HouseNumber)) {
            if (!is_numeric(value: $HouseNumber)) {
                throw new InvalidArgumentException(message: "Invalid `Housenumber` value passed: $HouseNumber");
            }

            $HouseNumber = (int) $HouseNumber;
        }

        $this->HouseNumber = $HouseNumber;

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

    public function getInterval(): int|null
    {
        return $this->Interval;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setInterval(int|string|null $Interval = null): static
    {
        if (is_string(value: $Interval)) {
            if (!is_numeric(value: $Interval)) {
                throw new InvalidArgumentException(message: "Invalid `Interval` value passed: $Interval");
            }

            $Interval = (int) $Interval;
        }

        $this->Interval = $Interval;


        return $this;
    }

    public function getTimeframeRange(): string|null
    {
        return $this->TimeframeRange;
    }

    public function setTimeframeRange(string|null $TimeframeRange = null): static
    {
        $this->TimeframeRange = $TimeframeRange;
        return $this;
    }

    public function getUniqueId(): string
    {
        $options = implode(separator: '+', array: $this->getOptions());

        return "{$this->getShortClassName()}-{$this->getStartDate()}|{$this->getEndDate()}|{$options}|{$this->getAllowSundaySorting()}|{$this->getCountryCode()}|{$this->getCity()}|{$this->getPostalCode()}|{$this->getStreet()}|{$this->getHouseNumber()}|{$this->getHouseNrExt()}|{$this->getInterval()}|{$this->getTimeframeRange()}";
    }

    public function jsonSerialize(): array
    {
        $query = parent::jsonSerialize();

        $query['Options'] = '';

        foreach ($this->getOptions() ?? [] as $option) {
            if ('PG' === $option) {
                continue;
            }
            $query['Options'] .= ",$option";
        }

        if (isset($query['AllowSundaySorting'])) {
            $query['AllowSundaySorting'] = $query['AllowSundaySorting'] ? 'true' : 'false';
        }

        $query['Options'] = ltrim(string: $query['Options'], characters: ',');
        if (!$query['Options']) {
            unset($query['Options']);
        }

        return $query;
    }
}
