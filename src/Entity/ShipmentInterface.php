<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Shipment.
 */
interface ShipmentInterface extends EntityInterface
{
    /**
     * Get addresses.
     *
     * @return AddressInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$addresses
     */
    public function getAddresses(): ?array;

    /**
     * Set addresses.
     *
     * @pattern N/A
     *
     * @param AddressInterface[]|null $addresses
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$addresses
     */
    public function setAddresses(?array $addresses): ShipmentInterface;

    /**
     * Get amounts.
     *
     * @return AmountInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$amounts
     */
    public function getAmounts(): ?array;

    /**
     * Set amounts.
     *
     * @pattern N/A
     *
     * @param AmountInterface[]|null $amounts
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$amounts
     */
    public function setAmounts(?array $amounts): ShipmentInterface;

    /**
     * Get barcode.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$barcode
     */
    public function getBarcode(): ?string;

    /**
     * Set barcode.
     *
     * @pattern ^.{1,35}$
     *
     * @param string|null $barcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3SDEVC2016112104
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$barcode
     */
    public function setBarcode(?string $barcode): ShipmentInterface;

    /**
     * Get coding text.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$codingText
     */
    public function getCodingText(): ?string;

    /**
     * Set coding text.
     *
     * @pattern ^.{0,35}$
     *
     * @example #2426A3A#03#0306#
     *
     * @param string|null $codingText
     *
     * @return static
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$codingText
     *
     * @throws InvalidArgumentException
     */
    public function setCodingText(?string $codingText): ShipmentInterface;

    /**
     * Get collection timestamp end.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$collectionTimeStampEnd
     */
    public function getCollectionTimeStampEnd(): ?string;

    /**
     * Set collection timestamp end.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $collectionTimeStampEnd
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 17:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$collectionTimeStampEnd
     */
    public function setCollectionTimeStampEnd(?string $collectionTimeStampEnd): ShipmentInterface;

    /**
     * Get collection timestamp start.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$collectionTimeStampStart
     */
    public function getCollectionTimeStampStart(): ?string;

    /**
     * Set collection timestamp start.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $collectionTimeStampStart
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 16:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$collectionTimeStampStart
     */
    public function setCollectionTimeStampStart(?string $collectionTimeStampStart): ShipmentInterface;

    /**
     * Get contacts.
     *
     * @pattern N/A
     *
     * @return ContactInterface[]|null
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$contacts
     */
    public function getContacts(): ?array;

    /**
     * Set contacts.
     *
     * @pattern N/A
     *
     * @param ContactInterface[]|null $contacts
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$contacts
     */
    public function setContacts(?array $contacts): ShipmentInterface;

    /**
     * Get content.
     *
     * @pattern N/A
     *
     * @return string|null
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$content
     */
    public function getContent(): ?string;

    /**
     * Set content.
     *
     * @pattern N/A
     *
     * @param string|null $content
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$content
     */
    public function setContent(?string $content): ShipmentInterface;

    /**
     * Get cost center.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$costCenter
     */
    public function getCostCenter(): ?string;

    /**
     * Set cost center.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $costCenter
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example SX-GT-66
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$costCenter
     */
    public function setCostCenter(?string $costCenter): ShipmentInterface;

    /**
     * Get customer order number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$customerOrderNumber
     */
    public function getCustomerOrderNumber(): ?string;

    /**
     * Set customer order number.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $customerOrderNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 8689242390
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$customerOrderNumber
     */
    public function setCustomerOrderNumber(?string $customerOrderNumber): ShipmentInterface;

    /**
     * Get customs.
     *
     * @return CustomsInterface|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$customs
     */
    public function getCustoms(): ?CustomsInterface;

    /**
     * Set customs.
     *
     * @pattern N/A
     *
     * @param CustomsInterface|null $customs
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$customs
     */
    public function setCustoms(?CustomsInterface $customs): ShipmentInterface;

    /**
     * Get delivery address type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$deliveryAddress
     */
    public function getDeliveryAddress(): ?string;

