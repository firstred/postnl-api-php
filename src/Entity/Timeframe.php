<?php
/**
 * The MIT License (MIT)
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

namespace ThirtyBees\PostNL\Entity;

use InvalidArgumentException;
use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Timeframe
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string      getCity()
 * @method string      getCountryCode()
 * @method string      getDate()
 * @method string      getEndDate()
 * @method string      getHouseNr()
 * @method string      getHouseNrExt()
 * @method string[]    getOptions()
 * @method string      getPostalCode()
 * @method string      getStartDate()
 * @method string      getStreet()
 * @method string      getSundaySorting()
 * @method string      getInterval()
 * @method string      getTimeframeRange()
 * @method Timeframe[] getTimeframes()
 *
 * @method Timeframe setCity(string $city)
 * @method Timeframe setCountryCode(string $code)
 * @method Timeframe setDate(string $date)
 * @method Timeframe setEndDate(string $date)
 * @method Timeframe setHouseNr(string $houseNr)
 * @method Timeframe setHouseNrExt(string $houseNrExt)
 * @method Timeframe setOptions(string[] $options)
 * @method Timeframe setPostalCode(string $postcode)
 * @method Timeframe setStartDate(string $date)
 * @method Timeframe setStreet(string $street)
 * @method Timeframe setSundaySorting(string $sunday)
 * @method Timeframe setInterval(string $interval)
 * @method Timeframe setTimeframeRange(string $range)
 * @method Timeframe setTimeframes(Timeframe[] $timeframes)
 */
class Timeframe extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
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
    /** @var string $City */
    protected $City;
    /** @var string $CountryCode */
    protected $CountryCode;
    /** @var string $Date */
    protected $Date;
    /** @var string $EndDate */
    protected $EndDate;
    /** @var string $HouseNr */
    protected $HouseNr;
    /** @var string $HouseNrExt */
    protected $HouseNrExt;
    /** @var string[] $Options */
    protected $Options;
    /** @var string $PostalCode */
    protected $PostalCode;
    /** @var string $StartDate */
    protected $StartDate;
    /** @var string $Street */
    protected $Street;
    /** @var string $SundaySorting */
    protected $SundaySorting;
    /** @var string $Interval */
    protected $Interval;
    /** @var string $TimeframeRange */
    protected $TimeframeRange;
    /** @var TimeframeTimeFrame[]|Timeframe[] $Timeframes */
    protected $Timeframes;
    // @codingStandardsIgnoreEnd

    /**
     * Timeframe constructor.
     *
     * @param string|null $city
     * @param string|null $countryCode
     * @param string|null $date
     * @param string|null $endDate
     * @param string|null $houseNr
     * @param string|null $houseNrExt
     * @param array       $options
     * @param string|null $postalCode
     * @param string|null $street
     * @param string      $sundaySorting
     * @param string      $interval
     * @param string      $range
     * @param Timeframe[] $timeframes
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
        array $timeframes = null
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
    }

    /**
     * Return a serializable array for `json_encode`
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
            if (isset($this->{$propertyName})) {
                if ($propertyName === 'Options') {
                    $json[$propertyName] = $this->{$propertyName};
                } elseif ($propertyName === 'Timeframes') {
                    $timeframes = [];
                    foreach ($this->Timeframes as $timeframe) {
                        $timeframes[] = $timeframe;
                    }
                    $json['Timeframes'] = ['TimeframeTimeFrame' => $timeframes];
                } elseif ($propertyName === 'SundaySorting') {
                    if (isset($this->{$propertyName})) {
                        if (is_bool($this->{$propertyName})) {
                            $value = $this->{$propertyName} ? 'true' : 'false';
                        } else {
                            $value = $this->{$propertyName};
                        }

                        $json[$propertyName] = $value;
                    }
                } else {
                    $json[$propertyName] = $this->{$propertyName};
                }
            }
        }

        return $json;
    }

    /**
     * Return a serializable array for the XMLWriter
     *
     * @param Writer $writer
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            throw new InvalidArgumentException('Service not set before serialization');
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ($propertyName === 'SundaySorting') {
                if (isset($this->SundaySorting)) {
                    if (is_bool($this->SundaySorting)) {
                        $xml["{{$namespace}}SundaySorting"] = $this->SundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}SundaySorting"] = $this->SundaySorting;
                    }
                }
            } elseif ($propertyName === 'Options') {
                if (isset($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ["{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string" => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }

        $writer->write($xml);
    }
}
