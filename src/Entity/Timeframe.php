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
     * @param string|null                   $city
     * @param string|null                   $countryCode
     * @param string|DateTimeInterface|null $date
     * @param string|DateTimeInterface|null $endDate
     * @param string|null                   $houseNr
     * @param string|null                   $houseNrExt
     * @param array|null                    $options
     * @param string|null                   $postalCode
     * @param string|null                   $street
     * @param string|null                   $sundaySorting
     * @param string|null                   $interval
     * @param string|null                   $range
     * @param Timeframe[]|null              $timeframes
     * @param string|DateTimeInterface|null $startDate
     *
     * @throws PostNLInvalidArgumentException
     */
    public function __construct(
        $city = null,
        $countryCode = null,
        $date = null,
        $endDate = null,
        $houseNr = null,
        $houseNrExt = null,
        array $options = [],
        $postalCode = null,
        $street = null,
        $sundaySorting = 'false',
        $interval = null,
        $range = null,
        array $timeframes = null,
        $startDate = null
    ) {
        parent::__construct();

        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setDate($date);
        $this->setEndDate($endDate);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setOptions($options);
        $this->setPostalCode($postalCode);
        $this->setStreet($street);
        $this->setSundaySorting($sundaySorting);
        $this->setInterval($interval);
        $this->setTimeframeRange($range);
        $this->setTimeframes($timeframes);
        $this->setStartDate($startDate);
    }

    /**
     * @param null $date
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDate($date = null)
    {
        if (is_string($date)) {
            try {
                $date = new DateTimeImmutable($date);
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage, 0, $e);
            }
        }

        $this->Date = $date;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $startDate
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setStartDate($startDate = null)
    {
        if (is_string($startDate)) {
            try {
                $startDate = new DateTimeImmutable($startDate);
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->StartDate = $startDate;

        return $this;
    }

    /**
     * @param string|DateTimeInterface|null $endDate
     *
     * @return static
     *
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setEndDate($endDate = null)
    {
        if (is_string($endDate)) {
            try {
                $endDate = new DateTimeImmutable($endDate);
            } catch (Exception $e) {
                throw new PostNLInvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->EndDate = $endDate;

        return $this;
    }

    /**
     * Set the postcode.
     *
     * @param string|null $postcode
     *
     * @return static
     */
    public function setPostalCode($postcode = null)
    {
        if (is_null($postcode)) {
            $this->PostalCode = null;
        } else {
            $this->PostalCode = strtoupper(str_replace(' ', '', $postcode));
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
