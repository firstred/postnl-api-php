<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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

namespace ThirtyBees\PostNL\Entity\Request;

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\CutOffTime;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class GetDeliveryDate
 *
 * This class is both the container and can be the actual GetDeliveryDate object itself!
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method bool            getAllowSundaySorting()
 * @method string          getCity()
 * @method string          getCountryCode()
 * @method CutOffTime[]    getCutOffTimes()
 * @method string          getHouseNr()
 * @method string          getHouseNrExt()
 * @method string[]        getOptions()
 * @method string          getOriginCountryCode()
 * @method string          getPostalCode()
 * @method string          getShippingDate()
 * @method string          getShippingDuration()
 * @method string          getStreet()
 * @method GetDeliveryDate getGetDeliveryDate()
 * @method Message         getMessage()
 *
 * @method GetDeliveryDate setAllowSundaySorting(bool $allowSundaySorting)
 * @method GetDeliveryDate setCity(string $city)
 * @method GetDeliveryDate setCountryCode(string $code)
 * @method GetDeliveryDate setCutOffTimes(CutOffTime[] $times)
 * @method GetDeliveryDate setHouseNr(string $houseNr)
 * @method GetDeliveryDate setHouseNrExt(string $houseNrExt)
 * @method GetDeliveryDate setOptions(string[] $options)
 * @method GetDeliveryDate setOriginCountryCode(string $code)
 * @method GetDeliveryDate setPostalCode(string $postcode)
 * @method GetDeliveryDate setShippingDate(string $date)
 * @method GetDeliveryDate setShippingDuration(int $duration)
 * @method GetDeliveryDate setStreet(string $street)
 * @method GetDeliveryDate setGetDeliveryDate(GetDeliveryDate $date)
 * @method GetDeliveryDate setMessage(Message $message)
 */
