<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class CalculateTimeframesRequest.
 */
final class CalculateTimeframesRequest extends AbstractEntity implements CalculateTimeframesRequestInterface
{
    /**
     * Allow Sunday sorting.
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @pattern N/A
     *
     * @since   2.0.0
     */
    private $allowSundaySorting;

    /**
     * Start date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $startDate;

    /**
     * End date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $endDate;

    /**
     * Postal code.
     *
     * @pattern ^.{1,10}$
     *
     * @example 2132WT
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $postalCode;

    /**
     * Filter for MyTime shipments (possible: 60/30); choose 60 if you only want ‘whole hour’ timeframes returned.
     *
     * @pattern ^(?:30|60)$
     *
     * @example 30
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $interval;

    /**
     * House number.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 42
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $houseNumber;

    /**
     * House number extension.
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $houseNrExt;

    /**
     * Filter for MyTime shipments; format H:i-H:i. Specifies which timeframes you want returned in the response.
     *
     * @example 14:00-15:00
     *
     * @var string|null
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @since   2.0.0
     */
    private $timeframeRange;

    /**
     * Street.
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $street;

    /**
     * City.
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $city;

    /**
     * Country code.
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $countryCode;

    /**
     * The delivery options for which timeframes should be returned. At least one delivery option must be specified. See Guidelines for possible values.
     * Available values: Daytime, Sameday, Evening, Morning, Noon, Sunday, Afternoon, MyTime.
     *
     * @pattern ^(?:Daytime|Sameday|Evening|Morning| Noon|Sunday|Afternoon|MyTime)$
     *
     * @example Daytime
     *
     * @var string[]|null
     *
     * @since   2.0.0
     */
    private $options;

    /**
     * Get allow Sunday sorting.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$allowSundaySorting
     */
    public function getAllowSundaySorting(): ?bool
    {
        return $this->allowSundaySorting;
    }

    /**
     * Set allow sunday sorting.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $allowSundaySorting
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$allowSundaySorting
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting): CalculateTimeframesRequestInterface
    {
        $this->allowSundaySorting = $allowSundaySorting;

        return $this;
    }

    /**
     * Get start date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$startDate
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * Set start date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @param string|null $startDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$startDate
     */
    public function setStartDate(?string $startDate): CalculateTimeframesRequestInterface
    {
        $this->startDate = $this->validate->date($startDate);

        return $this;
    }

    /**
     * Get end date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$endDate
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * Set end date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @param string|null $endDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$endDate
     */
    public function setEndDate(?string $endDate): CalculateTimeframesRequestInterface
    {
        $this->endDate = $this->validate->date($endDate);

        return $this;
    }

    /**
     * Get postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set postal code.
     *
     * @pattern ^.{1,10}$
     *
     * @example 2132WT
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$postalCode
     */
    public function setPostalCode(?string $postalCode): CalculateTimeframesRequestInterface
    {
        $this->postalCode = $this->validate->postcode($postalCode);

        return $this;
    }

    /**
     * Get interval.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$interval
     */
    public function getInterval(): ?int
    {
        return $this->interval;
    }

    /**
     * Set interval.
     *
     * @pattern ^(?:30|60)$
     *
     * @example 30
     *
     * @param int|null $interval
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$interval
     */
    public function setInterval(?int $interval): CalculateTimeframesRequestInterface
    {
        $this->interval = $this->validate->interval($this->validate->integer($interval));

        return $this;
    }

    /**
     * Get house number.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$houseNumber
     */
    public function getHouseNumber(): ?int
    {
        return $this->houseNumber;
    }

    /**
     * Set house number.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 42
     *
     * @param int|string|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateTimeframesRequestInterface
    {
        $this->houseNumber = $this->validate->integer($houseNumber);

        return $this;
    }

    /**
     * Get house number extension.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$houseNrExt
     */
    public function getHouseNrExt(): ?string
    {
        return $this->houseNrExt;
    }

    /**
     * Set house number extension.
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateTimeframesRequestInterface
    {
        $this->houseNrExt = $this->validate->genericString($houseNrExt);

        return $this;
    }

    /**
     * Get timeframe range.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$timeframeRange
     */
    public function getTimeframeRange(): ?string
    {
        return $this->timeframeRange;
    }

    /**
     * Set timeframe range.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 14:00-15:00
     *
     * @var string|null
     *
     * @param string|null $timeframeRange
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$timeframeRange
     */
    public function setTimeframeRange(?string $timeframeRange): CalculateTimeframesRequestInterface
    {
        $this->timeframeRange = $this->validate->timeRangeShort($timeframeRange);

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$street
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set street.
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$street
     */
    public function setStreet(?string $street): CalculateTimeframesRequestInterface
    {
        $this->street = $this->validate->street($street);

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set city.
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @param string|null $city
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$city
     */
    public function setCity(?string $city): CalculateTimeframesRequestInterface
    {
        $this->city = $this->validate->genericString($city);

        return $this;
    }

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$countryCode
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * Set country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateTimeframesRequestInterface
    {
        $this->countryCode = $this->validate->isoAlpha2CountryCodeNlBe($countryCode);

        return $this;
    }

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$options
     */
    public function setOptions(?array $options): CalculateTimeframesRequestInterface
    {
        $this->options = $options;

        return $this;
    }
}
