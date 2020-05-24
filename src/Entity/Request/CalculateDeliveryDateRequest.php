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
 * Class CalculateDeliveryDateRequest.
 *
 * This class is both the container and can be the actual CalculateDeliveryDateRequest object itself!
 */
final class CalculateDeliveryDateRequest extends AbstractEntity
{
    /**
     * Date/time of preparing the shipment for sending.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @example 03-07-2019 17:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $shippingDate;

    /**
     * The duration it takes for the shipment to be delivered to PostNL in days. A value of 1 means that the parcel will be delivered to PostNL on the same day as the date specified in ShippingDate.
     * A value of 2 means the parcel will arrive at PostNL a day later etc.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 2
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $shippingDuration;

    /**
     * Cut-off time.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.00
     */
    private $cutOffTime;

    /**
     * Zip / postal code.
     *
     * @example 2132WT
     *
     * @var string|null
     *
     * @pattern ^.{0,10}$
     *
     * @since   2.0.0
     */
    private $postalCode;

    /**
     * Country code.
     *
     * @pattern ^(?:NL|BE))$
     *
     * @example NL
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $countryCode;

    /**
     * Origin country code.
     *
     * @pattern ^(?:NL|BE))$
     *
     * @example NL
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $originCountryCode;

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
     * The street name of the delivery address.
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
     * @example A
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @since   2.0.0
     */
    private $houseNrExt;

    /**
     * Available options: Daytime, Evening, Morning, Noon, Sunday, Sameday, Afternoon, MyTime, Pickup.
     *
     * @pattern ^(?:Daytime|Evening|Morning|Noon|Sunday|Sameday|Afternoon|MyTime|Pickup)$
     *
     * @example Daytime
     *
     * @var string[]|null
     *
     * @since   2.0.0
     */
    private $options;

    /**
     * Cut-off time Monday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeMonday;

    /**
     * Available on Monday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableMonday;

    /**
     * Cut-off time Tuesday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeTuesday;

    /**
     * Available on Tuesday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableTuesday;

    /**
     * Cut-off time Wednesday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeWednesday;

    /**
     * Available on Wednesday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableWednesday;

    /**
     * Cut-off time Thursday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeThursday;

    /**
     * Available on Thursday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableThursday;

    /**
     * Cut-off time Friday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeFriday;

    /**
     * Available on Friday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableFriday;

    /**
     * Cut-off time Saturday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeSaturday;

    /**
     * Available on Saturday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableSaturday;

    /**
     * Cut-off time Sunday.
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 15:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $cutOffTimeSunday;

    /**
     * Available on Sunday.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since   2.0.0
     */
    private $availableSunday;

    /**
     * Get zip / postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

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
    public function setPostalCode(?string $postcode = null): CalculateDeliveryDateRequest
    {
        $this->postalCode = $this->validate->postcode($postcode);

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$city
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
     * @see     CalculateDeliveryDateRequest::$city
     */
    public function setCity(?string $city): CalculateDeliveryDateRequest
    {
        $this->city = $this->validate->city($city);

        return $this;
    }

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$countryCode
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
     * @see     CalculateDeliveryDateRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateDeliveryDateRequest
    {
        $this->countryCode = $this->validate->isoAlpha2CountryCodeNlBe($countryCode);

        return $this;
    }

    /**
     * Get house number.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$houseNumber
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
     * @param string|int|float|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     CalculateDeliveryDateRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateDeliveryDateRequest
    {
        $this->houseNumber = $this->validate->integer($houseNumber);

        return $this;
    }

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
     * @see     CalculateDeliveryDateRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateDeliveryDateRequest
    {
        $this->houseNrExt = $this->validate->genericString($houseNrExt);

        return $this;
    }

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

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
    public function setOptions(?array $options): CalculateDeliveryDateRequest
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get origin country code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$originCountryCode
     */
    public function getOriginCountryCode(): ?string
    {
        return $this->originCountryCode;
    }

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
    public function setOriginCountryCode(?string $originCountryCode): CalculateDeliveryDateRequest
    {
        $this->originCountryCode = $this->validate->isoAlpha2CountryCodeNlBe($originCountryCode);

        return $this;
    }

    /**
     * Get shipping date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$shippingDate
     */
    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

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
    public function setShippingDate(?string $shippingDate): CalculateDeliveryDateRequest
    {
        $this->shippingDate = $this->validate->dateTime($shippingDate);

        return $this;
    }

