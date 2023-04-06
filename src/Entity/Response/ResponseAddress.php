<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Enum\SoapNamespace;

/**
 * @since 1.0.0
 */
class ResponseAddress extends AbstractEntity
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
     *
     * At least one other AddressType must be specified, other than AddressType 02
     * In most cases this will be AddressType 01, the receiver ResponseAddress.
     *
     * @var string|null $AddressType
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $AddressType = null;

    /** @var string|null $Area */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Area = null;

    /** @var string|null $Buildingname */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Buildingname = null;

    /** @var string|null $City */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $City = null;

    /** @var string|null $CompanyName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CompanyName = null;

    /** @var string|null $Countrycode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Countrycode = null;

    /** @var string|null $Department */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Department = null;

    /** @var string|null $Doorcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Doorcode = null;

    /** @var string|null $FirstName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $FirstName = null;

    /** @var string|null $Floor */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Floor = null;

    /** @var string|null $HouseNr */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HouseNr = null;

    /** @var string|null $HouseNrExt */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HouseNrExt = null;

    /** @var string|null $Name */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Name = null;

    /** @var string|null $Region */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Region = null;

    /** @var string|null $Remark */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Remark = null;

    /** @var string|null $Street */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Street = null;

    /** @var string|null $Zipcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Zipcode = null;

    protected ?array $other = [];

    /**
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
     * @param string|null $BuildingName
     * @param string|null $Department
     * @param string|null $Doorcode
     * @param string|null $Floor
     * @param string|null $Region
     * @param string|null $Remark
     */
    public function __construct(
        ?string $AddressType = null,
        ?string $FirstName = null,
        ?string $Name = null,
        ?string $CompanyName = null,
        ?string $Street = null,
        ?string $HouseNr = null,
        ?string $HouseNrExt = null,
        ?string $Zipcode = null,
        ?string $City = null,
        ?string $Countrycode = null,
        ?string $Area = null,
        ?string $BuildingName = null,
        ?string $Department = null,
        ?string $Doorcode = null,
        ?string $Floor = null,
        ?string $Region = null,
        ?string $Remark = null
    ) {
        parent::__construct();

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
        $this->setBuildingname(Buildingname: $BuildingName);
        $this->setDepartment(Department: $Department);
        $this->setDoorcode(Doorcode: $Doorcode);
        $this->setFloor(Floor: $Floor);
        $this->setRegion(Region: $Region);
        $this->setRemark(Remark: $Remark);
    }

    /**
     * @return string|null
     */
    public function getAddressType(): ?string
    {
        return $this->AddressType;
    }

    /**
     * @param string|null $AddressType
     *
     * @return static
     */
    public function setAddressType(?string $AddressType): static
    {
        $this->AddressType = $AddressType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArea(): ?string
    {
        return $this->Area;
    }

    /**
     * @param string|null $Area
     *
     * @return static
     */
    public function setArea(?string $Area): static
    {
        $this->Area = $Area;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingname(): ?string
    {
        return $this->Buildingname;
    }

    /**
     * @param string|null $Buildingname
     *
     * @return static
     */
    public function setBuildingname(?string $Buildingname): static
    {
        $this->Buildingname = $Buildingname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(?string $City): static
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    /**
     * @param string|null $CompanyName
     *
     * @return static
     */
    public function setCompanyName(?string $CompanyName): static
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountrycode(): ?string
    {
        return $this->Countrycode;
    }

    /**
     * @param string|null $Countrycode
     *
     * @return static
     */
    public function setCountrycode(?string $Countrycode): static
    {
        $this->Countrycode = $Countrycode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->Department;
    }

    /**
     * @param string|null $Department
     *
     * @return static
     */
    public function setDepartment(?string $Department): static
    {
        $this->Department = $Department;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDoorcode(): ?string
    {
        return $this->Doorcode;
    }

    /**
     * @param string|null $Doorcode
     *
     * @return static
     */
    public function setDoorcode(?string $Doorcode): static
    {
        $this->Doorcode = $Doorcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    /**
     * @param string|null $FirstName
     *
     * @return static
     */
    public function setFirstName(?string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFloor(): ?string
    {
        return $this->Floor;
    }

    /**
     * @param string|null $Floor
     *
     * @return static
     */
    public function setFloor(?string $Floor): static
    {
        $this->Floor = $Floor;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNr(): ?string
    {
        return $this->HouseNr;
    }

    /**
     * @param string|null $HouseNr
     *
     * @return static
     */
    public function setHouseNr(?string $HouseNr): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): ?string
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(?string $HouseNrExt): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     *
     * @return static
     */
    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->Region;
    }

    /**
     * @param string|null $Region
     *
     * @return static
     */
    public function setRegion(?string $Region): static
    {
        $this->Region = $Region;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRemark(): ?string
    {
        return $this->Remark;
    }

    /**
     * @param string|null $Remark
     *
     * @return static
     */
    public function setRemark(?string $Remark): static
    {
        $this->Remark = $Remark;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(?string $Street): static
    {
        $this->Street = $Street;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOther(): ?array
    {
        return $this->other;
    }

    /**
     * @param array|null $other
     *
     * @return ResponseAddress
     */
    public function setOther(?array $other): static
    {
        $this->other = $other;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->Zipcode;
    }

    /**
     * @param string|null $Zipcode
     *
     * @return static
     */
    public function setZipcode(string $Zipcode = null): static
    {
        if (is_null(value: $Zipcode)) {
            $this->Zipcode = null;
        } else {
            $this->Zipcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $Zipcode));
        }

        return $this;
    }
}
