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
interface ValidatedAddressInterface extends EntityInterface
{
    /**
     * Get postal code.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$postalCode
     */
    public function getPostalCode(): ?string;

    /**
     * Set postal code.
     *
     * @pattern ^.{0,10}$
     *
     * @param string|null $postalCode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3123WT
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$postalCode
     */
    public function setPostalCode(?string $postalCode): ValidatedAddressInterface;

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$city
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
     * @see     ValidatedAddress::$city
     */
    public function setCity(?string $city): ValidatedAddressInterface;

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$street
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
     * @see     ValidatedAddress::$street
     */
    public function setStreet(?string $street): ValidatedAddressInterface;

    /**
     * Get house number.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$houseNumber
     */
    public function getHouseNumber(): ?string;

    /**
     * Set house number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $houseNumber
     *
     * @return static
     *
     * @example 42
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$houseNumber
     */
    public function setHouseNumber(?string $houseNumber): ValidatedAddressInterface;

    /**
     * Get house number addition.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$addition
     */
    public function getAddition(): ?string;

    /**
     * Set house number addition.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $addition
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example A
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$addition
     */
    public function setAddition(?string $addition): ValidatedAddressInterface;

    /**
     * Get formatted address.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$formattedAddress
     */
    public function getFormattedAddress(): ?array;

    /**
     * Set formatted address.
     *
     * @pattern N/A
     *
     * @param string[]|null $formattedAddress
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$formattedAddress
     */
    public function setFormattedAddress(?array $formattedAddress): ValidatedAddressInterface;

    /**
     * Get Geocode.
     *
     * @return GeocodeInterface|null
     *
     * @since 2.0.0
     * @see   Geocode
     */
    public function getGeocode(): ?GeocodeInterface;

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
    public function setGeocode(?GeocodeInterface $geocode): ValidatedAddressInterface;

    /**
     * Get result number.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$resultNumber
     */
    public function getResultNumber(): ?string;

    /**
     * Set result number.
     *
     * @pattern ^\d{1,10}$
     *
     * @param string|float|int|null $resultNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 13
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$resultNumber
     */
    public function setResultNumber($resultNumber): ValidatedAddressInterface;

    /**
     * Get mailability score.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$mailabilityScore
     */
    public function getMailabilityScore(): ?int;

    /**
     * Set mailability score.
     *
     * @pattern \d{1,3}$
     *
     * @param int|float|string|null $mailabilityScore
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 50
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$mailabilityScore
     */
    public function setMailabilityScore($mailabilityScore): ValidatedAddressInterface;

    /**
     * Get result percentage.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$resultPercentage
     */
    public function getResultPercentage(): ?int;

    /**
     * Set result percentage.
     *
     * @pattern ^\d{1,3}$
     *
     * @param int|string|float|null $resultPercentage
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 60
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$resultPercentage
     */
    public function setResultPercentage($resultPercentage): ValidatedAddressInterface;

    /**
     * Get province.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   ValidatedAddress::$province
     */
    public function getProvince(): ?string;

    /**
     * Set province.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $province
     *
     * @return static
     *
     * @example Zuid-Holland
     *
     * @since   2.0.0
     * @see     ValidatedAddress::$province
     */
    public function setProvince(?string $province): ValidatedAddressInterface;
}
