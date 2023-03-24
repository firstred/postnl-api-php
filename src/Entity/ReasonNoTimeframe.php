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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;
use stdClass;
use function array_merge;
use function is_array;
use function is_string;

/**
 * Class ReasonNoTimeframe.
 *
 * @method string|null            getCode()
 * @method DateTimeInterface|null getDate()
 * @method string|null            getDescription()
 * @method string[]|null          getOptions()
 * @method string|null            getFrom()
 * @method string|null            getTo()
 * @method ReasonNoTimeframe      setCode(string|null $Code = null)
 * @method ReasonNoTimeframe      setDescription(string|null $Description = null)
 * @method ReasonNoTimeframe      setOptions(string[]|null $Options = null)
 * @method ReasonNoTimeframe      setFrom(string|null $From = null)
 * @method ReasonNoTimeframe      setTo(string|null $To = null)
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
     * @param string|null                   $Code
     * @param string|DateTimeInterface|null $Date
     * @param string|null                   $Description
     * @param string[]|null                 $Options
     * @param string|null                   $From
     * @param string|null                   $To
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $Code = null,
        $Date = null,
        $Description = null,
        array $Options = null,
        $From = null,
        $To = null
    ) {
        parent::__construct();

        $this->setCode($Code);
        $this->setDate($Date);
        $this->setDescription($Description);
        $this->setOptions($Options);
        $this->setFrom($From);
        $this->setTo($To);
    }

    /**
     * Set date
     *
     * @param string|DateTimeInterface|null $date
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate($date = null)
    {
        if (is_string($date)) {
            try {
                $date = new DateTimeImmutable($date, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->Date = $date;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return mixed|stdClass|null
     *
     * @throws InvalidArgumentException
     * @throws \Firstred\PostNL\Exception\NotSupportedException
     *
     * @since 1.2.0
     */
    public static function jsonDeserialize(stdClass $json)
    {
        if (isset($json->ReasonNoTimeframe->Options)) {
            /** @psalm-var list<string> $deliveryOptions */
            $deliveryOptions = [];
            if (!is_array($json->ReasonNoTimeframe->Options)){
                $json->ReasonNoTimeframe->Options = [$json->ReasonNoTimeframe->Options];
            }

            foreach ($json->ReasonNoTimeframe->Options as $deliveryOption) {
                if (isset($deliveryOption->string)) {
                    if (!is_array($deliveryOption->string)) {
                        $deliveryOption->string = [$deliveryOption->string];
                    }
                    foreach ($deliveryOption->string as $optionString) {
                        $deliveryOptions[] = $optionString;
                    }
                } elseif (is_array($deliveryOption)) {
                    $deliveryOptions = array_merge($deliveryOptions, $deliveryOption);
                } elseif (is_string($deliveryOption)) {
                    $deliveryOptions[] = $deliveryOption;
                }
            }

            $json->ReasonNoTimeframe->Options = $deliveryOptions;
        }

        return parent::jsonDeserialize($json);
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
