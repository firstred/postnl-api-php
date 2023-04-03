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

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class Shipment extends AbstractEntity
{
    /** @var Address[]|null $Addresses */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Address::class, isArray: true)]
    protected ?array $Addresses = null;

    /** @var Amount[]|null $Amounts */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Amount::class, isArray: true)]
    protected ?array $Amounts = null;

    /** @var string|null $Barcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Barcode = null;

    /** @var DateTimeInterface|null $CollectionTimeStampEnd */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $CollectionTimeStampEnd = null;

    /** @var DateTimeInterface|null $CollectionTimeStampStart */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $CollectionTimeStampStart = null;

    /** @var Contact[]|null $Contacts */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Contact::class, isArray: true)]
    protected ?array $Contacts = null;

    /** @var string|null $Content */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Content = null;

    /** @var string|null $CostCenter */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CostCenter = null;

    /** @var string|null $CustomerOrderNumber */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $CustomerOrderNumber = null;

    /** @var Customer|null $Customer */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Customer::class)]
    protected ?Customer $Customer = null;

    /** @var Customs|null $Customs */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Customs::class)]
    protected ?Customs $Customs = null;

    /** @var string|null $StatusCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $StatusCode = null;

    /** @var int|null $PhaseCode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'int')]
    protected ?int $PhaseCode = null;

    /** @var DateTimeInterface|null $DateFrom */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DateFrom = null;

    /** @var DateTimeInterface|null $DateTo */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DateTo = null;

    /** @var string|null $DeliveryAddress */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $DeliveryAddress = null;

    /** @var DateTimeInterface|null $DeliveryTimeStampStart */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DeliveryTimeStampStart = null;

    /** @var DateTimeInterface|null $DeliveryTimeStampEnd */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DeliveryTimeStampEnd = null;

    /** @var DateTimeInterface|null $DeliveryDate */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: DateTimeInterface::class)]
    protected ?DateTimeInterface $DeliveryDate = null;

    /** @var Dimension|null $Dimension */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Dimension::class)]
    protected ?Dimension $Dimension = null;

    /** @var string|null $DownPartnerBarcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $DownPartnerBarcode = null;

    /** @var string|null $DownPartnerID */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $DownPartnerID = null;

    /** @var string|null $DownPartnerLocation */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $DownPartnerLocation = null;

    /** @var Event[]|null $Events */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Event::class, isArray: true)]
    protected ?array $Events = null;

    /** @var Group[]|null $Groups */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: Group::class, isArray: true)]
    protected ?array $Groups = null;

    /** @var string|null $IDExpiration */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $IDExpiration = null;

    /** @var string|null $IDNumber */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $IDNumber = null;

    /** @var string|null $IDType */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $IDType = null;

    /** @var string|null $OldStatuses */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $OldStatuses = null;

    /** @var string|null $ProductCodeCollect */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ProductCodeCollect = null;

    /** @var string|null $ProductCodeDelivery */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ProductCodeDelivery = null;

    /** @var ProductOption[]|null $ProductOptions */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: ProductOption::class, isArray: true)]
    protected ?array $ProductOptions = null;

    /** @var string|null $ReceiverDateOfBirth */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ReceiverDateOfBirth = null;

    /** @var string|null $Reference */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Reference = null;

    /** @var string|null $ReferenceCollect */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ReferenceCollect = null;

    /** @var string|null $Remark */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $Remark = null;

    /** @var string|null $ReturnBarcode */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ReturnBarcode = null;

    /** @var string|null $ReturnReference */
    #[SerializableProperty(namespace: SoapNamespace::Domain, type: 'string')]
    protected ?string $ReturnReference = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        /** @param Address[]|null $Addresses */
        array                         $Addresses = null,
        /** @param Amount[]|null $Amounts */
        array                         $Amounts = null,
        ?string                       $Barcode = null,
        /** @param Contact[]|null $Contacts */
        array                         $Contacts = null,
        ?string                       $Content = null,
        string|DateTimeInterface|null $CollectionTimeStampEnd = null,
        string|DateTimeInterface|null $CollectionTimeStampStart = null,
        ?string                       $CostCenter = null,
        ?Customer                     $Customer = null,
        ?string                       $CustomerOrderNumber = null,
        ?Customs                      $Customs = null,
        ?string                       $DeliveryAddress = null,
        string|DateTimeInterface|null $DeliveryDate = null,
        ?Dimension                    $Dimension = null,
        ?string                       $DownPartnerBarcode = null,
        ?string                       $DownPartnerID = null,
        ?string                       $DownPartnerLocation = null,
        /** @param Event[]|null $Events */
        array                         $Events = null,
        /** @param Group[]|null $Groups */
        array                         $Groups = null,
        ?string                       $IDExpiration = null,
        ?string                       $IDNumber = null,
        ?string                       $IDType = null,
        /** @param OldStatus[]|null $OldStatuses */
        array                         $OldStatuses = null,
        ?string                       $ProductCodeCollect = null,
        ?string                       $ProductCodeDelivery = null,
        /** @param ProductOption[]|null $ProductOptions */
        array                         $ProductOptions = null,
        ?string                       $ReceiverDateOfBirth = null,
        ?string                       $Reference = null,
        ?string                       $ReferenceCollect = null,
        ?string                       $Remark = null,
        ?string                       $ReturnBarcode = null,
        ?string                       $ReturnReference = null,
        ?string                       $StatusCode = null,
        ?int                          $PhaseCode = null,
        ?string                       $DateFrom = null,
        ?string                       $DateTo = null,
        string|DateTimeInterface|null $DeliveryTimeStampStart = null,
        string|DateTimeInterface|null $DeliveryTimeStampEnd = null
    ) {
        parent::__construct();

        $this->setAddresses(Addresses: $Addresses);
        $this->setAmounts(Amounts: $Amounts);
        $this->setBarcode(Barcode: $Barcode);
        $this->setCollectionTimeStampEnd(CollectionTimeStampEnd: $CollectionTimeStampEnd);
        $this->setCollectionTimeStampStart(CollectionTimeStampStart: $CollectionTimeStampStart);
        $this->setContacts(Contacts: $Contacts);
        $this->setContent(Content: $Content);
        $this->setCostCenter(CostCenter: $CostCenter);
        $this->setCustomer(Customer: $Customer);
        $this->setCustomerOrderNumber(CustomerOrderNumber: $CustomerOrderNumber);
        $this->setCustoms(Customs: $Customs);
        $this->setDeliveryAddress(DeliveryAddress: $DeliveryAddress);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setDimension(Dimension: $Dimension);
        $this->setDownPartnerBarcode(DownPartnerBarcode: $DownPartnerBarcode);
        $this->setDownPartnerID(DownPartnerID: $DownPartnerID);
        $this->setDownPartnerLocation(DownPartnerLocation: $DownPartnerLocation);
        $this->setEvents(Events: $Events);
        $this->setGroups(Groups: $Groups);
        $this->setIDExpiration(IDExpiration: $IDExpiration);
        $this->setIDNumber(IDNumber: $IDNumber);
        $this->setIDType(IDType: $IDType);
        $this->setOldStatuses(OldStatuses: $OldStatuses);
        $this->setProductCodeCollect(ProductCodeCollect: $ProductCodeCollect);
        $this->setProductCodeDelivery(ProductCodeDelivery: $ProductCodeDelivery);
        $this->setProductOptions(ProductOptions: $ProductOptions);
        $this->setReceiverDateOfBirth(ReceiverDateOfBirth: $ReceiverDateOfBirth);
        $this->setReference(Reference: $Reference);
        $this->setReferenceCollect(ReferenceCollect: $ReferenceCollect);
        $this->setRemark(Remark: $Remark);
        $this->setReturnBarcode(ReturnBarcode: $ReturnBarcode);
        $this->setReturnReference(ReturnReference: $ReturnReference);
        $this->setStatusCode(StatusCode: $StatusCode);
        $this->setPhaseCode(PhaseCode: $PhaseCode);
        $this->setDateFrom(DateFrom: $DateFrom);
        $this->setDateTo(DateTo: $DateTo);
        $this->setDeliveryTimeStampStart(DeliveryTimeStampStart: $DeliveryTimeStampStart);
        $this->setDeliveryTimeStampEnd(DeliveryTimeStampEnd: $DeliveryTimeStampEnd);
    }

    /**
     * @return Address[]|null
     */
    public function getAddresses(): ?array
    {
        return $this->Addresses;
    }

    /**
     * @param Address[]|null $Addresses
     *
     * @return static
     */
    public function setAddresses(?array $Addresses): static
    {
        $this->Addresses = $Addresses;

        return $this;
    }

    /**
     * @return Amount[]|null
     */
    public function getAmounts(): ?array
    {
        return $this->Amounts;
    }

    /**
     * @param Amount[]|null $Amounts
     *
     * @return static
     */
    public function setAmounts(?array $Amounts): static
    {
        $this->Amounts = $Amounts;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->Barcode;
    }

    /**
     * @param string|null $Barcode
     *
     * @return static
     */
    public function setBarcode(?string $Barcode): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }

    /**
     * @return Contact|null
     */
    public function getContacts(): ?array
    {
        return $this->Contacts;
    }

    /**
     * @param array|null $Contacts
     *
     * @return static
     */
    public function setContacts(?array $Contacts): static
    {
        $this->Contacts = $Contacts;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->Content;
    }

    /**
     * @param string|null $Content
     *
     * @return static
     */
    public function setContent(?string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCostCenter(): ?string
    {
        return $this->CostCenter;
    }

    /**
     * @param string|null $CostCenter
     *
     * @return static
     */
    public function setCostCenter(?string $CostCenter): static
    {
        $this->CostCenter = $CostCenter;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerOrderNumber(): ?string
    {
        return $this->CustomerOrderNumber;
    }

    /**
     * @param string|null $CustomerOrderNumber
     *
     * @return static
     */
    public function setCustomerOrderNumber(?string $CustomerOrderNumber): static
    {
        $this->CustomerOrderNumber = $CustomerOrderNumber;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $Customer
     *
     * @return static
     */
    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return Customs|null
     */
    public function getCustoms(): ?Customs
    {
        return $this->Customs;
    }

    /**
     * @param Customs|null $Customs
     *
     * @return static
     */
    public function setCustoms(?Customs $Customs): static
    {
        $this->Customs = $Customs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusCode(): ?string
    {
        return $this->StatusCode;
    }

    /**
     * @param string|null $StatusCode
     *
     * @return static
     */
    public function setStatusCode(?string $StatusCode): static
    {
        $this->StatusCode = $StatusCode;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhaseCode(): ?int
    {
        return $this->PhaseCode;
    }

    /**
     * @param int|null $PhaseCode
     *
     * @return static
     */
    public function setPhaseCode(?int $PhaseCode): static
    {
        $this->PhaseCode = $PhaseCode;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateFrom(): ?DateTimeInterface
    {
        return $this->DateFrom;
    }

    /**
     * @param DateTimeInterface|null $DateFrom
     *
     * @return static
     */
    public function setDateFrom(?DateTimeInterface $DateFrom): static
    {
        $this->DateFrom = $DateFrom;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateTo(): ?DateTimeInterface
    {
        return $this->DateTo;
    }

    /**
     * @param DateTimeInterface|null $DateTo
     *
     * @return static
     */
    public function setDateTo(?DateTimeInterface $DateTo): static
    {
        $this->DateTo = $DateTo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryAddress(): ?string
    {
        return $this->DeliveryAddress;
    }

    /**
     * @param string|null $DeliveryAddress
     *
     * @return static
     */
    public function setDeliveryAddress(?string $DeliveryAddress): static
    {
        $this->DeliveryAddress = $DeliveryAddress;

        return $this;
    }

    /**
     * @return Dimension|null
     */
    public function getDimension(): ?Dimension
    {
        return $this->Dimension;
    }

    /**
     * @param Dimension|null $Dimension
     *
     * @return static
     */
    public function setDimension(?Dimension $Dimension): static
    {
        $this->Dimension = $Dimension;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerBarcode(): ?string
    {
        return $this->DownPartnerBarcode;
    }

    /**
     * @param string|null $DownPartnerBarcode
     *
     * @return static
     */
    public function setDownPartnerBarcode(?string $DownPartnerBarcode): static
    {
        $this->DownPartnerBarcode = $DownPartnerBarcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerID(): ?string
    {
        return $this->DownPartnerID;
    }

    /**
     * @param string|null $DownPartnerID
     *
     * @return static
     */
    public function setDownPartnerID(?string $DownPartnerID): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerLocation(): ?string
    {
        return $this->DownPartnerLocation;
    }

    /**
     * @param string|null $DownPartnerLocation
     *
     * @return static
     */
    public function setDownPartnerLocation(?string $DownPartnerLocation): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }

    /**
     * @return Event[]|null
     */
    public function getEvents(): ?array
    {
        return $this->Events;
    }

    /**
     * @param Event[]|null $Events
     *
     * @return static
     */
    public function setEvents(?array $Events): static
    {
        $this->Events = $Events;

        return $this;
    }

    /**
     * @return Group[]|null
     */
    public function getGroups(): ?array
    {
        return $this->Groups;
    }

    /**
     * @param Group[]|null $Groups
     *
     * @return static
     */
    public function setGroups(?array $Groups): static
    {
        $this->Groups = $Groups;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIDExpiration(): ?string
    {
        return $this->IDExpiration;
    }

    /**
     * @param string|null $IDExpiration
     *
     * @return static
     */
    public function setIDExpiration(?string $IDExpiration): static
    {
        $this->IDExpiration = $IDExpiration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIDNumber(): ?string
    {
        return $this->IDNumber;
    }

    /**
     * @param string|null $IDNumber
     *
     * @return static
     */
    public function setIDNumber(?string $IDNumber): static
    {
        $this->IDNumber = $IDNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIDType(): ?string
    {
        return $this->IDType;
    }

    /**
     * @param string|null $IDType
     *
     * @return static
     */
    public function setIDType(?string $IDType): static
    {
        $this->IDType = $IDType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldStatuses(): ?string
    {
        return $this->OldStatuses;
    }

    /**
     * @param string|null $OldStatuses
     *
     * @return static
     */
    public function setOldStatuses(?string $OldStatuses): static
    {
        $this->OldStatuses = $OldStatuses;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductCodeCollect(): ?string
    {
        return $this->ProductCodeCollect;
    }

    /**
     * @param string|null $ProductCodeCollect
     *
     * @return static
     */
    public function setProductCodeCollect(?string $ProductCodeCollect): static
    {
        $this->ProductCodeCollect = $ProductCodeCollect;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductCodeDelivery(): ?string
    {
        return $this->ProductCodeDelivery;
    }

    /**
     * @param string|null $ProductCodeDelivery
     *
     * @return static
     */
    public function setProductCodeDelivery(?string $ProductCodeDelivery): static
    {
        $this->ProductCodeDelivery = $ProductCodeDelivery;

        return $this;
    }

    /**
     * @return ProductOption[]|null
     */
    public function getProductOptions(): ?array
    {
        return $this->ProductOptions;
    }

    /**
     * @param ProductOption[]|null $ProductOptions
     *
     * @return static
     */
    public function setProductOptions(?array $ProductOptions): static
    {
        $this->ProductOptions = $ProductOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReceiverDateOfBirth(): ?string
    {
        return $this->ReceiverDateOfBirth;
    }

    /**
     * @param string|null $ReceiverDateOfBirth
     *
     * @return static
     */
    public function setReceiverDateOfBirth(?string $ReceiverDateOfBirth): static
    {
        $this->ReceiverDateOfBirth = $ReceiverDateOfBirth;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->Reference;
    }

    /**
     * @param string|null $Reference
     *
     * @return static
     */
    public function setReference(?string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReferenceCollect(): ?string
    {
        return $this->ReferenceCollect;
    }

    /**
     * @param string|null $ReferenceCollect
     *
     * @return static
     */
    public function setReferenceCollect(?string $ReferenceCollect): static
    {
        $this->ReferenceCollect = $ReferenceCollect;

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
    public function getReturnBarcode(): ?string
    {
        return $this->ReturnBarcode;
    }

    /**
     * @param string|null $ReturnBarcode
     *
     * @return static
     */
    public function setReturnBarcode(?string $ReturnBarcode): static
    {
        $this->ReturnBarcode = $ReturnBarcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnReference(): ?string
    {
        return $this->ReturnReference;
    }

    /**
     * @param string|null $ReturnReference
     *
     * @return static
     */
    public function setReturnReference(?string $ReturnReference): static
    {
        $this->ReturnReference = $ReturnReference;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCollectionTimeStampEnd(): ?DateTimeInterface
    {
        return $this->CollectionTimeStampEnd;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCollectionTimeStampStart(): ?DateTimeInterface
    {
        return $this->CollectionTimeStampStart;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeliveryTimeStampStart(): ?DateTimeInterface
    {
        return $this->DeliveryTimeStampStart;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeliveryTimeStampEnd(): ?DateTimeInterface
    {
        return $this->DeliveryTimeStampEnd;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeliveryDate(): ?DateTimeInterface
    {
        return $this->DeliveryDate;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setCollectionTimeStampStart(string|DateTimeInterface|null $CollectionTimeStampStart = null): static
    {
        if (is_string(value: $CollectionTimeStampStart)) {
            try {
                $CollectionTimeStampStart = new DateTimeImmutable(datetime: $CollectionTimeStampStart, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->CollectionTimeStampStart = $CollectionTimeStampStart;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setCollectionTimeStampEnd(string|DateTimeInterface|null $CollectionTimeStampEnd = null): static
    {
        if (is_string(value: $CollectionTimeStampEnd)) {
            try {
                $CollectionTimeStampEnd = new DateTimeImmutable(datetime: $CollectionTimeStampEnd, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->CollectionTimeStampEnd = $CollectionTimeStampEnd;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryTimeStampStart(string|DateTimeInterface|null $DeliveryTimeStampStart = null): static
    {
        if (is_string(value: $DeliveryTimeStampStart)) {
            try {
                $DeliveryTimeStampStart = new DateTimeImmutable(datetime: $DeliveryTimeStampStart, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->DeliveryTimeStampStart = $DeliveryTimeStampStart;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryTimeStampEnd(string|DateTimeInterface|null $DeliveryTimeStampEnd = null): static
    {
        if (is_string(value: $DeliveryTimeStampEnd)) {
            try {
                $DeliveryTimeStampEnd = new DateTimeImmutable(datetime: $DeliveryTimeStampEnd, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->DeliveryTimeStampEnd = $DeliveryTimeStampEnd;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate(string|DateTimeInterface|null $DeliveryDate = null): static
    {
        if (is_string(value: $DeliveryDate)) {
            try {
                $DeliveryDate = new DateTimeImmutable(datetime: $DeliveryDate, timezone: new DateTimeZone(timezone: 'Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException(message: $e->getMessage(), code: 0, previous: $e);
            }
        }

        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    /**
     * @param Writer $writer
     *
     * @return void
     * @throws ServiceNotSetException
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespace) {
            if (!isset($this->$propertyName)) {
                continue;
            }

            if ('Addresses' === $propertyName) {
                if (is_array(value: $this->Addresses)) {
                    $items = [];
                    foreach ($this->Addresses as $address) {
                        $items[] = ["{{$namespace}}Address" => $address];
                    }
                    $xml["{{$namespace}}Addresses"] = $items;
                }
            } elseif ('Amounts' === $propertyName) {
                if (is_array(value: $this->Amounts)) {
                    $items = [];
                    foreach ($this->Amounts as $amount) {
                        $items[] = ["{{$namespace}}Amount" => $amount];
                    }
                    $xml["{{$namespace}}Amounts"] = $items;
                }
            } elseif ('Contacts' === $propertyName) {
                if (is_array(value: $this->Contacts)) {
                    $items = [];
                    foreach ($this->Contacts as $contact) {
                        $items[] = ["{{$namespace}}Contact" => $contact];
                    }
                    $xml["{{$namespace}}Contacts"] = $items;
                }
            } elseif ('Events' === $propertyName) {
                if (is_array(value: $this->Events)) {
                    $items = [];
                    foreach ($this->Events as $event) {
                        $items[] = ["{{$namespace}}Event" => $event];
                    }
                    $xml["{{$namespace}}Events"] = $items;
                }
            } elseif ('Groups' === $propertyName) {
                if (is_array(value: $this->Groups)) {
                    $items = [];
                    foreach ($this->Groups as $group) {
                        $items[] = ["{{$namespace}}Group" => $group];
                    }
                    $xml["{{$namespace}}Groups"] = $items;
                }
            } elseif ('ProductOptions' === $propertyName) {
                if (is_array(value: $this->ProductOptions)) {
                    $items = [];
                    foreach ($this->ProductOptions as $option) {
                        $items[] = ["{{$namespace}}ProductOption" => $option];
                    }
                    $xml["{{$namespace}}ProductOptions"] = $items;
                }
            } else {
                if ($this->$propertyName instanceof DateTimeInterface) {
                    $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName->format('d-m-y');
                } else {
                    $xml["{{$namespace}}{$propertyName}"] = $this->$propertyName;
                }
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
