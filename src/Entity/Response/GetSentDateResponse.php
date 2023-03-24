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

namespace Firstred\PostNL\Entity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class GetSentDateResponse.
 *
 * @method DateTimeInterface|null getSentDate()
 * @method string[]|null          getOptions()
 * @method GetSentDateResponse    setOptions(string[]|null $Options = null)
 *
 * @since 1.0.0
 */
class GetSentDateResponse extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'SentDate' => BarcodeService::DOMAIN_NAMESPACE,
            'Options'  => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'SentDate' => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'  => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'SentDate' => LabellingService::DOMAIN_NAMESPACE,
            'Options'  => LabellingService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'SentDate' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'  => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'SentDate' => LocationService::DOMAIN_NAMESPACE,
            'Options'  => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'SentDate' => TimeframeService::DOMAIN_NAMESPACE,
            'Options'  => timeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var DateTimeInterface|null */
    protected $SentDate;
    /** @var string[]|null */
    protected $Options;
    // @codingStandardsIgnoreEnd

    /**
     * GetSentDateResponse constructor.
     *
     * @param DateTimeInterface|string|null $GetSentDate
     * @param string[]|null                 $Options
     *
     * @throws InvalidArgumentException
     */
    public function __construct($GetSentDate = null, array $Options = null)
    {
        parent::__construct();

        $this->setSentDate($GetSentDate);
        $this->setOptions($Options);
    }

    /**
     * @param string|DateTimeInterface|null $SentDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setSentDate($SentDate = null)
    {
        if (is_string($SentDate)) {
            try {
                $SentDate = new DateTimeImmutable($SentDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->SentDate = $SentDate;

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
