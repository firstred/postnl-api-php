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

namespace ThirtyBees\PostNL\Entity\Response;

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Amount;
use ThirtyBees\PostNL\Entity\Barcode;
use ThirtyBees\PostNL\Entity\Dimension;
use ThirtyBees\PostNL\Entity\Expectation;
use ThirtyBees\PostNL\Entity\Group;
use ThirtyBees\PostNL\Entity\ProductOption;
use ThirtyBees\PostNL\Entity\Status;
use ThirtyBees\PostNL\Entity\Warning;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class CurrentStatusResponseShipment
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method Address[]       getAddresses()
 * @method Amount[]        getAmounts()
 * @method Barcode         getBarcode()
 * @method string          getDeliveryDate()
 * @method Dimension       getDimension()
 * @method Expectation     getExpectation()
 * @method Group[]         getGroups()
 * @method string          getProductCode()
 * @method ProductOption[] getProductOptions()
 * @method string          getReference()
 * @method Status          getStatus()
 * @method Warning[]       getWarnings()
 *
 * @method CurrentStatusResponseShipment setAddresses(Address[] $addresses = null)
 * @method CurrentStatusResponseShipment setAmounts(Amount[] $amounts = null)
 * @method CurrentStatusResponseShipment setBarcode(string $barcode)
 * @method CurrentStatusResponseShipment setDeliveryDate(string $date)
 * @method CurrentStatusResponseShipment setDimension(Dimension $dimension)
 * @method CurrentStatusResponseShipment setExpectation(Expectation $expectation)
 * @method CurrentStatusResponseShipment setGroups(Group[] $groups = null)
 * @method CurrentStatusResponseShipment setProductCode(string $productCode)
 * @method CurrentStatusResponseShipment setProductOptions(ProductOption[] $options = null)
 * @method CurrentStatusResponseShipment setReference(string $reference)
 * @method CurrentStatusResponseShipment setStatus(Status $status)
 * @method CurrentStatusResponseShipment setWarnings(Warning[] $warnings = null)
 */
