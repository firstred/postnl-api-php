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
use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class CalculateTimeframes
 */
class CalculateTimeframes extends AbstractEntity
{
    /**
     * Allow Sunday sorting
     *
     * @var string|null $allowSundaySorting
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
     * @throws TypeError
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
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframes::$allowSundaySorting
     */
    public function getAllowSundaySorting(): ?string
    {
        return $this->allowSundaySorting;
    }

    /**
     * Set allow sunday sorting
     *
     * @pattern N/A
     *
     * @param string|null $allowSundaySorting
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$allowSundaySorting
     */
    public function setAllowSundaySorting(?string $allowSundaySorting): CalculateTimeframes
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
     * @see   CalculateTimeframes::$startDate
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
     * @throws TypeError
     *
     * @example 03-07-2019
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$startDate
     */
    public function setStartDate(?string $startDate): CalculateTimeframes
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get end date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateTimeframes::$endDate
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 03-07-2019
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$endDate
     */
    public function setEndDate(?string $endDate): CalculateTimeframes
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
     * @see   CalculateTimeframes::$postalCode
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 2132WT
     *
     * @see     CalculateTimeframes::$postalCode
     *
     * @since   2.0.0
     */
    public function setPostalCode(?string $postalCode): CalculateTimeframes
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
     * @see   CalculateTimeframes::$interval
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 30
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$interval
     */
    public function setInterval(?int $interval): CalculateTimeframes
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
     * @see   CalculateTimeframes::$houseNumber
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 42
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateTimeframes
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
     * @see   CalculateTimeframes::$houseNrExt
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example A
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateTimeframes
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
     * @see   CalculateTimeframes::$timeframeRange
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @var string|null   $timeframeRange
     *
     * @example 14:00-15:00
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$timeframeRange
     */
    public function setTimeframeRange(?string $timeframeRange): CalculateTimeframes
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
     * @see   CalculateTimeframes::$street
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$street
     *
     * @example Siriusdreef
     */
    public function setStreet(?string $street): CalculateTimeframes
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
     * @see   CalculateTimeframes::$city
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example Hoofddorp
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$city
     */
    public function setCity(?string $city): CalculateTimeframes
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
     * @see   CalculateTimeframes::$countryCode
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
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since   2.0.0
     *
     * @example NL
     *
     * @see     CalculateTimeframes::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateTimeframes
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
     * @see   CalculateTimeframes::$options
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
     * @throws TypeError
     *
     * @example N/A
     *
     * @since   2.0.0
     *
     * @see     CalculateTimeframes::$options
     */
    public function setOptions(?array $options): CalculateTimeframes
    {
        $this->options = $options;

        return $this;
    }
}
