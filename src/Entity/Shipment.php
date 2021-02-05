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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Shipment.
 */
class Shipment extends SerializableObject
{
    /**
     * Shipment constructor.
     *
     * @param string         $service
     * @param string         $propType
     * @param array|null     $Addresses
     * @param array|null     $Amounts
     * @param string|null    $Barcode
     * @param string|null    $CollectionTimeStampEnd
     * @param string|null    $CollectionTimeStampStart
     * @param array|null     $Contacts
     * @param string|null    $Content
     * @param string|null    $CostCenter
     * @param string|null    $CustomerOrderNumber
     * @param Customer|null  $Customer
     * @param Customs|null   $Customs
     * @param string|null    $StatusCode
     * @param int|null       $PhaseCode
     * @param string|null    $DateFrom
     * @param string|null    $DateTo
     * @param string|null    $DeliveryAddress
     * @param string|null    $DeliveryTimeStampStart
     * @param string|null    $DeliveryTimeStampEnd
     * @param string|null    $DeliveryDate
     * @param Dimension|null $Dimension
     * @param string|null    $DownPartnerBarcode
     * @param string|null    $DownPartnerID
     * @param string|null    $DownPartnerLocation
     * @param array|null     $Events
     * @param array|null     $Groups
     * @param string|null    $IDExpiration
     * @param string|null    $IDNumber
     * @param string|null    $IDType
     * @param string|null    $OldStatuses
     * @param string|null    $ProductCodeCollect
     * @param string|null    $ProductCodeDelivery
     * @param array|null     $ProductOptions
     * @param string|null    $ReceiverDateOfBirth
     * @param string|null    $Reference
     * @param string|null    $ReferenceCollect
     * @param string|null    $Remark
     * @param string|null    $ReturnBarcode
     * @param string|null    $ReturnReference
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected array|null $Addresses = null,
        protected array|null $Amounts = null,
        protected string|null $Barcode = null,
        protected string|null $CollectionTimeStampEnd = null,
        protected string|null $CollectionTimeStampStart = null,
        protected array|null $Contacts = null,
        protected string|null $Content = null,
        protected string|null $CostCenter = null,
        protected string|null $CustomerOrderNumber = null,
        protected ?Customer $Customer = null,
        protected ?Customs $Customs = null,
        protected string|null $StatusCode = null,
        protected int|null $PhaseCode = null,
        protected string|null $DateFrom = null,
        protected string|null $DateTo = null,
        protected string|null $DeliveryAddress = null,
        protected string|null $DeliveryTimeStampStart = null,
        protected string|null $DeliveryTimeStampEnd = null,
        protected string|null $DeliveryDate = null,
        protected ?Dimension $Dimension = null,
        protected string|null $DownPartnerBarcode = null,
        protected string|null $DownPartnerID = null,
        protected string|null $DownPartnerLocation = null,
        protected array|null $Events = null,
        protected array|null $Groups = null,
        protected string|null $IDExpiration = null,
        protected string|null $IDNumber = null,
        protected string|null $IDType = null,
        protected string|null $OldStatuses = null,
        protected string|null $ProductCodeCollect = null,
        protected string|null $ProductCodeDelivery = null,
        protected array|null $ProductOptions = null,
        protected string|null $ReceiverDateOfBirth = null,
        protected string|null $Reference = null,
        protected string|null $ReferenceCollect = null,
        protected string|null $Remark = null,
        protected string|null $ReturnBarcode = null,
        protected string|null $ReturnReference = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

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
    }

    /**
     * @return array|null
     */
    public function getAddresses(): array|null
    {
        return $this->Addresses;
    }