    /**
     * Get shipping duration.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$shippingDuration
     */
    public function getShippingDuration(): ?int
    {
        return $this->shippingDuration;
    }

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
    public function setShippingDuration($shippingDuration): CalculateDeliveryDateRequest
    {
        $this->shippingDuration = $this->validate->integer($shippingDuration);

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$street
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
     * @see     CalculateDeliveryDateRequest::$street
     */
    public function setStreet(?string $street): CalculateDeliveryDateRequest
    {
        $this->street = $this->validate->street($street);

        return $this;
    }

    /**
     * Get cut-off time.
     *
     * @return mixed
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTime
     */
    public function getCutOffTime()
    {
        return $this->cutOffTime;
    }

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
    public function setCutOffTime($cutOffTime): CalculateDeliveryDateRequest
    {
        $this->cutOffTime = $this->validate->time($cutOffTime);

        return $this;
    }

    /**
     * Get cut-off time Monday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeMonday
     */
    public function getCutOffTimeMonday(): ?string
    {
        return $this->cutOffTimeMonday;
    }

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
    public function setCutOffTimeMonday(?string $cutOffTimeMonday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeMonday = $this->validate->time($cutOffTimeMonday);

        return $this;
    }

    /**
     * Get available Monday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableMonday
     */
    public function getAvailableMonday(): ?bool
    {
        return $this->availableMonday;
    }

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
    public function setAvailableMonday(?bool $availableMonday): CalculateDeliveryDateRequest
    {
        $this->availableMonday = $availableMonday;

        return $this;
    }

    /**
     * Get cut-off time Tuesday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeTuesday
     */
    public function getCutOffTimeTuesday(): ?string
    {
        return $this->cutOffTimeTuesday;
    }

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
    public function setCutOffTimeTuesday(?string $cutOffTimeTuesday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeTuesday = $this->validate->time($cutOffTimeTuesday);

        return $this;
    }

    /**
     * Get available Tuesday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableTuesday
     */
    public function getAvailableTuesday(): ?bool
    {
        return $this->availableTuesday;
    }

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
    public function setAvailableTuesday(?bool $availableTuesday): CalculateDeliveryDateRequest
    {
        $this->availableTuesday = $availableTuesday;

        return $this;
    }

    /**
     * Get cut-off time Wednesday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeWednesday
     */
    public function getCutOffTimeWednesday(): ?string
    {
        return $this->cutOffTimeWednesday;
    }

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
    public function setCutOffTimeWednesday(?string $cutOffTimeWednesday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeWednesday = $this->validate->time($cutOffTimeWednesday);

        return $this;
    }

    /**
     * Get available Wednesday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableWednesday
     */
    public function getAvailableWednesday(): ?bool
    {
        return $this->availableWednesday;
    }

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
    public function setAvailableWednesday(?bool $availableWednesday): CalculateDeliveryDateRequest
    {
        $this->availableWednesday = $availableWednesday;

        return $this;
    }

    /**
     * Get cut-off time Thursday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeThursday
     */
    public function getCutOffTimeThursday(): ?string
    {
        return $this->cutOffTimeThursday;
    }

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
    public function setCutOffTimeThursday(?string $cutOffTimeThursday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeThursday = $this->validate->time($cutOffTimeThursday);

        return $this;
    }

    /**
     * Get available Thursday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableThursday
     */
    public function getAvailableThursday(): ?bool
    {
        return $this->availableThursday;
    }

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
    public function setAvailableThursday(?bool $availableThursday): CalculateDeliveryDateRequest
    {
        $this->availableThursday = $this->validate->time($availableThursday);

        return $this;
    }

    /**
     * Get cut-off time Friday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeFriday
     */
    public function getCutOffTimeFriday(): ?string
    {
        return $this->cutOffTimeFriday;
    }

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
    public function setCutOffTimeFriday(?string $cutOffTimeFriday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeFriday = $this->validate->time($cutOffTimeFriday);

        return $this;
    }

    /**
     * Get available Friday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableFriday
     */
    public function getAvailableFriday(): ?bool
    {
        return $this->availableFriday;
    }

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
    public function setAvailableFriday(?bool $availableFriday): CalculateDeliveryDateRequest
    {
        $this->availableFriday = $availableFriday;

        return $this;
    }

    /**
     * Get cut-off time Saturday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeSaturday
     */
    public function getCutOffTimeSaturday(): ?string
    {
        return $this->cutOffTimeSaturday;
    }

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
    public function setCutOffTimeSaturday(?string $cutOffTimeSaturday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeSaturday = $this->validate->time($cutOffTimeSaturday);

        return $this;
    }

    /**
     * Get available Saturday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableSaturday
     */
    public function getAvailableSaturday(): ?bool
    {
        return $this->availableSaturday;
    }

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
    public function setAvailableSaturday(?bool $availableSaturday): CalculateDeliveryDateRequest
    {
        $this->availableSaturday = $availableSaturday;

        return $this;
    }

    /**
     * Get cut-off time Sunday.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$cutOffTimeSunday
     */
    public function getCutOffTimeSunday(): ?string
    {
        return $this->cutOffTimeSunday;
    }

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
    public function setCutOffTimeSunday(?string $cutOffTimeSunday): CalculateDeliveryDateRequest
    {
        $this->cutOffTimeSunday = $this->validate->time($cutOffTimeSunday);

        return $this;
    }

    /**
     * Get available Sunday.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   CalculateDeliveryDateRequest::$availableSunday
     */
    public function getAvailableSunday(): ?bool
    {
        return $this->availableSunday;
    }

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
    public function setAvailableSunday(?bool $availableSunday): CalculateDeliveryDateRequest
    {
        $this->availableSunday = $availableSunday;

        return $this;
    }
}
