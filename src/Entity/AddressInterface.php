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
use ReflectionException;

/**
 * Class Address.
 */
interface AddressInterface extends EntityInterface
{
    /**
     * Get address type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$addressType
     */
    public function getAddressType(): ?string;

    /**
     * Set the AddressType.
     *
     * Type of the address. This is a code.
     *
     * @pattern ^\d{2}$
     *
     * @param string|null $addressType
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$addressType
     */
    public function setAddressType(?string $addressType = null): AddressInterface;

    /**
     * Get zip / postal code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$zipcode
     */
    public function getZipcode(): ?string;

    /**
     * Set zip / postal code.
     *
     * Zipcode of the address.
     * Mandatory for shipments to Benelux.
     *
     * Max length:
     * - (NL)    6 characters
     * - (BE;LU) 4 numeric characters
     *
     * @pattern ^.{0,10}$
     *
     * @param string|null $zip
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2132WT
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$zipcode
     */
    public function setZipcode(?string $zip = null): AddressInterface;

    /**
     * Get area.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$area
     */
    public function getArea(): ?string;

    /**
     * Set area.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $area
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Beukenhorst
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$area
     */
    public function setArea(?string $area): AddressInterface;

    /**
     * Get building name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$buildingname
     */
    public function getBuildingname(): ?string;

    /**
     * Set building name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $buildingname
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example AA
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$buildingname
     */
    public function setBuildingname(?string $buildingname): AddressInterface;

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$city
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
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$city
     */
    public function setCity(?string $city): AddressInterface;

    /**
     * Get company name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$companyName
     */
    public function getCompanyName(): ?string;

    /**
     * Set company name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $companyName
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example PostNL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$companyName
     */
    public function setCompanyName(?string $companyName): AddressInterface;

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$countrycode
     */
    public function getCountrycode(): ?string;

    /**
     * Set country code.
     *
     * @pattern ^[A-Z]{2}$
     *
     * @param string|null $countrycode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$countrycode
     */
    public function setCountrycode(?string $countrycode): AddressInterface;

    /**
     * Get department.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$department
     */
    public function getDepartment(): ?string;

    /**
     * Set department.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $department
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example IT
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$department
     */
    public function setDepartment(?string $department): AddressInterface;

    /**
     * Get door code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$doorcode
     */
    public function getDoorcode(): ?string;

    /**
     * Set door code.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $doorcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 123
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$doorcode
     */
    public function setDoorcode(?string $doorcode): AddressInterface;

    /**
     * Get first name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$firstname
     */
    public function getFirstname(): ?string;

    /**
     * Set first name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $firstName
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Peter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$firstname
     */
    public function setFirstname(?string $firstName): AddressInterface;

    /**
     * Get last name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::getName()
     */
    public function getLastname(): ?string;

    /**
     * Set last name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $lastname
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example de Ruiter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::setName()
     */
    public function setLastname(?string $lastname): AddressInterface;

    /**
     * Get floor.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$floor
     */
    public function getFloor(): ?string;

    /**
     * Set floor.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $floor
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @example 4
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$floor
     */
    public function setFloor(?string $floor): AddressInterface;

    /**
     * Get house number.
     *
     * @return string|int|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$houseNr
     */
    public function getHouseNr();

    /**
     * Set house number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|int|null $houseNr
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @example 42
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$houseNr
     */
    public function setHouseNr($houseNr): AddressInterface;

    /**
     * Get house number extension.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$houseNrExt
     */
    public function getHouseNrExt(): ?string;

    /**
     * Set house number extension.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|int|null $houseNrExt
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @example A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$houseNrExt
     */
    public function setHouseNrExt($houseNrExt): AddressInterface;

    /**
     * Get street + house number + extension.
     *
     * @return string|null
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$streetHouseNrExt
     */
    public function getStreetHouseNrExt(): ?string;

    /**
     * Set street + house number + extension.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $streetHouseNrExt
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Siriusdreef 42 A
     *
     * @since   2.0.0 Strict typing
     * @see     Address::$streetHouseNrExt
     */
    public function setStreetHouseNrExt(?string $streetHouseNrExt): AddressInterface;

    /**
     * Get last name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$name
     */
    public function getName(): ?string;

    /**
     * Set last name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $name
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example de Ruiter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$name
     */
    public function setName(?string $name): AddressInterface;

    /**
     * Get region.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$region
     */
    public function getRegion(): ?string;

    /**
     * Set region.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $region
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Noord-Holland
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$region
     */
    public function setRegion(?string $region): AddressInterface;

    /**
     * Get remark.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$remark
     */
    public function getRemark(): ?string;

    /**
     * Set remark.
     *
     * @pattern ^.{0,1000}$
     *
     * @param string|null $remark
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Opmerking
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$remark
     */
    public function setRemark(?string $remark): AddressInterface;

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$street
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
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$street
     */
    public function setStreet(?string $street): AddressInterface;
}
