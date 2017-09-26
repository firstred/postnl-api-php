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
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity;

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\LabellingService;

/**
 * Class Shipment
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method Address[]       getAddresses()
 * @method string          getBarcode()
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
 */
class Shipment extends AbstractEntity
{
    /** @var string[] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'    => [
            'Addresses'                => BarcodeService::DOMAIN_NAMESPACE,
            'Barcode'                  => BarcodeService::DOMAIN_NAMESPACE,
            'Dimension'                => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => BarcodeService::DOMAIN_NAMESPACE,
            'Amounts'                  => BarcodeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => BarcodeService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => BarcodeService::DOMAIN_NAMESPACE,
            'Contacts'                 => BarcodeService::DOMAIN_NAMESPACE,
            'Content'                  => BarcodeService::DOMAIN_NAMESPACE,
            'CostCenter'               => BarcodeService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => BarcodeService::DOMAIN_NAMESPACE,
            'Customs'                  => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => BarcodeService::DOMAIN_NAMESPACE,
            'Groups'                   => BarcodeService::DOMAIN_NAMESPACE,
            'IDExpiration'             => BarcodeService::DOMAIN_NAMESPACE,
            'IDNumber'                 => BarcodeService::DOMAIN_NAMESPACE,
            'IDType'                   => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => BarcodeService::DOMAIN_NAMESPACE,
            'ProductOptions'           => BarcodeService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => BarcodeService::DOMAIN_NAMESPACE,
            'Reference'                => BarcodeService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => BarcodeService::DOMAIN_NAMESPACE,
            'Remark'                   => BarcodeService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => BarcodeService::DOMAIN_NAMESPACE,
            'ReturnReference'          => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Addresses'                => ConfirmingService::DOMAIN_NAMESPACE,
            'Barcode'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'Dimension'                => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Amounts'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => ConfirmingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => ConfirmingService::DOMAIN_NAMESPACE,
            'Contacts'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'Content'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'CostCenter'               => ConfirmingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Customs'                  => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Groups'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => ConfirmingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'IDType'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductOptions'           => ConfirmingService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Reference'                => ConfirmingService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Remark'                   => ConfirmingService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => ConfirmingService::DOMAIN_NAMESPACE,
            'ReturnReference'          => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'  => [
            'Addresses'                => LabellingService::DOMAIN_NAMESPACE,
            'Barcode'                  => LabellingService::DOMAIN_NAMESPACE,
            'Dimension'                => LabellingService::DOMAIN_NAMESPACE,
            'ProductCodeDelivery'      => LabellingService::DOMAIN_NAMESPACE,
            'Amounts'                  => LabellingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampEnd'   => LabellingService::DOMAIN_NAMESPACE,
            'CollectionTimeStampStart' => LabellingService::DOMAIN_NAMESPACE,
            'Contacts'                 => LabellingService::DOMAIN_NAMESPACE,
            'Content'                  => LabellingService::DOMAIN_NAMESPACE,
            'CostCenter'               => LabellingService::DOMAIN_NAMESPACE,
            'CustomerOrderNumber'      => LabellingService::DOMAIN_NAMESPACE,
            'Customs'                  => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryAddress'          => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'             => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerBarcode'       => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerID'            => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'      => LabellingService::DOMAIN_NAMESPACE,
            'Groups'                   => LabellingService::DOMAIN_NAMESPACE,
            'IDExpiration'             => LabellingService::DOMAIN_NAMESPACE,
            'IDNumber'                 => LabellingService::DOMAIN_NAMESPACE,
            'IDType'                   => LabellingService::DOMAIN_NAMESPACE,
            'ProductCodeCollect'       => LabellingService::DOMAIN_NAMESPACE,
            'ProductOptions'           => LabellingService::DOMAIN_NAMESPACE,
            'ReceiverDateOfBirth'      => LabellingService::DOMAIN_NAMESPACE,
            'Reference'                => LabellingService::DOMAIN_NAMESPACE,
            'ReferenceCollect'         => LabellingService::DOMAIN_NAMESPACE,
            'Remark'                   => LabellingService::DOMAIN_NAMESPACE,
            'ReturnBarcode'            => LabellingService::DOMAIN_NAMESPACE,
            'ReturnReference'          => LabellingService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address[] $Addresses */
    protected $Addresses = null;
    /** @var string $Barcode */
    protected $Barcode = null;
    /** @var Dimension $Dimension */
    protected $Dimension = null;
    /** @var string $ProductCodeDelivery */
    protected $ProductCodeDelivery = null;
    /** @var Amount[] $Amounts */
    protected $Amounts = null;
    /** @var string $CollectionTimeStampEnd */
    protected $CollectionTimeStampEnd = null;
    /** @var string $CollectionTimeStampStart */
    protected $CollectionTimeStampStart = null;
    /** @var Contact[] $Contacts */
    protected $Contacts = null;
    /** @var string $Content */
    protected $Content = null;
    /** @var string $CostCenter */
    protected $CostCenter = null;
    /** @var string $CustomerOrderNumber */
    protected $CustomerOrderNumber = null;
    /** @var Customs $Customs */
    protected $Customs = null;
    /** @var string $DeliveryAddress */
    protected $DeliveryAddress = null;
    /** @var string $DeliveryDate */
    protected $DeliveryDate = null;
    /** @var string $DownPartnerBarcode */
    protected $DownPartnerBarcode = null;
    /** @var string $DownPartnerID */
    protected $DownPartnerID = null;
    /** @var string $DownPartnerLocation */
    protected $DownPartnerLocation = null;
    /** @var Group[] $Groups */
    protected $Groups = null;
    /** @var string $IDExpiration */
    protected $IDExpiration = null;
    /** @var string $IDNumber */
    protected $IDNumber = null;
    /** @var string $IDType */
    protected $IDType = null;
    /** @var string $ProductCodeCollect */
    protected $ProductCodeCollect = null;
    /** @var ProductOption[] $ProductOptions */
    protected $ProductOptions = null;
    /** @var string $ReceiverDateOfBirth */
    protected $ReceiverDateOfBirth = null;
    /** @var string $Reference */
    protected $Reference = null;
    /** @var string $ReferenceCollect */
    protected $ReferenceCollect = null;
    /** @var string $Remark */
    protected $Remark = null;
    /** @var string $ReturnBarcode */
    protected $ReturnBarcode = null;
    /** @var string $ReturnReference */
    protected $ReturnReference = null;
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
     */
    public function __construct(
        array $addresses,
        $barcode,
        Dimension $dimension,
        $productCodeDelivery,
        array $amounts = null,
        $collectionTimeStampEnd = null,
        $collectionTimeStampStart = null,
        array $contacts = null,
        $content = null,
        $costCenter = null,
        $customerOrderNumber = null,
        Customs $customs = null,
        $deliveryAddress = null,
        $deliveryDate = null,
        $downPartnerBarcode = null,
        $downPartnerId = null,
        $downPartnerLocation = null,
        array $groups = null,
        $idExpiration = null,
        $idNumber = null,
        $idType = null,
        $productCodeCollect = null,
        array $productOptions = null,
        $receiverDateOfBirth = null,
        $reference = null,
        $referenceCollect = null,
        $remark = null,
        $returnBarcode = null,
        $returnReference = null
    ) {
        parent::__construct();

        $this->setAddresses($addresses);
        $this->setBarcode($barcode);
        $this->setDimension($dimension);
        $this->setProductCodeDelivery($productCodeDelivery);
        $this->setAmounts($amounts);
        $this->setCollectionTimeStampEnd($collectionTimeStampEnd);
        $this->setCollectionTimeStampStart($collectionTimeStampStart);
        $this->setContacts($contacts);
        $this->setContent($content);
        $this->setCostCenter($costCenter);
        $this->setCustomerOrderNumber($customerOrderNumber);
        $this->setCustoms($customs);
        $this->setDeliveryAddress($deliveryAddress);
        $this->setDeliveryDate($deliveryDate);
        $this->setDownPartnerBarcode($downPartnerBarcode);
        $this->setDownPartnerID($downPartnerId);
        $this->setDownPartnerLocation($downPartnerLocation);
        $this->setGroups($groups);
        $this->setIDExpiration($idExpiration);
        $this->setIDNumber($idNumber);
        $this->setIDType($idType);
        $this->setProductCodeCollect($productCodeCollect);
        $this->setProductOptions($productOptions);
        $this->setReceiverDateOfBirth($receiverDateOfBirth);
        $this->setReference($reference);
        $this->setReferenceCollect($referenceCollect);
        $this->setRemark($remark);
        $this->setReturnBarcode($returnBarcode);
        $this->setReturnReference($returnReference);
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
                $shipments = [];
                foreach ($this->Addresses as $address) {
                    $shipments[] = ["{{$namespace}}Address" => $address];
                }
                $xml["{{$namespace}}Addresses"] = $shipments;
            } elseif (!is_null($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
