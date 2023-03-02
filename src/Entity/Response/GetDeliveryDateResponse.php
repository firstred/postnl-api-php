<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use ReflectionException;
use Sabre\Xml\Writer;
use stdClass;
use function is_array;

/**
 * Class GetDeliveryDateResponse.
 *
 * @method DateTimeInterface|null  getDeliveryDate()
 * @method string[]|null           getOptions()
 * @method GetDeliveryDateResponse setOptions(string[]|null $Options = null)
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
        'Barcode'        => [
            'DeliveryDate' => BarcodeService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Confirming'     => [
            'DeliveryDate' => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Labelling'      => [
            'DeliveryDate' => LabellingService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'DeliveryDate'   => [
            'DeliveryDate' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Location'       => [
            'DeliveryDate' => LocationService::DOMAIN_NAMESPACE,
            'Options'      => 'http://schemas.microsoft.com/2003/10/Serialization/Arrays',
        ],
        'Timeframe'      => [
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
     * @param string|DateTimeInterface|null $DeliveryDate
     * @param string[]|null                 $Options
     *
     * @throws PostNLInvalidArgumentException
     */
    public function __construct($DeliveryDate = null, array $Options = null)
    {
        parent::__construct();

        $this->setDeliveryDate($DeliveryDate);
        $this->setOptions($Options);
    }

    /**
     * @param DateTimeInterface|string|null $DeliveryDate
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate($DeliveryDate = null)
    {
        if (is_string($DeliveryDate)) {
            try {
                $DeliveryDate = new DateTimeImmutable($DeliveryDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryDate = $DeliveryDate;

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
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }

    /**
     * @param stdClass $json
     *
     * @return GetDeliveryDateResponse|object|stdClass|null
     *
     * @throws PostNLInvalidArgumentException
     */
    public static function jsonDeserialize(stdClass $json)
    {
        if (!isset($json->GetDeliveryDateResponse)) {
            return $json;
        }

        $getDeliveryDateResponse = self::create();
        try {
            $getDeliveryDateResponse->DeliveryDate = new DateTimeImmutable($json->GetDeliveryDateResponse->DeliveryDate, new DateTimeZone('Europe/Amsterdam'));
        } catch (Exception $e) {
            throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
        }
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
