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
use stdClass;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;
use function is_array;

/**
 * Class GetDeliveryDateResponse.
 *
 * @method DateTimeInterface|null  getDeliveryDate()
 * @method string[]|null           getOptions()
 * @method GetDeliveryDateResponse setOptions(string[]|null $options = null)
 *
 * @since 1.0.0
 */
class GetDeliveryDateResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'DeliveryDate' => BarcodeService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Confirming' => [
            'DeliveryDate' => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Labelling' => [
            'DeliveryDate' => LabellingService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'ShippingStatus' => [
            'DeliveryDate' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'DeliveryDate' => [
            'DeliveryDate' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Location' => [
            'DeliveryDate' => LocationService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Timeframe' => [
            'DeliveryDate' => TimeframeService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $DeliveryDate;
    /** @var string[]|null */
    protected $Options;
    // @codingStandardsIgnoreEnd

    /**
     * GetDeliveryDateResponse constructor.
     *
     * @param string|DateTimeInterface|null $date
     * @param string[]|null                 $options
     *
     * @throws Exception
     * @throws Exception
     */
    public function __construct($date = null, array $options = null)
    {
        parent::__construct();

        $this->setDeliveryDate($date);
        $this->setOptions($options);
    }

    /**
     * @param DateTimeInterface|string|null $deliveryDate
     *
     * @return static
     *
     * @throws Exception
     *
     * @since 1.2.0
     */
    public function setDeliveryDate($deliveryDate = null)
    {
        if (is_string($deliveryDate)) {
            $deliveryDate = new DateTimeImmutable($deliveryDate);
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
            if ('Shipments' === $propertyName) {
                $options = [];
                if (is_array($this->Options)) {
                    foreach ($this->Options as $option) {
                        $options[] = ["{{$namespace}}string" => $option];
                    }
                }
                $xml["{{$namespace}}Options"] = $options;
            } elseif (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }

    /**
     * @param stdClass $json
     *
     * @return mixed|object|stdClass|GetDeliveryDateResponse|null
     *
     * @throws ReflectionException
     * @throws \ReflectionException
     */
    public static function jsonDeserialize(stdClass $json)
    {
        if (!isset($json->GetDeliveryDateResponse)) {
            return $json;
        }

        $getDeliveryDateResponse = self::create();
        $getDeliveryDateResponse->DeliveryDate = new DateTimeImmutable($json->GetDeliveryDateResponse->DeliveryDate);
        if (isset($json->GetDeliveryDateResponse->Options)) {
            if (!is_array($json->GetDeliveryDateResponse->Options)) {
                $json->GetDeliveryDateResponse->Options = [$json->GetDeliveryDateResponse->Options];
            }

            $options = [];
            foreach ($json->GetDeliveryDateResponse->Options as $key => $option) {
                if (is_string($option)) {
                    $options[] = $option;
                } elseif ($option instanceof stdClass && isset($option->string)) {
                    $options[] = $option->string;
                }
            }

            $getDeliveryDateResponse->setOptions($options);
        }

        return $getDeliveryDateResponse;
    }
}
