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

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class GetNearestLocations
 *
 * This class is both the container and can be the actual GetNearestLocations object itself!
 */
class GetNearestLocations extends AbstractEntity
{
    /**
     * Country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null $countrycode
     *
     * @since 1.0.0
     */
    protected $countrycode;

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
     * Delivery date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 03-07-2019
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    protected $deliveryDate;

    /**
     * Opening time
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 09:00:00
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    protected $openingTime;

    /**
     * Delivery options
     *
     * @pattern ^(?:PG|PGE)$
     *
     * @example PGE
     *
     * @var array|null $deliveryOptions
     *
     * @since   2.0.0
     */
    protected $deliveryOptions;

    /**
     * GetNearestLocations constructor.
     *
     * @throws TypeError
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$countrycode
     */
    public function getCountrycode(): ?string
    {
        return $this->countrycode;
    }

    /**
     * Set country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $countrycode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example NL
     *
     * @since 1.0.0
     * @since   2.0.0
     *
     * @see     GetNearestLocations::$countrycode
     */
    public function setCountrycode(?string $countrycode): GetNearestLocations
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$postalCode
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
     * @since   2.0.0
     *
     * @see     GetNearestLocations::$postalCode
     */
    public function setPostalCode(?string $postalCode): GetNearestLocations
    {
        $this->postalCode = ValidateAndFix::postcode($postalCode);

        return $this;
    }

    /**
     * Get city
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$city
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
     * @see     GetNearestLocations::$city
     */
    public function setCity(?string $city): GetNearestLocations
    {
        $this->city = ValidateAndFix::city($city);

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$street
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
     * @since   2.0.0
     *
     * @see     GetNearestLocations::$street
     */
    public function setStreet(?string $street): GetNearestLocations
    {
        $this->street = ValidateAndFix::street($street);

        return $this;
    }

    /**
     * Get house number
     *
     * @return int|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$houseNumber
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
     * @see     GetNearestLocations::$houseNumber
     */
    public function setHouseNumber($houseNumber): GetNearestLocations
    {
        $this->houseNumber = ValidateAndFix::integer($houseNumber);

        return $this;
    }

    /**
     * Get delivery date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$deliveryDateq
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
     * @since   2.0.0
     *
     * @see     GetNearestLocations::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): GetNearestLocations
    {
        $this->deliveryDate = ValidateAndFix::date($deliveryDate);

        return $this;
    }

    /**
     * Get opening time
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$openingTime
     */
    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    /**
     * Set opening time
     *
     * @pattern ^(?:2[0-3]|[01]?[0-9]):(?:[0-5]?[0-9]):(?:[0-5]?[0-9])$
     *
     * @example 09:00:00
     *
     * @param string|null $openingTime
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @since   2.0.0
     *
     * @see     GetNearestLocations::$openingTime
     */
    public function setOpeningTime(?string $openingTime): GetNearestLocations
    {
        $this->openingTime = ValidateAndFix::time($openingTime);

        return $this;
    }

    /**
     * Get delivery options
     *
     * @return array|null
     *
     * @since 2.0.0
     *
     * @see   GetNearestLocations::$deliveryOptions
     */
    public function getDeliveryOptions(): ?array
    {
        return $this->deliveryOptions;
    }

    /**
     * Set delivery options
     *
     * @pattern ^(?:PG|PGE)$
     *
     * @example PGE
     *
     * @param array|null $deliveryOptions
     *
     * @return static
     *
     * @throws TypeError
     *
     * @since   2.0.0
     *
     * @see     GetNearestLocations::$deliveryOptions
     */
    public function setDeliveryOptions(?array $deliveryOptions): GetNearestLocations
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }
}
