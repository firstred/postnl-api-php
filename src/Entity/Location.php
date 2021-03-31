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
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\DeliveryDateService;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LocationService;
use Firstred\PostNL\Service\TimeframeService;
use Sabre\Xml\Writer;

/**
 * Class Location.
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
 * @method DateTimeInterface|null    getDeliveryDate()
 * @method string[]|null             getDeliveryOptions()
 * @method string|null               getOpeningTime()
 * @method string[]|null             getOptions()
 * @method string|null               getLocationCode()
 * @method string|null               getSaleschannel()
 * @method string|null               getTerminalType()
 * @method string|null               getRetailNetworkID()
 * @method string|null               getDownPartnerID()
 * @method string|null               getDownPartnerLocation()
 * @method Location                  setCoordinates(Coordinates|null $Coordinates = null)
 * @method Location                  setCoordinatesNorthWest(CoordinatesNorthWest|null $CoordinatesNorthWest = null)
 * @method Location                  setCoordinatesSouthEast(CoordinatesSouthEast|null $coordinatesSouthEast = null)
 * @method Location                  setCity(string|null $City = null)
 * @method Location                  setStreet(string|null $Street = null)
 * @method Location                  setHouseNr(string|null $HouseNr = null)
 * @method Location                  setHouseNrExt(string|null $HouseNrExt = null)
 * @method Location                  setAllowSundaySorting(string|null $AllowSundaySorting = null)
 * @method Location                  setDeliveryOptions(string[]|null $DeliveryOptions = null)
 * @method Location                  setOpeningTime(string|null $OpeningTime = null)
 * @method Location                  setOptions(string[]|null $Options = null)
 * @method Location                  setLocationCode(string|null $LocationCode = null)
 * @method Location                  setSaleschannel(string|null $Saleschannel = null)
 * @method Location                  setTerminalType(string|null $TerminalType = null)
 * @method Location                  setRetailNetworkID(string|null $RetailNetworkID = null)
 * @method Location                  setDownPartnerID(string|null $DownPartnerID = null)
 * @method Location                  setDownPartnerLocation(string|null $DownPartnerLocation = null)
 *
 * @since 1.0.0
 */
class Location extends AbstractEntity
{
    /** @var string[][] */
    public static $defaultProperties = [
        'Barcode' => [
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
        'Confirming' => [
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
        'Labelling' => [
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
        'DeliveryDate' => [
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
        'Location' => [
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
        'Timeframe' => [
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
    /** @var string|null */
    protected $AllowSundaySorting;
    /** @var string|null */
    protected $DeliveryDate;
    /** @var string[]|null */
    protected $DeliveryOptions;
    /** @var string|null */
    protected $OpeningTime;
    /** @var string[]|null */
    protected $Options;
    /** @var string|null */
    protected $City;
    /** @var string|null */
    protected $HouseNr;
    /** @var string|null */
    protected $HouseNrExt;
    /** @var string|null */
    protected $Postalcode;
    /** @var string|null */
    protected $Street;
    /** @var Coordinates|null */
    protected $Coordinates;
    /** @var CoordinatesNorthWest|null */
    protected $CoordinatesNorthWest;
    /** @var CoordinatesSouthEast|null */
    protected $CoordinatesSouthEast;
    /** @var string|null */
    protected $LocationCode;
    /** @var string|null */
    protected $Saleschannel;
    /** @var string|null */
    protected $TerminalType;
    /** @var string|null */
    protected $RetailNetworkID;
    /** @var string|null */
    protected $DownPartnerID;
    /** @var string|null */
    protected $DownPartnerLocation;
    // @codingStandardsIgnoreEnd

    /**
     * @param string|null                   $Postalcode
     * @param string|null                   $AllowSundaySorting
     * @param string|DateTimeInterface|null $DeliveryDate
     * @param array|null                    $DeliveryOptions
     * @param array|null                    $Options
     * @param Coordinates|null              $Coordinates
     * @param CoordinatesNorthWest|null     $CoordinatesNorthWest
     * @param CoordinatesSouthEast|null     $CoordinatesSouthEast
     * @param string|null                   $City
     * @param string|null                   $Street
     * @param string|null                   $HouseNr
     * @param string|null               $HouseNrExt
     * @param string|null               $LocationCode
     * @param string|null               $Saleschannel
     * @param string|null               $TerminalType
     * @param string|null               $RetailNetworkID
     * @param string|null               $DownPartnerID
     * @param string|null               $DownPartnerLocation
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        $Postalcode = null,
        $AllowSundaySorting = null,
        $DeliveryDate = null,
        array $DeliveryOptions = null,
        array $Options = null,
        Coordinates $Coordinates = null,
        CoordinatesNorthWest $CoordinatesNorthWest = null,
        CoordinatesSouthEast $CoordinatesSouthEast = null,
        $City = null,
        $Street = null,
        $HouseNr = null,
        $HouseNrExt = null,
        $LocationCode = null,
        $Saleschannel = null,
        $TerminalType = null,
        $RetailNetworkID = null,
        $DownPartnerID = null,
        $DownPartnerLocation = null
    ) {
        parent::__construct();

        $this->setAllowSundaySorting($AllowSundaySorting);
        try {
            $this->setDeliveryDate($DeliveryDate ?: (new DateTimeImmutable('next monday', new DateTimeZone('Europe/Amsterdam'))));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), 0, $e);
        }
        $this->setDeliveryOptions($DeliveryOptions);
        $this->setOptions($Options);
        $this->setPostalcode($Postalcode);
        $this->setCoordinates($Coordinates);
        $this->setCoordinatesNorthWest($CoordinatesNorthWest);
        $this->setCoordinatesSouthEast($CoordinatesSouthEast);
        $this->setCity($City);
        $this->setStreet($Street);
        $this->setHouseNr($HouseNr);
        $this->setHouseNrExt($HouseNrExt);
        $this->setLocationCode($LocationCode);
        $this->setSaleschannel($Saleschannel);
        $this->setTerminalType($TerminalType);
        $this->setRetailNetworkID($RetailNetworkID);
        $this->setDownPartnerID($DownPartnerID);
        $this->setDownPartnerLocation($DownPartnerLocation);
    }

    /**
     * @param string|DateTimeInterface|null $DeliveryDate
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public function setDeliveryDate($DeliveryDate = null)
    {
        if (is_string($DeliveryDate)) {
            try {
                $DeliveryDate = new DateTimeImmutable($DeliveryDate, new DateTimeZone('Europe/Amsterdam'));
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), 0, $e);
            }
        }

        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    /**
     * Set the postcode.
     *
     * @param string|null $Postalcode
     *
     * @return Location
     */
    public function setPostalcode($Postalcode = null)
    {
        if (is_null($Postalcode)) {
            $this->Postalcode = null;
        } else {
            $this->Postalcode = strtoupper(str_replace(' ', '', $Postalcode));
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
                if ($this->DeliveryDate instanceof DateTimeImmutable) {
                    $xml["{{$namespace}}DeliveryDate"] = $this->DeliveryDate->format('d-m-Y');
                }
            } elseif ('Options' === $propertyName) {
                if (is_array($this->Options)) {
                    $options = [];
                    foreach ($this->Options as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}Options"] = $options;
                }
            } elseif ('DeliveryOptions' === $propertyName) {
                if (is_array($this->DeliveryOptions)) {
                    $options = [];
                    foreach ($this->DeliveryOptions as $option) {
                        $options[] = ['{http://schemas.microsoft.com/2003/10/Serialization/Arrays}string' => $option];
                    }
                    $xml["{{$namespace}}DeliveryOptions"] = $options;
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
