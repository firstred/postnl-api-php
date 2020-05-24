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
 * Interface CalculateDeliveryDateRequestInterface.
 */
interface CalculateDeliveryDateRequestInterface extends EntityInterface
{
    /**
     * Get zip / postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$postalCode
     */
    public function getPostalCode(): ?string;

    /**
     * Set the zip / postcode.
     *
     * @pattern ^.{0,10}$
     *
     * @example 2132WT
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$postalCode
     */
    public function setPostalCode(?string $postcode = null): CalculateDeliveryDateRequest;

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$city
     */
    public function getCity(): ?string;

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
     * @see     CalculateDeliveryDateRequest::$city
     */
    public function setCity(?string $city): CalculateDeliveryDateRequest;

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$countryCode
     */
    public function getCountryCode(): ?string;

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
     * @see     CalculateDeliveryDateRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateDeliveryDateRequest;

    /**
     * Get house number.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$houseNumber
     */
    public function getHouseNumber(): ?int;

    /**
     * Set house number.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 42
     *
     * @param string|int|float|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateDeliveryDateRequest;

    /**
     * Get house number extension.
     *
     * Get house number extension
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$houseNrExt
     */
    public function getHouseNrExt(): ?string;

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
     * @see     CalculateDeliveryDateRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateDeliveryDateRequest;

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$options
     */
    public function getOptions(): ?array;

    /**
     * Set options.
     *
     * @pattern ^(?:Daytime|Evening|Morning|Noon|Sunday|Sameday|Afternoon|MyTime|Pickup)$
     *
     * @example Daytime
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$options
     */
    public function setOptions(?array $options): CalculateDeliveryDateRequest;

    /**
     * Get origin country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$originCountryCode
     */
    public function getOriginCountryCode(): ?string;

    /**
     * Set origin country code.
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @param string|null $originCountryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$originCountryCode
     */
    public function setOriginCountryCode(?string $originCountryCode): CalculateDeliveryDateRequest;

    /**
     * Get shipping date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$shippingDate
     */
    public function getShippingDate(): ?string;

    /**
     * Set shipping date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 03-07-2019 17:00:00
     *
     * @param string|null $shippingDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$shippingDate
     */
    public function setShippingDate(?string $shippingDate): CalculateDeliveryDateRequest;

    /**
     * Get shipping duration.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$shippingDuration
     */
    public function getShippingDuration(): ?int;

    /**
     * Set shipping duration.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 2
     *
     * @param int|float|string|null $shippingDuration
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$shippingDuration
     */
    public function setShippingDuration($shippingDuration): CalculateDeliveryDateRequest;

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$street
     */
    public function getStreet(): ?string;

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
     * @see     CalculateDeliveryDateRequest::$street
     */
    public function setStreet(?string $street): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time.
     *
     * @return mixed
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTime
     */
    public function getCutOffTime();

    /**
     * Set cut-off time.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param mixed $cutOffTime
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTime
     */
    public function setCutOffTime($cutOffTime): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Monday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeMonday
     */
    public function getCutOffTimeMonday(): ?string;

    /**
     * Set cut-off time Monday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeMonday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeMonday
     */
    public function setCutOffTimeMonday(?string $cutOffTimeMonday): CalculateDeliveryDateRequest;

    /**
     * Get available Monday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableMonday
     */
    public function getAvailableMonday(): ?bool;

    /**
     * Set available Monday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableMonday
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableMonday
     */
    public function setAvailableMonday(?bool $availableMonday): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Tuesday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeTuesday
     */
    public function getCutOffTimeTuesday(): ?string;

    /**
     * Set cut-off time Tuesday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeTuesday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeTuesday
     */
    public function setCutOffTimeTuesday(?string $cutOffTimeTuesday): CalculateDeliveryDateRequest;

    /**
     * Get available Tuesday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableTuesday
     */
    public function getAvailableTuesday(): ?bool;

    /**
     * Set available Tuesday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableTuesday
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableTuesday
     */
    public function setAvailableTuesday(?bool $availableTuesday): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Wednesday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeWednesday
     */
    public function getCutOffTimeWednesday(): ?string;

    /**
     * Set cut-off time Wednesday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeWednesday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeWednesday
     */
    public function setCutOffTimeWednesday(?string $cutOffTimeWednesday): CalculateDeliveryDateRequest;

    /**
     * Get available Wednesday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableWednesday
     */
    public function getAvailableWednesday(): ?bool;

    /**
     * Set available Wednesday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableWednesday
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableWednesday
     */
    public function setAvailableWednesday(?bool $availableWednesday): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Thursday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeThursday
     */
    public function getCutOffTimeThursday(): ?string;

    /**
     * Set cut-off time Thursday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeThursday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeThursday
     */
    public function setCutOffTimeThursday(?string $cutOffTimeThursday): CalculateDeliveryDateRequest;

    /**
     * Get available Thursday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableThursday
     */
    public function getAvailableThursday(): ?bool;

    /**
     * Set available Thursday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableThursday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableThursday
     */
    public function setAvailableThursday(?bool $availableThursday): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Friday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeFriday
     */
    public function getCutOffTimeFriday(): ?string;

    /**
     * Set cut-off time Friday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeFriday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeFriday
     */
    public function setCutOffTimeFriday(?string $cutOffTimeFriday): CalculateDeliveryDateRequest;

    /**
     * Get available Friday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableFriday
     */
    public function getAvailableFriday(): ?bool;

    /**
     * Set available Friday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableFriday
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableFriday
     */
    public function setAvailableFriday(?bool $availableFriday): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Saturday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeSaturday
     */
    public function getCutOffTimeSaturday(): ?string;

    /**
     * Set cut-off time Saturday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeSaturday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeSaturday
     */
    public function setCutOffTimeSaturday(?string $cutOffTimeSaturday): CalculateDeliveryDateRequest;

    /**
     * Get available Saturday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableSaturday
     */
    public function getAvailableSaturday(): ?bool;

    /**
     * Set available Saturday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableSaturday
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableSaturday
     */
    public function setAvailableSaturday(?bool $availableSaturday): CalculateDeliveryDateRequest;

    /**
     * Get cut-off time Sunday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeSunday
     */
    public function getCutOffTimeSunday(): ?string;

    /**
     * Set cut-off time Sunday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @param string|null $cutOffTimeSunday
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$cutOffTimeSunday
     */
    public function setCutOffTimeSunday(?string $cutOffTimeSunday): CalculateDeliveryDateRequest;

    /**
     * Get available Sunday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableSunday
     */
    public function getAvailableSunday(): ?bool;

    /**
     * Set available Sunday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $availableSunday
     *
     * @return static
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$availableSunday
     */
    public function setAvailableSunday(?bool $availableSunday): CalculateDeliveryDateRequest;
}