class GetDeliveryDate extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API
     *
     * @var array $defaultProperties
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'AllowSundaySorting' => BarcodeService::DOMAIN_NAMESPACE,
            'City'               => BarcodeService::DOMAIN_NAMESPACE,
            'CountryCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNr'            => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => BarcodeService::DOMAIN_NAMESPACE,
            'Options'            => BarcodeService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => BarcodeService::DOMAIN_NAMESPACE,
            'PostalCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'ShippingDate'       => BarcodeService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => BarcodeService::DOMAIN_NAMESPACE,
            'Street'             => BarcodeService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => BarcodeService::DOMAIN_NAMESPACE,
            'Message'            => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'AllowSundaySorting' => ConfirmingService::DOMAIN_NAMESPACE,
            'City'               => ConfirmingService::DOMAIN_NAMESPACE,
            'CountryCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNr'            => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'            => ConfirmingService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => ConfirmingService::DOMAIN_NAMESPACE,
            'PostalCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'ShippingDate'       => ConfirmingService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'             => ConfirmingService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => ConfirmingService::DOMAIN_NAMESPACE,
            'Message'            => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'AllowSundaySorting' => LabellingService::DOMAIN_NAMESPACE,
            'City'               => LabellingService::DOMAIN_NAMESPACE,
            'CountryCode'        => LabellingService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => LabellingService::DOMAIN_NAMESPACE,
            'HouseNr'            => LabellingService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => LabellingService::DOMAIN_NAMESPACE,
            'Options'            => LabellingService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => LabellingService::DOMAIN_NAMESPACE,
            'PostalCode'         => LabellingService::DOMAIN_NAMESPACE,
            'ShippingDate'       => LabellingService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => LabellingService::DOMAIN_NAMESPACE,
            'Street'             => LabellingService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => LabellingService::DOMAIN_NAMESPACE,
            'Message'            => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'AllowSundaySorting' => ShippingStatusService::DOMAIN_NAMESPACE,
            'City'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'CountryCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNr'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => ShippingStatusService::DOMAIN_NAMESPACE,
            'PostalCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'ShippingDate'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Street'             => ShippingStatusService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => ShippingStatusService::DOMAIN_NAMESPACE,
            'Message'            => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'AllowSundaySorting' => DeliveryDateService::DOMAIN_NAMESPACE,
            'City'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'CountryCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNr'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => DeliveryDateService::DOMAIN_NAMESPACE,
            'PostalCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'ShippingDate'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'             => DeliveryDateService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => DeliveryDateService::DOMAIN_NAMESPACE,
            'Message'            => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'AllowSundaySorting' => LocationService::DOMAIN_NAMESPACE,
            'City'               => LocationService::DOMAIN_NAMESPACE,
            'CountryCode'        => LocationService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => LocationService::DOMAIN_NAMESPACE,
            'HouseNr'            => LocationService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => LocationService::DOMAIN_NAMESPACE,
            'Options'            => LocationService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => LocationService::DOMAIN_NAMESPACE,
            'PostalCode'         => LocationService::DOMAIN_NAMESPACE,
            'ShippingDate'       => LocationService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => LocationService::DOMAIN_NAMESPACE,
            'Street'             => LocationService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => LocationService::DOMAIN_NAMESPACE,
            'Message'            => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'AllowSundaySorting' => TimeframeService::DOMAIN_NAMESPACE,
            'City'               => TimeframeService::DOMAIN_NAMESPACE,
            'CountryCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'CutOffTimes'        => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNr'            => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => TimeframeService::DOMAIN_NAMESPACE,
            'Options'            => TimeframeService::DOMAIN_NAMESPACE,
            'OriginCountryCode'  => TimeframeService::DOMAIN_NAMESPACE,
            'PostalCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'ShippingDate'       => TimeframeService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => TimeframeService::DOMAIN_NAMESPACE,
            'Street'             => TimeframeService::DOMAIN_NAMESPACE,
            'GetDeliveryDate'    => TimeframeService::DOMAIN_NAMESPACE,
            'Message'            => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var bool $AllowSundaySorting */
    protected $AllowSundaySorting;
    /** @var string $City */
    protected $City;
    /** @var string $CountryCode */
    protected $CountryCode;
    /** @var CutOffTime[] $CutOffTimes */
    protected $CutOffTimes;
    /** @var string $HouseNr */
    protected $HouseNr;
    /** @var string $HouseNrExt */
    protected $HouseNrExt;
    /** @var string[] $Options */
    protected $Options;
    /** @var string $OriginCountryCode */
    protected $OriginCountryCode;
    /** @var string $PostalCode */
    protected $PostalCode;
    /** @var string $ShippingDate */
    protected $ShippingDate;
    /** @var string $ShippingDuration */
    protected $ShippingDuration;
    /** @var string $Street */
    protected $Street;
    /** @var GetDeliveryDate $GetDeliveryDate */
    protected $GetDeliveryDate;
    /** @var Message $Message */
    protected $Message;
    // @codingStandardsIgnoreEnd

    /**
     * GetDeliveryDate constructor.
     *
     * @param bool                 $allowSundaySorting
     * @param string|null          $city
     * @param string|null          $countryCode
     * @param array                $cutOffTimes
     * @param string|null          $houseNr
     * @param string|null          $houseNrExt
     * @param array                $options
     * @param string|null          $originCountryCode
     * @param string|null          $postalCode
     * @param string|null          $shippingDate
     * @param string|null          $shippingDuration
     * @param string|null          $street
     * @param GetDeliveryDate|null $getDeliveryDate
     * @param Message|null         $message
     */
    public function __construct(
        $allowSundaySorting = null,
        $city = null,
        $countryCode = null,
        array $cutOffTimes = null,
        $houseNr = null,
        $houseNrExt = null,
        array $options = null,
        $originCountryCode = null,
        $postalCode = null,
        $shippingDate = null,
        $shippingDuration = null,
        $street = null,
        GetDeliveryDate $getDeliveryDate = null,
        $message = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting($allowSundaySorting);
        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setCutOffTimes($cutOffTimes);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setOptions($options);
        $this->setOriginCountryCode($originCountryCode);
        $this->setPostalCode($postalCode);
        $this->setShippingDate($shippingDate);
        $this->setShippingDuration($shippingDuration);
        $this->setStreet($street);
        $this->setGetDeliveryDate($getDeliveryDate);
        $this->setMessage($message);
    }

    /**
     * Return a serializable array for the XMLWriter
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
            if ($propertyName === 'CutOffTimes') {
                if (isset($this->CutOffTimes)) {
                    $cutOffTimes = [];
                    foreach ($this->CutOffTimes as $cutOffTime) {
                        $cutOffTimes[] = ["{{$namespace}}CutOffTime" => $cutOffTime];
                    }
                    $xml["{{$namespace}}CutOffTimes"] = $cutOffTimes;
                }
            } elseif ($propertyName === 'Options') {
                if (isset($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ["{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string" => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif ($propertyName === 'AllowSundaySorting') {
                if (isset($this->AllowSundaySorting)) {
                    if (is_bool($this->AllowSundaySorting)) {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting;
                    }
                }
            } elseif (!is_null($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}