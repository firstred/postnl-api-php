<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\ShippingStatusService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class Location
 *
 * @method string|null               getPostalcode()
 * @method Coordinates|null          getCoordinates()
 * @method CoordinatesNorthWest|null getCoordinatesNorthWest()
 * @method CoordinatesSouthEast|null getCoordinatesSouthEast()
 * @method string|null               getCity()
 * @method string|null               getStreet()
 * @method string|null               getHouseNr()
 * @method string|null               getHouseNrExt()
 * @method string|null               getAllowSundaySorting()
 * @method string|null               getDeliveryDate()
 * @method string[]|null             getDeliveryOptions()
 * @method string|null               getOpeningTime()
 * @method string[]|null             getOptions()
 * @method string|null               getLocationCode()
 * @method string|null               getSaleschannel()
 * @method string|null               getTerminalType()
 * @method string|null               getRetailNetworkID()
 * @method string|null               getDownPartnerID()
 * @method string|null               getDownPartnerLocation()
 *
 * @method Location setCoordinates(Coordinates|null $coordinates = null)
 * @method Location setCoordinatesNorthWest(CoordinatesNorthWest|null $coordinates = null)
 * @method Location setCoordinatesSouthEast(CoordinatesSouthEast|null $coordinates = null)
 * @method Location setCity(string|null $city = null)
 * @method Location setStreet(string|null $street = null)
 * @method Location setHouseNr(string|null $houseNr = null)
 * @method Location setHouseNrExt(string|null $houseNrExt = null)
 * @method Location setAllowSundaySorting(string|null $sundaySorting = null)
 * @method Location setDeliveryDate(string|null $deliveryDate = null)
 * @method Location setDeliveryOptions(string[]|null $deliveryOptions = null)
 * @method Location setOpeningTime(string|null $openingTime = null)
 * @method Location setOptions(string[]|null $options = null)
 * @method Location setLocationCode(string|null $code = null)
 * @method Location setSaleschannel(string|null $channel = null)
 * @method Location setTerminalType(string|null $type = null)
 * @method Location setRetailNetworkID(string|null $id = null)
 * @method Location setDownPartnerID(string|null $id = null)
 * @method Location setDownPartnerLocation(string|null $location = null)
 */
