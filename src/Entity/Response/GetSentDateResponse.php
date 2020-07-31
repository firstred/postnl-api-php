<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GetSentDateResponse.
 *
 * @method string|null         getSentDate()
 * @method string[]|null       getOptions()
 * @method GetSentDateResponse setSentDate(string|null $date = null)
 * @method GetSentDateResponse setOptions(string[]|null $options = null)
 */
class GetSentDateResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
            'SentDate' => BarcodeService::DOMAIN_NAMESPACE,
            'Options'  => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'SentDate' => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'  => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'SentDate' => LabellingService::DOMAIN_NAMESPACE,
            'Options'  => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'SentDate' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'  => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'SentDate' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'  => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'SentDate' => LocationService::DOMAIN_NAMESPACE,
            'Options'  => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'SentDate' => TimeframeService::DOMAIN_NAMESPACE,
            'Options'  => timeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $SentDate;
    /** @var string[]|null */
    protected $Options;
    // @codingStandardsIgnoreEnd

    /**
     * GetSentDateResponse constructor.
     *
     * @param string|null   $date
     * @param string[]|null $options
     */
    public function __construct($date = null, array $options = null)
    {
        parent::__construct();

        $this->setSentDate($date);
        $this->setOptions($options);
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
            if ('Options' === $propertyName) {
                if (isset($this->Options)) {
                    $options = [];
                    if (is_array($this->Options)) {
                        foreach ($this->Options as $option) {
                            $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                        }
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
