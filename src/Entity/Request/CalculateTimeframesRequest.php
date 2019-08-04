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

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class CalculateTimeframesRequest
 */
class CalculateTimeframesRequest extends AbstractEntity
{
    /**
     * Allow Sunday sorting
     *
     * @var bool|null $allowSundaySorting
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @since   2.0.0
     */
    protected $allowSundaySorting;

    /**
     * Start date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null $startDate
     *
     * @since   2.0.0
     */
    protected $startDate;

    /**
     * End date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null $endDate
     *
     * @since   2.0.0
     */
    protected $endDate;

    /**
     * Postal code
     *
     * @pattern ^.{1,10}$
     *
     * @example 2132WT
     *
     * @var string|null $postalCode
     *
     * @since   2.0.0
     */
    protected $postalCode;

    /**
     * Filter for MyTime shipments (possible: 60/30); choose 60 if you only want ‘whole hour’ timeframes returned
     *
     * @pattern ^(?:30|60)$
     *
     * @example 30
     *
     * @var int|null $interval
     *
     * @since   2.0.0
     */
    protected $interval;

    /**
     * House number
     *
     * @pattern ^\d{1,10}$
     *
     * @example 42
     *
     * @var int|null $houseNumber
     *
     * @since   2.0.0
     */
    protected $houseNumber;

    /**
     * House number extension
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @var string|null $houseNrExt
     *
     * @since   2.0.0
     */
    protected $houseNrExt;

    /**
     * Filter for MyTime shipments; format H:i-H:i. Specifies which timeframes you want returned in the response.
     *
     * @var string|null $timeframeRange
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @example 14:00-15:00
     *
     * @since   2.0.0
     */
    protected $timeframeRange;

    /**
     * Street
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @var string|null $street
     *
     * @since   2.0.0
     */
    protected $street;

    /**
     * City
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @var string|null $city
     *
     * @since   2.0.0
     */
    protected $city;

    /**
     * Country code
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @var string|null $countryCode
     *
     * @since   2.0.0
     */
    protected $countryCode;

    /**
     * The delivery options for which timeframes should be returned. At least one delivery option must be specified. See Guidelines for possible values.
     * Available values: Daytime, Sameday, Evening, Morning, Noon, Sunday, Afternoon, MyTime
     *
     * @pattern ^(?:Daytime|Sameday|Evening|Morning| Noon|Sunday|Afternoon|MyTime)$
     *
     * @example Daytime
     *
     * @var string[]|null $options
     *
     * @since   2.0.0
     */
    protected $options;

    /**
     * Timeframe constructor.
     *
     * @since 2.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get allow Sunday sorting
     *
     * @return bool|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$allowSundaySorting
     */
    public function getAllowSundaySorting(): ?bool
    {
        return $this->allowSundaySorting;
    }

    /**
     * Set allow sunday sorting
     *
     * @pattern N/A
     *
     * @param bool|null $allowSundaySorting
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$allowSundaySorting
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting): CalculateTimeframesRequest
    {
        $this->allowSundaySorting = $allowSundaySorting;

        return $this;
    }

    /**
     * Get start date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$startDate
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * Set start date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $startDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$startDate
     */
    public function setStartDate(?string $startDate): CalculateTimeframesRequest
    {
        $this->startDate = ValidateAndFix::date($startDate);

        return $this;
    }

    /**
     * Get end date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$endDate
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * Set end date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $endDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$endDate
     */
    public function setEndDate(?string $endDate): CalculateTimeframesRequest
    {
        $this->endDate = ValidateAndFix::date($endDate);

        return $this;
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set postal code
     *
     * @pattern ^.{1,10}$
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2132WT
     *
     * @see     CalculateTimeframesRequest::$postalCode
     *
     * @since   2.0.0
     */
    public function setPostalCode(?string $postalCode): CalculateTimeframesRequest
    {
        $this->postalCode = ValidateAndFix::postcode($postalCode);

        return $this;
    }

    /**
     * Get interval
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$interval
     */
    public function getInterval(): ?int
    {
        return $this->interval;
    }

    /**
     * Set interval
     *
     * @pattern ^(?:30|60)$
     *
     * @param int|null $interval
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 30
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$interval
     */
    public function setInterval(?int $interval): CalculateTimeframesRequest
    {
        $this->interval = ValidateAndFix::interval(ValidateAndFix::integer($interval));

        return $this;
    }

    /**
     * Get house number
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$houseNumber
     */
    public function getHouseNumber(): ?int
    {
        return $this->houseNumber;
    }

    /**
     * Set house number
     *
     * @pattern ^\d{1,10}$
     *
     * @param int|string|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 42
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateTimeframesRequest
    {
        $this->houseNumber = ValidateAndFix::integer($houseNumber);

        return $this;
    }

    /**
     * Get house number extension
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$houseNrExt
     */
    public function getHouseNrExt(): ?string
    {
        return $this->houseNrExt;
    }

    /**
     * Set house number extension
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example A
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateTimeframesRequest
    {
        $this->houseNrExt = ValidateAndFix::genericString($houseNrExt);

        return $this;
    }

    /**
     * Get timeframe range
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$timeframeRange
     */
    public function getTimeframeRange(): ?string
    {
        return $this->timeframeRange;
    }

    /**
     * Set timeframe range
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $timeframeRange
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @var string|null   $timeframeRange
     *
     * @example 14:00-15:00
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$timeframeRange
     */
    public function setTimeframeRange(?string $timeframeRange): CalculateTimeframesRequest
    {
        $this->timeframeRange = ValidateAndFix::timeRangeShort($timeframeRange);

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$street
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$street
     *
     * @example Siriusdreef
     */
    public function setStreet(?string $street): CalculateTimeframesRequest
    {
        $this->street = ValidateAndFix::street($street);

        return $this;
    }

    /**
     * Get city
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $city
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Hoofddorp
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$city
     */
    public function setCity(?string $city): CalculateTimeframesRequest
    {
        $this->city = ValidateAndFix::genericString($city);

        return $this;
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$countryCode
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * Set country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @example NL
     *
     * @see     CalculateTimeframesRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateTimeframesRequest
    {
        $this->countryCode = ValidateAndFix::countryCodeNlBe($countryCode);

        return $this;
    }

    /**
     * Get options
     *
     * @return string[]|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframesRequest::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @pattern N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframesRequest::$options
     */
    public function setOptions(?array $options): CalculateTimeframesRequest
    {
        $this->options = $options;

        return $this;
    }
}
