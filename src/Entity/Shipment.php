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
use Sabre\Xml\Writer;

/**
 * @since 1.0.0
 */
class Shipment extends AbstractEntity
{
    /** @var Address[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Addresses = null;

    /** @var Amount[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Amounts = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Barcode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $CollectionTimeStampEnd = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $CollectionTimeStampStart = null;

    /** @var Contact[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Contacts = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Content = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CostCenter = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $CustomerOrderNumber = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Customer $Customer = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Customs $Customs = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $StatusCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?int $PhaseCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DateFrom = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DateTo = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DeliveryAddress = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DeliveryTimeStampStart = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DeliveryTimeStampEnd = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?DateTimeInterface $DeliveryDate = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Dimension $Dimension = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerBarcode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerID = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerLocation = null;

    /** @var Event[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Events = null;

    /** @var Group[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Groups = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $IDExpiration = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $IDNumber = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $IDType = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $OldStatuses = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ProductCodeCollect = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ProductCodeDelivery = null;

    /** @var ProductOption[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $ProductOptions = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ReceiverDateOfBirth = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Reference = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ReferenceCollect = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Remark = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $ReturnBarcode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
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
     * @return $this
     */
    public function setAmounts(?array $Amounts): static
    {
        $this->Amounts = $Amounts;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->Barcode;
    }

    public function setBarcode(?string $Barcode): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }

    public function getContacts(): ?array
    {
        return $this->Contacts;
    }

    public function setContacts(?array $Contacts): static
    {
        $this->Contacts = $Contacts;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getCostCenter(): ?string
    {
        return $this->CostCenter;
    }

    public function setCostCenter(?string $CostCenter): static
    {
        $this->CostCenter = $CostCenter;

        return $this;
    }

    public function getCustomerOrderNumber(): ?string
    {
        return $this->CustomerOrderNumber;
    }

    public function setCustomerOrderNumber(?string $CustomerOrderNumber): static
    {
        $this->CustomerOrderNumber = $CustomerOrderNumber;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getCustoms(): ?Customs
    {
        return $this->Customs;
    }

    public function setCustoms(?Customs $Customs): static
    {
        $this->Customs = $Customs;

        return $this;
    }

    public function getStatusCode(): ?string
    {
        return $this->StatusCode;
    }

    public function setStatusCode(?string $StatusCode): static
    {
        $this->StatusCode = $StatusCode;

        return $this;
    }

    public function getPhaseCode(): ?int
    {
        return $this->PhaseCode;
    }

    public function setPhaseCode(?int $PhaseCode): static
    {
        $this->PhaseCode = $PhaseCode;

        return $this;
    }

    public function getDateFrom(): ?DateTimeInterface
    {
        return $this->DateFrom;
    }

    public function setDateFrom(?DateTimeInterface $DateFrom): static
    {
        $this->DateFrom = $DateFrom;

        return $this;
    }

    public function getDateTo(): ?DateTimeInterface
    {
        return $this->DateTo;
    }

    public function setDateTo(?DateTimeInterface $DateTo): static
    {
        $this->DateTo = $DateTo;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->DeliveryAddress;
    }

    public function setDeliveryAddress(?string $DeliveryAddress): static
    {
        $this->DeliveryAddress = $DeliveryAddress;

        return $this;
    }

    public function getDimension(): ?Dimension
    {
        return $this->Dimension;
    }

    public function setDimension(?Dimension $Dimension): static
    {
        $this->Dimension = $Dimension;

        return $this;
    }

    public function getDownPartnerBarcode(): ?string
    {
        return $this->DownPartnerBarcode;
    }

    public function setDownPartnerBarcode(?string $DownPartnerBarcode): static
    {
        $this->DownPartnerBarcode = $DownPartnerBarcode;

        return $this;
    }

    public function getDownPartnerID(): ?string
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(?string $DownPartnerID): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): ?string
    {
        return $this->DownPartnerLocation;
    }

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
     * @return static
     */
    public function setGroups(?array $Groups): static
    {
        $this->Groups = $Groups;

        return $this;
    }

    public function getIDExpiration(): ?string
    {
        return $this->IDExpiration;
    }

    public function setIDExpiration(?string $IDExpiration): static
    {
        $this->IDExpiration = $IDExpiration;

        return $this;
    }

    public function getIDNumber(): ?string
    {
        return $this->IDNumber;
    }

    public function setIDNumber(?string $IDNumber): static
    {
        $this->IDNumber = $IDNumber;

        return $this;
    }

    public function getIDType(): ?string
    {
        return $this->IDType;
    }

    public function setIDType(?string $IDType): static
    {
        $this->IDType = $IDType;

        return $this;
    }

    public function getOldStatuses(): ?string
    {
        return $this->OldStatuses;
    }

    public function setOldStatuses(?string $OldStatuses): static
    {
        $this->OldStatuses = $OldStatuses;

        return $this;
    }

    public function getProductCodeCollect(): ?string
    {
        return $this->ProductCodeCollect;
    }

    public function setProductCodeCollect(?string $ProductCodeCollect): static
    {
        $this->ProductCodeCollect = $ProductCodeCollect;

        return $this;
    }

    public function getProductCodeDelivery(): ?string
    {
        return $this->ProductCodeDelivery;
    }

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
     * @return static
     */
    public function setProductOptions(?array $ProductOptions): static
    {
        $this->ProductOptions = $ProductOptions;

        return $this;
    }

    public function getReceiverDateOfBirth(): ?string
    {
        return $this->ReceiverDateOfBirth;
    }

    public function setReceiverDateOfBirth(?string $ReceiverDateOfBirth): static
    {
        $this->ReceiverDateOfBirth = $ReceiverDateOfBirth;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(?string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getReferenceCollect(): ?string
    {
        return $this->ReferenceCollect;
    }

    public function setReferenceCollect(?string $ReferenceCollect): static
    {
        $this->ReferenceCollect = $ReferenceCollect;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->Remark;
    }

    public function setRemark(?string $Remark): static
    {
        $this->Remark = $Remark;

        return $this;
    }

    public function getReturnBarcode(): ?string
    {
        return $this->ReturnBarcode;
    }

    public function setReturnBarcode(?string $ReturnBarcode): static
    {
        $this->ReturnBarcode = $ReturnBarcode;

        return $this;
    }

    public function getReturnReference(): ?string
    {
        return $this->ReturnReference;
    }

    public function setReturnReference(?string $ReturnReference): static
    {
        $this->ReturnReference = $ReturnReference;

        return $this;
    }

    public function getCollectionTimeStampEnd(): ?DateTimeInterface
    {
        return $this->CollectionTimeStampEnd;
    }

    public function getCollectionTimeStampStart(): ?DateTimeInterface
    {
        return $this->CollectionTimeStampStart;
    }

    public function getDeliveryTimeStampStart(): ?DateTimeInterface
    {
        return $this->DeliveryTimeStampStart;
    }

    public function getDeliveryTimeStampEnd(): ?DateTimeInterface
    {
        return $this->DeliveryTimeStampEnd;
    }

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

    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
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
            } elseif (isset($this->$propertyName)) {
                if ($this->$propertyName instanceof DateTimeInterface) {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName->format('d-m-y');
                } else {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
                }
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write(value: $xml);
    }
}
