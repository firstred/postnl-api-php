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

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Sabre\Xml\Writer;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class Shipment.
 *
 * @method Address[]|null         getAddresses()
 * @method string|null            getBarcode()
 * @method int|null               getPhaseCode()
 * @method string|null            getDateFrom()
 * @method string|null            getDateTo()
 * @method Dimension|null         getDimension()
 * @method string|null            getProductCodeDelivery()
 * @method Amount[]|null          getAmounts()
 * @method DateTimeInterface|null getCollectionTimeStampEnd()
 * @method DateTimeInterface|null getCollectionTimeStampStart()
 * @method Contact[]|null         getContacts()
 * @method string|null            getContent()
 * @method string|null            getCostCenter()
 * @method Customer|null          getCustomer()
 * @method string|null            getCustomerOrderNumber()
 * @method Customs|null           getCustoms()
 * @method string|null            getDeliveryAddress()
 * @method DateTimeInterface|null getDeliveryDate()
 * @method DateTimeInterface|null getDeliveryTimeStampStart()
 * @method DateTimeInterface|null getDeliveryTimeStampEnd()
 * @method string|null            getDownPartnerBarcode()
 * @method string|null            getDownPartnerID()
 * @method string|null            getDownPartnerLocation()
 * @method Event[]|null           getEvents()
 * @method Group[]|null           getGroups()
 * @method string|null            getIDExpiration()
 * @method string|null            getIDNumber()
 * @method string|null            getIDType()
 * @method OldStatus[]|null       getOldStatuses()
 * @method string|null            getProductCodeCollect()
 * @method ProductOption[]|null   getProductOptions()
 * @method string|null            getReceiverDateOfBirth()
 * @method string|null            getReference()
 * @method string|null            getReferenceCollect()
 * @method string|null            getRemark()
 * @method string|null            getReturnBarcode()
 * @method string|null            getReturnReference()
 * @method string|null            getStatusCode()
 * @method Shipment               setAddresses(Address[]|null $Addresses = null)
 * @method Shipment               setBarcode(string|null $Barcode = null)
 * @method Shipment               setDimension(string|null $Dimension = null)
 * @method Shipment               setProductCodeDelivery(string|null $ProductCodeDelivery = null)
 * @method Shipment               setAmounts(Amount[]|null $Amounts = null)
 * @method Shipment               setContacts(Contact[]|null $Contact = null)
 * @method Shipment               setContent(string|null $Content = null)
 * @method Shipment               setCostCenter(string|null $CostCenter = null)
 * @method Shipment               setCustomer(Customer|null $Customer = null)
 * @method Shipment               setCustomerOrderNumber(string|null $CustomerOrderNumber = null)
 * @method Shipment               setCustoms(Customs|null $Customs = null)
 * @method Shipment               setPhaseCode(int|null $PhaseCode = null)
 * @method Shipment               setDateFrom(string|null $DateFrom = null)
 * @method Shipment               setDateTo(string $DateTo = null)
 * @method Shipment               setDeliveryAddress(string|null $DeliveryAddress = null)
 * @method Shipment               setDownPartnerBarcode(string|null $DownPartnerBarcode = null)
 * @method Shipment               setDownPartnerID(string|null $DownPartnerID = null)
 * @method Shipment               setDownPartnerLocation(string|null $DownPartnerLocation = null)
 * @method Shipment               setEvents(Event[]|null $Events = null)
 * @method Shipment               setGroups(Group[]|null $Groups = null)
 * @method Shipment               setIDExpiration(string|null $IDExpiration = null)
 * @method Shipment               setIDNumber(string|null $IDNumber = null)
 * @method Shipment               setIDType(string|null $IDType = null)
 * @method Shipment               setOldStatuses(OldStatus[]|null $OldStatuses = null)
 * @method Shipment               setProductCodeCollect(string|null $ProductCodeCollect = null)
 * @method Shipment               setProductOptions(ProductOption[]|null $ProductOptions = null)
 * @method Shipment               setReceiverDateOfBirth(string|null $ReceiverDateOfBirth = null)
 * @method Shipment               setReference(string|null $Reference = null)
 * @method Shipment               setReferenceCollect(string|null $ReferenceCollect = null)
 * @method Shipment               setRemark(string|null $Remark = null)
 * @method Shipment               setReturnBarcode(string|null $ReturnBarcode = null)
 * @method Shipment               setReturnReference(string|null $ReturnReference = null)
 * @method Shipment               setStatusCode(string|null $StatusCode = null)
 *
 * @since 1.0.0
 */
