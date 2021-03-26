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

use InvalidArgumentException;
use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\ReasonNoTimeframe;
use ThirtyBees\PostNL\Entity\Timeframe;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class ResponseTimeframes.
 *
 * @method ReasonNoTimeframe[]|null getReasonNoTimeframes()
 * @method Timeframe[]|null         getTimeframes()
 * @method ResponseTimeframes       setReasonNoTimeframes(ReasonNoTimeframe[]|null $noTimeframes = null)
 * @method ResponseTimeframes       setTimeframes(Timeframe[]|null $timeframes = null)
 *
 * @since 1.0.0
 */
class ResponseTimeframes extends AbstractEntity
{
    /** @var array */
    public static $defaultProperties = [
        'Barcode' => [
            'ReasonNoTimeframes' => BarcodeService::DOMAIN_NAMESPACE,
            'Timeframes'         => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'ReasonNoTimeframes' => ConfirmingService::DOMAIN_NAMESPACE,
            'Timeframes'         => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'ReasonNoTimeframes' => LabellingService::DOMAIN_NAMESPACE,
            'Timeframes'         => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'ReasonNoTimeframes' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Timeframes'         => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'ReasonNoTimeframes' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Timeframes'         => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'ReasonNoTimeframes' => LocationService::DOMAIN_NAMESPACE,
            'Timeframes'         => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'ReasonNoTimeframes' => TimeframeService::DOMAIN_NAMESPACE,
            'Timeframes'         => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var ReasonNoTimeframe[]|null */
    protected $ReasonNoTimeframes;
    /** @var Timeframe[]|null */
    protected $Timeframes;
    // @codingStandardsIgnoreEnd

    /**
     * @param ReasonNoTimeframe[]|null $noTimeframes
     * @param Timeframe[]|null         $timeframes
     */
    public function __construct(
        array $noTimeframes = null,
        array $timeframes = null
    ) {
        parent::__construct();

        $this->setReasonNoTimeframes($noTimeframes);
        $this->setTimeframes($timeframes);
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
                if ('ReasonNoTimeframes' === $propertyName) {
                    $noTimeframes = [];
                    foreach ($this->ReasonNoTimeframes as $noTimeframe) {
                        $noTimeframes[] = $noTimeframe;
                    }
                    $json['ReasonNotimeframes'] = ['ReasonNoTimeframe' => $noTimeframes];
                } elseif ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->Timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json[$propertyName] = ['Timeframe' => $timeframes];
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }

//
//    /**
//     * Return a serializable array for the XMLWriter
//     *
//     * @param Writer $writer
//     *
//     * @return void
//     * @throws InvalidArgumentException
//     */
//    public function xmlSerialize(Writer $writer)
//    {
//        $xml = [];
//        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
//            throw new InvalidArgumentException('Service not set before serialization');
//        }
//
//        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
//            if ($propertyName === 'ReasonNoTimeframes') {
//                $noTimeframes = [];
//                foreach ($this->ReasonNoTimeframes as $noTimeframe) {
//                    $options[] = ["{{$namespace}}ReasonNoTimeFrame" => $noTimeframe];
//                }
//                $xml["{{$namespace}}ReasonNoTimeframes"] = $noTimeframes;
//            } elseif ($propertyName === 'Timeframes') {
//                $timeframes = [];
//                foreach ($this->Timeframes as $timeframe) {
//                    $timeframes[] = ["{{$namespace}}Timeframe" => $timeframe];
//                }
//                $xml["{{$namespace}}Timeframes"] = $timeframes;
//            } elseif (!is_null($this->$propertyName)) {
//                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
//            }
//        }
//
//        $writer->write($xml);
//    }
}
