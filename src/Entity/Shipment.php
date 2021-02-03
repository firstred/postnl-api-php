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
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

class Shipment extends SerializableObject
{
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

        $this->setAddresses(Addresses: $addresses);
        $this->setAmounts(Amounts: $amounts);
        $this->setBarcode(Barcode: $barcode);
        $this->setCollectionTimeStampEnd(CollectionTimeStampEnd: $collectionTimeStampEnd);
        $this->setCollectionTimeStampStart(CollectionTimeStampStart: $collectionTimeStampStart);
        $this->setContacts(Contacts: $contacts);
        $this->setContent(Content: $content);
        $this->setCostCenter(CostCenter: $costCenter);
        $this->setCustomer(Customer: $customer);
        $this->setCustomerOrderNumber(CustomerOrderNumber: $customerOrderNumber);
        $this->setCustoms(Customs: $customs);
        $this->setDeliveryAddress(DeliveryAddress: $deliveryAddress);
        $this->setDeliveryDate(DeliveryDate: $deliveryDate);
        $this->setDimension(Dimension: $dimension);
        $this->setDownPartnerBarcode(DownPartnerBarcode: $downPartnerBarcode);
        $this->setDownPartnerID(DownPartnerID: $downPartnerID);
        $this->setDownPartnerLocation(DownPartnerLocation: $downPartnerLocation);
        $this->setEvents(Events: $events);
        $this->setGroups(Groups: $groups);
        $this->setIDExpiration(IDExpiration: $idExpiration);
        $this->setIDNumber(IDNumber: $idNumber);
        $this->setIDType(IDType: $idType);
        $this->setProductCodeCollect(ProductCodeCollect: $productCodeCollect);
        $this->setProductCodeDelivery(ProductCodeDelivery: $productCodeDelivery);
        $this->setProductOptions(ProductOptions: $productOptions);
        $this->setReceiverDateOfBirth(ReceiverDateOfBirth: $receiverDateOfBirth);
        $this->setReference(Reference: $reference);
        $this->setReferenceCollect(ReferenceCollect: $referenceCollect);
        $this->setRemark(Remark: $remark);
        $this->setReturnBarcode(ReturnBarcode: $returnBarcode);
        $this->setReturnReference(ReturnReference: $returnReference);
        $this->setStatusCode(StatusCode: $statusCode);
        $this->setPhaseCode(PhaseCode: $phaseCode);
        $this->setDateFrom(DateFrom: $dateFrom);
        $this->setDateTo(DateTo: $dateTo);
    }

    public function getAddresses(): array|null
    {
        return $this->Addresses;
    }

    public function setAddresses(array|null $Addresses = null): static
    {
        $this->Addresses = $Addresses;

        return $this;
    }

    public function getAmounts(): array|null
    {
        return $this->Amounts;
    }

    public function setAmounts(array|null $Amounts = null): static
    {
        $this->Amounts = $Amounts;

        return $this;
    }

    public function getBarcode(): string|null
    {
        return $this->Barcode;
    }

    public function setBarcode(string|null $Barcode = null): static
    {
        $this->Barcode = $Barcode;

        return $this;
    }

    public function getCollectionTimeStampEnd(): string|null
    {
        return $this->CollectionTimeStampEnd;
    }

    public function setCollectionTimeStampEnd(string|null $CollectionTimeStampEnd = null): static
    {
        $this->CollectionTimeStampEnd = $CollectionTimeStampEnd;

        return $this;
    }

    public function getCollectionTimeStampStart(): string|null
    {
        return $this->CollectionTimeStampStart;
    }

    public function setCollectionTimeStampStart(string|null $CollectionTimeStampStart = null): static
    {
        $this->CollectionTimeStampStart = $CollectionTimeStampStart;

        return $this;
    }

    public function getContacts(): array|null
    {
        return $this->Contacts;
    }

    public function setContacts(array|null $Contacts = null): static
    {
        $this->Contacts = $Contacts;

        return $this;
    }

    public function getContent(): string|null
    {
        return $this->Content;
    }

    public function setContent(string|null $Content = null): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getCostCenter(): string|null
    {
        return $this->CostCenter;
    }

    public function setCostCenter(string|null $CostCenter = null): static
    {
        $this->CostCenter = $CostCenter;

        return $this;
    }

    public function getCustomerOrderNumber(): string|null
    {
        return $this->CustomerOrderNumber;
    }

    public function setCustomerOrderNumber(string|null $CustomerOrderNumber = null): static
    {
        $this->CustomerOrderNumber = $CustomerOrderNumber;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer = null): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getCustoms(): ?Customs
    {
        return $this->Customs;
    }

    public function setCustoms(?Customs $Customs = null): static
    {
        $this->Customs = $Customs;

        return $this;
    }

    public function getStatusCode(): string|null
    {
        return $this->StatusCode;
    }

    public function setStatusCode(string|null $StatusCode = null): static
    {
        $this->StatusCode = $StatusCode;

        return $this;
    }

    public function getPhaseCode(): int|null
    {
        return $this->PhaseCode;
    }

    public function setPhaseCode(int|null $PhaseCode = null): static
    {
        $this->PhaseCode = $PhaseCode;

        return $this;
    }

    public function getDateFrom(): string|null
    {
        return $this->DateFrom;
    }

    public function setDateFrom(string|null $DateFrom = null): static
    {
        $this->DateFrom = $DateFrom;

        return $this;
    }

    public function getDateTo(): string|null
    {
        return $this->DateTo;
    }

    public function setDateTo(string|null $DateTo = null): static
    {
        $this->DateTo = $DateTo;

        return $this;
    }

    public function getDeliveryAddress(): string|null
    {
        return $this->DeliveryAddress;
    }

    public function setDeliveryAddress(string|null $DeliveryAddress = null): static
    {
        $this->DeliveryAddress = $DeliveryAddress;

        return $this;
    }

    public function getDeliveryTimeStampStart(): string|null
    {
        return $this->DeliveryTimeStampStart;
    }

    public function setDeliveryTimeStampStart(string|null $DeliveryTimeStampStart = null): static
    {
        $this->DeliveryTimeStampStart = $DeliveryTimeStampStart;

        return $this;
    }

    public function getDeliveryTimeStampEnd(): string|null
    {
        return $this->DeliveryTimeStampEnd;
    }

    public function setDeliveryTimeStampEnd(string|null $DeliveryTimeStampEnd = null): static
    {
        $this->DeliveryTimeStampEnd = $DeliveryTimeStampEnd;

        return $this;
    }

    public function calculateDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    public function setDeliveryDate(string|null $DeliveryDate = null): static
    {
        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    public function getDimension(): ?Dimension
    {
        return $this->Dimension;
    }

    public function setDimension(?Dimension $Dimension = null): static
    {
        $this->Dimension = $Dimension;

        return $this;
    }

    public function getDownPartnerBarcode(): string|null
    {
        return $this->DownPartnerBarcode;
    }

    public function setDownPartnerBarcode(string|null $DownPartnerBarcode = null): static
    {
        $this->DownPartnerBarcode = $DownPartnerBarcode;

        return $this;
    }

    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(string|null $DownPartnerID = null): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    public function setDownPartnerLocation(string|null $DownPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }

    public function getEvents(): array|null
    {
        return $this->Events;
    }

    public function setEvents(array|null $Events = null): static
    {
        $this->Events = $Events;

        return $this;
    }

    public function getGroups(): array|null
    {
        return $this->Groups;
    }

    public function setGroups(array|null $Groups = null): static
    {
        $this->Groups = $Groups;

        return $this;
    }

    public function getIDExpiration(): string|null
    {
        return $this->IDExpiration;
    }

    public function setIDExpiration(string|null $IDExpiration = null): static
    {
        $this->IDExpiration = $IDExpiration;

        return $this;
    }

    public function getIDNumber(): string|null
    {
        return $this->IDNumber;
    }

    public function setIDNumber(string|null $IDNumber = null): static
    {
        $this->IDNumber = $IDNumber;

        return $this;
    }

    public function getIDType(): string|null
    {
        return $this->IDType;
    }

    public function setIDType(string|null $IDType = null): static
    {
        $this->IDType = $IDType;

        return $this;
    }

    public function getOldStatuses(): string|null
    {
        return $this->OldStatuses;
    }

    public function setOldStatuses(string|null $OldStatuses = null): static
    {
        $this->OldStatuses = $OldStatuses;

        return $this;
    }

    public function getProductCodeCollect(): string|null
    {
        return $this->ProductCodeCollect;
    }

    public function setProductCodeCollect(string|null $ProductCodeCollect = null): static
    {
        $this->ProductCodeCollect = $ProductCodeCollect;

        return $this;
    }

    public function getProductCodeDelivery(): string|null
    {
        return $this->ProductCodeDelivery;
    }

    public function setProductCodeDelivery(string|null $ProductCodeDelivery = null): static
    {
        $this->ProductCodeDelivery = $ProductCodeDelivery;

        return $this;
    }

    public function getProductOptions(): array|null
    {
        return $this->ProductOptions;
    }

    public function setProductOptions(array|null $ProductOptions = null): static
    {
        $this->ProductOptions = $ProductOptions;

        return $this;
    }

    public function getReceiverDateOfBirth(): string|null
    {
        return $this->ReceiverDateOfBirth;
    }

    public function setReceiverDateOfBirth(string|null $ReceiverDateOfBirth = null): static
    {
        $this->ReceiverDateOfBirth = $ReceiverDateOfBirth;

        return $this;
    }

    public function getReference(): string|null
    {
        return $this->Reference;
    }

    public function setReference(string|null $Reference = null): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getReferenceCollect(): string|null
    {
        return $this->ReferenceCollect;
    }

    public function setReferenceCollect(string|null $ReferenceCollect = null): static
    {
        $this->ReferenceCollect = $ReferenceCollect;

        return $this;
    }

    public function getRemark(): string|null
    {
        return $this->Remark;
    }

    public function setRemark(string|null $Remark = null): static
    {
        $this->Remark = $Remark;

        return $this;
    }

    public function getReturnBarcode(): string|null
    {
        return $this->ReturnBarcode;
    }

    public function setReturnBarcode(string|null $ReturnBarcode = null): static
    {
        $this->ReturnBarcode = $ReturnBarcode;

        return $this;
    }

    public function getReturnReference(): string|null
    {
        return $this->ReturnReference;
    }

    public function setReturnReference(string|null $ReturnReference = null): static
    {
        $this->ReturnReference = $ReturnReference;

        return $this;
    }
}