    /**
     * Set delivery address type.
     *
     * @pattern pattern: ^\d{2}$
     *
     * @param string|null $deliveryAddress
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 09
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$deliveryAddress
     */
    public function setDeliveryAddress(?string $deliveryAddress): ShipmentInterface;

    /**
     * Get delivery timestamp start.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$deliveryTimeStampStart
     */
    public function getDeliveryTimeStampStart(): ?string;

    /**
     * Set delivery timestamp start.
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @param string|null $deliveryTimeStampStart
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 14:30:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$deliveryTimeStampStart
     */
    public function setDeliveryTimeStampStart(?string $deliveryTimeStampStart): ShipmentInterface;

    /**
     * Get delivery timestamp end.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$deliveryTimeStampEnd
     */
    public function getDeliveryTimeStampEnd(): ?string;

    /**
     * Set delivery timestamp end.
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3}\s+)[0-2]\d:[0-5]\d(?:[0-5]\d)$
     *
     * @param string|null $deliveryTimeStampEnd
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 16:30:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$deliveryTimeStampEnd
     */
    public function setDeliveryTimeStampEnd(?string $deliveryTimeStampEnd): ShipmentInterface;

    /**
     * Get delivery date.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$deliveryDate
     */
    public function getDeliveryDate(): ?string;

    /**
     * Set delivery date.
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}\s(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 03-07-2019 14:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): ShipmentInterface;

    /**
     * Get dimension.
     *
     * @return DimensionInterface|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$dimension
     */
    public function getDimension(): ?DimensionInterface;

    /**
     * Set dimension.
     *
     * @pattern N/A
     *
     * @param DimensionInterface|null $dimension
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$dimension
     */
    public function setDimension(?DimensionInterface $dimension): ShipmentInterface;

    /**
     * Get down partner barcode.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$downPartnerBarcode
     */
    public function getDownPartnerBarcode(): ?string;

    /**
     * Set down partner barcode.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $downPartnerBarcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example CD123456785NL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$downPartnerBarcode
     */
    public function setDownPartnerBarcode(?string $downPartnerBarcode): ShipmentInterface;

    /**
     * Get down partner ID.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$downPartnerID
     */
    public function getDownPartnerID(): ?string;

    /**
     * Set down partner ID.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $downPartnerID
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example LD-01
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$downPartnerID
     */
    public function setDownPartnerID(?string $downPartnerID): ShipmentInterface;

    /**
     * Get down partner location.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$downPartnerLocation
     */
    public function getDownPartnerLocation(): ?string;

    /**
     * Set down partner location.
     *
     * @pattern ^.{0,10}$
     *
     * @param string|null $downPartnerLocation
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example BE0Q82
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$downPartnerLocation
     */
    public function setDownPartnerLocation(?string $downPartnerLocation): ShipmentInterface;

    /**
     * Get groups.
     *
     * @return GroupInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$groups
     */
    public function getGroups(): ?array;

    /**
     * Set groups.
     *
     * @pattern N/A
     *
     * @param GroupInterface[]|null $groups
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$groups
     */
    public function setGroups(?array $groups): ShipmentInterface;

    /**
     * Get ID expiration date.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$IDExpiration
     */
    public function getIDExpiration(): ?string;

    /**
     * Set ID expiration date.
     *
     * @pattern  ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @param string|null $IDExpiration
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example  05-07-2019
     *
     * @since    1.0.0
     * @since    2.0.0 Strict typing
     * @see      Shipment::$IDExpiration
     */
    public function setIDExpiration(?string $IDExpiration): ShipmentInterface;

    /**
     * Get ID number.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$IDNumber
     */
    public function getIDNumber(): ?string;

    /**
     * Set ID number.
     *
     * @pattern ^.{0,20}$
     *
     * @param string|null $IDNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 4261103214
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$IDNumber
     */
    public function setIDNumber(?string $IDNumber): ShipmentInterface;

    /**
     * Get ID type.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$IDType
     */
    public function getIDType(): ?string;

    /**
     * Set ID type.
     *
     * @pattern ^\d{2}$
     *
     * @param string|null $IDType
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 02
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$IDType
     */
    public function setIDType(?string $IDType): ShipmentInterface;

