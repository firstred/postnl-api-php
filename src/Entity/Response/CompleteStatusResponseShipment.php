<?php
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Amount;
use ThirtyBees\PostNL\Entity\Barcode;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Dimension;
use ThirtyBees\PostNL\Entity\Expectation;
use ThirtyBees\PostNL\Entity\Group;
use ThirtyBees\PostNL\Entity\ProductOption;
use ThirtyBees\PostNL\Entity\Status;
use ThirtyBees\PostNL\Entity\Warning;
use ThirtyBees\PostNL\Exception\InvalidArgumentException;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class CompleteStatusResponseShipment.
 *
 * @method Address[]|null                       getAddresses()
 * @method Amount[]|null                        getAmounts()
 * @method Barcode|null                         getBarcode()
 * @method Customer|null                        getCustomer()
 * @method DateTimeInterface|null               getDeliveryDate()
 * @method Dimension|null                       getDimension()
 * @method CompleteStatusResponseEvent[]|null   getEvents()
 * @method Expectation|null                     getExpectation()
 * @method Group[]|null                         getGroups()
 * @method CompleteStatusResponseOldStatus|null getOldStatuses()
 * @method string|null                          getProductCode()
 * @method ProductOption[]|null                 getProductOptions()
 * @method string|null                          getReference()
 * @method Status|null                          getStatus()
 * @method Warning[]|null                       getWarnings()
 * @method CompleteStatusResponseShipment       setAddresses(Address[]|null $addresses = null)
 * @method CompleteStatusResponseShipment       setAmounts(Amount[]|null $amounts = null)
 * @method CompleteStatusResponseShipment       setBarcode(string|null $barcode = null)
 * @method CompleteStatusResponseShipment       setCustomer(Customer|null $customer = null)
 * @method CompleteStatusResponseShipment       setDimension(Dimension|null $dimension = null)
 * @method CompleteStatusResponseShipment       setEvents(CompleteStatusResponseEvent[]|null $events = null)
 * @method CompleteStatusResponseShipment       setExpectation(Expectation|null $expectation = null)
 * @method CompleteStatusResponseShipment       setGroups(Group[]|null $groups = null)
 * @method CompleteStatusResponseShipment       setOldStatuses(CompleteStatusResponseOldStatus|null $oldStatuses = null)
 * @method CompleteStatusResponseShipment       setProductCode(string|null $productCode = null)
 * @method CompleteStatusResponseShipment       setProductOptions(ProductOption[]|null $options = null)
 * @method CompleteStatusResponseShipment       setReference(string|null $reference = null)
 * @method CompleteStatusResponseShipment       setStatus(Status|null $status = null)
 * @method CompleteStatusResponseShipment       setWarnings(Warning[]|null $warnings = null)
 *
 * @since 1.0.0
 */
