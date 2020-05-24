<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\EntityInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Interface CalculateTimeframesRequestInterface.
 */
interface CalculateTimeframesRequestInterface extends EntityInterface
{
    /**
     * Get allow Sunday sorting.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$allowSundaySorting
     */
    public function getAllowSundaySorting(): ?bool;

    /**
     * Set allow sunday sorting.
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
     * @see     CalculateTimeframesRequest::$allowSundaySorting
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting): CalculateTimeframesRequestInterface;

    /**
     * Get start date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$startDate
     */
    public function getStartDate(): ?string;

    /**
     * Set start date.
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
     * @see     CalculateTimeframesRequest::$startDate
     */
    public function setStartDate(?string $startDate): CalculateTimeframesRequestInterface;

    /**
     * Get end date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$endDate
     */
    public function getEndDate(): ?string;

    /**
     * Set end date.
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
     * @see     CalculateTimeframesRequest::$endDate
     */
    public function setEndDate(?string $endDate): CalculateTimeframesRequestInterface;

    /**
     * Get postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$postalCode
     */
    public function getPostalCode(): ?string;

    /**
     * Set postal code.
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
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$postalCode
     */
    public function setPostalCode(?string $postalCode): CalculateTimeframesRequestInterface;

    /**
     * Get interval.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$interval
     */
    public function getInterval(): ?int;

    /**
     * Set interval.
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
     * @see     CalculateTimeframesRequest::$interval
     */
    public function setInterval(?int $interval): CalculateTimeframesRequestInterface;

    /**
     * Get house number.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$houseNumber
     */
    public function getHouseNumber(): ?int;

    /**
     * Set house number.
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
     * @see     CalculateTimeframesRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateTimeframesRequestInterface;

    /**
     * Get house number extension.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$houseNrExt
     */
    public function getHouseNrExt(): ?string;

    /**
     * Set house number extension.
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
     * @see     CalculateTimeframesRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateTimeframesRequestInterface;

    /**
     * Get timeframe range.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$timeframeRange
     */
    public function getTimeframeRange(): ?string;

    /**
     * Set timeframe range.
     *
     * @pattern ^[0-2][0-9]:[0-5][0-9]-$[0-2][0-9]:[0-5][0-9]$
     *
     * @param string|null $timeframeRange
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @var string|null
     *
     * @example 14:00-15:00
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$timeframeRange
     */
    public function setTimeframeRange(?string $timeframeRange): CalculateTimeframesRequestInterface;

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$street
     */
    public function getStreet(): ?string;

    /**
     * Set street.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Siriusdreef
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$street
     */
    public function setStreet(?string $street): CalculateTimeframesRequestInterface;

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$city
     */
    public function getCity(): ?string;

    /**
     * Set city.
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
     * @see     CalculateTimeframesRequest::$city
     */
    public function setCity(?string $city): CalculateTimeframesRequestInterface;

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$countryCode
     */
    public function getCountryCode(): ?string;

    /**
     * Set country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   2.0.0
     * @see     CalculateTimeframesRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateTimeframesRequestInterface;

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   CalculateTimeframesRequest::$options
     */
    public function getOptions(): ?array;

    /**
     * Set options.
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
     * @see     CalculateTimeframesRequest::$options
     */
    public function setOptions(?array $options): CalculateTimeframesRequestInterface;
}
