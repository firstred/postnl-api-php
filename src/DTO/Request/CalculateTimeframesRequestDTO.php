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
use function implode;
use function is_numeric;
use function ltrim;

/**
 * Class CalculateTimeframesRequestDTO
 *
 * @see https://developer.postnl.nl/browse-apis/delivery-options/timeframe-webservice/testtool-rest/#/Timeframe/get_calculate_timeframes
 */
class CalculateTimeframesRequestDTO extends CacheableDTO
{
    /**
     * Date of the beginning of the timeframe.
     *
     * Format:dd-mm-yyyy
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $StartDate = null;

    /**
     * Date of the enddate of the timeframe.
     *
     * Format:dd-mm-yyyy
     *
     * Enddate may not be before StartDate.
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $EndDate = null;

    /**
     * The delivery options for which timeframes should be returned. At least one delivery option must be specified. See Guidelines for possible values.
     *
     * Available values : Daytime, Sameday, Evening, Morning, Noon, Sunday, Afternoon, MyTime
     *
     * Default value: Daytime
     *
     * @var array|null
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected array|null $Options = null;

    /**
     * @var null|bool
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected bool|null $AllowSundaySorting = null;

    /**
     * @var null|string
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $CountryCode = null;

    /**
     * @var null|string
     */
    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected string|null $City = null;

    /**
     * @var null|string
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $PostalCode = null;

    /**
     * @var null|string
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected string|null $Street = null;

    /**
     * @var null|int
     */
    #[RequestProp(requiredFor: ([TimeframeServiceInterface::class]))]
    protected int|null $HouseNumber = null;

    /**
     * @var null|string
     */
    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected string|null $HouseNrExt = null;

    /**
     * @var null|int
     */
    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected int|null $Interval = null;

    /**
     * @var null|string
     */
    #[RequestProp(optionalFor: ([TimeframeServiceInterface::class]))]
    protected string|null $TimeframeRange = null;

    /**
     * CalculateTimeframesRequestDTO constructor.
     *
     * @param string          $service
     * @param string          $propType
     * @param string          $cacheKey
     * @param string|null     $StartDate
     * @param string|null     $EndDate
     * @param array|null      $Options
     * @param bool|null       $AllowSundaySorting
     * @param string|null     $CountryCode
     * @param string|null     $City
     * @param string|null     $PostalCode
     * @param string|null     $Street
     * @param int|string|null $HouseNumber
     * @param string|null     $HouseNrExt
     * @param int|string|null $Interval
     * @param string|null     $TimeframeRange
     *
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

    /**
     * @return string|null
     */
    public function getStartDate(): string|null
    {
        return $this->StartDate;
    }

    /**
     * @param string|null $StartDate
     *
     * @return static
     */
    public function setStartDate(string|null $StartDate = null): static
    {
        $this->StartDate = $StartDate;
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
     * @return bool|null
     */
    public function getAllowSundaySorting(): bool|null
    {
        return $this->AllowSundaySorting;
    }

    /**
     * @param bool|null $AllowSundaySorting
     *
     * @return static
     */
    public function setAllowSundaySorting(bool|null $AllowSundaySorting = null): static
    {
        $this->AllowSundaySorting = $AllowSundaySorting;
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
        $this->PostalCode = $PostalCode;
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
     * @return int|null
     */
    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

    /**
     * @param int|string|null $HouseNumber
     *
     * @return static
     *
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
     * @return int|null
     */
    public function getInterval(): int|null
    {
        return $this->Interval;
    }

    /**
     * @param int|string|null $Interval
     *
     * @return static
     *
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

    /**
     * @return string|null
     */
    public function getTimeframeRange(): string|null
    {
        return $this->TimeframeRange;
    }

    /**
     * @param string|null $TimeframeRange
     *
     * @return static
     */
    public function setTimeframeRange(string|null $TimeframeRange = null): static
    {
        $this->TimeframeRange = $TimeframeRange;
        return $this;
    }

    /**
     * @return string
     */
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
