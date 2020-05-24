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

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class ValidatedAddress.
 */
final class ValidatedAddress extends AbstractEntity implements ValidatedAddressInterface
{
    /**
     * Result number.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 13
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $resultNumber;

    /**
     * Mailability score.
     *
     * @pattern ^\d{1,3}$
     *
     * @example 50
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $mailabilityScore;

    /**
     * Result percentage.
     *
     * @pattern ^\d{1,3}$
     *
     * @example 50
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $resultPercentage;

    /**
     * Postal code.
     *
     * @pattern ^.{0,10}$
     *
     * @example 3123WT
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $postalCode;

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
     * House number.
     *
     * @pattern ^.{0,35}$
     *
     * @example 42
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $houseNumber;

    /**
     * Province.
     *
     * @pattern ^.{0,35}$
     *
     * @example Zuid-Holland
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $province;

    /**
     * House number addition.
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @var string|null
     *
     * @since   2.0.0
     */
    private $addition;

    /**
     * Formatted address.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null
     *
     * @since   2.0.0
     */
    private $formattedAddress;

    /**
     * Geocode.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var GeocodeInterface|null
     *
     * @since   2.0.0
     */
    private $geocode;

    /**
     * Get postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set postal code.
     *
     * @pattern ^.{0,10}$
     *
     * @example 3123WT
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$postalCode
     */
    public function setPostalCode(?string $postalCode): ValidatedAddressInterface
    {
        $this->postalCode = $this->validate->postcode($postalCode);

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$city
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
     * @see     ValidatedAddress::$city
     */
    public function setCity(?string $city): ValidatedAddressInterface
    {
        $this->city = $this->validate->city($city);

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$street
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
     * @see     ValidatedAddress::$street
     */
    public function setStreet(?string $street): ValidatedAddressInterface
    {
        $this->street = $this->validate->street($street);

        return $this;
    }

    /**
     * Get house number.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$houseNumber
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * Set house number.
     *
     * @pattern ^.{0,35}$
     *
     * @example 42
     *
     * @param string|null $houseNumber
     *
     * @return static
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$houseNumber
     */
    public function setHouseNumber(?string $houseNumber): ValidatedAddressInterface
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get house number addition.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$addition
     */
    public function getAddition(): ?string
    {
        return $this->addition;
    }

    /**
     * Set house number addition.
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @param string|null $addition
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$addition
     */
    public function setAddition(?string $addition): ValidatedAddressInterface
    {
        $this->addition = $this->validate->genericString($addition);

        return $this;
    }

    /**
     * Get formatted address.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$formattedAddress
     */
    public function getFormattedAddress(): ?array
    {
        return $this->formattedAddress;
    }

    /**
     * Set formatted address.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string[]|null $formattedAddress
     *
     * @return static
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$formattedAddress
     */
    public function setFormattedAddress(?array $formattedAddress): ValidatedAddressInterface
    {
        $this->formattedAddress = $formattedAddress;

        return $this;
    }

    /**
     * Get Geocode.
     *
     * @return GeocodeInterface|null
     *
     * @since 2.0.0
     * @see   Geocode
     */
    public function getGeocode(): ?GeocodeInterface
    {
        return $this->geocode;
    }

    /**
     * Set Geocode.
     *
     * @pattern N/A
     *
     * @param GeocodeInterface|null $geocode
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     Geocode
     */
    public function setGeocode(?GeocodeInterface $geocode): ValidatedAddressInterface
    {
        $this->geocode = $geocode;

        return $this;
    }

    /**
     * Get result number.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$resultNumber
     */
    public function getResultNumber(): ?string
    {
        return $this->resultNumber;
    }

    /**
     * Set result number.
     *
     * @pattern ^\d{1,10}$
     *
     * @example 13
     *
     * @param string|float|int|null $resultNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$resultNumber
     */
    public function setResultNumber($resultNumber): ValidatedAddressInterface
    {
        $this->resultNumber = $this->validate->integer($resultNumber);

        return $this;
    }

    /**
     * Get mailability score.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$mailabilityScore
     */
    public function getMailabilityScore(): ?int
    {
        return $this->mailabilityScore;
    }

    /**
     * Set mailability score.
     *
     * @pattern \d{1,3}$
     *
     * @example 50
     *
     * @param int|float|string|null $mailabilityScore
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$mailabilityScore
     */
    public function setMailabilityScore($mailabilityScore): ValidatedAddressInterface
    {
        $this->mailabilityScore = $this->validate->integer($mailabilityScore);

        return $this;
    }

    /**
     * Get result percentage.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$resultPercentage
     */
    public function getResultPercentage(): ?int
    {
        return $this->resultPercentage;
    }

    /**
     * Set result percentage.
     *
     * @pattern ^\d{1,3}$
     *
     * @example 60
     *
     * @param int|string|float|null $resultPercentage
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$resultPercentage
     */
    public function setResultPercentage($resultPercentage): ValidatedAddressInterface
    {
        $this->resultPercentage = $this->validate->integer($resultPercentage);

        return $this;
    }

    /**
     * Get province.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$province
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * Set province.
     *
     * @pattern ^.{0,35}$
     *
     * @example Zuid-Holland
     *
     * @param string|null $province
     *
     * @return static
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$province
     */
    public function setProvince(?string $province): ValidatedAddressInterface
    {
        $this->province = $province;

        return $this;
    }
}