    /**
     * Get product code collect.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$productCodeCollect
     */
    public function getProductCodeCollect(): ?string;

    /**
     * Set product code collect.
     *
     * @pattern ^\d{4}$
     *
     * @param string|null $productCodeCollect
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3153
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$productCodeCollect
     */
    public function setProductCodeCollect(?string $productCodeCollect): ShipmentInterface;

    /**
     * Get product code delivery.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$productCodeDelivery
     */
    public function getProductCodeDelivery(): ?string;

    /**
     * Set product code delivery.
     *
     * @pattern ^\d{4}$
     *
     * @param string|null $productCodeDelivery
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3085
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$productCodeDelivery
     */
    public function setProductCodeDelivery(?string $productCodeDelivery): ShipmentInterface;

    /**
     * Get product options.
     *
     * @return ProductOptionInterface[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$productOptions
     */
    public function getProductOptions(): ?array;

    /**
     * Set product options.
     *
     * @pattern N/A
     *
     * @param ProductOptionInterface[]|null $productOptions
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$productOptions
     */
    public function setProductOptions(?array $productOptions): ShipmentInterface;

    /**
     * Get receiver date of birth.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$receiverDateOfBirth
     */
    public function getReceiverDateOfBirth(): ?string;

    /**
     * Set receiver date of birth.
     *
     * @pattern  ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @param string|null $receiverDateOfBirth
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example  01-01-1970
     *
     * @since    1.0.0
     * @since    2.0.0 Strict typing
     * @see      Shipment::$receiverDateOfBirth
     */
    public function setReceiverDateOfBirth(?string $receiverDateOfBirth): ShipmentInterface;

    /**
     * Get reference.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$reference
     */
    public function getReference(): ?string;

    /**
     * Set reference.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $reference
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 2016014567
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$reference
     */
    public function setReference(?string $reference): ShipmentInterface;

    /**
     * Get reference collect.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$referenceCollect
     */
    public function getReferenceCollect(): ?string;

    /**
     * Set reference collect.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $referenceCollect
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 6659150
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$referenceCollect
     */
    public function setReferenceCollect(?string $referenceCollect): ShipmentInterface;

    /**
     * Get remark.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$remark
     */
    public function getRemark(): ?string;

    /**
     * Set remark.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $remark
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example Fragile
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$remark
     */
    public function setRemark(?string $remark): ShipmentInterface;

    /**
     * Set remark.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$remark
     */
    public function getReturnBarcode(): ?string;

    /**
     * Set return barcode.
     *
     * @pattern ^.{11,15}$
     *
     * @param string|null $returnBarcode
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 3SABCD7762162
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$returnBarcode
     */
    public function setReturnBarcode(?string $returnBarcode): ShipmentInterface;

    /**
     * Get return reference.
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     * @see   Shipment::$returnReference
     */
    public function getReturnReference(): ?string;

    /**
     * Set return reference.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $returnReference
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 112233
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Shipment::$returnReference
     */
    public function setReturnReference(?string $returnReference): ShipmentInterface;

    /**
     * Get main barcode.
     *
     * @return string|null
     *
     * @since   2.0.0 Strict typing
     * @see     Shipment::$barcode
     */
    public function getMainBarcode(): ?string;

    /**
     * Set main barcode.
     *
     * @pattern ^{0,95}$
     *
     * @param string|null $mainBarcode
     *
     * @return static
     *
     * @example 3SDEVC2309482387
     *
     * @since   2.0.0 Strict typing
     * @see     Shipment::$barcode
     */
    public function setMainBarcode(?string $mainBarcode): ShipmentInterface;

    /**
     * Get shipment amount.
     *
     * @return int|null
     *
     * @since 2.0.0 Strict typing
     * @see   Shipment::$shipmentAmount
     */
    public function getShipmentAmount(): ?int;

    /**
     * Set shipment amount.
     *
     * @pattern ^\d{0,10}$
     *
     * @param int|float|string|null $shipmentAmount
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 1
     *
     * @since   2.0.0 Strict typing
     * @see     Shipment::$shipmentAmount
     */
    public function setShipmentAmount($shipmentAmount): ShipmentInterface;

