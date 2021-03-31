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

namespace Firstred\PostNL\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use InvalidArgumentException;
use Sabre\Xml\Writer;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;
use stdClass;
use function array_merge;
use function is_array;
use function is_string;

/**
 * Class Timeframe.
 *
 * @method string|null            getCity()
 * @method string|null            getCountryCode()
 * @method DateTimeInterface|null getDate()
 * @method DateTimeInterface|null getEndDate()
 * @method string|null            getHouseNr()
 * @method string|null            getHouseNrExt()
 * @method string[]|null          getOptions()
 * @method string|null            getPostalCode()
 * @method DateTimeInterface|null getStartDate()
 * @method string|null            getStreet()
 * @method string|null            getSundaySorting()
 * @method string|null            getInterval()
 * @method string|null            getTimeframeRange()
 * @method Timeframe[]|null       getTimeframes()
 * @method Timeframe              setCity(string|null $city = null)
 * @method Timeframe              setCountryCode(string|null $code = null)
 * @method Timeframe              setHouseNr(string|null $houseNr = null)
 * @method Timeframe              setHouseNrExt(string|null $houseNrExt = null)
 * @method Timeframe              setOptions(string[]|null $options = null)
 * @method Timeframe              setStreet(string|null $street = null)
 * @method Timeframe              setSundaySorting(string|null $sunday = null)
 * @method Timeframe              setInterval(string|null $interval = null)
 * @method Timeframe              setTimeframeRange(string|null $range = null)
 * @method Timeframe              setTimeframes(Timeframe[]|null $timeframes = null)
 *
 * @since 1.0.0
 */
