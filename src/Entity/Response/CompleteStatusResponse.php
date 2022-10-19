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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use ReflectionObject;
use ReflectionProperty;
use Sabre\Xml\Writer;
use stdClass;
use function count;

/**
 * Class CompleteStatusResponse.
 *
 * @method CompleteStatusResponseShipment[]|null getShipments()
 * @method Warning[]|null                        getWarnings()
 * @method CompleteStatusResponse                setShipments(CompleteStatusResponseShipment[] $Shipments = null)
 * @method CompleteStatusResponse                setWarnings(Warning[] $Warnings = null)
 *
 * @since 1.0.0
 */
class CompleteStatusResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'Shipments' => BarcodeService::DOMAIN_NAMESPACE,
            'Warnings'  => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'Shipments' => ConfirmingService::DOMAIN_NAMESPACE,
            'Warnings'  => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'Shipments' => LabellingService::DOMAIN_NAMESPACE,
            'Warnings'  => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'Shipments' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Warnings'  => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'Shipments' => LocationService::DOMAIN_NAMESPACE,
            'Warnings'  => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'Shipments' => TimeframeService::DOMAIN_NAMESPACE,
            'Warnings'  => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var CompleteStatusResponseShipment[]|null */
    protected $Shipments;
    /** @var Warning[]|null */
    protected $Warnings;
    // @codingStandardsIgnoreEnd

    /**
     * CompleteStatusResponse constructor.
     *
     * @param CompleteStatusResponseShipment[]|null $Shipments
     * @param Warnings[]|null $Warnings
     */
    public function __construct(
        array $Shipments = null,
        array $Warnings = null
    ) {
        parent::__construct();

        $this->setShipments($Shipments);
        $this->setWarnings($Warnings);
    }

    public static function jsonDeserialize(stdClass $json)
    {
        // Find the entity name
        $reflection = new ReflectionObject($json);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        if (!count($properties)) {
            return $json;
        }

        if (isset($json->CompleteStatusResponse->Shipments) && !is_array($json->CompleteStatusResponse->Shipments)) {
            $json->CompleteStatusResponse->Shipments = [$json->CompleteStatusResponse->Shipments];
        }

        $completeStatusResponse = self::create();
        $shipments = [];
        if (!empty($json->CompleteStatusResponse->Shipments)) {
            foreach ($json->CompleteStatusResponse->Shipments as $shipment) {
                $shipments[] = CompleteStatusResponseShipment::jsonDeserialize((object) ['CompleteStatusResponseShipment' => $shipment]);
            }
        }
        $completeStatusResponse->setShipments($shipments);

        return $completeStatusResponse;
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
                if (is_array($this->Shipments)) {
                    foreach ($this->Shipments as $shipment) {
                        $shipments[] = ["{{$namespace}}Shipment" => $shipment];
                    }
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
