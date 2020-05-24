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
use ReflectionClass;
use ReflectionException;

/**
 * Class Address.
 */
final class Address extends AbstractEntity implements AddressInterface
{
    const TYPE_RECEIVER = '01';
    const TYPE_SENDER = '02';
    const TYPE_ALTERNATIVE_SENDER = '03';
    const TYPE_COLLECTION_ADDRESS = '04';
    const TYPE_RETURN_ADDRESS = '08';
    const DROP_OFF_LOCATION = '09';

    /**
     * PostNL internal applications validate the receiver address. In case the spelling of
     * addresses should be different according to our PostNL information, the address details will
     * be corrected. This can be noticed in Track & Trace.
     *
     * Please note that the webservice will not add address details. Street and City fields will
     * only be printed when they are in the call towards the labeling webservice.
     *
     * The element Address type is a code in the request. Possible values are:
     *
     * Code Description
     * 01   Receiver
     * 02   Sender
     * 03   Alternative sender address
     * 04   Collection address (In the orders need to be collected first)
     * 08   Return address*
     * 09   Drop off location (for use with Pick up at PostNL location)
     *
     * > * When using the ‘label in the box return label’, it is mandatory to use an
     * >   `Antwoordnummer` in AddressType 08.
     * >   This cannot be a regular address
     *
     * The following rules apply:
     * If there is no Address specified with AddressType = 02, the data from Customer/Address
     * will be added to the list as AddressType 02.
     * If there is no Customer/Address, the message will be rejected.
     *
     * At least one other AddressType must be specified, other than AddressType 02
     * In most cases this will be AddressType 01, the receiver address.
     *
     * @var string|null
     *
     * @pattern ^\d{2}$
     *
     * @example 02
     *
     * @since   1.0.0
     */
    private $addressType;

    /**
     * Area of the address.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example Beukenhorst
     *
     * @since   1.0.0
     */
    private $area;

    /**
     * Building name of the address.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example AA
     *
     * @since   1.0.0
     */
    private $buildingname;

    /**
     * City of the address.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @since   1.0.0
     */
    private $city;

    /**
     * This field has a dependency with the field Name. One of both fields must be filled mandatory; using both fields is also allowed. Mandatory when AddressType is 09.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example PostNL
     *
     * @since   1.0.0
     */
    private $companyName;

    /**
     * The ISO-2 country code.
     *
     * @var string|null
     *
     * @pattern ^[A-Z]{2}$
     *
     * @example NL
     *
     * @since   1.0.0
     */
    private $countrycode;

    /**
     * Send to specific department of a company.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example IT
     *
     * @since   1.0.0
     */
    private $department;

    /**
     * Door code of address. Mandatory for some international shipments.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example 123
     *
     * @since   1.0.0
     */
    private $doorcode;

    /**
     * Remark: please add FirstName and Name (lastname) of the receiver to improve the parcel tracking experience of your customer.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example Peter
     *
     * @since   1.0.0
     */
    private $firstname;

    /**
     * Send to specific floor of a company.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example 4
     *
     * @since   1.0.0
     */
    private $floor;

    /**
     * Mandatory for shipments to Benelux. Max. length is 5 characters (only for Benelux addresses). For Benelux addresses,this field should always be numeric.
     *
     * @var string|int|null
     *
     * @pattern ^.{0,35}$
     *
     * @example 42
     *
     * @since   1.0.0
     */
    private $houseNr;

    /**
     * House number extension.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example A
     *
     * @since   1.0.0
     */
    private $houseNrExt;

    /**
     * Combination of Street, HouseNr and HouseNrExt. Please see Guidelines for the explanation.
     * The field StreetHouseNrExt is only usable for locations in NL, BE and DE.
     *
     * @var string|null
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef 42 A
     *
     * @since   2.0.0
     */
    private $streetHouseNrExt;

    /**
     * Last name of person. This field has a dependency with the field CompanyName. One of both fields must be filled mandatory; using both fields is also allowed. Remark: please add FirstName and
     * Name (lastname) of the receiver to improve the parcel tracking experience of your customer.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example de Ruiter
     *
     * @since   1.0.0
     */
    private $name;