class CompleteStatusResponseShipment extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Addresses'      => BarcodeService::DOMAIN_NAMESPACE,
            'Amounts'        => BarcodeService::DOMAIN_NAMESPACE,
            'Barcode'        => BarcodeService::DOMAIN_NAMESPACE,
            'Customer'       => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => BarcodeService::DOMAIN_NAMESPACE,
            'Dimension'      => BarcodeService::DOMAIN_NAMESPACE,
            'Events'         => BarcodeService::DOMAIN_NAMESPACE,
            'Expectation'    => BarcodeService::DOMAIN_NAMESPACE,
            'Groups'         => BarcodeService::DOMAIN_NAMESPACE,
            'OldStatuses'    => BarcodeService::DOMAIN_NAMESPACE,
            'ProductCode'    => BarcodeService::DOMAIN_NAMESPACE,
            'ProductOptions' => BarcodeService::DOMAIN_NAMESPACE,
            'Reference'      => BarcodeService::DOMAIN_NAMESPACE,
            'Status'         => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'       => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Addresses'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Amounts'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Barcode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Customer'       => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Dimension'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Events'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Expectation'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Groups'         => ConfirmingService::DOMAIN_NAMESPACE,
            'OldStatuses'    => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductCode'    => ConfirmingService::DOMAIN_NAMESPACE,
            'ProductOptions' => ConfirmingService::DOMAIN_NAMESPACE,
            'Reference'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Status'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'       => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Addresses'      => LabellingService::DOMAIN_NAMESPACE,
            'Amounts'        => LabellingService::DOMAIN_NAMESPACE,
            'Barcode'        => LabellingService::DOMAIN_NAMESPACE,
            'Customer'       => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => LabellingService::DOMAIN_NAMESPACE,
            'Dimension'      => LabellingService::DOMAIN_NAMESPACE,
            'Events'         => LabellingService::DOMAIN_NAMESPACE,
            'Expectation'    => LabellingService::DOMAIN_NAMESPACE,
            'Groups'         => LabellingService::DOMAIN_NAMESPACE,
            'OldStatuses'    => LabellingService::DOMAIN_NAMESPACE,
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
            'Customer'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Dimension'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Events'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Expectation'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Groups'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'OldStatuses'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductCode'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'ProductOptions' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Reference'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Status'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Warnings'       => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Addresses'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Amounts'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Barcode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Customer'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Dimension'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Events'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Expectation'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Groups'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'OldStatuses'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductCode'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'ProductOptions' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Reference'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Status'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'       => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Addresses'      => LocationService::DOMAIN_NAMESPACE,
            'Amounts'        => LocationService::DOMAIN_NAMESPACE,
            'Barcode'        => LocationService::DOMAIN_NAMESPACE,
            'Customer'       => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => LocationService::DOMAIN_NAMESPACE,
            'Dimension'      => LocationService::DOMAIN_NAMESPACE,
            'Events'         => LocationService::DOMAIN_NAMESPACE,
            'Expectation'    => LocationService::DOMAIN_NAMESPACE,
            'Groups'         => LocationService::DOMAIN_NAMESPACE,
            'OldStatuses'    => LocationService::DOMAIN_NAMESPACE,
            'ProductCode'    => LocationService::DOMAIN_NAMESPACE,
            'ProductOptions' => LocationService::DOMAIN_NAMESPACE,
            'Reference'      => LocationService::DOMAIN_NAMESPACE,
            'Status'         => LocationService::DOMAIN_NAMESPACE,
            'Warnings'       => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Addresses'      => TimeframeService::DOMAIN_NAMESPACE,
            'Amounts'        => TimeframeService::DOMAIN_NAMESPACE,
            'Barcode'        => TimeframeService::DOMAIN_NAMESPACE,
            'Customer'       => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'   => TimeframeService::DOMAIN_NAMESPACE,
            'Dimension'      => TimeframeService::DOMAIN_NAMESPACE,
            'Events'         => TimeframeService::DOMAIN_NAMESPACE,
            'Expectation'    => TimeframeService::DOMAIN_NAMESPACE,
            'Groups'         => TimeframeService::DOMAIN_NAMESPACE,
            'OldStatuses'    => TimeframeService::DOMAIN_NAMESPACE,
            'ProductCode'    => TimeframeService::DOMAIN_NAMESPACE,
            'ProductOptions' => TimeframeService::DOMAIN_NAMESPACE,
            'Reference'      => TimeframeService::DOMAIN_NAMESPACE,
            'Status'         => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'       => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Address[]|null */
    protected $Addresses;
    /** @var Amount[]|null */
    protected $Amounts;
    /** @var Barcode|null */
    protected $Barcode;
    /** @var Customer|null */
    protected $Customer;
    /** @var DateTimeInterface|null */
    protected $DeliveryDate;
    /** @var Dimension|null Dimension */
    protected $Dimension;
    /** @var CompleteStatusResponseEvent[]|null */
    protected $Events;
    /** @var Expectation|null */
    protected $Expectation;
    /** @var Group[]|null */
    protected $Groups;
    /** @var CompleteStatusResponseOldStatus[]|null */
    protected $OldStatuses;
    /** @var string|null */
    protected $ProductCode;
    /** @var ProductOption[]|null */
    protected $ProductOptions;
    /** @var string|null */
    protected $Reference;
    /** @var Status|null */
    protected $Status;
    /** @var Warning[]|null */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    /**
     * CompleteStatusResponseShipment constructor.
     *
     * @param Address[]|null                         $addresses
     * @param Amount[]|null                          $amounts
     * @param string|null                            $barcode
     * @param Customer|null                          $customer
     * @param DateTimeInterface|string|null          $deliveryDate
     * @param Dimension|null                         $dimension
     * @param CompleteStatusResponseEvent[]|null     $events
     * @param Expectation|null                       $expectation
     * @param Group[]|null                           $groups
     * @param CompleteStatusResponseOldStatus[]|null $oldStatuses
     * @param string|null                            $productCode
     * @param ProductOption[]|null                   $productOptions
     * @param string|null                            $reference
     * @param Status|null                            $status
     * @param Warning[]|null                         $warnings
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        array $addresses = null,
        array $amounts = null,
        $barcode = null,
        $customer = null,
        $deliveryDate = null,
        $dimension = null,
        array $events = null,
        $expectation = null,
        array $groups = null,
        array $oldStatuses = null,
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
        $this->setCustomer($customer);
        $this->setDeliveryDate($deliveryDate);
        $this->setDimension($dimension);
        $this->setEvents($events);
        $this->setExpectation($expectation);
        $this->setGroups($groups);
        $this->setOldStatuses($oldStatuses);
        $this->setProductCode($productCode);
        $this->setProductOptions($productOptions);
        $this->setReference($reference);
        $this->setStatus($status);
        $this->setWarnings($warnings);
    }

    /**
     * @param string|DateTimeInterface|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate($deliveryDate = null)
    {
        if (is_string($deliveryDate)) {
            try {
                $deliveryDate = new DateTimeImmutable($deliveryDate);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryDate = $deliveryDate;

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
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            $writer->write($xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('Addresses' === $propertyName) {
                $addresses = [];
                foreach ($this->Addresses as $address) {
                    $addresses[] = ["{{$namespace}}Address" => $address];
                }
                $xml["{{$namespace}}Addresses"] = $addresses;
            } elseif ('Amounts' === $propertyName) {
                $amounts = [];
                foreach ($this->Amounts as $amount) {
                    $amounts[] = ["{{$namespace}}Amount" => $amount];
                }
                $xml["{{$namespace}}Amounts"] = $amounts;
            } elseif ('Groups' === $propertyName) {
                $groups = [];
                foreach ($this->Groups as $group) {
                    $groups[] = ["{{$namespace}}Group" => $group];
                }
                $xml["{{$namespace}}Groups"] = $groups;
            } elseif ('Events' === $propertyName) {
                $events = [];
                foreach ($this->Events as $event) {
                    $events[] = ["{{$namespace}}CompleteStatusResponseEvent" => $event];
                }
                $xml["{{$namespace}}Events"] = $events;
            } elseif ('OldStatuses' === $propertyName) {
                $oldStatuses = [];
                foreach ($this->OldStatuses as $oldStatus) {
                    $oldStatuses[] = ["{{$namespace}}CompleteStatusResponseOldStatus" => $oldStatus];
                }
                $xml["{{$namespace}}OldStatuses"] = $oldStatuses;
            } elseif ('ProductOption' === $propertyName) {
                $productOptions = [];
                foreach ($this->ProductOptions as $productOption) {
                    $productOptions[] = ["{{$namespace}}ProductOptions" => $productOption];
                }
                $xml["{{$namespace}}ProductOptions"] = $productOptions;
            } elseif ('Warnings' === $propertyName) {
                $warnings = [];
                foreach ($this->Warnings as $warning) {
                    $warnings[] = ["{{$namespace}}Warning" => $warning];
                }
                $xml["{{$namespace}}Warnings"] = $warnings;
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
