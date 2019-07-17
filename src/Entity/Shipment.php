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

namespace Firstred\PostNL\Entity;

/**
 * Class Shipment
 */
class Shipment extends AbstractEntity
{
    /** @var Address[]|null $addresses */
    protected $addresses;
    /** @var Amount[]|null $amounts */
    protected $amounts;
    /** @var string|null $barcode */
    protected $barcode;
    /** @var string|null $collectionTimeStampEnd */
    protected $collectionTimeStampEnd;
    /** @var string|null $collectionTimeStampStart */
    protected $collectionTimeStampStart;
    /** @var Contact[]|null $contacts */
    protected $contacts;
    /** @var string|null $content */
    protected $content;
    /** @var string|null $costCenter */
    protected $costCenter;
    /** @var string|null $customerOrderNumber */
    protected $customerOrderNumber;
    /** @var Customer|null $customer */
    protected $customer;
    /** @var Customs|null $customs */
    protected $customs;
    /** @var string|null $statusCode */
    protected $statusCode;
    /** @var string|null $phaseCode */
    protected $phaseCode;
    /** @var string|null $dateFrom */
    protected $dateFrom;
    /** @var string|null $dateTo */
    protected $dateTo;
    /** @var string|null $deliveryAddress */
    protected $deliveryAddress;
    /** @var string|null $deliveryTimeStampStart */
    protected $deliveryTimeStampStart;
    /** @var string|null $deliveryTimeStampEnd */
    protected $deliveryTimeStampEnd;
    /** @var string|null $deliveryDate */
    protected $deliveryDate;
    /** @var Dimension|null $dimension */
    protected $dimension;
    /** @var string|null $downPartnerBarcode */
    protected $downPartnerBarcode;
    /** @var string|null $downPartnerID */
    protected $downPartnerID;
    /** @var string|null $downPartnerLocation */
    protected $downPartnerLocation;
    /** @var Event[]|null $events */
    protected $events;
    /** @var Group[]|null $groups */
    protected $groups;
    /** @var string|null $IDExpiration */
    protected $IDExpiration;
    /** @var string|null $IDNumber */
    protected $IDNumber;
    /** @var string|null $IDType */
    protected $IDType;
    /** @var Status[]|null $oldStatuses */
    protected $oldStatuses;
    /** @var string|null $productCodeCollect */
    protected $productCodeCollect;
    /** @var string|null $productCodeDelivery */
    protected $productCodeDelivery;
    /** @var ProductOption[]|null $productOptions */
    protected $productOptions;
    /** @var string|null $receiverDateOfBirth */
    protected $receiverDateOfBirth;
    /** @var string|null $reference */
    protected $reference;
    /** @var string|null $referenceCollect */
    protected $referenceCollect;
    /** @var string|null $remark */
    protected $remark;
    /** @var string|null $returnBarcode */
    protected $returnBarcode;
    /** @var string|null $returnReference */
    protected $returnReference;