class Timeframe extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode'        => [
            'City'           => BarcodeService::DOMAIN_NAMESPACE,
            'CountryCode'    => BarcodeService::DOMAIN_NAMESPACE,
            'Date'           => BarcodeService::DOMAIN_NAMESPACE,
            'EndDate'        => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNr'        => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => BarcodeService::DOMAIN_NAMESPACE,
            'Options'        => BarcodeService::DOMAIN_NAMESPACE,
            'PostalCode'     => BarcodeService::DOMAIN_NAMESPACE,
            'StartDate'      => BarcodeService::DOMAIN_NAMESPACE,
            'Street'         => BarcodeService::DOMAIN_NAMESPACE,
            'SundaySorting'  => BarcodeService::DOMAIN_NAMESPACE,
            'Interval'       => BarcodeService::DOMAIN_NAMESPACE,
            'TimeframeRange' => BarcodeService::DOMAIN_NAMESPACE,
            'Timeframes'     => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'City'           => ConfirmingService::DOMAIN_NAMESPACE,
            'CountryCode'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Date'           => ConfirmingService::DOMAIN_NAMESPACE,
            'EndDate'        => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNr'        => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'        => ConfirmingService::DOMAIN_NAMESPACE,
            'PostalCode'     => ConfirmingService::DOMAIN_NAMESPACE,
            'StartDate'      => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'         => ConfirmingService::DOMAIN_NAMESPACE,
            'SundaySorting'  => ConfirmingService::DOMAIN_NAMESPACE,
            'Interval'       => ConfirmingService::DOMAIN_NAMESPACE,
            'TimeframeRange' => ConfirmingService::DOMAIN_NAMESPACE,
            'Timeframes'     => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'City'           => LabellingService::DOMAIN_NAMESPACE,
            'CountryCode'    => LabellingService::DOMAIN_NAMESPACE,
            'Date'           => LabellingService::DOMAIN_NAMESPACE,
            'EndDate'        => LabellingService::DOMAIN_NAMESPACE,
            'HouseNr'        => LabellingService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => LabellingService::DOMAIN_NAMESPACE,
            'Options'        => LabellingService::DOMAIN_NAMESPACE,
            'PostalCode'     => LabellingService::DOMAIN_NAMESPACE,
            'StartDate'      => LabellingService::DOMAIN_NAMESPACE,
            'Street'         => LabellingService::DOMAIN_NAMESPACE,
            'SundaySorting'  => LabellingService::DOMAIN_NAMESPACE,
            'Interval'       => LabellingService::DOMAIN_NAMESPACE,
            'TimeframeRange' => LabellingService::DOMAIN_NAMESPACE,
            'Timeframes'     => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'City'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'CountryCode'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Date'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'EndDate'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNr'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'PostalCode'     => ShippingStatusService::DOMAIN_NAMESPACE,
            'StartDate'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'Street'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'SundaySorting'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'Interval'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'TimeframeRange' => ShippingStatusService::DOMAIN_NAMESPACE,
            'Timeframes'     => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'City'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'CountryCode'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Date'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'EndDate'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNr'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'PostalCode'     => DeliveryDateService::DOMAIN_NAMESPACE,
            'StartDate'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'SundaySorting'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'Interval'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'TimeframeRange' => DeliveryDateService::DOMAIN_NAMESPACE,
            'Timeframes'     => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'City'           => LocationService::DOMAIN_NAMESPACE,
            'CountryCode'    => LocationService::DOMAIN_NAMESPACE,
            'Date'           => LocationService::DOMAIN_NAMESPACE,
            'EndDate'        => LocationService::DOMAIN_NAMESPACE,
            'HouseNr'        => LocationService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => LocationService::DOMAIN_NAMESPACE,
            'Options'        => LocationService::DOMAIN_NAMESPACE,
            'PostalCode'     => LocationService::DOMAIN_NAMESPACE,
            'StartDate'      => LocationService::DOMAIN_NAMESPACE,
            'Street'         => LocationService::DOMAIN_NAMESPACE,
            'SundaySorting'  => LocationService::DOMAIN_NAMESPACE,
            'Interval'       => LocationService::DOMAIN_NAMESPACE,
            'TimeframeRange' => LocationService::DOMAIN_NAMESPACE,
            'Timeframes'     => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'City'           => TimeframeService::DOMAIN_NAMESPACE,
            'CountryCode'    => TimeframeService::DOMAIN_NAMESPACE,
            'Date'           => TimeframeService::DOMAIN_NAMESPACE,
            'EndDate'        => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNr'        => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNrExt'     => TimeframeService::DOMAIN_NAMESPACE,
            'Options'        => TimeframeService::DOMAIN_NAMESPACE,
            'PostalCode'     => TimeframeService::DOMAIN_NAMESPACE,
            'StartDate'      => TimeframeService::DOMAIN_NAMESPACE,
            'Street'         => TimeframeService::DOMAIN_NAMESPACE,
            'SundaySorting'  => TimeframeService::DOMAIN_NAMESPACE,
            'Interval'       => TimeframeService::DOMAIN_NAMESPACE,
            'TimeframeRange' => TimeframeService::DOMAIN_NAMESPACE,
            'Timeframes'     => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null */
    protected $City;
    /** @var string|null */
    protected $CountryCode;
    /** @var DateTimeInterface|null */
    protected $Date;
    /** @var DateTimeInterface|null */
    protected $EndDate;
    /** @var string|null */
    protected $HouseNr;
    /** @var string|null */
    protected $HouseNrExt;
    /** @var string[]|null */
    protected $Options;
    /** @var string|null */
    protected $PostalCode;
    /** @var string|null */
    protected $StartDate;
    /** @var string|null */
    protected $Street;
    /** @var string|null */
    protected $SundaySorting;
    /** @var string|null */
    protected $Interval;
    /** @var string|null */
    protected $TimeframeRange;
    /** @var TimeframeTimeFrame[]|Timeframe[]|null */
    protected $Timeframes;
    // @codingStandardsIgnoreEnd

    /**
     * Timeframe constructor.
     *
     * @param string|null                   $City
     * @param string|null                   $CountryCode
     * @param string|DateTimeInterface|null $Date
     * @param string|DateTimeInterface|null $EndDate
     * @param string|null                   $HouseNr
     * @param string|null                   $HouseNrExt
     * @param array|null                    $Options
     * @param string|null                   $PostalCode
     * @param string|null                   $Street
     * @param string|null                   $SundaySorting
     * @param string|null                   $Interval
     * @param string|null                   $Range
     * @param Timeframe[]|null              $Timeframes
     * @param string|DateTimeInterface|null $StartDate
     *
     * @throws PostNLInvalidArgumentException
     */
    public function __construct(
        $City = null,
        $CountryCode = null,
        $Date = null,
        $EndDate = null,
        $HouseNr = null,
        $HouseNrExt = null,
        array $Options = [],
        $PostalCode = null,
        $Street = null,
        $SundaySorting = 'false',
        $Interval = null,
        $Range = null,
        array $Timeframes = null,
        $StartDate = null
    ) {
        parent::__construct();

        $this->setCity($City);
        $this->setCountryCode($CountryCode);
        $this->setDate($Date);
        $this->setEndDate($EndDate);
        $this->setHouseNr($HouseNr);
        $this->setHouseNrExt($HouseNrExt);
        $this->setOptions($Options);
        $this->setPostalCode($PostalCode);
        $this->setStreet($Street);
        $this->setSundaySorting($SundaySorting);
        $this->setInterval($Interval);
        $this->setTimeframeRange($Range);
        $this->setTimeframes($Timeframes);
        $this->setStartDate($StartDate);
    }

    /**
     * @param null $Date
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate($Date = null)
    {
        if (is_string($Date)) {
            try {
                $Date = new DateTimeImmutable($Date, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->Date = $Date;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $StartDate
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setStartDate($StartDate = null)
    {
        if (is_string($StartDate)) {
            try {
                $StartDate = new DateTimeImmutable($StartDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->StartDate = $StartDate;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $EndDate
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setEndDate($EndDate = null)
    {
        if (is_string($EndDate)) {
            try {
                $EndDate = new DateTimeImmutable($EndDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->EndDate = $EndDate;

        return $this;
    }

    /**
     * Set the postcode.
     *
     * @param string|null $PostalCode
     *
     * @return static
     */
    public function setPostalCode($PostalCode = null)
    {
        if (is_null($PostalCode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(str_replace(' ', '', $PostalCode));
        }

        return $this;
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
                if ('Options' === $propertyName) {
                    $json[$propertyName] = $this->$propertyName;
                } elseif ('Timeframes' === $propertyName) {
                    $timeframes = [];
                    foreach ($this->Timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json['Timeframes'] = ['TimeframeTimeFrame' => $timeframes];
                } elseif ('SundaySorting' === $propertyName) {
                    if (isset($this->$propertyName)) {
                        if (is_bool($this->$propertyName)) {
                            $value = $this->$propertyName ? 'true' : 'false';
                        } else {
                            $value = $this->$propertyName;
                        }

                        $json[$propertyName] = $value;
                    }
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @param Writer $writer
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            throw new InvalidArgumentException('Service not set before serialization');
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('StartDate' === $propertyName) {
                if ($this->StartDate instanceof DateTimeInterface) {
                    $xml["{{$namespace}}StartDate"] = $this->StartDate->format('d-m-Y');
                }
            } elseif ('EndDate' === $propertyName) {
                if ($this->StartDate instanceof DateTimeInterface) {
                    $xml["{{$namespace}}EndDate"] = $this->EndDate->format('d-m-Y');
                }
            } elseif ('SundaySorting' === $propertyName) {
                if (isset($this->SundaySorting)) {
                    if (is_bool($this->SundaySorting)) {
                        $xml["{{$namespace}}SundaySorting"] = $this->SundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}SundaySorting"] = $this->SundaySorting;
                    }
                }
            } elseif ('Options' === $propertyName) {
                if (isset($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }

        $writer->write($xml);
    }
}