    /**
     * @param array|null $Addresses
     *
     * @return static
     */
    public function setAddresses(array|null $Addresses = null): static
    {
        $this->Addresses = $Addresses;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAmounts(): array|null
    {
        return $this->Amounts;
    }

    /**
     * @param array|null $Amounts
     *
     * @return static
     */
    public function setAmounts(array|null $Amounts = null): static
    {
        $this->Amounts = $Amounts;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBarcode(): string|null
    {
        return $this->Barcode;
    }

    /**
     * @param string|null $Barcode
     *
     * @return static
     */
    public function setBarcode(string|null $Barcode = null): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCollectionTimeStampEnd(): string|null
    {
        return $this->CollectionTimeStampEnd;
    }

    /**
     * @param string|null $CollectionTimeStampEnd
     *
     * @return static
     */
    public function setCollectionTimeStampEnd(string|null $CollectionTimeStampEnd = null): static
    {
        $this->CollectionTimeStampEnd = $CollectionTimeStampEnd;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCollectionTimeStampStart(): string|null
    {
        return $this->CollectionTimeStampStart;
    }

    /**
     * @param string|null $CollectionTimeStampStart
     *
     * @return static
     */
    public function setCollectionTimeStampStart(string|null $CollectionTimeStampStart = null): static
    {
        $this->CollectionTimeStampStart = $CollectionTimeStampStart;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getContacts(): array|null
    {
        return $this->Contacts;
    }

    /**
     * @param array|null $Contacts
     *
     * @return static
     */
    public function setContacts(array|null $Contacts = null): static
    {
        $this->Contacts = $Contacts;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): string|null
    {
        return $this->Content;
    }

    /**
     * @param string|null $Content
     *
     * @return static
     */
    public function setContent(string|null $Content = null): static
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCostCenter(): string|null
    {
        return $this->CostCenter;
    }

    /**
     * @param string|null $CostCenter
     *
     * @return static
     */
    public function setCostCenter(string|null $CostCenter = null): static
    {
        $this->CostCenter = $CostCenter;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerOrderNumber(): string|null
    {
        return $this->CustomerOrderNumber;
    }

    /**
     * @param string|null $CustomerOrderNumber
     *
     * @return static
     */
    public function setCustomerOrderNumber(string|null $CustomerOrderNumber = null): static
    {
        $this->CustomerOrderNumber = $CustomerOrderNumber;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): Customer|null
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $Customer
     *
     * @return static
     */
    public function setCustomer(Customer|null $Customer = null): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return Customs|null
     */
    public function getCustoms(): Customs|null
    {
        return $this->Customs;
    }

    /**
     * @param Customs|null $Customs
     *
     * @return static
     */
    public function setCustoms(Customs|null $Customs = null): static
    {
        $this->Customs = $Customs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusCode(): string|null
    {
        return $this->StatusCode;
    }

    /**
     * @param string|null $StatusCode
     *
     * @return static
     */
    public function setStatusCode(string|null $StatusCode = null): static
    {
        $this->StatusCode = $StatusCode;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhaseCode(): int|null
    {
        return $this->PhaseCode;
    }

    /**
     * @param int|null $PhaseCode
     *
     * @return static
     */
    public function setPhaseCode(int|null $PhaseCode = null): static
    {
        $this->PhaseCode = $PhaseCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateFrom(): string|null
    {
        return $this->DateFrom;
    }

    /**
     * @param string|null $DateFrom
     *
     * @return static
     */
    public function setDateFrom(string|null $DateFrom = null): static
    {
        $this->DateFrom = $DateFrom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateTo(): string|null
    {
        return $this->DateTo;
    }

    /**
     * @param string|null $DateTo
     *
     * @return static
     */
    public function setDateTo(string|null $DateTo = null): static
    {
        $this->DateTo = $DateTo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryAddress(): string|null
    {
        return $this->DeliveryAddress;
    }

    /**
     * @param string|null $DeliveryAddress
     *
     * @return static
     */
    public function setDeliveryAddress(string|null $DeliveryAddress = null): static
    {
        $this->DeliveryAddress = $DeliveryAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryTimeStampStart(): string|null
    {
        return $this->DeliveryTimeStampStart;
    }

    /**
     * @param string|null $DeliveryTimeStampStart
     *
     * @return static
     */
    public function setDeliveryTimeStampStart(string|null $DeliveryTimeStampStart = null): static
    {
        $this->DeliveryTimeStampStart = $DeliveryTimeStampStart;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryTimeStampEnd(): string|null
    {
        return $this->DeliveryTimeStampEnd;
    }

    /**
     * @param string|null $DeliveryTimeStampEnd
     *
     * @return static
     */
    public function setDeliveryTimeStampEnd(string|null $DeliveryTimeStampEnd = null): static
    {
        $this->DeliveryTimeStampEnd = $DeliveryTimeStampEnd;

        return $this;
    }

    /**
     * @return string|null
     */
    public function calculateDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    /**
     * @param string|null $DeliveryDate
     *
     * @return static
     */
    public function setDeliveryDate(string|null $DeliveryDate = null): static
    {
        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    /**
     * @return Dimension|null
     */
    public function getDimension(): Dimension|null
    {
        return $this->Dimension;
    }

    /**
     * @param Dimension|null $Dimension
     *
     * @return static
     */
    public function setDimension(Dimension|null $Dimension = null): static
    {
        $this->Dimension = $Dimension;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerBarcode(): string|null
    {
        return $this->DownPartnerBarcode;
    }

    /**
     * @param string|null $DownPartnerBarcode
     *
     * @return static
     */
    public function setDownPartnerBarcode(string|null $DownPartnerBarcode = null): static
    {
        $this->DownPartnerBarcode = $DownPartnerBarcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    /**
     * @param string|null $DownPartnerID
     *
     * @return static
     */
    public function setDownPartnerID(string|null $DownPartnerID = null): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    /**
     * @param string|null $DownPartnerLocation
     *
     * @return static
     */
    public function setDownPartnerLocation(string|null $DownPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getEvents(): array|null
    {
        return $this->Events;
    }

    /**
     * @param array|null $Events
     *
     * @return static
     */
    public function setEvents(array|null $Events = null): static
    {
        $this->Events = $Events;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getGroups(): array|null
    {
        return $this->Groups;
    }

    /**
     * @param array|null $Groups
     *
     * @return static
     */
    public function setGroups(array|null $Groups = null): static
    {
        $this->Groups = $Groups;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIDExpiration(): string|null
    {
        return $this->IDExpiration;
    }

    /**
     * @param string|null $IDExpiration
     *
     * @return static
     */
    public function setIDExpiration(string|null $IDExpiration = null): static
    {
        $this->IDExpiration = $IDExpiration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIDNumber(): string|null
    {
        return $this->IDNumber;
    }

    /**
     * @param string|null $IDNumber
     *
     * @return static
     */
    public function setIDNumber(string|null $IDNumber = null): static
    {
        $this->IDNumber = $IDNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIDType(): string|null
    {
        return $this->IDType;
    }

    /**
     * @param string|null $IDType
     *
     * @return static
     */
    public function setIDType(string|null $IDType = null): static
    {
        $this->IDType = $IDType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldStatuses(): string|null
    {
        return $this->OldStatuses;
    }

    /**
     * @param string|null $OldStatuses
     *
     * @return static
     */
    public function setOldStatuses(string|null $OldStatuses = null): static
    {
        $this->OldStatuses = $OldStatuses;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductCodeCollect(): string|null
    {
        return $this->ProductCodeCollect;
    }

    /**
     * @param string|null $ProductCodeCollect
     *
     * @return static
     */
    public function setProductCodeCollect(string|null $ProductCodeCollect = null): static
    {
        $this->ProductCodeCollect = $ProductCodeCollect;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductCodeDelivery(): string|null
    {
        return $this->ProductCodeDelivery;
    }

    /**
     * @param string|null $ProductCodeDelivery
     *
     * @return static
     */
    public function setProductCodeDelivery(string|null $ProductCodeDelivery = null): static
    {
        $this->ProductCodeDelivery = $ProductCodeDelivery;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getProductOptions(): array|null
    {
        return $this->ProductOptions;
    }

    /**
     * @param array|null $ProductOptions
     *
     * @return static
     */
    public function setProductOptions(array|null $ProductOptions = null): static
    {
        $this->ProductOptions = $ProductOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReceiverDateOfBirth(): string|null
    {
        return $this->ReceiverDateOfBirth;
    }

    /**
     * @param string|null $ReceiverDateOfBirth
     *
     * @return static
     */
    public function setReceiverDateOfBirth(string|null $ReceiverDateOfBirth = null): static
    {
        $this->ReceiverDateOfBirth = $ReceiverDateOfBirth;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): string|null
    {
        return $this->Reference;
    }

    /**
     * @param string|null $Reference
     *
     * @return static
     */
    public function setReference(string|null $Reference = null): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReferenceCollect(): string|null
    {
        return $this->ReferenceCollect;
    }

    /**
     * @param string|null $ReferenceCollect
     *
     * @return static
     */
    public function setReferenceCollect(string|null $ReferenceCollect = null): static
    {
        $this->ReferenceCollect = $ReferenceCollect;

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
    public function getReturnBarcode(): string|null
    {
        return $this->ReturnBarcode;
    }

    /**
     * @param string|null $ReturnBarcode
     *
     * @return static
     */
    public function setReturnBarcode(string|null $ReturnBarcode = null): static
    {
        $this->ReturnBarcode = $ReturnBarcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnReference(): string|null
    {
        return $this->ReturnReference;
    }

    /**
     * @param string|null $ReturnReference
     *
     * @return static
     */
    public function setReturnReference(string|null $ReturnReference = null): static
    {
        $this->ReturnReference = $ReturnReference;

        return $this;
    }
}