class Shipment extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Addresses'                => BarcodeService::DOMAIN_NAMESPACE,
            'Amounts'                  => BarcodeService::DOMAIN_NAMESPACE,
            'Barcode'                  => BarcodeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => BarcodeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => BarcodeService::DOMAIN_NAMESPACE,
            'Contacts'                 => BarcodeService::DOMAIN_NAMESPACE,
            'Content'                  => BarcodeService::DOMAIN_NAMESPACE,
            'CostCenter'               => BarcodeService::DOMAIN_NAMESPACE,
            'Customer'                 => BarcodeService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => BarcodeService::DOMAIN_NAMESPACE,
            'Customs'                  => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryTimeStampStart'   => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => BarcodeService::DOMAIN_NAMESPACE,
            'Dimension'                => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => BarcodeService::DOMAIN_NAMESPACE,
            'Events'                   => BarcodeService::DOMAIN_NAMESPACE,
            'Groups'                   => BarcodeService::DOMAIN_NAMESPACE,
            'IDExpiration'             => BarcodeService::DOMAIN_NAMESPACE,
            'IDNumber'                 => BarcodeService::DOMAIN_NAMESPACE,
            'IDType'                   => BarcodeService::DOMAIN_NAMESPACE,
            'OldStatuses'              => BarcodeService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => BarcodeService::DOMAIN_NAMESPACE,
            'DateTo'                   => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Addresses'                => ConfirmingService::DOMAIN_NAMESPACE,
            'Amounts'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'Barcode'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => ConfirmingService::DOMAIN_NAMESPACE,
            'Contacts'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'Content'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'CostCenter'               => ConfirmingService::DOMAIN_NAMESPACE,
            'Customer'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Customs'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => ConfirmingService::DOMAIN_NAMESPACE,
            'Dimension'                => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Events'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'Groups'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => ConfirmingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'IDType'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'OldStatuses'              => ConfirmingService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'DateTo'                   => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Addresses'                => LabellingService::DOMAIN_NAMESPACE,
            'Amounts'                  => LabellingService::DOMAIN_NAMESPACE,
            'Barcode'                  => LabellingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => LabellingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => LabellingService::DOMAIN_NAMESPACE,
            'Contacts'                 => LabellingService::DOMAIN_NAMESPACE,
            'Content'                  => LabellingService::DOMAIN_NAMESPACE,
            'CostCenter'               => LabellingService::DOMAIN_NAMESPACE,
            'Customer'                 => LabellingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => LabellingService::DOMAIN_NAMESPACE,
            'Customs'                  => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => LabellingService::DOMAIN_NAMESPACE,
            'Dimension'                => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => LabellingService::DOMAIN_NAMESPACE,
            'Events'                   => LabellingService::DOMAIN_NAMESPACE,
            'Groups'                   => LabellingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => LabellingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => LabellingService::DOMAIN_NAMESPACE,
            'IDType'                   => LabellingService::DOMAIN_NAMESPACE,
            'OldStatuses'              => LabellingService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => LabellingService::DOMAIN_NAMESPACE,
            'DateTo'                   => LabellingService::DOMAIN_NAMESPACE,
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
            'Customer'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Customs'                  => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'Dimension'                => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Events'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Groups'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'IDExpiration'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'IDNumber'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'IDType'                   => ShippingStatusService::DOMAIN_NAMESPACE,
            'OldStatuses'              => ShippingStatusService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'DateTo'                   => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Addresses'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'Amounts'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Barcode'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Contacts'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'Content'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'CostCenter'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'Customer'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Customs'                  => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'Dimension'                => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Events'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Groups'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'IDExpiration'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'IDNumber'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'IDType'                   => DeliveryDateService::DOMAIN_NAMESPACE,
            'OldStatuses'              => DeliveryDateService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'DateTo'                   => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Addresses'                => LocationService::DOMAIN_NAMESPACE,
            'Amounts'                  => LocationService::DOMAIN_NAMESPACE,
            'Barcode'                  => LocationService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => LocationService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => LocationService::DOMAIN_NAMESPACE,
            'Contacts'                 => LocationService::DOMAIN_NAMESPACE,
            'Content'                  => LocationService::DOMAIN_NAMESPACE,
            'CostCenter'               => LocationService::DOMAIN_NAMESPACE,
            'Customer'                 => LocationService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => LocationService::DOMAIN_NAMESPACE,
            'Customs'                  => LocationService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => LocationService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => LocationService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => LocationService::DOMAIN_NAMESPACE,
            'Dimension'                => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => LocationService::DOMAIN_NAMESPACE,
            'Events'                   => LocationService::DOMAIN_NAMESPACE,
            'Groups'                   => LocationService::DOMAIN_NAMESPACE,
            'IDExpiration'             => LocationService::DOMAIN_NAMESPACE,
            'IDNumber'                 => LocationService::DOMAIN_NAMESPACE,
            'IDType'                   => LocationService::DOMAIN_NAMESPACE,
            'OldStatuses'              => LocationService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => LocationService::DOMAIN_NAMESPACE,
            'DateTo'                   => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Addresses'                => TimeframeService::DOMAIN_NAMESPACE,
            'Amounts'                  => TimeframeService::DOMAIN_NAMESPACE,
            'Barcode'                  => TimeframeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => TimeframeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => TimeframeService::DOMAIN_NAMESPACE,
            'Contacts'                 => TimeframeService::DOMAIN_NAMESPACE,
            'Content'                  => TimeframeService::DOMAIN_NAMESPACE,
            'CostCenter'               => TimeframeService::DOMAIN_NAMESPACE,
            'Customer'                 => TimeframeService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => TimeframeService::DOMAIN_NAMESPACE,
            'Customs'                  => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => TimeframeService::DOMAIN_NAMESPACE,
            'Dimension'                => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => TimeframeService::DOMAIN_NAMESPACE,
            'Events'                   => TimeframeService::DOMAIN_NAMESPACE,
            'Groups'                   => TimeframeService::DOMAIN_NAMESPACE,
            'IDExpiration'             => TimeframeService::DOMAIN_NAMESPACE,
            'IDNumber'                 => TimeframeService::DOMAIN_NAMESPACE,
            'IDType'                   => TimeframeService::DOMAIN_NAMESPACE,
            'OldStatuses'              => TimeframeService::DOMAIN_NAMESPACE,
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
            'DateFrom'                 => TimeframeService::DOMAIN_NAMESPACE,
            'DateTo'                   => TimeframeService::DOMAIN_NAMESPACE,
        ],
        'Shipping' => [
            'Addresses'                => ShippingService::DOMAIN_NAMESPACE,
            'Amounts'                  => ShippingService::DOMAIN_NAMESPACE,
            'Barcode'                  => ShippingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => ShippingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => ShippingService::DOMAIN_NAMESPACE,
            'Contacts'                 => ShippingService::DOMAIN_NAMESPACE,
            'Content'                  => ShippingService::DOMAIN_NAMESPACE,
            'CostCenter'               => ShippingService::DOMAIN_NAMESPACE,
            'Customer'                 => ShippingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => ShippingService::DOMAIN_NAMESPACE,
            'Customs'                  => ShippingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => ShippingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampStart'   => ShippingService::DOMAIN_NAMESPACE,
            'DeliveryTimestampEnd'     => ShippingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => ShippingService::DOMAIN_NAMESPACE,
            'Dimension'                => ShippingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => ShippingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => ShippingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => ShippingService::DOMAIN_NAMESPACE,
            'Events'                   => ShippingService::DOMAIN_NAMESPACE,
            'Groups'                   => ShippingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => ShippingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => ShippingService::DOMAIN_NAMESPACE,
            'IDType'                   => ShippingService::DOMAIN_NAMESPACE,
            'OldStatuses'              => ShippingService::DOMAIN_NAMESPACE,
            'PhaseCode'                => ShippingService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => ShippingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => ShippingService::DOMAIN_NAMESPACE,
            'ProductOptions'           => ShippingService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => ShippingService::DOMAIN_NAMESPACE,
            'Reference'                => ShippingService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => ShippingService::DOMAIN_NAMESPACE,
            'Remark'                   => ShippingService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => ShippingService::DOMAIN_NAMESPACE,
            'ReturnReference'          => ShippingService::DOMAIN_NAMESPACE,
            'StatusCode'               => ShippingService::DOMAIN_NAMESPACE,
            'DateFrom'                 => ShippingService::DOMAIN_NAMESPACE,
            'DateTo'                   => ShippingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address[]|null */
    protected $Addresses;
    /** @var Amount[]|null */
    protected $Amounts;
    /** @var string|null */
    protected $Barcode;
    /** @var DateTimeInterface|null */
    protected $CollectionTimeStampEnd;
    /** @var DateTimeInterface|null */
    protected $CollectionTimeStampStart;
    /** @var Contact[]|null */
    protected $Contacts;
    /** @var string|null */
    protected $Content;
    /** @var string|null */
    protected $CostCenter;
    /** @var string|null */
    protected $CustomerOrderNumber;
    /** @var Customer|null */
    protected $Customer;
    /** @var Customs|null */
    protected $Customs;
    /** @var string |null$StatusCode */
    protected $StatusCode;
    /** @var int|null */
    protected $PhaseCode;
    /** @var DateTimeInterface|null */
    protected $DateFrom;
    /** @var DateTimeInterface|null */
    protected $DateTo;
    /** @var string|null */
    protected $DeliveryAddress;
    /** @var DateTimeInterface|null */
    protected $DeliveryTimeStampStart;
    /** @var DateTimeInterface|null */
    protected $DeliveryTimeStampEnd;
    /** @var DateTimeInterface|null */
    protected $DeliveryDate;
    /** @var Dimension|null */
    protected $Dimension;
    /** @var string|null */
    protected $DownPartnerBarcode;
    /** @var string|null */
    protected $DownPartnerID;
    /** @var string|null */
    protected $DownPartnerLocation;
    /** @var Event[]|null */
    protected $Events;
    /** @var Group[]|null */
    protected $Groups;
    /** @var string|null */
    protected $IDExpiration;
    /** @var string|null */
    protected $IDNumber;
    /** @var string|null */
    protected $IDType;
    /** @var string|null */
    protected $OldStatuses;
    /** @var string|null */
    protected $ProductCodeCollect;
    /** @var string|null */
    protected $ProductCodeDelivery;
    /** @var ProductOption[]|null */
    protected $ProductOptions;
    /** @var string|null */
    protected $ReceiverDateOfBirth;
    /** @var string|null */
    protected $Reference;
    /** @var string|null */
    protected $ReferenceCollect;
    /** @var string|null */
    protected $Remark;
    /** @var string|null */
    protected $ReturnBarcode;
    /** @var string|null */
    protected $ReturnReference;
    // @codingStandardsIgnoreEnd

    /**
     * Shipment constructor.
     *
     * @param Address[]|null                $Addresses
     * @param array|null                    $Amounts
     * @param string|null                   $Barcode
     * @param Contact[]|null                $Contacts
     * @param string|null                   $Content
     * @param string|DateTimeInterface|null $CollectionTimeStampEnd
     * @param string|DateTimeInterface|null $CollectionTimeStampStart
     * @param string|null                   $CostCenter
     * @param Customer|null                 $Customer
     * @param string|null                   $CustomerOrderNumber
     * @param Customs|null                  $Customs
     * @param string|null                   $DeliveryAddress
     * @param string|DateTimeInterface|null $DeliveryDate
     * @param Dimension|null       $Dimension
     * @param string|null          $DownPartnerBarcode
     * @param string|null          $DownPartnerID
     * @param string|null                   $DownPartnerLocation
     * @param Event[]|null                  $Events
     * @param Group[]|null                  $Groups
     * @param string|null                   $IDExpiration
     * @param string|null                   $IDNumber
     * @param string|null                   $IDType
     * @param array|null                    $OldStatuses
     * @param string|null                   $ProductCodeCollect
     * @param string|null                   $ProductCodeDelivery
     * @param ProductOption[]|null          $ProductOptions
     * @param string|null                   $ReceiverDateOfBirth
     * @param string|null                   $Reference
     * @param string|null                   $ReferenceCollect
     * @param string|null                   $Remark
     * @param string|null                   $ReturnBarcode
     * @param string|null                   $ReturnReference
     * @param string|null                   $StatusCode
     * @param int|null                      $PhaseCode
     * @param string|null                   $DateFrom
     * @param string|null                   $DateTo
     * @param string|DateTimeInterface|null $DeliveryTimeStampStart
     * @param string|DateTimeInterface|null $DeliveryTimeStampEnd
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        array $Addresses = null,
        array $Amounts = null,
        $Barcode = null,
        array $Contacts = null,
        $Content = null,
        $CollectionTimeStampEnd = null,
        $CollectionTimeStampStart = null,
        $CostCenter = null,
        $Customer = null,
        $CustomerOrderNumber = null,
        Customs $Customs = null,
        $DeliveryAddress = null,
        $DeliveryDate = null,
        Dimension $Dimension = null,
        $DownPartnerBarcode = null,
        $DownPartnerID = null,
        $DownPartnerLocation = null,
        array $Events = null,
        array $Groups = null,
        $IDExpiration = null,
        $IDNumber = null,
        $IDType = null,
        array $OldStatuses = null,
        $ProductCodeCollect = null,
        $ProductCodeDelivery = null,
        array $ProductOptions = null,
        $ReceiverDateOfBirth = null,
        $Reference = null,
        $ReferenceCollect = null,
        $Remark = null,
        $ReturnBarcode = null,
        $ReturnReference = null,
        $StatusCode = null,
        $PhaseCode = null,
        $DateFrom = null,
        $DateTo = null,
        $DeliveryTimeStampStart = null,
        $DeliveryTimeStampEnd = null
    ) {
        parent::__construct();

        $this->setAddresses($Addresses);
        $this->setAmounts($Amounts);
        $this->setBarcode($Barcode);
        $this->setCollectionTimeStampEnd($CollectionTimeStampEnd);
        $this->setCollectionTimeStampStart($CollectionTimeStampStart);
        $this->setContacts($Contacts);
        $this->setContent($Content);
        $this->setCostCenter($CostCenter);
        $this->setCustomer($Customer);
        $this->setCustomerOrderNumber($CustomerOrderNumber);
        $this->setCustoms($Customs);
        $this->setDeliveryAddress($DeliveryAddress);
        $this->setDeliveryDate($DeliveryDate);
        $this->setDimension($Dimension);
        $this->setDownPartnerBarcode($DownPartnerBarcode);
        $this->setDownPartnerID($DownPartnerID);
        $this->setDownPartnerLocation($DownPartnerLocation);
        $this->setEvents($Events);
        $this->setGroups($Groups);
        $this->setIDExpiration($IDExpiration);
        $this->setIDNumber($IDNumber);
        $this->setIDType($IDType);
        $this->setOldStatuses($OldStatuses);
        $this->setProductCodeCollect($ProductCodeCollect);
        $this->setProductCodeDelivery($ProductCodeDelivery);
        $this->setProductOptions($ProductOptions);
        $this->setReceiverDateOfBirth($ReceiverDateOfBirth);
        $this->setReference($Reference);
        $this->setReferenceCollect($ReferenceCollect);
        $this->setRemark($Remark);
        $this->setReturnBarcode($ReturnBarcode);
        $this->setReturnReference($ReturnReference);
        $this->setStatusCode($StatusCode);
        $this->setPhaseCode($PhaseCode);
        $this->setDateFrom($DateFrom);
        $this->setDateTo($DateTo);
        $this->setDeliveryTimeStampStart($DeliveryTimeStampStart);
        $this->setDeliveryTimeStampEnd($DeliveryTimeStampEnd);
    }

    /**
     * @param string|DateTimeInterface|null $CollectionTimeStampStart
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setCollectionTimeStampStart($CollectionTimeStampStart = null)
    {
        if (is_string($CollectionTimeStampStart)) {
            try {
                $CollectionTimeStampStart = new DateTimeImmutable($CollectionTimeStampStart);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->CollectionTimeStampStart = $CollectionTimeStampStart;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $CollectionTimeStampEnd
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setCollectionTimeStampEnd($CollectionTimeStampEnd = null)
    {
        if (is_string($CollectionTimeStampEnd)) {
            try {
                $CollectionTimeStampEnd = new DateTimeImmutable($CollectionTimeStampEnd);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(),0, $e);
            }
        }

        $this->CollectionTimeStampEnd = $CollectionTimeStampEnd;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $DeliveryTimeStampStart
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryTimeStampStart($DeliveryTimeStampStart = null)
    {
        if (is_string($DeliveryTimeStampStart)) {
            try {
                $DeliveryTimeStampStart = new DateTimeImmutable($DeliveryTimeStampStart);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryTimeStampStart = $DeliveryTimeStampStart;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $DeliveryTimeStampEnd
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryTimeStampEnd($DeliveryTimeStampEnd = null)
    {
        if (is_string($DeliveryTimeStampEnd)) {
            try {
                $DeliveryTimeStampEnd = new DateTimeImmutable($DeliveryTimeStampEnd);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryTimeStampEnd = $DeliveryTimeStampEnd;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $DeliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate($DeliveryDate = null)
    {
        if (is_string($DeliveryDate)) {
            try {
                $DeliveryDate = new DateTimeImmutable($DeliveryDate);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @param Writer $writer
     *
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('Addresses' === $propertyName) {
                if (is_array($this->Addresses)) {
                    $items = [];
                    foreach ($this->Addresses as $address) {
                        $items[] = ["{{$namespace}}Address" => $address];
                    }
                    $xml["{{$namespace}}Addresses"] = $items;
                }
            } elseif ('Amounts' === $propertyName) {
                if (is_array($this->Amounts)) {
                    $items = [];
                    foreach ($this->Amounts as $amount) {
                        $items[] = ["{{$namespace}}Amount" => $amount];
                    }
                    $xml["{{$namespace}}Amounts"] = $items;
                }
            } elseif ('Contacts' === $propertyName) {
                if (is_array($this->Contacts)) {
                    $items = [];
                    foreach ($this->Contacts as $contact) {
                        $items[] = ["{{$namespace}}Contact" => $contact];
                    }
                    $xml["{{$namespace}}Contacts"] = $items;
                }
            } elseif ('Events' === $propertyName) {
                if (is_array($this->Events)) {
                    $items = [];
                    foreach ($this->Events as $event) {
                        $items[] = ["{{$namespace}}Event" => $event];
                    }
                    $xml["{{$namespace}}Events"] = $items;
                }
            } elseif ('Groups' === $propertyName) {
                if (is_array($this->Groups)) {
                    $items = [];
                    foreach ($this->Groups as $group) {
                        $items[] = ["{{$namespace}}Group" => $group];
                    }
                    $xml["{{$namespace}}Groups"] = $items;
                }
            } elseif ('ProductOptions' === $propertyName) {
                if (is_array($this->ProductOptions)) {
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
        $writer->write($xml);
    }
}