    /**
     * Shipment constructor.
     *
     * @param Address[]|null       $addresses
     * @param array|null           $amounts
     * @param string|null          $barcode
     * @param Contact[]|null       $contacts
     * @param string|null          $content
     * @param string|null          $collectionTimeStampEnd
     * @param string|null          $collectionTimeStampStart
     * @param string|null          $costCenter
     * @param Customer|null        $customer
     * @param string|null          $customerOrderNumber
     * @param Customs|null         $customs
     * @param string|null          $deliveryAddress
     * @param string|null          $deliveryDate
     * @param Dimension|null       $dimension
     * @param string|null          $downPartnerBarcode
     * @param string|null          $downPartnerId
     * @param string|null          $downPartnerLocation
     * @param Event[]|null         $events
     * @param Group[]|null         $groups
     * @param string|null          $idExpiration
     * @param string|null          $idNumber
     * @param string|null          $idType
     * @param array|null           $oldStatuses
     * @param string|null          $productCodeCollect
     * @param string|null          $productCodeDelivery
     * @param ProductOption[]|null $productOptions
     * @param string|null          $receiverDateOfBirth
     * @param string|null          $reference
     * @param string|null          $referenceCollect
     * @param string|null          $remark
     * @param string|null          $returnBarcode
     * @param string|null          $returnReference
     * @param string|null          $statusCode
     * @param string|null          $phaseCode
     * @param string|null          $dateFrom
     * @param string|null          $dateTo
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?array $addresses = null, ?array $amounts = null, ?string $barcode = null, ?array $contacts = null, ?string $content = null, ?string $collectionTimeStampEnd = null, ?string $collectionTimeStampStart = null, ?string $costCenter = null, ?Customer $customer = null, ?string $customerOrderNumber = null, ?Customs $customs = null, ?string $deliveryAddress = null, ?string $deliveryDate = null, ?Dimension $dimension = null, ?string $downPartnerBarcode = null, ?string $downPartnerId = null, ?string $downPartnerLocation = null, ?array $events = null, ?array $groups = null, ?string $idExpiration = null, ?string $idNumber = null, ?string $idType = null, ?array $oldStatuses = null, ?string $productCodeCollect = null, ?string $productCodeDelivery = null, ?array $productOptions = null, ?string $receiverDateOfBirth = null, ?string $reference = null, ?string $referenceCollect = null, ?string $remark = null, ?string $returnBarcode = null, ?string $returnReference = null, ?string $statusCode = null, ?string $phaseCode = null, ?string $dateFrom = null, ?string $dateTo = null)
    {
        parent::__construct();

        $this->setAddresses($addresses);
        $this->setAmounts($amounts);
        $this->setBarcode($barcode);
        $this->setCollectionTimeStampEnd($collectionTimeStampEnd);
        $this->setCollectionTimeStampStart($collectionTimeStampStart);
        $this->setContacts($contacts);
        $this->setContent($content);
        $this->setCostCenter($costCenter);
        $this->setCustomer($customer);
        $this->setCustomerOrderNumber($customerOrderNumber);
        $this->setCustoms($customs);
        $this->setDeliveryAddress($deliveryAddress);
        $this->setDeliveryDate($deliveryDate);
        $this->setDimension($dimension);
        $this->setDownPartnerBarcode($downPartnerBarcode);
        $this->setDownPartnerID($downPartnerId);
        $this->setDownPartnerLocation($downPartnerLocation);
        $this->setEvents($events);
        $this->setGroups($groups);
        $this->setIDExpiration($idExpiration);
        $this->setIDNumber($idNumber);
        $this->setIDType($idType);
        $this->setOldStatuses($oldStatuses);
        $this->setProductCodeCollect($productCodeCollect);
        $this->setProductCodeDelivery($productCodeDelivery);
        $this->setProductOptions($productOptions);
        $this->setReceiverDateOfBirth($receiverDateOfBirth);
        $this->setReference($reference);
        $this->setReferenceCollect($referenceCollect);
        $this->setRemark($remark);
        $this->setReturnBarcode($returnBarcode);
        $this->setReturnReference($returnReference);
        $this->setStatusCode($statusCode);
        $this->setPhaseCode($phaseCode);
        $this->setDateFrom($dateFrom);
        $this->setDateTo($dateTo);
    }

    /**
     * @return Address[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }

    /**
     * @param Address[]|null $addresses
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAddresses(?array $addresses): Shipment
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return Amount[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    /**
     * @param Amount[]|null $amounts
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAmounts(?array $amounts): Shipment
    {
        $this->amounts = $amounts;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBarcode(?string $barcode): Shipment
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCollectionTimeStampEnd(): ?string
    {
        return $this->collectionTimeStampEnd;
    }

    /**
     * @param string|null $collectionTimeStampEnd
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCollectionTimeStampEnd(?string $collectionTimeStampEnd): Shipment
    {
        $this->collectionTimeStampEnd = $collectionTimeStampEnd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCollectionTimeStampStart(): ?string
    {
        return $this->collectionTimeStampStart;
    }

    /**
     * @param string|null $collectionTimeStampStart
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCollectionTimeStampStart(?string $collectionTimeStampStart): Shipment
    {
        $this->collectionTimeStampStart = $collectionTimeStampStart;

        return $this;
    }

    /**
     * @return Contact[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContacts(): ?array
    {
        return $this->contacts;
    }

    /**
     * @param Contact[]|null $contacts
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContacts(?array $contacts): Shipment
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setContent(?string $content): Shipment
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCostCenter(): ?string
    {
        return $this->costCenter;
    }

    /**
     * @param string|null $costCenter
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCostCenter(?string $costCenter): Shipment
    {
        $this->costCenter = $costCenter;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCustomerOrderNumber(): ?string
    {
        return $this->customerOrderNumber;
    }

    /**
     * @param string|null $customerOrderNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCustomerOrderNumber(?string $customerOrderNumber): Shipment
    {
        $this->customerOrderNumber = $customerOrderNumber;

        return $this;
    }

    /**
     * @return Customer|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCustomer(?Customer $customer): Shipment
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Customs|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCustoms(): ?Customs
    {
        return $this->customs;
    }

    /**
     * @param Customs|null $customs
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCustoms(?Customs $customs): Shipment
    {
        $this->customs = $customs;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * @param string|null $statusCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStatusCode(?string $statusCode): Shipment
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPhaseCode(): ?string
    {
        return $this->phaseCode;
    }

    /**
     * @param string|null $phaseCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPhaseCode(?string $phaseCode): Shipment
    {
        $this->phaseCode = $phaseCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    /**
     * @param string|null $dateFrom
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDateFrom(?string $dateFrom): Shipment
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDateTo(): ?string
    {
        return $this->dateTo;
    }

    /**
     * @param string|null $dateTo
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDateTo(?string $dateTo): Shipment
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    /**
     * @param string|null $deliveryAddress
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryAddress(?string $deliveryAddress): Shipment
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryTimeStampStart(): ?string
    {
        return $this->deliveryTimeStampStart;
    }

    /**
     * @param string|null $deliveryTimeStampStart
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryTimeStampStart(?string $deliveryTimeStampStart): Shipment
    {
        $this->deliveryTimeStampStart = $deliveryTimeStampStart;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryTimeStampEnd(): ?string
    {
        return $this->deliveryTimeStampEnd;
    }

    /**
     * @param string|null $deliveryTimeStampEnd
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryTimeStampEnd(?string $deliveryTimeStampEnd): Shipment
    {
        $this->deliveryTimeStampEnd = $deliveryTimeStampEnd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryDate(?string $deliveryDate): Shipment
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return Dimension|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    /**
     * @param Dimension|null $dimension
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDimension(?Dimension $dimension): Shipment
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerBarcode(): ?string
    {
        return $this->downPartnerBarcode;
    }

    /**
     * @param string|null $downPartnerBarcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerBarcode(?string $downPartnerBarcode): Shipment
    {
        $this->downPartnerBarcode = $downPartnerBarcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerID(): ?string
    {
        return $this->downPartnerID;
    }

    /**
     * @param string|null $downPartnerID
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerID(?string $downPartnerID): Shipment
    {
        $this->downPartnerID = $downPartnerID;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerLocation(): ?string
    {
        return $this->downPartnerLocation;
    }

    /**
     * @param string|null $downPartnerLocation
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerLocation(?string $downPartnerLocation): Shipment
    {
        $this->downPartnerLocation = $downPartnerLocation;

        return $this;
    }

    /**
     * @return Event[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * @param Event[]|null $events
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setEvents(?array $events): Shipment
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return Group[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * @param Group[]|null $groups
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGroups(?array $groups): Shipment
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getIDExpiration(): ?string
    {
        return $this->IDExpiration;
    }

    /**
     * @param string|null $IDExpiration
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setIDExpiration(?string $IDExpiration): Shipment
    {
        $this->IDExpiration = $IDExpiration;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getIDNumber(): ?string
    {
        return $this->IDNumber;
    }

    /**
     * @param string|null $IDNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setIDNumber(?string $IDNumber): Shipment
    {
        $this->IDNumber = $IDNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getIDType(): ?string
    {
        return $this->IDType;
    }

    /**
     * @param string|null $IDType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setIDType(?string $IDType): Shipment
    {
        $this->IDType = $IDType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getOldStatuses(): ?string
    {
        return $this->oldStatuses;
    }

    /**
     * @param Status[]|null $oldStatuses
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOldStatuses(?array $oldStatuses): Shipment
    {
        $this->oldStatuses = $oldStatuses;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductCodeCollect(): ?string
    {
        return $this->productCodeCollect;
    }

    /**
     * @param string|null $productCodeCollect
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductCodeCollect(?string $productCodeCollect): Shipment
    {
        $this->productCodeCollect = $productCodeCollect;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductCodeDelivery(): ?string
    {
        return $this->productCodeDelivery;
    }

    /**
     * @param string|null $productCodeDelivery
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductCodeDelivery(?string $productCodeDelivery): Shipment
    {
        $this->productCodeDelivery = $productCodeDelivery;

        return $this;
    }

    /**
     * @return ProductOption[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getProductOptions(): ?array
    {
        return $this->productOptions;
    }

    /**
     * @param ProductOption[]|null $productOptions
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setProductOptions(?array $productOptions): Shipment
    {
        $this->productOptions = $productOptions;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getReceiverDateOfBirth(): ?string
    {
        return $this->receiverDateOfBirth;
    }

    /**
     * @param string|null $receiverDateOfBirth
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReceiverDateOfBirth(?string $receiverDateOfBirth): Shipment
    {
        $this->receiverDateOfBirth = $receiverDateOfBirth;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReference(?string $reference): Shipment
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getReferenceCollect(): ?string
    {
        return $this->referenceCollect;
    }

    /**
     * @param string|null $referenceCollect
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReferenceCollect(?string $referenceCollect): Shipment
    {
        $this->referenceCollect = $referenceCollect;

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
    public function setRemark(?string $remark): Shipment
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getReturnBarcode(): ?string
    {
        return $this->returnBarcode;
    }

    /**
     * @param string|null $returnBarcode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReturnBarcode(?string $returnBarcode): Shipment
    {
        $this->returnBarcode = $returnBarcode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getReturnReference(): ?string
    {
        return $this->returnReference;
    }

    /**
     * @param string|null $returnReference
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setReturnReference(?string $returnReference): Shipment
    {
        $this->returnReference = $returnReference;

        return $this;
    }
}
