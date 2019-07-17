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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;

/**
 * Class ResponseAddress
 */
class ResponseAddress extends AbstractEntity
{
    /**
     * @var string|null $addressType
     *
     * PostNL internal applications validate the receiver ResponseAddress. In case the spelling of
     * ResponseAddresses should be different according to our PostNL information, the ResponseAddress details will
     * be corrected. This can be noticed in Track & Trace.
     *
     * Please note that the webservice will not add ResponseAddress details. Street and City fields will
     * only be printed when they are in the call towards the labeling webservice.
     *
     * The element ResponseAddress type is a code in the request. Possible values are:
     *
     * Code Description
     * 01   Receiver
     * 02   Sender
     * 03   Alternative sender ResponseAddress
     * 04   Collection ResponseAddress (In the orders need to be collected first)
     * 08   Return ResponseAddress*
     * 09   Drop off location (for use with Pick up at PostNL location)
     *
     * > * When using the ‘label in the box return label’, it is mandatory to use an
     * >   `Antwoordnummer` in AddressType 08.
     * >   This cannot be a regular ResponseAddress
     *
     * The following rules apply:
     * If there is no ResponseAddress specified with AddressType = 02, the data from Customer/ResponseAddress
     * will be added to the list as AddressType 02.
     * If there is no Customer/ResponseAddress, the message will be rejected.
     *
     * At least one other AddressType must be specified, other than AddressType 02
     * In most cases this will be AddressType 01, the receiver ResponseAddress.
     */
    protected $addressType;
    /** @var string|null $area */
    protected $area;
    /** @var string|null $buildingname */
    protected $buildingname;
    /** @var string|null $city */
    protected $city;
    /** @var string|null $companyName */
    protected $companyName;
    /** @var string|null $countrycode */
    protected $countrycode;
    /** @var string|null $department */
    protected $department;
    /** @var string|null $doorcode */
    protected $doorcode;
    /** @var string|null $firstName */
    protected $firstName;
    /** @var string|null $floor */
    protected $floor;
    /** @var string|null $houseNr */
    protected $houseNr;
    /** @var string|null $houseNrExt */
    protected $houseNrExt;
    /** @var string|null $name */
    protected $name;
    /** @var string|null $region */
    protected $region;
    /** @var string|null $remark */
    protected $remark;
    /** @var string|null $street */
    protected $street;
    /** @var string|null $zipcode */
    protected $zipcode;

    /**
     * @param string|null $addressType
     * @param string|null $firstName
     * @param string|null $name
     * @param string|null $companyName
     * @param string|null $street
     * @param string|null $houseNr
     * @param string|null $houseNrExt
     * @param string|null $zipcode
     * @param string|null $city
     * @param string|null $countryCode
     * @param string|null $area
     * @param string|null $buildingName
     * @param string|null $department
     * @param string|null $doorcode
     * @param string|null $floor
     * @param string|null $region
     * @param string|null $remark
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $addressType = null, ?string $firstName = null, ?string $name = null, ?string $companyName = null, ?string $street = null, ?string $houseNr = null, ?string $houseNrExt = null, ?string $zipcode = null, ?string $city = null, ?string $countryCode = null, ?string $area = null, ?string $buildingName = null, ?string $department = null, ?string $doorcode = null, ?string $floor = null, ?string $region = null, ?string $remark = null)
    {
        parent::__construct();

        $this->setAddressType($addressType);
        $this->setFirstName($firstName);
        $this->setName($name);
        $this->setCompanyName($companyName);
        $this->setStreet($street);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setCountrycode($countryCode);

        // Optional parameters.
        $this->setArea($area);
        $this->setBuildingname($buildingName);
        $this->setDepartment($department);
        $this->setDoorcode($doorcode);
        $this->setFloor($floor);
        $this->setRegion($region);
        $this->setRemark($remark);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * Set postcode
     *
     * @param string|null $zip
     *
     * @return static
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function setZipcode($zip = null): ResponseAddress
    {
        if (is_null($zip)) {
            $this->zipcode = null;
        } else {
            $this->zipcode = strtoupper(str_replace(' ', '', $zip));
        }

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAddressType(): ?string
    {
        return $this->addressType;
    }

    /**
     * @param string|null $addressType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAddressType(?string $addressType): ResponseAddress
    {
        $this->addressType = $addressType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getArea(): ?string
    {
        return $this->area;
    }

    /**
     * @param string|null $area
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setArea(?string $area): ResponseAddress
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBuildingname(): ?string
    {
        return $this->buildingname;
    }

    /**
     * @param string|null $buildingname
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBuildingname(?string $buildingname): ResponseAddress
    {
        $this->buildingname = $buildingname;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): ResponseAddress
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCompanyName(?string $companyName): ResponseAddress
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCountrycode(): ?string
    {
        return $this->countrycode;
    }

    /**
     * @param string|null $countrycode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCountrycode(?string $countrycode): ResponseAddress
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @param string|null $department
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDepartment(?string $department): ResponseAddress
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDoorcode(): ?string
    {
        return $this->doorcode;
    }

    /**
     * @param string|null $doorcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDoorcode(?string $doorcode): ResponseAddress
    {
        $this->doorcode = $doorcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setFirstName(?string $firstName): ResponseAddress
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getFloor(): ?string
    {
        return $this->floor;
    }

    /**
     * @param string|null $floor
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setFloor(?string $floor): ResponseAddress
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNr(): ?string
    {
        return $this->houseNr;
    }

    /**
     * @param string|null $houseNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNr(?string $houseNr): ResponseAddress
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNrExt(): ?string
    {
        return $this->houseNrExt;
    }

    /**
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNrExt(?string $houseNrExt): ResponseAddress
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setName(?string $name): ResponseAddress
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRegion(?string $region): ResponseAddress
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * @param string|null $remark
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRemark(?string $remark): ResponseAddress
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): ResponseAddress
    {
        $this->street = $street;

        return $this;
    }
}