class CurrentStatusResponseShipment extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'Addresses'      => BarcodeService::DOMAIN_NAMESPACE,
            'Amounts'        => BarcodeService::DOMAIN_NAMESPACE,
            'Barcode'        => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => BarcodeService::DOMAIN_NAMESPACE,
            'Dimension'      => BarcodeService::DOMAIN_NAMESPACE,
            'Expectation'    => BarcodeService::DOMAIN_NAMESPACE,
            'Groups'         => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCode'    => BarcodeService::DOMAIN_NAMESPACE,
            'ProductOptions' => BarcodeService::DOMAIN_NAMESPACE,
            'Reference'      => BarcodeService::DOMAIN_NAMESPACE,
            'Status'         => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'       => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Addresses'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Amounts'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Barcode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Dimension'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Expectation'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Groups'         => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCode'    => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductOptions' => ConfirmingService::DOMAIN_NAMESPACE,
            'Reference'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Status'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'       => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Addresses'      => LabellingService::DOMAIN_NAMESPACE,
            'Amounts'        => LabellingService::DOMAIN_NAMESPACE,
            'Barcode'        => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => LabellingService::DOMAIN_NAMESPACE,
            'Dimension'      => LabellingService::DOMAIN_NAMESPACE,
            'Expectation'    => LabellingService::DOMAIN_NAMESPACE,
            'Groups'         => LabellingService::DOMAIN_NAMESPACE,
            'ProductCode'    => LabellingService::DOMAIN_NAMESPACE,
            'ProductOptions' => LabellingService::DOMAIN_NAMESPACE,
            'Reference'      => LabellingService::DOMAIN_NAMESPACE,
            'Status'         => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'       => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Addresses'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Amounts'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Barcode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Dimension'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Expectation'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Groups'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductCode'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductOptions' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Reference'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Status'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings'       => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Addresses'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Amounts'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Barcode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Dimension'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Expectation'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Groups'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductCode'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductOptions' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Reference'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Status'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'       => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Addresses'      => LocationService::DOMAIN_NAMESPACE,
            'Amounts'        => LocationService::DOMAIN_NAMESPACE,
            'Barcode'        => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => LocationService::DOMAIN_NAMESPACE,
            'Dimension'      => LocationService::DOMAIN_NAMESPACE,
            'Expectation'    => LocationService::DOMAIN_NAMESPACE,
            'Groups'         => LocationService::DOMAIN_NAMESPACE,
            'ProductCode'    => LocationService::DOMAIN_NAMESPACE,
            'ProductOptions' => LocationService::DOMAIN_NAMESPACE,
            'Reference'      => LocationService::DOMAIN_NAMESPACE,
            'Status'         => LocationService::DOMAIN_NAMESPACE,
            'Warnings'       => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Addresses'      => TimeframeService::DOMAIN_NAMESPACE,
            'Amounts'        => TimeframeService::DOMAIN_NAMESPACE,
            'Barcode'        => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => TimeframeService::DOMAIN_NAMESPACE,
            'Dimension'      => TimeframeService::DOMAIN_NAMESPACE,
            'Expectation'    => TimeframeService::DOMAIN_NAMESPACE,
            'Groups'         => TimeframeService::DOMAIN_NAMESPACE,
            'ProductCode'    => TimeframeService::DOMAIN_NAMESPACE,
            'ProductOptions' => TimeframeService::DOMAIN_NAMESPACE,
            'Reference'      => TimeframeService::DOMAIN_NAMESPACE,
            'Status'         => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'       => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address[] $Addresses */
    protected $Addresses;
    /** @var Amount[] $Amounts */
    protected $Amounts;
    /** @var Barcode $Barcode */
    protected $Barcode;
    /** @var string $DeliveryDate */
    protected $DeliveryDate;
    /** @var Dimension Dimension */
    protected $Dimension;
    /** @var Expectation $Expectation */
    protected $Expectation;
    /** @var Group[] $Groups */
    protected $Groups;
    /** @var string $ProductCode */
    protected $ProductCode;
    /** @var ProductOption[] $ProuctOptions */
    protected $ProductOptions;
    /** @var string $Reference */
    protected $Reference;
    /** @var Status $Status */
    protected $Status;
    /** @var Warning[] $Warnings */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    /**
     * CurrentStatusResponseShipment constructor.
     *
     * @param Address[]|null $addresses
     * @param Amount[]|null $amounts
     * @param null       $barcode
     * @param null       $deliveryDate
     * @param null       $dimension
     * @param null       $expectation
     * @param Group[]|null $groups
     * @param null       $productCode
     * @param ProductOption[]|null $productOptions
     * @param null       $reference
     * @param null       $status
     * @param Warning[]|null $warnings
     */
    public function __construct(
        array $addresses = null,
        array $amounts = null,
        $barcode = null,
        $deliveryDate = null,
        $dimension = null,
        $expectation = null,
        array $groups = null,
        $productCode = null,
        array $productOptions = null,
        $reference = null,
        $status = null,
        array $warnings = null
    ) {
        parent::__construct();

        $this->setAddresses($addresses);
        $this->setAmounts($amounts);
        $this->setBarcode($barcode);
        $this->setDeliveryDate($deliveryDate);
        $this->setDimension($dimension);
        $this->setExpectation($expectation);
        $this->setGroups($groups);
        $this->setProductCode($productCode);
        $this->setProductOptions($productOptions);
        $this->setReference($reference);
        $this->setStatus($status);
        $this->setWarnings($warnings);
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
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            $writer->write($xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ($propertyName === 'Addresses') {
                $addresses = [];
                foreach ($this->Addresses as $address) {
                    $addresses[] = ["{{$namespace}}Address" => $address];
                }
                $xml["{{$namespace}}Addresses"] = $addresses;
            } elseif ($propertyName === 'Amounts') {
                $amounts = [];
                foreach ($this->Amounts as $amount) {
                    $amounts[] = ["{{$namespace}}Amount" => $amount];
                }
                $xml["{{$namespace}}Amounts"] = $amounts;
            } elseif ($propertyName === 'Groups') {
                $groups = [];
                foreach ($this->Groups as $group) {
                    $groups[] = ["{{$namespace}}Group" => $group];
                }
                $xml["{{$namespace}}Groups"] = $groups;
            } elseif ($propertyName === 'ProductOption') {
                $productOptions = [];
                foreach ($this->ProductOptions as $productOption) {
                    $productOptions[] = ["{{$namespace}}ProductOptions" => $productOption];
                }
                $xml["{{$namespace}}ProductOptions"] = $productOptions;
            } elseif ($propertyName === 'Warnings') {
                $warnings = [];
                foreach ($this->Warnings as $warning) {
                    $warnings[] = ["{{$namespace}}Warning" => $warning];
                }
                $xml["{{$namespace}}Warnings"] = $warnings;
            } elseif (!is_null($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