    /**
     * Region.
     *
     * @var string|null
     *
     * @pattern ^.{0,35}$
     *
     * @example Noord-Holland
     *
     * @since   1.0.0
     */
    private $region;

    /**
     * Remark of the shipment.
     *
     * @var string|null
     *
     * @pattern ^.{0,1000}$
     *
     * @example Opmerking
     *
     * @since   1.0.0
     */
    private $remark;

    /**
     * This field has a dependency with the field StreetHouseNrExt. One of both fields must be filled mandatory; using both fields is also allowed.
     *
     * @var string|null
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @since   1.0.0
     */
    private $street;

    /**
     * Zip / postal code.
     *
     * @var string|null
     *
     * @pattern ^.{0,10}$
     *
     * @example 2132WT
     *
     * @since   1.0.0
     */
    private $zipcode;

    /**
     * Get address type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$addressType
     */
    public function getAddressType(): ?string
    {
        return $this->addressType;
    }

    /**
     * Set the AddressType.
     *
     * Type of the address. This is a code.
     *
     * @pattern ^\d{2}$
     *
     * @param string|null $addressType
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$addressType
     */
    public function setAddressType(?string $addressType = null): AddressInterface
    {
        $this->addressType = $this->validate->addressType($addressType);

        return $this;
    }

    /**
     * Get zip / postal code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$zipcode
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

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
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 2132WT
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$zipcode
     */
    public function setZipcode(?string $zip = null): AddressInterface
    {
        $this->zipcode = $this->validate->postcode($zip);

        return $this;
    }

    /**
     * Get area.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see Address::$area
     */
    public function getArea(): ?string
    {
        return $this->area;
    }

    /**
     * Set area.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $area
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Beukenhorst
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$area
     */
    public function setArea(?string $area): AddressInterface
    {
        $this->area = $this->validate->area($area);

        return $this;
    }

    /**
     * Get building name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$buildingname
     */
    public function getBuildingname(): ?string
    {
        return $this->buildingname;
    }

