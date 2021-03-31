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

namespace Firstred\PostNL\Entity\Request;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Sabre\Xml\Writer;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class GetDeliveryDate.
 *
 * This class is both the container and can be the actual GetDeliveryDate object itself!
 *
 * @method bool|null              getAllowSundaySorting()
 * @method string|null            getCity()
 * @method string|null            getCountryCode()
 * @method CutOffTime[]|null      getCutOffTimes()
 * @method string|null            getHouseNr()
 * @method string|null            getHouseNrExt()
 * @method string[]|null          getOptions()
 * @method string|null            getOriginCountryCode()
 * @method string|null            getPostalCode()
 * @method DateTimeInterface|null getShippingDate()
 * @method string|null            getShippingDuration()
 * @method string|null            getStreet()
 * @method GetDeliveryDate|null   getGetDeliveryDate()
 * @method Message|null           getMessage()
 * @method GetDeliveryDate        setAllowSundaySorting(bool|null $AllowSundaySorting = null)
 * @method GetDeliveryDate        setCity(string|null $City = null)
 * @method GetDeliveryDate        setCountryCode(string|null $CountryCode = null)
 * @method GetDeliveryDate        setCutOffTimes(CutOffTime[]|null $CutOffTimes = null)
 * @method GetDeliveryDate        setHouseNr(string|null $HouseNr = null)
 * @method GetDeliveryDate        setHouseNrExt(string|null $HouseNrExt = null)
 * @method GetDeliveryDate        setOptions(string[]|null $Options = null)
 * @method GetDeliveryDate        setOriginCountryCode(string|null $OriginCountryCode = null)
 * @method GetDeliveryDate        setShippingDuration(int|null $ShippingDuration = null)
 * @method GetDeliveryDate        setStreet(string|null $Street = null)
 * @method GetDeliveryDate        setGetDeliveryDate(GetDeliveryDate|null $GetDeliveryDate = null)
 * @method GetDeliveryDate        setMessage(Message|null $Message = null)
 *
 * @since 1.0.0
 */
class GetDeliveryDate extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode' => [
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
        'Confirming' => [
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
        'Labelling' => [
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
        'DeliveryDate' => [
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
        'Location' => [
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
        'Timeframe' => [
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
    /** @var bool|null */
    protected $AllowSundaySorting;
    /** @var string|null */
    protected $City;
    /** @var string|null */
    protected $CountryCode;
    /** @var CutOffTime[]|null */
    protected $CutOffTimes;
    /** @var string|null */
    protected $HouseNr;
    /** @var string|null */
    protected $HouseNrExt;
    /** @var string[]|null */
    protected $Options;
    /** @var string|null */
    protected $OriginCountryCode;
    /** @var string|null */
    protected $PostalCode;
    /** @var DateTimeInterface|null */
    protected $ShippingDate;
    /** @var string|null */
    protected $ShippingDuration;
    /** @var string|null */
    protected $Street;
    /** @var GetDeliveryDate|null */
    protected $GetDeliveryDate;
    /** @var Message|null */
    protected $Message;
    // @codingStandardsIgnoreEnd

    /**
     * GetDeliveryDate constructor.
     *
     * @param bool|null                     $AllowSundaySorting
     * @param string|null                   $City
     * @param string|null                   $CountryCode
     * @param array|null                    $CutOffTimes
     * @param string|null                   $HouseNr
     * @param string|null                   $HouseNrExt
     * @param array|null                    $Options
     * @param string|null                   $OriginCountryCode
     * @param string|null                   $PostalCode
     * @param DateTimeInterface|string|null $ShippingDate
     * @param string|null                   $ShippingDuration
     * @param string|null                   $Street
     * @param GetDeliveryDate|null          $GetDeliveryDate
     * @param Message|null                  $Message
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $AllowSundaySorting = null,
        $City = null,
        $CountryCode = null,
        array $CutOffTimes = null,
        $HouseNr = null,
        $HouseNrExt = null,
        array $Options = null,
        $OriginCountryCode = null,
        $PostalCode = null,
        $ShippingDate = null,
        $ShippingDuration = null,
        $Street = null,
        GetDeliveryDate $GetDeliveryDate = null,
        $Message = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting($AllowSundaySorting);
        $this->setCity($City);
        $this->setCountryCode($CountryCode);
        $this->setCutOffTimes($CutOffTimes);
        $this->setHouseNr($HouseNr);
        $this->setHouseNrExt($HouseNrExt);
        $this->setOptions($Options);
        $this->setOriginCountryCode($OriginCountryCode);
        $this->setPostalCode($PostalCode);
        $this->setShippingDate($ShippingDate);
        $this->setShippingDuration($ShippingDuration);
        $this->setStreet($Street);
        $this->setGetDeliveryDate($GetDeliveryDate);
        $this->setMessage($Message);
    }

    /**
     * @param string|DateTimeInterface|null $shippingDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setShippingDate($shippingDate = null)
    {
        if (is_string($shippingDate)) {
            try {
                $shippingDate = new DateTimeImmutable($shippingDate);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->ShippingDate = $shippingDate;

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
            if ('CutOffTimes' === $propertyName) {
                if (isset($this->CutOffTimes)) {
                    $cutOffTimes = [];
                    foreach ($this->CutOffTimes as $cutOffTime) {
                        $cutOffTimes[] = ["{{$namespace}}CutOffTime" => $cutOffTime];
                    }
                    $xml["{{$namespace}}CutOffTimes"] = $cutOffTimes;
                }
            } elseif ('Options' === $propertyName) {
                if (isset($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif ('AllowSundaySorting' === $propertyName) {
                if (isset($this->AllowSundaySorting)) {
                    if (is_bool($this->AllowSundaySorting)) {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
                    } else {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting;
                    }
                }
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
