<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

/**
 * Class ResponseAddress
 */
class ResponseAddress
{
    /**
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
     * At least one other AddressType must be specified, other than AddressType 02
     * In most cases this will be AddressType 01, the receiver ResponseAddress.
     */
    protected string|null $AddressType = null;
    protected string|null $Area = null;
    protected string|null $Buildingname = null;
    protected string|null $City = null;
    protected string|null $CompanyName = null;
    protected string|null $Countrycode = null;
    protected string|null $Department = null;
    protected string|null $Doorcode = null;
    protected string|null $FirstName = null;
    protected string|null $Floor = null;
    protected string|null $HouseNr = null;
    protected string|null $HouseNrExt = null;
    protected string|null $Name = null;
    protected string|null $Region = null;
    protected string|null $Remark = null;
    protected string|null $Street = null;
    protected string|null $Zipcode = null;
    protected array|null $other = [];

    /**
     * ResponseAddress constructor.
     *
     * @param string|null $AddressType
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
     */
    public function __construct(
        string|null $AddressType = null,
        string|null $firstName = null,
        string|null $name = null,
        string|null $companyName = null,
        string|null $street = null,
        string|null $houseNr = null,
        string|null $houseNrExt = null,
        string|null $zipcode = null,
        string|null $city = null,
        string|null $countryCode = null,
        string|null $area = null,
        string|null $buildingName = null,
        string|null $department = null,
        string|null $doorcode = null,
        string|null $floor = null,
        string|null $region = null,
        string|null $remark = null,
    ) {
        $this->setAddressType(addressType: $AddressType);
        $this->setFirstName(firstName: $firstName);
        $this->setName(name: $name);
        $this->setCompanyName(companyName: $companyName);
        $this->setStreet(street: $street);
        $this->setHouseNr(houseNr: $houseNr);
        $this->setHouseNrExt(houseNrExt: $houseNrExt);
        $this->setZipcode(zipcode: $zipcode);
        $this->setCity(city: $city);
        $this->setCountrycode(countryCode: $countryCode);

        // Optional parameters.
        $this->setArea(area: $area);
        $this->setBuildingname(buildingName: $buildingName);
        $this->setDepartment(department: $department);
        $this->setDoorcode(doorcode: $doorcode);
        $this->setFloor(floor: $floor);
        $this->setRegion(region: $region);
        $this->setRemark(remark: $remark);
    }

    /**
     * @return string|null
     */
    public function getAddressType(): string|null
    {
        return $this->AddressType;
    }

    /**
     * @param string|null $addressType
     *
     * @return $this
     */
    public function setAddressType(string|null $addressType = null): static
    {
        $this->AddressType = $addressType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArea(): string|null
    {
        return $this->Area;
    }

    /**
     * @param string|null $area
     *
     * @return $this
     */
    public function setArea(string|null $area = null): static
    {
        $this->Area = $area;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingname(): string|null
    {
        return $this->Buildingname;
    }

    /**
     * @param string|null $buildingName
     *
     * @return $this
     */
    public function setBuildingname(string|null $buildingName = null): static
    {
        $this->Buildingname = $buildingName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->City;
    }

    /**
     * @param string|null $city
     *
     * @return $this
     */
    public function setCity(string|null $city = null): static
    {
        $this->City = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): string|null
    {
        return $this->CompanyName;
    }

    /**
     * @param string|null $companyName
     *
     * @return $this
     */
    public function setCompanyName(string|null $companyName = null): static
    {
        $this->CompanyName = $companyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountrycode(): string|null
    {
        return $this->Countrycode;
    }

    /**
     * @param string|null $countryCode
     *
     * @return $this
     */
    public function setCountrycode(string|null $countryCode = null): static
    {
        $this->Countrycode = $countryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartment(): string|null
    {
        return $this->Department;
    }

    /**
     * @param string|null $department
     *
     * @return $this
     */
    public function setDepartment(string|null $department = null): static
    {
        $this->Department = $department;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDoorcode(): string|null
    {
        return $this->Doorcode;
    }

    /**
     * @param string|null $doorcode
     *
     * @return $this
     */
    public function setDoorcode(string|null $doorcode = null): static
    {
        $this->Doorcode = $doorcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): string|null
    {
        return $this->FirstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return $this
     */
    public function setFirstName(string|null $firstName = null): static
    {
        $this->FirstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFloor(): string|null
    {
        return $this->Floor;
    }

    /**
     * @param string|null $floor
     *
     * @return $this
     */
    public function setFloor(string|null $floor = null): static
    {
        $this->Floor = $floor;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNr(): string|null
    {
        return $this->HouseNr;
    }

    /**
     * @param string|null $houseNr
     *
     * @return $this
     */
    public function setHouseNr(string|null $houseNr = null): static
    {
        $this->HouseNr = $houseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $houseNrExt
     *
     * @return $this
     */
    public function setHouseNrExt(string|null $houseNrExt = null): static
    {
        $this->HouseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): string|null
    {
        return $this->Name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(string|null $name = null): static
    {
        $this->Name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegion(): string|null
    {
        return $this->Region;
    }

    /**
     * @param string|null $region
     *
     * @return $this
     */
    public function setRegion(string|null $region = null): static
    {
        $this->Region = $region;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRemark(): string|null
    {
        return $this->Remark;
    }

    /**
     * @param string|null $remark
     *
     * @return $this
     */
    public function setRemark(string|null $remark = null): static
    {
        $this->Remark = $remark;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): string|null
    {
        return $this->Street;
    }

    /**
     * @param string|null $street
     *
     * @return $this
     */
    public function setStreet(string|null $street = null): static
    {
        $this->Street = $street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipcode(): string|null
    {
        return $this->Zipcode;
    }

    /**
     * Set postcode.
     *
     * @param string|null $zipcode
     *
     * @return $this
     */
    public function setZipcode($zipcode = null): static
    {
        if (is_null(value: $zipcode)) {
            $this->Zipcode = null;
        } else {
            $this->Zipcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $zipcode));
        }

        return $this;
    }
}
