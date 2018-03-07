<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Shipment
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method Address[]       getAddresses()
 * @method string          getBarcode()
 * @method int             getPhaseCode()
 * @method string          getDateFrom()
 * @method string          getDateTo()
 * @method Dimension       getDimension()
 * @method string          getProductCodeDelivery()
 * @method Amount[]        getAmounts()
 * @method string          getCollectionTimeStampEnd()
 * @method string          getCollectionTimeStampStart()
 * @method Contact[]       getContacts()
 * @method string          getContent()
 * @method string          getCostCenter()
 * @method string          getCustomerOrderNumber()
 * @method Customs         getCustoms()
 * @method string          getDeliveryAddress()
 * @method string          getDeliveryDate()
 * @method string          getDownPartnerBarcode()
 * @method string          getDownPartnerID()
 * @method string          getDownPartnerLocation()
 * @method Group[]         getGroups()
 * @method string          getIDExpiration()
 * @method string          getIDNumber()
 * @method string          getIDType()
 * @method string          getProductCodeCollect()
 * @method ProductOption[] getProductOptions()
 * @method string          getReceiverDateOfBirth()
 * @method string          getReference()
 * @method string          getReferenceCollect()
 * @method string          getRemark()
 * @method string          getReturnBarcode()
 * @method string          getReturnReference()
 * @method string          getStatusCode()
 *
 * @method Shipment setAddresses(Address[] $addresses)
 * @method Shipment setBarcode(string $barcode)
 * @method Shipment setDimension(string $dimension)
 * @method Shipment setProductCodeDelivery(string $productCodeDelivery)
 * @method Shipment setAmounts(Amount[] $amounts)
 * @method Shipment setCollectionTimeStampEnd(string $value)
 * @method Shipment setCollectionTimeStampStart(string $value)
 * @method Shipment setContacts(Contact[] $contact)
 * @method Shipment setContent(string $content)
 * @method Shipment setCostCenter(string $costCenter)
 * @method Shipment setCustomerOrderNumber(string $customerOrderNumber)
 * @method Shipment setCustoms(Customs $customs)
 * @method Shipment setPhaseCode(int $phaseCode)
 * @method Shipment setDateFrom(string $date)
 * @method Shipment setDateTo(string $date)
 * @method Shipment setDeliveryAddress(string $deliveryAddress)
 * @method Shipment setDeliveryDate(string $deliveryDate)
 * @method Shipment setDownPartnerBarcode(string $downPartnerBarcode)
 * @method Shipment setDownPartnerID(string $downPartnerID)
 * @method Shipment setDownPartnerLocation(string $downPartnerLocation)
 * @method Shipment setGroups(Group[] $groups)
 * @method Shipment setIDExpiration(string $idExpiration)
 * @method Shipment setIDNumber(string $idNumber)
 * @method Shipment setIDType(string $idType)
 * @method Shipment setProductCodeCollect(string $productCodeCollect)
 * @method Shipment setProductOptions(ProductOption[] $productOptions)
 * @method Shipment setReceiverDateOfBirth(string $receiverDateOfBirth)
 * @method Shipment setReference(string $reference)
 * @method Shipment setReferenceCollect(string $referenceCollect)
 * @method Shipment setRemark(string $remark)
 * @method Shipment setReturnBarcode(string $returnBarcode)
 * @method Shipment setReturnReference(string $returnReference)
 * @method Shipment setStatusCode(string $statusCode)
 */
