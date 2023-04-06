<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;

use function is_string;

/**
 * @since 1.0.0
 */
class StatusAddress extends AbstractEntity
{
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
     * @var string|null $AddressType
     */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $AddressType = null;

    /** @var string|null $Building */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Building = null;

    /** @var string|null $City */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $City = null;

    /** @var string|null $CompanyName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CompanyName = null;

    /** @var string|null $CountryCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CountryCode = null;

    /** @var string|null $DepartmentName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $DepartmentName = null;

    /** @var string|null $District */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $District = null;

    /** @var string|null $FirstName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $FirstName = null;

    /** @var string|null $Floor */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Floor = null;

    /** @var string|null $HouseNumber */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HouseNumber = null;

    /** @var string|null $HouseNumberSuffix */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $HouseNumberSuffix = null;

    /** @var string|null $LastName */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $LastName = null;

    /** @var string|null $Region */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Region = null;

    /** @var string|null $RegistrationDate */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $RegistrationDate = null;

    /** @var string|null $Remark */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Remark = null;

    /** @var string|null $Street */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Street = null;

    /** @var string|null $Zipcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Zipcode = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string                       $AddressType = null,
        ?string                       $FirstName = null,
        ?string                       $LastName = null,
        ?string                       $CompanyName = null,
        ?string                       $DepartmentName = null,
        ?string                       $Street = null,
        ?string                       $HouseNumber = null,
        ?string                       $HouseNumberSuffix = null,
        ?string                       $Zipcode = null,
        ?string                       $City = null,
        ?string                       $CountryCode = null,
        ?string                       $Region = null,
        ?string                       $District = null,
        ?string                       $Building = null,
        ?string                       $Floor = null,
        ?string                       $Remark = null,
        DateTimeInterface|string|null $RegistrationDate = null
    ) {
        parent::__construct();

        $this->setAddressType(AddressType: $AddressType);
        $this->setBuilding(Building: $Building);
        $this->setCity(City: $City);
        $this->setCompanyName(CompanyName: $CompanyName);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDepartmentName(DepartmentName: $DepartmentName);
        $this->setDistrict(District: $District);
        $this->setFirstName(FirstName: $FirstName);
        $this->setFloor(Floor: $Floor);
        $this->setHouseNumber(HouseNumber: $HouseNumber);
        $this->setHouseNumberSuffix(HouseNumberSuffix: $HouseNumberSuffix);
        $this->setLastName(LastName: $LastName);
        $this->setRegion(Region: $Region);
        $this->setRegistrationDate(RegistrationDate: $RegistrationDate);
        $this->setRemark(Remark: $Remark);
        $this->setStreet(Street: $Street);
        $this->setZipcode(Zipcode: $Zipcode);
    }

    /**
     * @return string|null
     */
    public function getBuilding(): ?string
    {
        return $this->Building;
    }

    /**
     * @param string|null $Building
     *
     * @return static
     */
    public function setBuilding(?string $Building): static
    {
        $this->Building = $Building;

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
    public function getCountryCode(): ?string
    {
        return $this->CountryCode;
    }

    /**
     * @param string|null $CountryCode
     *
     * @return static
     */
    public function setCountryCode(?string $CountryCode): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartmentName(): ?string
    {
        return $this->DepartmentName;
    }

    /**
     * @param string|null $DepartmentName
     *
     * @return static
     */
    public function setDepartmentName(?string $DepartmentName): static
    {
        $this->DepartmentName = $DepartmentName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistrict(): ?string
    {
        return $this->District;
    }

    /**
     * @param string|null $District
     *
     * @return static
     */
    public function setDistrict(?string $District): static
    {
        $this->District = $District;

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
    public function getHouseNumber(): ?string
    {
        return $this->HouseNumber;
    }

    /**
     * @param string|null $HouseNumber
     *
     * @return static
     */
    public function setHouseNumber(?string $HouseNumber): static
    {
        $this->HouseNumber = $HouseNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNumberSuffix(): ?string
    {
        return $this->HouseNumberSuffix;
    }

    /**
     * @param string|null $HouseNumberSuffix
     *
     * @return static
     */
    public function setHouseNumberSuffix(?string $HouseNumberSuffix): static
    {
        $this->HouseNumberSuffix = $HouseNumberSuffix;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    /**
     * @param string|null $LastName
     *
     * @return static
     */
    public function setLastName(?string $LastName): static
    {
        $this->LastName = $LastName;

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
     * @return string|null
     */
    public function getAddressType(): ?string
    {
        return $this->AddressType;
    }

    /**
     * @return string|null
     */
    public function getRegistrationDate(): ?string
    {
        return $this->RegistrationDate;
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
    public function setZipcode(?string $Zipcode = null): static
    {
        if (is_null(value: $Zipcode)) {
            $this->Zipcode = null;
        } else {
            $this->Zipcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $Zipcode));
        }

        return $this;
    }

    /**
     * @param int|string|null $AddressType
     *
     * @return static
     */
    public function setAddressType(int|string|null $AddressType = null): static
    {
        if (is_null(value: $AddressType)) {
            $this->AddressType = null;
        } else {
            $this->AddressType = str_pad(string: (string) $AddressType, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT);
        }

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setRegistrationDate(DateTimeInterface|string|null $RegistrationDate = null): static
    {
        if (is_string(value: $RegistrationDate)) {
            try {
                $RegistrationDate = new DateTimeImmutable(datetime: $RegistrationDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->RegistrationDate = $RegistrationDate;

        return $this;
    }
}
