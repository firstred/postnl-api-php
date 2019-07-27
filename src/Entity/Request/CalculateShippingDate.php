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
 * Class CalculateShippingDate
 */
class CalculateShippingDate extends AbstractEntity
{
    /**
     * Delivery date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null $deliveryDate
     *
     * @since 1.0.0
     */
    protected $deliveryDate;

    /**
     * Shipping duration
     *
     * @pattern ^\d{1,10}$
     *
     * @example 1
     *
     * @var string|null $shippingDuration
     *
     * @since 1.0.0
     */
    protected $shippingDuration;

    /**
     * Postal code
     *
     * @pattern ^{0,10}$
     *
     * @example 2132WT
     *
     * @var string|null $postalCode
     *
     * @since   1.0.0
     */
    protected $postalCode;

    /**
     * Country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null $countryCode
     *
     * @since 1.0.0
     */
    protected $countryCode;

    /**
     * Origin country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null $originCountryCode
     *
     * @since   1.0.0
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
     * @since 1.0.0
     */
    protected $city;

    /**
     * Street name
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @var string|null $street
     *
     * @since   1.0.0
     */
    protected $street;

    /**
     * House number
     *
     * @pattern ^.{0,35}$
     *
     * @example 42
     *
     * @var string|null $houseNumber
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
     * @since 1.0.0
     */
    protected $houseNrExt;

    /**
     * CalculateShippingDate constructor.
     *
     * @param string|null $city
     * @param string|null $countryCode
     * @param string|null $houseNr
     * @param string|null $houseNrExt
     * @param string|null $postalCode
     * @param string|null $deliveryDate
     * @param string|null $street
     * @param string|null $shippingDuration
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $city = null, ?string $countryCode = null, ?string $houseNr = null, ?string $houseNrExt = null, ?string $postalCode = null, ?string $deliveryDate = null, ?string $street = null, ?string $shippingDuration = null)
    {
        parent::__construct();

        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setHouseNumber($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setPostalCode($postalCode);
        $this->setDeliveryDate($deliveryDate);
        $this->setStreet($street);
        $this->setShippingDuration($shippingDuration);
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the postcode
     *
     * @pattern ^{0,10}$
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example 2132WT
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$postalCode
     */
    public function setPostalCode($postcode = null): CalculateShippingDate
    {
        if (is_null($postcode)) {
            $this->postalCode = null;
        } else {
            $this->postalCode = strtoupper(str_replace(' ', '', $postcode));
        }

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$city
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
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$city
     */
    public function setCity(?string $city): CalculateShippingDate
    {
        $this->city = ValidateAndFix::city($city);

        return $this;
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$countryCode
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
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$countryCode
     */
    public function setCountryCode(?string $countryCode): CalculateShippingDate
    {
        $this->countryCode = ValidateAndFix::countryCodeNlBe($countryCode);

        return $this;
    }

    /**
     * Get delivery date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$deliveryDate
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 03-07-2019
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): CalculateShippingDate
    {
        $this->deliveryDate = ValidateAndFix::dateTime($deliveryDate);

        return $this;
    }

    /**
     * Get house number
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$houseNumber
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * Set house number
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $houseNumber
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example 42
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$houseNumber
     */
    public function setHouseNumber(?string $houseNumber): CalculateShippingDate
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get house number extension
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$houseNrExt
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
     *
     * @example A
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$houseNrExt
     */
    public function setHouseNrExt(?string $houseNrExt): CalculateShippingDate
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * Get shipping duration
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$shippingDuration
     */
    public function getShippingDuration(): ?string
    {
        return $this->shippingDuration;
    }

    /**
     * Set shipping duration
     *
     * @pattern ^\d{1,10}$
     *
     * @param string|null $shippingDuration
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example 1
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$shippingDuration
     */
    public function setShippingDuration(?string $shippingDuration): CalculateShippingDate
    {
        $this->shippingDuration = $shippingDuration;

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   CalculateShippingDate::$street
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
     * @example Siriusdreef
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see     CalculateShippingDate::$street
     */
    public function setStreet(?string $street): CalculateShippingDate
    {
        $this->street = ValidateAndFix::street($street);

        return $this;
    }

    /**
     * Get origin country code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see CalculateShippingDate::$originCountryCode
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
     * @example NL
     *
     * @param string|null $originCountryCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since 2.0.0
     *
     * @see CalculateShippingDate::$originCountryCode
     */
    public function setOriginCountryCode(?string $originCountryCode): CalculateShippingDate
    {
        $this->originCountryCode = $originCountryCode;

        return $this;
    }
}