class Location extends AbstractEntity
{
    /** @var string[][] $defaultProperties */
    public static $defaultProperties = [
        'Barcode'        => [
            'AllowSundaySorting'   => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => BarcodeService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => BarcodeService::DOMAIN_NAMESPACE,
            'OpeningTime'          => BarcodeService::DOMAIN_NAMESPACE,
            'Options'              => BarcodeService::DOMAIN_NAMESPACE,
            'City'                 => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNr'              => BarcodeService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => BarcodeService::DOMAIN_NAMESPACE,
            'Postalcode'           => BarcodeService::DOMAIN_NAMESPACE,
            'Street'               => BarcodeService::DOMAIN_NAMESPACE,
            'Coordinates'          => BarcodeService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => BarcodeService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => BarcodeService::DOMAIN_NAMESPACE,
            'LocationCode'         => BarcodeService::DOMAIN_NAMESPACE,
            'Saleschannel'         => BarcodeService::DOMAIN_NAMESPACE,
            'TerminalType'         => BarcodeService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => BarcodeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => BarcodeService::DOMAIN_NAMESPACE,
        ],
        'Confirming'     => [
            'AllowSundaySorting'   => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => ConfirmingService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => ConfirmingService::DOMAIN_NAMESPACE,
            'OpeningTime'          => ConfirmingService::DOMAIN_NAMESPACE,
            'Options'              => ConfirmingService::DOMAIN_NAMESPACE,
            'City'                 => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNr'              => ConfirmingService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => ConfirmingService::DOMAIN_NAMESPACE,
            'Postalcode'           => ConfirmingService::DOMAIN_NAMESPACE,
            'Street'               => ConfirmingService::DOMAIN_NAMESPACE,
            'Coordinates'          => ConfirmingService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => ConfirmingService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => ConfirmingService::DOMAIN_NAMESPACE,
            'LocationCode'         => ConfirmingService::DOMAIN_NAMESPACE,
            'Saleschannel'         => ConfirmingService::DOMAIN_NAMESPACE,
            'TerminalType'         => ConfirmingService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => ConfirmingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => ConfirmingService::DOMAIN_NAMESPACE,
        ],
        'Labelling'      => [
            'AllowSundaySorting'   => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => LabellingService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => LabellingService::DOMAIN_NAMESPACE,
            'OpeningTime'          => LabellingService::DOMAIN_NAMESPACE,
            'Options'              => LabellingService::DOMAIN_NAMESPACE,
            'City'                 => LabellingService::DOMAIN_NAMESPACE,
            'HouseNr'              => LabellingService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => LabellingService::DOMAIN_NAMESPACE,
            'Postalcode'           => LabellingService::DOMAIN_NAMESPACE,
            'Street'               => LabellingService::DOMAIN_NAMESPACE,
            'Coordinates'          => LabellingService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => LabellingService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => LabellingService::DOMAIN_NAMESPACE,
            'LocationCode'         => LabellingService::DOMAIN_NAMESPACE,
            'Saleschannel'         => LabellingService::DOMAIN_NAMESPACE,
            'TerminalType'         => LabellingService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => LabellingService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => LabellingService::DOMAIN_NAMESPACE,
        ],
        'ShippingStatus' => [
            'AllowSundaySorting'   => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'OpeningTime'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'Options'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'City'                 => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNr'              => ShippingStatusService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'Postalcode'           => ShippingStatusService::DOMAIN_NAMESPACE,
            'Street'               => ShippingStatusService::DOMAIN_NAMESPACE,
            'Coordinates'          => ShippingStatusService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => ShippingStatusService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => ShippingStatusService::DOMAIN_NAMESPACE,
            'LocationCode'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'Saleschannel'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'TerminalType'         => ShippingStatusService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => ShippingStatusService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => ShippingStatusService::DOMAIN_NAMESPACE,
        ],
        'DeliveryDate'   => [
            'AllowSundaySorting'   => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'OpeningTime'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'Options'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'City'                 => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNr'              => DeliveryDateService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'Postalcode'           => DeliveryDateService::DOMAIN_NAMESPACE,
            'Street'               => DeliveryDateService::DOMAIN_NAMESPACE,
            'Coordinates'          => DeliveryDateService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => DeliveryDateService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => DeliveryDateService::DOMAIN_NAMESPACE,
            'LocationCode'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'Saleschannel'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'TerminalType'         => DeliveryDateService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => DeliveryDateService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => DeliveryDateService::DOMAIN_NAMESPACE,
        ],
        'Location'       => [
            'AllowSundaySorting'   => LocationService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => LocationService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => LocationService::DOMAIN_NAMESPACE,
            'OpeningTime'          => LocationService::DOMAIN_NAMESPACE,
            'Options'              => LocationService::DOMAIN_NAMESPACE,
            'City'                 => LocationService::DOMAIN_NAMESPACE,
            'HouseNr'              => LocationService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => LocationService::DOMAIN_NAMESPACE,
            'Postalcode'           => LocationService::DOMAIN_NAMESPACE,
            'Street'               => LocationService::DOMAIN_NAMESPACE,
            'Coordinates'          => LocationService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => LocationService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => LocationService::DOMAIN_NAMESPACE,
            'LocationCode'         => LocationService::DOMAIN_NAMESPACE,
            'Saleschannel'         => LocationService::DOMAIN_NAMESPACE,
            'TerminalType'         => LocationService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => LocationService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => LocationService::DOMAIN_NAMESPACE,
        ],
        'Timeframe'      => [
            'AllowSundaySorting'   => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryDate'         => TimeframeService::DOMAIN_NAMESPACE,
            'DeliveryOptions'      => TimeframeService::DOMAIN_NAMESPACE,
            'OpeningTime'          => TimeframeService::DOMAIN_NAMESPACE,
            'Options'              => TimeframeService::DOMAIN_NAMESPACE,
            'City'                 => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNr'              => TimeframeService::DOMAIN_NAMESPACE,
            'HouseNrExt'           => TimeframeService::DOMAIN_NAMESPACE,
            'Postalcode'           => TimeframeService::DOMAIN_NAMESPACE,
            'Street'               => TimeframeService::DOMAIN_NAMESPACE,
            'Coordinates'          => TimeframeService::DOMAIN_NAMESPACE,
            'CoordinatesNorthWest' => TimeframeService::DOMAIN_NAMESPACE,
            'CoordinatesSouthEast' => TimeframeService::DOMAIN_NAMESPACE,
            'LocationCode'         => TimeframeService::DOMAIN_NAMESPACE,
            'Saleschannel'         => TimeframeService::DOMAIN_NAMESPACE,
            'TerminalType'         => TimeframeService::DOMAIN_NAMESPACE,
            'RetailNetworkID'      => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerID'        => TimeframeService::DOMAIN_NAMESPACE,
            'DownPartnerLocation'  => TimeframeService::DOMAIN_NAMESPACE,
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string|null $AllowSundaySorting */
    protected $AllowSundaySorting;
    /** @var string|null $DeliveryDate */
    protected $DeliveryDate;
    /** @var string[]|null $DeliveryOptions */
    protected $DeliveryOptions;
    /** @var string|null $OpeningTime */
    protected $OpeningTime;
    /** @var string[]|null $Options */
    protected $Options;
    /** @var string|null $City */
    protected $City;
    /** @var string|null $HouseNr */
    protected $HouseNr;
    /** @var string|null $HouseNrExt */
    protected $HouseNrExt;
    /** @var string|null $Postalcode */
    protected $Postalcode;
    /** @var string|null $Street */
    protected $Street;
    /** @var Coordinates|null $Coordinates */
    protected $Coordinates;
    /** @var CoordinatesNorthWest|null $CoordinatesNorthWest */
    protected $CoordinatesNorthWest;
    /** @var CoordinatesSouthEast|null $CoordinatesSouthEast */
    protected $CoordinatesSouthEast;
    /** @var string|null $LocationCode */
    protected $LocationCode;
    /** @var string|null $Saleschannel */
    protected $Saleschannel;
    /** @var string|null $TerminalType */
    protected $TerminalType;
    /** @var string|null $RetailNetworkID */
    protected $RetailNetworkID;
    /** @var string|null $DownPartnerID */
    protected $DownPartnerID;
    /** @var string|null $DownPartnerLocation */
    protected $DownPartnerLocation;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null               $zipcode
     * @param string|null               $allowSundaySorting
     * @param string|null               $deliveryDate
     * @param array|null                $deliveryOptions
     * @param array|null                $options
     * @param Coordinates|null          $coordinates
     * @param CoordinatesNorthWest|null $coordinatesNW
     * @param CoordinatesSouthEast|null $coordinatesSE
     * @param string|null               $city
     * @param string|null               $street
     * @param string|null               $houseNr
     * @param string|null               $houseNrExt
     * @param string|null               $locationCode
     * @param string|null               $saleschannel
     * @param string|null               $terminalType
     * @param string|null               $retailNetworkId
     * @param string|null               $downPartnerID
     * @param string|null               $downPartnerLocation
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function __construct(?string $zipcode = null, ?string $allowSundaySorting = null, ?string $deliveryDate = null, ?array $deliveryOptions = null, ?array $options = null, ?Coordinates $coordinates = null, ?CoordinatesNorthWest $coordinatesNW = null, ?CoordinatesSouthEast $coordinatesSE = null, ?string $city = null, ?string $street = null, ?string $houseNr = null, ?string $houseNrExt = null, ?string $locationCode = null, ?string $saleschannel = null, ?string $terminalType = null, ?string $retailNetworkId = null, ?string $downPartnerID = null, ?string $downPartnerLocation = null)
    {
        parent::__construct();

        $this->setAllowSundaySorting($allowSundaySorting);
        $this->setDeliveryDate($deliveryDate ?: (new \DateTime('next monday'))->format('d-m-Y'));
        $this->setDeliveryOptions($deliveryOptions);
        $this->setOptions($options);
        $this->setPostalcode($zipcode);
        $this->setCoordinates($coordinates);
        $this->setCoordinatesNorthWest($coordinatesNW);
        $this->setCoordinatesSouthEast($coordinatesSE);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setLocationCode($locationCode);
        $this->setSaleschannel($saleschannel);
        $this->setTerminalType($terminalType);
        $this->setRetailNetworkID($retailNetworkId);
        $this->setDownPartnerID($downPartnerID);
        $this->setDownPartnerLocation($downPartnerLocation);
    }

    /**
     * Set the postcode
     *
     * @param string|null $postcode
     *
     * @return Location
     */
    public function setPostalcode($postcode = null)
    {
        if (is_null($postcode)) {
            // @codingStandardsIgnoreLine
            $this->Postalcode = null;
        } else {
            // @codingStandardsIgnoreLine
            $this->Postalcode = strtoupper(str_replace(' ', '', $postcode));
        }

        return $this;
    }

    /**
     * Return a serializable array for the XMLWriter
     *
     * @param Writer $writer
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            $writer->write($xml);

            return;
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if ('Options' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (is_array($this->Options)) {
                    $options = [];
                    // @codingStandardsIgnoreLine
                    foreach ($this->Options as $option) {
                        $options[] = ["{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string" => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif ('DeliveryOptions' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (is_array($this->DeliveryOptions)) {
                    $options = [];
                    // @codingStandardsIgnoreLine
                    foreach ($this->DeliveryOptions as $option) {
                        $options[] = ["{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string" => $option];
                    }
                    $xml["{{$namespace}}DeliveryOptions"] = $options;
                }
            } elseif ('AllowSundaySorting' === $propertyName) {
                // @codingStandardsIgnoreLine
                if (isset($this->AllowSundaySorting)) {
                    // @codingStandardsIgnoreLine
                    if (is_bool($this->AllowSundaySorting)) {
                        // @codingStandardsIgnoreLine
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
                    } else {
                        // @codingStandardsIgnoreLine
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting;
                    }
                }
            } elseif (isset($this->{$propertyName})) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->{$propertyName};
            }
        }
        // Auto extending this object with other properties is not supported with SOAP
        $writer->write($xml);
    }
}