    /**
     * Get shipment counter.
     *
     * @return int|null
     *
     * @since 2.0.0 Strict typing
     * @see   Shipment::$shipmentCounter
     */
    public function getShipmentCounter(): ?int;

    /**
     * Set shipment counter.
     *
     * @pattern ^\d{0,10}$
     *
     * @param int|float|string|null $shipmentCounter
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example 1
     *
     * @since   2.0.0 Strict typing
     * @see     Shipment::$shipmentCounter
     */
    public function setShipmentCounter($shipmentCounter): ShipmentInterface;

    /**
     * Get customer.
     *
     * @return CustomerInterface|null
     *
     * @since 2.0.0 Strict typing
     * @see   Customer
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * Set customer.
     *
     * @pattern N/A
     *
     * @param CustomerInterface|null $customer
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Customer
     */
    public function setCustomer(?CustomerInterface $customer): ShipmentInterface;

    /**
     * Get product code.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Shipment::$productCode
     */
    public function getProductCode(): ?string;

    /**
     * Set product code.
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $productCode
     *
     * @return static
     *
     * @example 003085
     *
     * @since   2.0.0 Strict typing
     * @see     Shipment::$productCode
     */
    public function setProductCode(?string $productCode): ShipmentInterface;

    /**
     * Get product description.
     *
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     * @see   Shipment::$productDescription
     */
    public function getProductDescription(): ?string;

    /**
     * Set product description.
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $productDescription
     *
     * @return static
     *
     * @example Standaardzending
     *
     * @since   2.0.0 Strict typing
     * @see     Shipment::$productDescription
     */
    public function setProductDescription(?string $productDescription): ShipmentInterface;

    /**
     * Get addresses.
     *
     * @return AddressInterface[]|null
     *
     * @since 2.0.0 Strict typing
     * @see   Address
     */
    public function getAddress(): ?array;

    /**
     * Set addresses.
     *
     * @pattern N/A
     *
     * @param AddressInterface[]|null $address
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Address
     */
    public function setAddress(?array $address): ShipmentInterface;

    /**
     * Get events.
     *
     * @return EventInterface[]|null
     *
     * @since 2.0.0 Strict typing
     * @see   Event
     */
    public function getEvent(): ?array;

    /**
     * Set events.
     *
     * @pattern N/A
     *
     * @param EventInterface[]|null $event
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Event
     */
    public function setEvent(?array $event): ShipmentInterface;

    /**
     * Get status.
     *
     * @return StatusInterface|null
     *
     * @since 2.0.0 Strict typing
     * @see   Status
     */
    public function getStatus(): ?StatusInterface;

    /**
     * Set status.
     *
     * @pattern N/A
     *
     * @param StatusInterface|null $status
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Status
     */
    public function setStatus(?StatusInterface $status): ShipmentInterface;

    /**
     * Get old statuses.
     *
     * @return OldStatusInterface[]|null
     *
     * @since 2.0.0 Strict typing
     * @see   OldStatus
     */
    public function getOldStatus(): ?array;

    /**
     * Set old status.
     *
     * @pattern N/A
     *
     * @param OldStatusInterface[]|null $oldStatus
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     OldStatus
     */
    public function setOldStatus(?array $oldStatus): ShipmentInterface;

    /**
     * Get labels.
     *
     * @return LabelInterface[]|null
     *
     * @since 2.0.0 Strict typing
     * @see   Label
     */
    public function getLabels(): ?array;

    /**
     * Add label.
     *
     * @param LabelInterface $label
     *
     * @return ShipmentInterface
     *
     * @since 2.0.0
     * @see   Label
     * @see   Label
     */
    public function addLabel(LabelInterface $label): ShipmentInterface;

    /**
     * Set labels.
     *
     * @pattern N/A
     *
     * @param LabelInterface[]|null $labels
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Label
     */
    public function setLabels(?array $labels): ShipmentInterface;
}
