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

namespace ThirtyBees\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class ReasonNoTimeframe.
 *
 * @method string|null            getCode()
 * @method DateTimeInterface|null getDate()
 * @method string|null            getDescription()
 * @method string[]|null          getOptions()
 * @method string|null            getFrom()
 * @method string|null            getTo()
 * @method ReasonNoTimeframe      setCode(string|null $code = null)
 * @method ReasonNoTimeframe      setDescription(string|null $desc = null)
 * @method ReasonNoTimeframe      setOptions(string[]|null $options = null)
 * @method ReasonNoTimeframe      setFrom(string|null $from = null)
 * @method ReasonNoTimeframe      setTo(string|null $to = null)
 *
 * @since 1.0.0
 */
class ReasonNoTimeframe extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
            'Code'        => BarcodeService::DOMAIN_NAMESPACE,
            'Date'        => BarcodeService::DOMAIN_NAMESPACE,
            'Description' => BarcodeService::DOMAIN_NAMESPACE,
            'Options'     => BarcodeService::DOMAIN_NAMESPACE,
            'From'        => BarcodeService::DOMAIN_NAMESPACE,
            'To'          => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming' => [
            'Code'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Date'        => ConfirmingService::DOMAIN_NAMESPACE,
            'Description' => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'     => ConfirmingService::DOMAIN_NAMESPACE,
            'From'        => ConfirmingService::DOMAIN_NAMESPACE,
            'To'          => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling' => [
            'Code'        => LabellingService::DOMAIN_NAMESPACE,
            'Date'        => LabellingService::DOMAIN_NAMESPACE,
            'Description' => LabellingService::DOMAIN_NAMESPACE,
            'Options'     => LabellingService::DOMAIN_NAMESPACE,
            'From'        => LabellingService::DOMAIN_NAMESPACE,
            'To'          => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'Code'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Date'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'Description' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'From'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'To'          => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate' => [
            'Code'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Date'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'Description' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'From'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'To'          => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location' => [
            'Code'        => LocationService::DOMAIN_NAMESPACE,
            'Date'        => LocationService::DOMAIN_NAMESPACE,
            'Description' => LocationService::DOMAIN_NAMESPACE,
            'Options'     => LocationService::DOMAIN_NAMESPACE,
            'From'        => LocationService::DOMAIN_NAMESPACE,
            'To'          => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe' => [
            'Code'        => TimeframeService::DOMAIN_NAMESPACE,
            'Date'        => TimeframeService::DOMAIN_NAMESPACE,
            'Description' => TimeframeService::DOMAIN_NAMESPACE,
            'Options'     => TimeframeService::DOMAIN_NAMESPACE,
            'From'        => TimeframeService::DOMAIN_NAMESPACE,
            'To'          => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $Code;
    /** @var DateTimeInterface|null */
    protected $Date;
    /** @var string|null */
    protected $Description;
    /** @var string[]|null */
    protected $Options;
    /** @var string|null */
    protected $From;
    /** @var string|null */
    protected $To;
    // @codingStandardsIgnoreEnd

    /**
     * ReasonNoTimeframe constructor.
     *
     * @param string|null                   $code
     * @param string|DateTimeInterface|null $date
     * @param string|null                   $desc
     * @param string[]|null                 $options
     * @param string|null                   $from
     * @param string|null                   $to
     *
     * @throws Exception
     */
    public function __construct(
        $code = null,
        $date = null,
        $desc = null,
        array $options = null,
        $from = null,
        $to = null
    ) {
        parent::__construct();

        $this->setCode($code);
        $this->setDate($date);
        $this->setDescription($desc);
        $this->setOptions($options);
        $this->setFrom($from);
        $this->setTo($to);
    }

    /**
     * Set date
     *
     * @param string|DateTimeInterface|null $date
     *
     * @return static
     *
     * @throws Exception
     *
     * @since 1.2.0
     */
    public function setDate($date = null)
    {
        if (is_string($date)) {
            $date = new DateTimeImmutable($date);
        }

        $this->Date = $date;

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
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
