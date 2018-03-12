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

use Sabre\Xml\Writer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\LabellingService;
use ThirtyBees\PostNL\Service\LocationService;
use ThirtyBees\PostNL\Service\ShippingStatusService;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class Location
 *
 * @package ThirtyBees\PostNL\Entity
 *
 * @method string               getPostalcode()
 * @method Coordinates          getCoordinates()
 * @method CoordinatesNorthWest getCoordinatesNorthWest()
 * @method CoordinatesSouthEast getCoordinatesSouthEast()
 * @method string               getCity()
 * @method string               getStreet()
 * @method string               getHouseNr()
 * @method string               getHouseNrExt()
 * @method string               getAllowSundaySorting()
 * @method string               getDeliveryDate()
 * @method string[]             getDeliveryOptions()
 * @method string               getOpeningTime()
 * @method string[]             getOptions()
 * @method string               getLocationCode()
 * @method string               getSaleschannel()
 * @method string               getTerminalType()
 * @method string               getRetailNetworkID()
 *
 * @method Location setPostalcode(string $postcode)
 * @method Location setCoordinates(Coordinates $coordinates)
 * @method Location setCoordinatesNorthWest(CoordinatesNorthWest $coordinates)
 * @method Location setCoordinatesSouthEast(CoordinatesSouthEast $coordinates)
 * @method Location setCity(string $city)
 * @method Location setStreet(string $street)
 * @method Location setHouseNr(string $houseNr)
 * @method Location setHouseNrExt(string $houseNrExt)
 * @method Location setAllowSundaySorting(string $sundaySorting)
 * @method Location setDeliveryDate(string $deliveryDate)
 * @method Location setDeliveryOptions(string[] $deliveryOptions)
 * @method Location setOpeningTime(string $openingTime)
 * @method Location setOptions(string[] $options)
 * @method Location setLocationCode(string $code)
 * @method Location setSaleschannel(string $channel = null)
 * @method Location setTerminalType(string $type = null)
 * @method Location setRetailNetworkID(string $id)
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
        ],
    ];
    // @codingStandardsIgnoreStart
    /** @var string $AllowSundaySorting */
    protected $AllowSundaySorting;
    /** @var string $DeliveryDate */
    protected $DeliveryDate;
    /** @var string[] $DeliveryOptions */
    protected $DeliveryOptions;
    /** @var string $OpeningTime */
    protected $OpeningTime;
    /** @var string[] $Options */
    protected $Options;
    /** @var string $City */
    protected $City;
    /** @var string $HouseNr */
    protected $HouseNr;
    /** @var string $HouseNrExt */
    protected $HouseNrExt;
    /** @var string $Postalcode */
    protected $Postalcode;
    /** @var string $Street */
    protected $Street;
    /** @var Coordinates $Coordinates */
    protected $Coordinates;
    /** @var CoordinatesNorthWest $CoordinatesNorthWest */
    protected $CoordinatesNorthWest;
    /** @var CoordinatesSouthEast $CoordinatesSouthEast */
    protected $CoordinatesSouthEast;
    /** @var string $LocationCode */
    protected $LocationCode;
    /** @var string $Saleschannel */
    protected $Saleschannel;
    /** @var string $TerminalType */
    protected $TerminalType;
    /** @var string $RetailNetworkID */
    protected $RetailNetworkID;
    // @codingStandardsIgnoreEnd

    /**
     * @param string               $zipcode
     * @param string               $allowSundaySorting
     * @param string               $deliveryDate
     * @param array                $deliveryOptions
     * @param array                $options
     * @param Coordinates          $coordinates
     * @param CoordinatesNorthWest $coordinatesNW
     * @param CoordinatesSouthEast $coordinatesSE
     * @param string               $city
     * @param string               $street
     * @param string               $houseNr
     * @param string               $houseNrExt
     * @param string               $locationCode
     * @param string               $saleschannel
     * @param string               $terminalType
     * @param string               $retailNetworkId
     */
    public function __construct(
        $zipcode = null,
        $allowSundaySorting = null,
        $deliveryDate = null,
        array $deliveryOptions = null,
        array $options = null,
        Coordinates $coordinates = null,
        CoordinatesNorthWest $coordinatesNW = null,
        CoordinatesSouthEast $coordinatesSE = null,
        $city = null,
        $street = null,
        $houseNr = null,
        $houseNrExt = null,
        $locationCode = null,
        $saleschannel = null,
        $terminalType = null,
        $retailNetworkId = null
    ) {
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
            if ($propertyName === 'Options') {
                if (is_array($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ["{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string" => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }

            } elseif ($propertyName === 'DeliveryOptions') {
                if (is_array($this->DeliveryOptions)) {
                    $options = [];
                    foreach ($this->DeliveryOptions as $option) {
                        $options[] = ["{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string" => $option];
                    }
                    $xml["{{$namespace}}DeliveryOptions"] = $options;
                }

            } elseif ($propertyName === 'AllowSundaySorting') {
                if (isset($this->AllowSundaySorting)) {
                    if (is_bool($this->AllowSundaySorting)) {
                        $xml["{{$namespace}}AllowSundaySorting"] = $this->AllowSundaySorting ? 'true' : 'false';
                    } else {
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
