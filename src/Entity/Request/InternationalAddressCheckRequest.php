<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
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
 *
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class InternationalAddressCheckRequest
 */
class InternationalAddressCheckRequest extends AbstractEntity
{
    /**
     * Country
     *
     * @pattern ^[A-Z]{3}$
     *
     * @example ITA
     *
     * @var string|null $country
     *
     * @since   2.0.0
     */
    protected $country;

    // @codingStandardsIgnoreStart
    /**
     * 1st string
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $q1
     *
     * @since   2.0.0
     */
    protected $q1;

    /**
     * 2nd string
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $q2
     *
     * @since   2.0.0
     */
    protected $q2;

    /**
     * 3rd string
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $q3
     *
     * @since   2.0.0
     */
    protected $q3;
    // @codingStandardsIgnoreEnd

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
     * Postal code
     *
     * @pattern ^{0,10}$
     *
     * @example 2132WT
     *
     * @var string|null $postalCode
     *
     * @since   2.0.0
     */
    protected $postalCode;

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
     * Building
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @var string|null $building
     *
     * @since   2.0.0
     */
    protected $building;

    /**
     * Sub building
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @var string|null $subBuilding
     *
     * @since   2.0.0
     */
    protected $subBuilding;

    /**
     * InternationalAddressCheckRequest constructor.
     *
     * @param string|null       $country
     * @param string|array|null $street
     * @param string|null       $houseNumber
     * @param string|null       $postalCode
     * @param string|null       $city
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(?string $country = null, $street = null, ?string $houseNumber = null, ?string $postalCode = null, ?string $city = null)
    {
        parent::__construct();

        $this->setCountry($country);
        if (is_array($street)) {
            list($q1, $q2, $q3) = array_pad($street, 3, null);
            $this->setQ1($q1);
            $this->setQ2($q2);
            $this->setQ3($q3);
        } else {
            $this->setStreet($street);
        }
        $this->setHouseNumber($houseNumber);
        $this->setPostalCode($postalCode);
        $this->setCity($city);
    }

    /**
     * Get ISO3166-1 alpha 3 country code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   InternationalAddressCheckRequest::$country
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Set ISO3166-1 alpha 3 country code
     *
     * @pattern ^[A-Z]{3}$
     *
     * @example ITA
     *
     * @param string|null $country
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     InternationalAddressCheckRequest::$country
     */
    public function setCountry(?string $country): InternationalAddressCheckRequest
    {
        $this->country = ValidateAndFix::isoAlpha3CountryCode($country);

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   InternationalAddressCheckRequest::$street
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
     * @example Siriusdreef
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     *
     * @see     InternationalAddressCheckRequest::$street
     *
     */
    public function setStreet(?string $street): InternationalAddressCheckRequest
    {
        $this->street = ValidateAndFix::street($street);

        return $this;
    }

    /**
     * Get house number
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   InternationalAddressCheckRequest::$houseNumber
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
     * @example 42
     *
     * @param string|null $houseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     InternationalAddressCheckRequest::$houseNumber
     *
     */
    public function setHouseNumber(?string $houseNumber): InternationalAddressCheckRequest
    {
        $this->houseNumber = ValidateAndFix::houseNumber($houseNumber);

        return $this;
    }

    /**
     * Get postal code
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   InternationalAddressCheckRequest::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set postal code
     *
     * @pattern ^{0,10}$
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
     * @see     InternationalAddressCheckRequest::$postalCode
     *
     */
    public function setPostalCode(?string $postalCode): InternationalAddressCheckRequest
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
     * @see   InternationalAddressCheckRequest::$city
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
     * @example Hoofddorp
     *
     * @param string|null $city
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     InternationalAddressCheckRequest::$city
     */
    public function setCity(?string $city): InternationalAddressCheckRequest
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get building
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   InternationalAddressCheckRequest::$building
     */
    public function getBuilding(): ?string
    {
        return $this->building;
    }

    /**
     * Set building
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @param string|null $building
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     InternationalAddressCheckRequest::$building
     */
    public function setBuilding(?string $building): InternationalAddressCheckRequest
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get sub building
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   InternationalAddressCheckRequest::$subBuilding
     */
    public function getSubBuilding(): ?string
    {
        return $this->subBuilding;
    }

    /**
     * Set sub building
     *
     * @pattern ^.{0,95}$
     *
     * @example N/A
     *
     * @param string|null $subBuilding
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     InternationalAddressCheckRequest::$subBuilding
     */
    public function setSubBuilding(?string $subBuilding): InternationalAddressCheckRequest
    {
        $this->subBuilding = $subBuilding;

        return $this;
    }

    /**
     * Get 1st string
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   InternationalAddressCheckRequest::$q1
     */
    public function getQ1(): ?string
    {
        return $this->q1;
    }

    /**
     * Set 1st string
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $q1
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     InternationalAddressCheckRequest::$q1
     */
    public function setQ1(?string $q1): InternationalAddressCheckRequest
    {
        $this->q1 = $q1;

        return $this;
    }

    /**
     * Get 2nd string
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   InternationalAddressCheckRequest::$q2
     */
    public function getQ2(): ?string
    {
        return $this->q2;
    }

    /**
     * Set 2nd string
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $q2
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     InternationalAddressCheckRequest::$q2
     */
    public function setQ2(?string $q2): InternationalAddressCheckRequest
    {
        $this->q2 = $q2;

        return $this;
    }

    /**
     * Get third string
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   InternationalAddressCheckRequest::$q3
     */
    public function getQ3(): ?string
    {
        return $this->q3;
    }

    /**
     * Set 3rd string
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $q3
     *
     * @return static
     *
     * @since   2.0.0 Strict typing
     *
     * @see     InternationalAddressCheckRequest::$q3
     */
    public function setQ3(?string $q3): InternationalAddressCheckRequest
    {
        $this->q3 = $q3;

        return $this;
    }

    /**
     * Serialize JSON
     *
     * @return array
     *
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        if ($this->getQ1()) {
            return [
                'Country' => $this->getCountry(),
                'q1'      => $this->getQ1(),
                'q2'      => $this->getQ2(),
                'q3'      => $this->getQ3(),
            ];
        }

        return parent::jsonSerialize();
    }
}
