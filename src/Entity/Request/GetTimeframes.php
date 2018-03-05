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

namespace ThirtyBees\PostNL\Entity\Request;

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\Timeframe;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GetTimeframes
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method Message     getMessage()
 * @method Timeframe[] getTimeframe()
 *
 * @method GetTimeframes setMessage(Message $message)
 * @method GetTimeframes setTimeframe(Timeframe[] $timeframes)
 */
class GetTimeframes extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Message'   => BarcodeService::DOMAIN_NAMESPACE,
            'Timeframe' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Message'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Timeframe' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Message'   => LabellingService::DOMAIN_NAMESPACE,
            'Timeframe' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Message'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Timeframe' => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Message'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Timeframe' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Message'   => LocationService::DOMAIN_NAMESPACE,
            'Timeframe' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Message'   => TimeframeService::DOMAIN_NAMESPACE,
            'Timeframe' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var Message $Message */
    protected $Message;
    /** @var Timeframe[] $Timeframe */
    protected $Timeframe;
    // @codingStandardsIgnoreEnd

    /**
     * GetTimeframes constructor.
     *
     * @param Message     $message
     * @param Timeframe[] $timeframes
     */
    public function __construct(Message $message = null, array $timeframes = [])
    {
        parent::__construct();

        $this->setMessage($message ?: new Message());
        $this->setTimeframe($timeframes);
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
            // TODO: figure something out for the Timeframes
//            if ($propertyName === 'Timeframes') {
//                $shipments = [];
//                foreach ($this->Shipments as $shipment) {
//                    $shipments[] = ["{{$namespace}}Shipment" => $shipment];
//                }
//                $xml["{{$namespace}}Shipments"] = $shipments;
//            } else
                if (!is_null($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
