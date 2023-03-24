<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class GenerateLabel.
 *
 * @method Customer|null         getCustomer()
 * @method LabellingMessage|null getMessage()
 * @method Shipment[]|null       getShipments()
 * @method string|null           getLabelSignature()
 * @method GenerateLabel         setCustomer(Customer|null $Customer = null)
 * @method GenerateLabel         setMessage(LabellingMessage|null $Message = null)
 * @method GenerateLabel         setShipments(Shipment[]|null $Shipments = null)
 * @method GenerateLabel         setLabelSignature(string|null $signature = null)
 *
 * @since 1.0.0
 */
class GenerateLabel extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'Customer'  => BarcodeService::DOMAIN_NAMESPACE,
            'Message'   => BarcodeService::DOMAIN_NAMESPACE,
            'Shipments' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Customer'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Shipments' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Customer'  => LabellingService::DOMAIN_NAMESPACE,
            'Message'   => LabellingService::DOMAIN_NAMESPACE,
            'Shipments' => LabellingService::DOMAIN_NAMESPACE,
            'LabelSignature' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Message'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Customer'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Shipments' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Message'   => LocationService::DOMAIN_NAMESPACE,
            'Customer'  => LocationService::DOMAIN_NAMESPACE,
            'Shipments' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Message'   => TimeframeService::DOMAIN_NAMESPACE,
            'Customer'  => TimeframeService::DOMAIN_NAMESPACE,
            'Shipments' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Customer|null */
    protected $Customer;
    /** @var LabellingMessage|null */
    protected $Message;
    /** @var Shipment[]|null */
    protected $Shipments;
    /** @var string|null */
    protected $LabelSignature;
    // @codingStandardsIgnoreEnd

    /**
     * GenerateLabel constructor.
     *
     * @param Shipment[]|null       $Shipments
     * @param LabellingMessage|null $Message
     * @param Customer|null         $Customer
     * @param string|null           $LabelSignature
     */
    public function __construct(
        array $Shipments = null,
        LabellingMessage $Message = null,
        Customer $Customer = null,
        $LabelSignature = null
    ) {
        parent::__construct();

        $this->setShipments($Shipments);
        $this->setMessage($Message ?: new LabellingMessage());
        $this->setCustomer($Customer);
        if ($LabelSignature) {
            $this->setLabelSignature($LabelSignature);
        }
    }

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            return $json;
        }

        foreach (array_keys(static::$defaultProperties[$this->currentService]) as $propertyName) {
            if (isset($this->$propertyName)) {
                // The REST API only seems to accept one shipment per request at the moment of writing (Sep. 24th, 2017)
                if ('Shipments' === $propertyName && count($this->$propertyName) >= 1) {
                    $json[$propertyName] = $this->{$propertyName}[0];
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
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
            if ('Shipments' === $propertyName) {
                $shipments = [];
                foreach ($this->Shipments as $shipment) {
                    $shipments[] = ["{{$namespace}}Shipment" => $shipment];
                }
                $xml["{{$namespace}}Shipments"] = $shipments;
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