class Shipment extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Addresses'                => BarcodeService::DOMAIN_NAMESPACE,
            'Amounts'                  => BarcodeService::DOMAIN_NAMESPACE,
            'Barcode'                  => BarcodeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => BarcodeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => BarcodeService::DOMAIN_NAMESPACE,
            'Contacts'                 => BarcodeService::DOMAIN_NAMESPACE,
            'Content'                  => BarcodeService::DOMAIN_NAMESPACE,
            'CostCenter'               => BarcodeService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => BarcodeService::DOMAIN_NAMESPACE,
            'Customs'                  => BarcodeService::DOMAIN_NAMESPACE,
            'DateFrom'                 => BarcodeService::DOMAIN_NAMESPACE,
            'DateTo'                   => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryTimeStampStart'   => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => BarcodeService::DOMAIN_NAMESPACE,
            'Dimension'                => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => BarcodeService::DOMAIN_NAMESPACE,
            'Groups'                   => BarcodeService::DOMAIN_NAMESPACE,
            'IDExpiration'             => BarcodeService::DOMAIN_NAMESPACE,
            'IDNumber'                 => BarcodeService::DOMAIN_NAMESPACE,
            'IDType'                   => BarcodeService::DOMAIN_NAMESPACE,
            'PhaseCode'                => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => BarcodeService::DOMAIN_NAMESPACE,
            'ProductOptions'           => BarcodeService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => BarcodeService::DOMAIN_NAMESPACE,
            'Reference'                => BarcodeService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => BarcodeService::DOMAIN_NAMESPACE,
            'Remark'                   => BarcodeService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => BarcodeService::DOMAIN_NAMESPACE,
            'ReturnReference'          => BarcodeService::DOMAIN_NAMESPACE,
            'StatusCode'               => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Addresses'                => ConfirmingService::DOMAIN_NAMESPACE,
            'Amounts'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'Barcode'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => ConfirmingService::DOMAIN_NAMESPACE,
            'Contacts'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'Content'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'CostCenter'               => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Customs'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'DateFrom'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'DateTo'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => ConfirmingService::DOMAIN_NAMESPACE,
            'Dimension'                => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Groups'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => ConfirmingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'IDType'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'PhaseCode'                => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductOptions'           => ConfirmingService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Reference'                => ConfirmingService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Remark'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => ConfirmingService::DOMAIN_NAMESPACE,
            'ReturnReference'          => ConfirmingService::DOMAIN_NAMESPACE,
            'StatusCode'               => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Addresses'                => LabellingService::DOMAIN_NAMESPACE,
            'Amounts'                  => LabellingService::DOMAIN_NAMESPACE,
            'Barcode'                  => LabellingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => LabellingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => LabellingService::DOMAIN_NAMESPACE,
            'Contacts'                 => LabellingService::DOMAIN_NAMESPACE,
            'Content'                  => LabellingService::DOMAIN_NAMESPACE,
            'CostCenter'               => LabellingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => LabellingService::DOMAIN_NAMESPACE,
            'Customs'                  => LabellingService::DOMAIN_NAMESPACE,
            'DateFrom'                 => LabellingService::DOMAIN_NAMESPACE,
            'DateTo'                   => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => LabellingService::DOMAIN_NAMESPACE,
            'Dimension'                => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => LabellingService::DOMAIN_NAMESPACE,
            'Groups'                   => LabellingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => LabellingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => LabellingService::DOMAIN_NAMESPACE,
            'IDType'                   => LabellingService::DOMAIN_NAMESPACE,
            'PhaseCode'                => LabellingService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => LabellingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => LabellingService::DOMAIN_NAMESPACE,
            'ProductOptions'           => LabellingService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => LabellingService::DOMAIN_NAMESPACE,
            'Reference'                => LabellingService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => LabellingService::DOMAIN_NAMESPACE,
            'Remark'                   => LabellingService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => LabellingService::DOMAIN_NAMESPACE,
            'ReturnReference'          => LabellingService::DOMAIN_NAMESPACE,
            'StatusCode'               => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Addresses'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'Amounts'                  => ShippingStatusService::DOMAIN_NAMESPACE,
            'Barcode'                  => ShippingStatusService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Contacts'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'Content'                  => ShippingStatusService::DOMAIN_NAMESPACE,
            'CostCenter'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Customs'                  => ShippingStatusService::DOMAIN_NAMESPACE,
            'DateFrom'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'DateTo'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'Dimension'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Groups'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'IDExpiration'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'IDNumber'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'IDType'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'PhaseCode'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductOptions'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Reference'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Remark'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'ReturnReference'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'StatusCode'               => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Addresses'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'Amounts'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Barcode'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Contacts'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'Content'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'CostCenter'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Customs'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'DateFrom'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'DateTo'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'Dimension'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Groups'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'IDExpiration'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'IDNumber'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'IDType'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'PhaseCode'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductOptions'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Reference'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Remark'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'ReturnReference'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'StatusCode'               => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Addresses'                => LocationService::DOMAIN_NAMESPACE,
            'Amounts'                  => LocationService::DOMAIN_NAMESPACE,
            'Barcode'                  => LocationService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => LocationService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => LocationService::DOMAIN_NAMESPACE,
            'Contacts'                 => LocationService::DOMAIN_NAMESPACE,
            'Content'                  => LocationService::DOMAIN_NAMESPACE,
            'CostCenter'               => LocationService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => LocationService::DOMAIN_NAMESPACE,
            'Customs'                  => LocationService::DOMAIN_NAMESPACE,
            'DateFrom'                 => LocationService::DOMAIN_NAMESPACE,
            'DateTo'                   => LocationService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => LocationService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => LocationService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => LocationService::DOMAIN_NAMESPACE,
            'Dimension'                => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => LocationService::DOMAIN_NAMESPACE,
            'Groups'                   => LocationService::DOMAIN_NAMESPACE,
            'IDExpiration'             => LocationService::DOMAIN_NAMESPACE,
            'IDNumber'                 => LocationService::DOMAIN_NAMESPACE,
            'IDType'                   => LocationService::DOMAIN_NAMESPACE,
            'PhaseCode'                => LocationService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => LocationService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => LocationService::DOMAIN_NAMESPACE,
            'ProductOptions'           => LocationService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => LocationService::DOMAIN_NAMESPACE,
            'Reference'                => LocationService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => LocationService::DOMAIN_NAMESPACE,
            'Remark'                   => LocationService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => LocationService::DOMAIN_NAMESPACE,
            'ReturnReference'          => LocationService::DOMAIN_NAMESPACE,
            'StatusCode'               => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Addresses'                => TimeframeService::DOMAIN_NAMESPACE,
            'Amounts'                  => TimeframeService::DOMAIN_NAMESPACE,
            'Barcode'                  => TimeframeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => TimeframeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => TimeframeService::DOMAIN_NAMESPACE,
            'Contacts'                 => TimeframeService::DOMAIN_NAMESPACE,
            'Content'                  => TimeframeService::DOMAIN_NAMESPACE,
            'CostCenter'               => TimeframeService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => TimeframeService::DOMAIN_NAMESPACE,
            'Customs'                  => TimeframeService::DOMAIN_NAMESPACE,
            'DateFrom'                 => TimeframeService::DOMAIN_NAMESPACE,
            'DateTo'                   => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => TimeframeService::DOMAIN_NAMESPACE,
            'Dimension'                => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => TimeframeService::DOMAIN_NAMESPACE,
            'Groups'                   => TimeframeService::DOMAIN_NAMESPACE,
            'IDExpiration'             => TimeframeService::DOMAIN_NAMESPACE,
            'IDNumber'                 => TimeframeService::DOMAIN_NAMESPACE,
            'IDType'                   => TimeframeService::DOMAIN_NAMESPACE,
            'PhaseCode'                => TimeframeService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => TimeframeService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => TimeframeService::DOMAIN_NAMESPACE,
            'ProductOptions'           => TimeframeService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => TimeframeService::DOMAIN_NAMESPACE,
            'Reference'                => TimeframeService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => TimeframeService::DOMAIN_NAMESPACE,
            'Remark'                   => TimeframeService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => TimeframeService::DOMAIN_NAMESPACE,
            'ReturnReference'          => TimeframeService::DOMAIN_NAMESPACE,
            'StatusCode'               => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address[] $Addresses */
    protected $Addresses;
    /** @var Amount[] $Amounts */
    protected $Amounts;
    /** @var string $Barcode */
    protected $Barcode;
    /** @var string $CollectionTimeStampEnd */
    protected $CollectionTimeStampEnd;
    /** @var string $CollectionTimeStampStart */
    protected $CollectionTimeStampStart;
    /** @var Contact[] $Contacts */
    protected $Contacts;
    /** @var string $Content */
    protected $Content;
    /** @var string $CostCenter */
    protected $CostCenter;
    /** @var string $CustomerOrderNumber */
    protected $CustomerOrderNumber;
    /** @var Customs $Customs */
    protected $Customs;
    /** @var string $StatusCode */
    protected $StatusCode;
    /** @var int $PhaseCode */
    protected $PhaseCode;
    /** @var string $DateFrom */
    protected $DateFrom;
    /** @var string $DateTo */
    protected $DateTo;
    /** @var string $DeliveryAddress */
    protected $DeliveryAddress;
    /** @var string $DeliveryTimeStampStart */
    protected $DeliveryTimeStampStart;
    /** @var string $DeliveryTimeStampEnd */
    protected $DeliveryTimeStampEnd;
    /** @var string $DeliveryDate */
    protected $DeliveryDate;
    /** @var Dimension $Dimension */
    protected $Dimension;
    /** @var string $DownPartnerBarcode */
    protected $DownPartnerBarcode;
    /** @var string $DownPartnerID */
    protected $DownPartnerID;
    /** @var string $DownPartnerLocation */
    protected $DownPartnerLocation;
    /** @var Group[] $Groups */
    protected $Groups;
    /** @var string $IDExpiration */
    protected $IDExpiration;
    /** @var string $IDNumber */
    protected $IDNumber;
    /** @var string $IDType */
    protected $IDType;
    /** @var string $ProductCodeCollect */
    protected $ProductCodeCollect;
    /** @var string $ProductCodeDelivery */
    protected $ProductCodeDelivery;
    /** @var ProductOption[] $ProductOptions */
    protected $ProductOptions;
    /** @var string $ReceiverDateOfBirth */
    protected $ReceiverDateOfBirth;
    /** @var string $Reference */
    protected $Reference;
    /** @var string $ReferenceCollect */
    protected $ReferenceCollect;
    /** @var string $Remark */
    protected $Remark;
    /** @var string $ReturnBarcode */
    protected $ReturnBarcode;
    /** @var string $ReturnReference */
    protected $ReturnReference;
    // @codingStandardsIgnoreEnd

    /**
     * Shipment constructor.
     *
     * @param Address[]            $addresses
     * @param string               $barcode
     * @param Dimension            $dimension
     * @param string               $productCodeDelivery
     * @param array|null           $amounts
     * @param string|null          $collectionTimeStampEnd
     * @param string|null          $collectionTimeStampStart
     * @param Contact[]|null       $contacts
     * @param string|null          $content
     * @param string|null          $costCenter
     * @param string|null          $customerOrderNumber
     * @param Customs|null         $customs
     * @param string|null          $deliveryAddress
     * @param string|null          $deliveryDate
     * @param string|null          $downPartnerBarcode
     * @param string|null          $downPartnerId
     * @param string|null          $downPartnerLocation
     * @param Group[]|null         $groups
     * @param string|null          $idExpiration
     * @param string|null          $idNumber
     * @param string|null          $idType
     * @param string|null          $productCodeCollect
     * @param ProductOption[]|null $productOptions
     * @param string|null          $receiverDateOfBirth
     * @param string|null          $reference
     * @param string|null          $referenceCollect
     * @param string|null          $remark
     * @param string|null          $returnBarcode
     * @param string|null          $returnReference
     * @param string|null          $statusCode
     * @param int|null             $phaseCode
     * @param string|null          $dateFrom
     * @param string|null          $dateTo
     */
    public function __construct(
        array $addresses = null,
        array $amounts = null,
        $barcode = null,
        array $contacts = null,
        $content = null,
        $collectionTimeStampEnd = null,
        $collectionTimeStampStart = null,
        $costCenter = null,
        $customerOrderNumber = null,
        Customs $customs = null,
        $deliveryAddress = null,
        $deliveryDate = null,
        Dimension $dimension = null,
        $downPartnerBarcode = null,
        $downPartnerId = null,
        $downPartnerLocation = null,
        array $groups = null,
        $idExpiration = null,
        $idNumber = null,
        $idType = null,
        $productCodeCollect = null,
        $productCodeDelivery = null,
        array $productOptions = null,
        $receiverDateOfBirth = null,
        $reference = null,
        $referenceCollect = null,
        $remark = null,
        $returnBarcode = null,
        $returnReference = null,
        $statusCode = null,
        $phaseCode = null,
        $dateFrom = null,
        $dateTo = null
    ) {
        parent::__construct();

        $this->setAddresses($addresses);
        $this->setAmounts($amounts);
        $this->setBarcode($barcode);
        $this->setCollectionTimeStampEnd($collectionTimeStampEnd);
        $this->setCollectionTimeStampStart($collectionTimeStampStart);
        $this->setContacts($contacts);
        $this->setContent($content);
        $this->setCostCenter($costCenter);
        $this->setCustomerOrderNumber($customerOrderNumber);
        $this->setCustoms($customs);
        $this->setDeliveryAddress($deliveryAddress);
        $this->setDeliveryDate($deliveryDate);
        $this->setDimension($dimension);
        $this->setDownPartnerBarcode($downPartnerBarcode);
        $this->setDownPartnerID($downPartnerId);
        $this->setDownPartnerLocation($downPartnerLocation);
        $this->setGroups($groups);
        $this->setIDExpiration($idExpiration);
        $this->setIDNumber($idNumber);
        $this->setIDType($idType);
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
     * Return a serializable array for the XMLWriter
     *
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ($propertyName === 'Addresses') {
                if (is_array($this->Addresses)) {
                    $items = [];
                    foreach ($this->Addresses as $address) {
                        $items[] = ["{{$namespace}}Address" => $address];
                    }
                    $xml["{{$namespace}}Addresses"] = $items;
                }
            } elseif ($propertyName === 'Amounts') {
                if (is_array($this->Amounts)) {
                    $items = [];
                    foreach ($this->Amounts as $amount) {
                        $items[] = ["{{$namespace}}Amount" => $amount];
                    }
                    $xml["{{$namespace}}Amounts"] = $items;
                }
            } elseif ($propertyName === 'Contacts') {
                if (is_array($this->Contacts)) {
                    $items = [];
                    foreach ($this->Contacts as $contact) {
                        $items[] = ["{{$namespace}}Contact" => $contact];
                    }
                    $xml["{{$namespace}}Contacts"] = $items;
                }
            } elseif ($propertyName === 'Groups') {
                if (is_array($this->Groups)) {
                    $items = [];
                    foreach ($this->Groups as $group) {
                        $items[] = ["{{$namespace}}Group" => $group];
                    }
                    $xml["{{$namespace}}Groups"] = $items;
                }
            } elseif ($propertyName === 'ProductOptions') {
                if (is_array($this->ProductOptions)) {
                    $items = [];
                    foreach ($this->ProductOptions as $option) {
                        $items[] = ["{{$namespace}}ProductOption" => $option];
                    }
                    $xml["{{$namespace}}ProductOptions"] = $items;
                }
            } elseif (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
