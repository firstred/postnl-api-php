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
 * Class CalculateShippingDateRequest
 *
 * This class is both the container and can be the actual CalculateShippingDateRequest object itself!
 */
class CalculateShippingDateRequest extends AbstractEntity
{
    /**
     * Delivery date
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @example 03-07-2019
     *
     * @var string|null $deliveryDate
     *
     * @since   2.0.0
     */
    protected $deliveryDate;

    /**
     * The duration it takes for the shipment to be delivered to PostNL in days. A value of 1 means that the parcel will be delivered to PostNL on the same day as the date specified in ShippingDate.
     * A value of 2 means the parcel will arrive at PostNL a day later etc
     *
     * @pattern ^\d{1,10}$
     *
     * @example 2
     *
     * @var int|null $shippingDuration
     *
     * @since   2.0.0
     */
    protected $shippingDuration;

    /**
     * Zip / postal code
     *
     * @var string|null $postalCode
     *
     * @pattern ^.{0,10}$
     *
     * @example 2132WT
     *
     * @since   2.0.0
     */
    protected $postalCode;

    /**
     * Country code
     *
     * @pattern ^(?:NL|BE))$
     *
     * @example NL
     *
     * @var string|null $countryCode
     *
     * @since   2.0.0
     */
    protected $countryCode;

    /**
     * Origin country code
     *
     * @pattern ^(?:NL|BE))$
     *
     * @example NL
     *
     * @var string|null $originCountryCode
     *
     * @since   2.0.0
     */
    protected $originCountryCode;

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
     * The street name of the delivery address.
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
     * @var string|null $houseNrExt
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @since   2.0.0
     */
    protected $houseNrExt;

    /**
     * CalculateShippingDateRequest constructor.
     *
     * @param string|null           $deliveryDate
     * @param int|float|string|null $shippingDuration
     * @param string|null           $postalCode
     * @param string|null           $countryCode
     * @param string|null           $originCountryCode
     * @param string|null           $city
     * @param string|null           $street
     * @param int|float|string|null $houseNumber
     * @param string|null           $houseNrExt
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(?string $deliveryDate = null, $shippingDuration = null, ?string $postalCode = null, ?string $countryCode = null, ?string $originCountryCode = null, ?string $city = null, ?string $street = null, $houseNumber = null, ?string $houseNrExt = null)
    {
        parent::__construct();

        $this->setDeliveryDate($deliveryDate);
        $this->setShippingDuration($shippingDuration);
        $this->setPostalCode($postalCode);
        $this->setCountryCode($countryCode);
        $this->setOriginCountryCode($originCountryCode);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setHouseNumber($houseNumber);
        $this->setHouseNrExt($houseNrExt);
    }

    /**
     * Get zip / postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the zip / postcode
     *
     * @pattern ^.{0,10}$
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2132WT
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$postalCode
     */
    public function setPostalCode(?string $postcode = null): CalculateShippingDateRequest
    {
        $this->postalCode = ValidateAndFix::postcode($postcode);

        return $this;
    }

    /**
     * Get city
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$city
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
     * @see     CalculateShippingDateRequest::$city
     */
    public function setCity(?string $city): CalculateShippingDateRequest
    {
        $this->city = ValidateAndFix::city($city);

        return $this;
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$countryCode
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
     * @example NL
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateShippingDateRequest
    {
        $this->countryCode = ValidateAndFix::isoAlpha2CountryCodeNlBe($countryCode);

        return $this;
    }

    /**
     * Get house number
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$houseNumber
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
     * @param string|int|float|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 42
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$houseNumber
     */
    public function setHouseNumber($houseNumber): CalculateShippingDateRequest
    {
        $this->houseNumber = ValidateAndFix::integer($houseNumber);

        return $this;
    }

    /**
     * Get house number extension
     *
     * Get house number extension
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$houseNrExt
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
     * @see     CalculateShippingDateRequest::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateShippingDateRequest
    {
        $this->houseNrExt = ValidateAndFix::genericString($houseNrExt);

        return $this;
    }

    /**
     * Get origin country code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$originCountryCode
     */
    public function getOriginCountryCode(): ?string
    {
        return $this->originCountryCode;
    }

    /**
     * Set origin country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $originCountryCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$originCountryCode
     */
    public function setOriginCountryCode(?string $originCountryCode): CalculateShippingDateRequest
    {
        $this->originCountryCode = ValidateAndFix::isoAlpha2CountryCodeNlBe($originCountryCode);

        return $this;
    }

    /**
     * Get shipping date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$deliveryDate
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set shipping date
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 17:00:00
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): CalculateShippingDateRequest
    {
        $this->deliveryDate = ValidateAndFix::date($deliveryDate);

        return $this;
    }

    /**
     * Get shipping duration
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$shippingDuration
     */
    public function getShippingDuration(): ?int
    {
        return $this->shippingDuration;
    }

    /**
     * Set shipping duration
     *
     * @pattern ^\d{1,10}$
     *
     * @param int|float|string|null $shippingDuration
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$shippingDuration
     */
    public function setShippingDuration($shippingDuration): CalculateShippingDateRequest
    {
        $this->shippingDuration = ValidateAndFix::integer($shippingDuration);

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CalculateShippingDateRequest::$street
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
     * @example Siriusdreef
     *
     * @since   2.0.0
     *
     * @see     CalculateShippingDateRequest::$street
     */
    public function setStreet(?string $street): CalculateShippingDateRequest
    {
        $this->street = ValidateAndFix::street($street);

        return $this;
    }
}
