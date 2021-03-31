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
use DateTimeZone;
use Exception;
use Sabre\Xml\Writer;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class GetSentDate.
 *
 * @method bool|null              getAllowSundaySorting()
 * @method string|null            getCity()
 * @method string|null            getCountryCode()
 * @method string|null            getHouseNr()
 * @method string|null            getHouseNrExt()
 * @method string[]|null          getOptions()
 * @method string|null            getPostalCode()
 * @method DateTimeInterface|null getDeliveryDate()
 * @method string|null            getShippingDuration()
 * @method string|null            getStreet()
 * @method GetSentDate            setAllowSundaySorting(bool|null $AllowSundaySorting = null)
 * @method GetSentDate            setCity(string|null $City = null)
 * @method GetSentDate            setCountryCode(string|null $CountryCode = null)
 * @method GetSentDate            setHouseNr(string|null $HouseNr = null)
 * @method GetSentDate            setHouseNrExt(string|null $HouseNrExt = null)
 * @method GetSentDate            setOptions(array|null $Options = null)
 * @method GetSentDate            setShippingDuration(string|null $ShippingDuration = null)
 * @method GetSentDate            setStreet(string|null $Street = null)
 *
 * @since 1.0.0
 */
class GetSentDate extends AbstractEntity
{
    /**
     * Default properties and namespaces for the SOAP API.
     *
     * @var array
     */
    public static $defaultProperties = [
        'Barcode'        => [
            'AllowSundaySorting' => BarcodeService::DOMAIN_NAMESPACE,
            'City'               => BarcodeService::DOMAIN_NAMESPACE,
            'CountryCode'        => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNr'            => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => BarcodeService::DOMAIN_NAMESPACE,
            'Options'            => BarcodeService::DOMAIN_NAMESPACE,
            'PostalCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => BarcodeService::DOMAIN_NAMESPACE,
            'Street'             => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'AllowSundaySorting' => ConfirmingService::DOMAIN_NAMESPACE,
            'City'               => ConfirmingService::DOMAIN_NAMESPACE,
            'CountryCode'        => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNr'            => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'            => ConfirmingService::DOMAIN_NAMESPACE,
            'PostalCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'             => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'AllowSundaySorting' => LabellingService::DOMAIN_NAMESPACE,
            'City'               => LabellingService::DOMAIN_NAMESPACE,
            'CountryCode'        => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => LabellingService::DOMAIN_NAMESPACE,
            'HouseNr'            => LabellingService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => LabellingService::DOMAIN_NAMESPACE,
            'Options'            => LabellingService::DOMAIN_NAMESPACE,
            'PostalCode'         => LabellingService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => LabellingService::DOMAIN_NAMESPACE,
            'Street'             => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'AllowSundaySorting' => ShippingStatusService::DOMAIN_NAMESPACE,
            'City'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'CountryCode'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNr'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'            => ShippingStatusService::DOMAIN_NAMESPACE,
            'PostalCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'Street'             => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'AllowSundaySorting' => DeliveryDateService::DOMAIN_NAMESPACE,
            'City'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'CountryCode'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNr'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'            => DeliveryDateService::DOMAIN_NAMESPACE,
            'PostalCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'             => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'AllowSundaySorting' => LocationService::DOMAIN_NAMESPACE,
            'City'               => LocationService::DOMAIN_NAMESPACE,
            'CountryCode'        => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => LocationService::DOMAIN_NAMESPACE,
            'HouseNr'            => LocationService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => LocationService::DOMAIN_NAMESPACE,
            'Options'            => LocationService::DOMAIN_NAMESPACE,
            'PostalCode'         => LocationService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => LocationService::DOMAIN_NAMESPACE,
            'Street'             => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'AllowSundaySorting' => TimeframeService::DOMAIN_NAMESPACE,
            'City'               => TimeframeService::DOMAIN_NAMESPACE,
            'CountryCode'        => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'       => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNr'            => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNrExt'         => TimeframeService::DOMAIN_NAMESPACE,
            'Options'            => TimeframeService::DOMAIN_NAMESPACE,
            'PostalCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'ShippingDuration'   => TimeframeService::DOMAIN_NAMESPACE,
            'Street'             => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var bool|null */
    protected $AllowSundaySorting;
    /** @var string|null */
    protected $City;
    /** @var string|null */
    protected $CountryCode;
    /** @var DateTimeInterface|null */
    protected $DeliveryDate;
    /** @var string|null */
    protected $HouseNr;
    /** @var string|null */
    protected $HouseNrExt;
    /** @var string[]|null */
    protected $Options;
    /** @var string|null */
    protected $PostalCode;
    /** @var string|null */
    protected $ShippingDuration;
    /** @var string|null */
    protected $Street;
    // @codingStandardsIgnoreEnd

    /**
     * GetSentDate constructor.
     *
     * @param bool|null                     $AllowSundaySorting
     * @param string|null                   $City
     * @param string|null                   $CountryCode
     * @param string|null                   $HouseNr
     * @param string|null                   $HouseNrExt
     * @param array|null                    $Options
     * @param string|null                   $PostalCode
     * @param DateTimeInterface|string|null $DeliveryDate
     * @param string|null                   $Street
     * @param string|null                   $ShippingDuration
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $AllowSundaySorting = false,
        $City = null,
        $CountryCode = null,
        $HouseNr = null,
        $HouseNrExt = null,
        array $Options = null,
        $PostalCode = null,
        $DeliveryDate = null,
        $Street = null,
        $ShippingDuration = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting($AllowSundaySorting);
        $this->setCity($City);
        $this->setCountryCode($CountryCode);
        $this->setHouseNr($HouseNr);
        $this->setHouseNrExt($HouseNrExt);
        $this->setOptions($Options);
        $this->setPostalCode($PostalCode);
        $this->setDeliveryDate($DeliveryDate);
        $this->setStreet($Street);
        $this->setShippingDuration($ShippingDuration);
    }

    /**
     * @param string|DateTimeInterface|null $deliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate($deliveryDate = null)
    {
        if (is_string($deliveryDate)) {
            try {
                $deliveryDate = new DateTimeImmutable($deliveryDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryDate = $deliveryDate;

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
            if ('DeliveryDate' === $propertyName) {
                if ($this->DeliveryDate instanceof DateTimeInterface) {
                    $xml["{{$namespace}}DeliveryDate"] = $this->DeliveryDate->format('d-m-Y');
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
                $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
            } elseif (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
