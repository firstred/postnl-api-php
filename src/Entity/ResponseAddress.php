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

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class ResponseAddress
 */
class ResponseAddress extends SerializableObject
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
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $AddressType = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Area = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Buildingname = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $City = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $CompanyName = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Countrycode = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Department = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Doorcode = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $FirstName = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Floor = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $HouseNr = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $HouseNrExt = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Name = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Region = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Remark = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Street = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Zipcode = null;

    /**
     * ResponseAddress constructor.
     *
     * @param string      $service
     * @param string      $propType
     * @param string|null $AddressType
     * @param string|null $FirstName
     * @param string|null $Name
     * @param string|null $CompanyName
     * @param string|null $Street
     * @param string|null $HouseNr
     * @param string|null $HouseNrExt
     * @param string|null $Zipcode
     * @param string|null $City
     * @param string|null $Countrycode
     * @param string|null $Area
     * @param string|null $Buildingname
     * @param string|null $Department
     * @param string|null $Doorcode
     * @param string|null $Floor
     * @param string|null $Region
     * @param string|null $Remark
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,

        string|null $AddressType = null,
        string|null $FirstName = null,
        string|null $Name = null,
        string|null $CompanyName = null,
        string|null $Street = null,
        string|null $HouseNr = null,
        string|null $HouseNrExt = null,
        string|null $Zipcode = null,
        string|null $City = null,
        string|null $Countrycode = null,
        string|null $Area = null,
        string|null $Buildingname = null,
        string|null $Department = null,
        string|null $Doorcode = null,
        string|null $Floor = null,
        string|null $Region = null,
        string|null $Remark = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setAddressType(AddressType: $AddressType);
        $this->setFirstName(FirstName: $FirstName);
        $this->setName(Name: $Name);
        $this->setCompanyName(CompanyName: $CompanyName);
        $this->setStreet(Street: $Street);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setZipcode(Zipcode: $Zipcode);
        $this->setCity(City: $City);
        $this->setCountrycode(Countrycode: $Countrycode);

        // Optional parameters.
        $this->setArea(Area: $Area);
        $this->setBuildingname(Buildingname: $Buildingname);
        $this->setDepartment(Department: $Department);
        $this->setDoorcode(Doorcode: $Doorcode);
        $this->setFloor(Floor: $Floor);
        $this->setRegion(Region: $Region);
        $this->setRemark(Remark: $Remark);
    }

    /**
     * @return string|null
     */
    public function getAddressType(): string|null
    {
        return $this->AddressType;
    }

    /**
     * @param string|null $AddressType
     *
     * @return static
     */
    public function setAddressType(string|null $AddressType = null): static
    {
        $this->AddressType = $AddressType;

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
     * @param string|null $Area
     *
     * @return static
     */
    public function setArea(string|null $Area = null): static
    {
        $this->Area = $Area;

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
     * @param string|null $Buildingname
     *
     * @return static
     */
    public function setBuildingname(string|null $Buildingname = null): static
    {
        $this->Buildingname = $Buildingname;

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
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

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
     * @param string|null $CompanyName
     *
     * @return static
     */
    public function setCompanyName(string|null $CompanyName = null): static
    {
        $this->CompanyName = $CompanyName;

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
     * @param string|null $Countrycode
     *
     * @return static
     */
    public function setCountrycode(string|null $Countrycode = null): static
    {
        $this->Countrycode = $Countrycode;

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
     * @param string|null $Department
     *
     * @return static
     */
    public function setDepartment(string|null $Department = null): static
    {
        $this->Department = $Department;

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
     * @param string|null $Doorcode
     *
     * @return static
     */
    public function setDoorcode(string|null $Doorcode = null): static
    {
        $this->Doorcode = $Doorcode;

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
     * @param string|null $FirstName
     *
     * @return static
     */
    public function setFirstName(string|null $FirstName = null): static
    {
        $this->FirstName = $FirstName;

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
     * @param string|null $Floor
     *
     * @return static
     */
    public function setFloor(string|null $Floor = null): static
    {
        $this->Floor = $Floor;

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
     * @param string|null $HouseNr
     *
     * @return static
     */
    public function setHouseNr(string|null $HouseNr = null): static
    {
        $this->HouseNr = $HouseNr;

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
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

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
     * @param string|null $Name
     *
     * @return static
     */
    public function setName(string|null $Name = null): static
    {
        $this->Name = $Name;

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
     * @param string|null $Region
     *
     * @return static
     */
    public function setRegion(string|null $Region = null): static
    {
        $this->Region = $Region;

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
     * @param string|null $Remark
     *
     * @return static
     */
    public function setRemark(string|null $Remark = null): static
    {
        $this->Remark = $Remark;

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
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

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
     * @param string|null $Zipcode
     *
     * @return static
     */
    public function setZipcode(string|null $Zipcode = null): static
    {
        if (is_null(value: $Zipcode)) {
            $this->Zipcode = null;
        } else {
            $this->Zipcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $Zipcode));
        }

        return $this;
    }
}
