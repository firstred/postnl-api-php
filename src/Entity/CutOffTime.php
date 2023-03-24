<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class CutOffTime.
 *
 * @method string|null getDay()
 * @method string|null getTime()
 * @method bool|null   getAvailable()
 * @method CutOffTime  setDay(string|null $Day = null)
 * @method CutOffTime  setTime(string|null $Time = null)
 * @method CutOffTime  setAvailable(bool|null $Available = null)
 *
 * @since 1.0.0
 */
class CutOffTime extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Day'       => BarcodeService::DOMAIN_NAMESPACE,
            'Time'      => BarcodeService::DOMAIN_NAMESPACE,
            'Available' => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Day'       => ConfirmingService::DOMAIN_NAMESPACE,
            'Time'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Available' => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Day'       => LabellingService::DOMAIN_NAMESPACE,
            'Time'      => LabellingService::DOMAIN_NAMESPACE,
            'Available' => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Day'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'Time'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Available' => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Day'       => LocationService::DOMAIN_NAMESPACE,
            'Time'      => LocationService::DOMAIN_NAMESPACE,
            'Available' => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Day'       => TimeframeService::DOMAIN_NAMESPACE,
            'Time'      => TimeframeService::DOMAIN_NAMESPACE,
            'Available' => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Day;
    /** @var string|null */
    protected $Time;
    /** @var bool|null */
    protected $Available;
    // @codingStandardsIgnoreEnd

    /**
     * @param string $Day
     * @param string $Time
     * @param bool   $Available
     */
    public function __construct($Day = null, $Time = null, $Available = null)
    {
        parent::__construct();

        $this->setDay($Day);
        $this->setTime($Time);
        $this->setAvailable($Available);
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
            if (isset($this->$propertyName)) {
                if ('Available' === $propertyName) {
                    if (is_bool($this->$propertyName)) {
                        $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName ? 'true' : 'false';
                    } elseif (is_int($this->$propertyName)) {
                        $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = 1 === $this->$propertyName ? 'true' : 'false';
                    } else {
                        $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
                    }
                } else {
                    $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
                }
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