    /**
     * Set building name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $buildingname
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example AA
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$buildingname
     */
    public function setBuildingname(?string $buildingname): AddressInterface
    {
        $this->buildingname = $this->validate->buildingName($buildingname);

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$city
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
     * @param string|null $city
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Hoofddorp
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$city
     */
    public function setCity(?string $city): AddressInterface
    {
        $this->city = $this->validate->city($city);

        return $this;
    }

    /**
     * Get company name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$companyName
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * Set company name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $companyName
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example PostNL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$companyName
     */
    public function setCompanyName(?string $companyName): AddressInterface
    {
        $this->companyName = $this->validate->companyName($companyName);

        return $this;
    }

    /**
     * Get country code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$countrycode
     */
    public function getCountrycode(): ?string
    {
        return $this->countrycode;
    }

    /**
     * Set country code.
     *
     * @pattern ^[A-Z]{2}$
     *
     * @param string|null $countrycode
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$countrycode
     */
    public function setCountrycode(?string $countrycode): AddressInterface
    {
        $this->countrycode = $this->validate->isoAlpha2CountryCode($countrycode);

        return $this;
    }

    /**
     * Get department.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$department
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * Set department.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $department
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example IT
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$department
     */
    public function setDepartment(?string $department): AddressInterface
    {
        $this->department = $this->validate->department($department);

        return $this;
    }

    /**
     * Get door code.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$doorcode
     */
    public function getDoorcode(): ?string
    {
        return $this->doorcode;
    }

    /**
     * Set door code.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $doorcode
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example 123
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$doorcode
     */
    public function setDoorcode(?string $doorcode): AddressInterface
    {
        $this->doorcode = $this->validate->doorcode($doorcode);

        return $this;
    }

    /**
     * Get first name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$firstname
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set first name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $firstName
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Peter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$firstname
     */
    public function setFirstname(?string $firstName): AddressInterface
    {
        $this->firstname = $this->validate->firstName($firstName);

        return $this;
    }

    /**
     * Get last name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::getName()
     */
    public function getLastname(): ?string
    {
        return $this->getName();
    }

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
    public function setLastname(?string $lastname): AddressInterface
    {
        return $this->setName($lastname);
    }

    /**
     * Get floor.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$floor
     */
    public function getFloor(): ?string
    {
        return $this->floor;
    }

    /**
     * Set floor.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $floor
     *
     * @return AddressInterface
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
    public function setFloor(?string $floor): AddressInterface
    {
        static $maxLength = 35;
        if (is_string($floor) && mb_strlen($floor) > $maxLength) {
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid floor given, must be max %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $maxLength));
        }

        $this->floor = $floor;

        return $this;
    }

    /**
     * Get house number.
     *
     * @return string|int|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$houseNr
     */
    public function getHouseNr()
    {
        return $this->houseNr;
    }

    /**
     * Set house number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|int|null $houseNr
     *
     * @return AddressInterface
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
    public function setHouseNr($houseNr): AddressInterface
    {
        if (is_int($houseNr)) {
            $houseNr = (string) $houseNr;
        }
        if (is_string($houseNr)) {
            if ($this->countrycode && in_array($this->countrycode, ['NL', 'BE', 'LU'])) {
                if (mb_strlen($houseNr) > 5) {
                    throw new InvalidArgumentException(sprintf('%s::%s - Invalid house number given, must be max 5 characters long for NL, BE & LU', (new ReflectionClass($this))->getShortName(), __METHOD__));
                }
            } elseif (mb_strlen($houseNr) > 35) {
                throw new InvalidArgumentException(sprintf('%s::%s - Invalid house number given, must be max 35 characters long outside NL, BE & LU', (new ReflectionClass($this))->getShortName(), __METHOD__));
            }
        }

        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * Get house number extension.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$houseNrExt
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
     * @param string|int|null $houseNrExt
     *
     * @return AddressInterface
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
    public function setHouseNrExt($houseNrExt): AddressInterface
    {
        static $maxLength = 35;
        if (is_int($houseNrExt)) {
            $houseNrExt = (string) $houseNrExt;
        }
        if (is_string($houseNrExt) && mb_strlen($houseNrExt) > $maxLength) {
            throw new InvalidArgumentException(sprintf('%s::%s - Invalid house number extension given, must be max %d characters long', (new ReflectionClass($this))->getShortName(), __METHOD__, $maxLength));
        }
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * Get street + house number + extension.
     *
     * @return string|null
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$streetHouseNrExt
     */
    public function getStreetHouseNrExt(): ?string
    {
        return $this->streetHouseNrExt;
    }

    /**
     * Set street + house number + extension.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $streetHouseNrExt
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Siriusdreef 42 A
     *
     * @since   2.0.0 Strict typing
     * @see     Address::$streetHouseNrExt
     */
    public function setStreetHouseNrExt(?string $streetHouseNrExt): AddressInterface
    {
        $this->streetHouseNrExt = $this->validate->streetHouseNumberExtension($streetHouseNrExt);

        return $this;
    }

    /**
     * Get last name.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set last name.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $name
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example de Ruiter
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$name
     */
    public function setName(?string $name): AddressInterface
    {
        $this->name = $this->validate->lastName($name);

        return $this;
    }

    /**
     * Get region.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$region
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * Set region.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $region
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Noord-Holland
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$region
     */
    public function setRegion(?string $region): AddressInterface
    {
        $this->region = $this->validate->region($region);

        return $this;
    }

    /**
     * Get remark.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$remark
     */
    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * Set remark.
     *
     * @pattern ^.{0,1000}$
     *
     * @param string|null $remark
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Opmerking
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$remark
     */
    public function setRemark(?string $remark): AddressInterface
    {
        $this->remark = $this->validate->remark($remark);

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Address::$street
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
     * @param string|null $street
     *
     * @return AddressInterface
     *
     * @throws InvalidArgumentException
     *
     * @example Siriusdreef
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Address::$street
     */
    public function setStreet(?string $street): AddressInterface
    {
        $this->street = $this->validate->street($street);

        return $this;
    }
}
