<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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

use DateTime;
use Firstred\PostNL\Exception\InvalidTypeException;
use Firstred\PostNL\Misc\ValidateAndFix;
use ReflectionException;
use TypeError;

/**
 * Class Location
 */
class Location extends AbstractEntity
{
    /**
     * Country code of the location
     *
     * Can be NL or BE
     *
     * @pattern ^(?:NL|BE)$
     *
     * @example NL
     *
     * @var string|null $countryCode
     *
     * @since 1.0.0
     */
    protected $countryCode;

    /**
     * Delivery Date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @example 04-06-2019
     *
     * @var string|null $deliveryDate
     *
     * @since 1.0.0
     */
    protected $deliveryDate;

    /**
     * Distance in meters
     *
     * @pattern ^\d{1,10}$
     *
     * @example 1200
     *
     * @var int|null $distance
     *
     * @since   2.0.0
     */
    protected $distance;

    /**
     * Delivery Options
     *
     * Available values:
     *
     * - PG: Pick up at PostNL location (in Dutch: Ophalen bij  PostNL Locatie)
     * - PGE: Pick up at PostNL location Express (in Dutch: Extra Vroeg Ophalen)
     * - KEL: Customer own location (in Dutch: Klant Eigen Locatie
     *
     * The delivery options UL, PU and DO can be shown in the response. Please ignore these codes. These codes are internal PostNL codes.
     *
     * Restrictions
     *
     * It is not possible to offer the opportunity PG (Pick up at PostNL location) on a Sunday. So it may be possible that a location is open on Sunday, but parcels will not be delivered on Sundays at PostNL locations.
     *
     * Also the combination Monday delivery and PGE (Pick up at PostNL location Express) is not possible, because the parcels will not be delivered before Monday morning 08:30 am.
     *
     * @pattern ^.{0,35}$
     *
     * @example PGE
     *
     * @var string[]|null $deliveryOptions
     *
     * @since 1.0.0
     */
    protected $deliveryOptions;

    /**
     * The latitude of the location
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $latitude
     *
     * @since   1.0.0
     */
    protected $latitude;

    /**
     * The longitude of the location
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 5.015643
     *
     * @var float|null $longitude
     *
     * @since   1.0.0
     */
    protected $longitude;

    /**
     * The coordinates of the north point of the area.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $latitudeNorthq
     *
     * @since   1.0.0
     */
    protected $latitudeNorth;

    /**
     * The coordinates of the west point of the area.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 5.015643
     *
     * @var float|null $longitudeWest
     *
     * @since   1.0.0
     */
    protected $longitudeWest;

    /**
     * The coordinates of the south point of the area.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 52.156439
     *
     * @var float|null $latitudeSouth
     *
     * @since   1.0.0
     */
    protected $latitudeSouth;

    /**
     * The coordinates of the east point of the area.
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @example 5.015643
     *
     * @var float|null $longitudeEast
     *
     * @since   1.0.0
     */
    protected $longitudeEast;

    /**
     * Time of opening. This field will be used to filter the locations on opening hours.
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @example 09:00:00
     *
     * @var float|null $openingTime
     *
     * @since 1.0.0
     */
    protected $openingTime;

    /**
     * Opening hours
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var OpeningHours|null $openingHours
     *
     * @since 1.0.0
     */
    protected $openingHours;

    /**
     * City of the address
     *
     * @pattern ^.{0,35}$
     *
     * @example Hoofddorp
     *
     * @var string|null $city
     *
     * @since 1.0.0
     */
    protected $city;

    /**
     * House number of the address (number only, no extension / box number)
     *
     * @pattern ^\d{0,10}$
     *
     * @example 12
     *
     * @var string|null $houseNr
     *
     * @since 1.0.0
     */
    protected $houseNr;

    /**
     * Zip / postal code of the location
     *
     * @pattern ^.{0,10}$
     *
     * @example 1234AB
     *
     * @var string|null $postalCode
     *
     * @since 1.0.0
     */
    protected $postalCode;

    /**
     * Street of the location
     *
     * @pattern ^.{0,95}$
     *
     * @example Siriusdreef
     *
     * @var string|null $street
     *
     * @since 1.0.0
     */
    protected $street;

    /**
     * Code of the location
     *
     * @pattern ^.{0,35}$
     *
     * @example 161503
     *
     * @var int|null $locationCode
     *
     * @since 1.0.0
     */
    protected $locationCode;

    /**
     * Sales channel of the location
     *
     * @pattern ^.{0,35}$
     *
     * @example PKT XL
     *
     * @var string|null $saleschannel
     *
     * @since 1.0.0
     */
    protected $saleschannel;

    /**
     * Terminal Type
     *
     * @pattern ^.{0,35}$
     *
     * @example NRS
     *
     * @var string|null $terminalType
     *
     * @since 1.0.0
     */
    protected $terminalType;

    /**
     * RetailNetworkID information. Always use PNPNL-01 for Dutch locations. For Belgium locations use LD-01.
     *
     * @pattern ^.{0,35}$
     *
     * @example PNPNL-01
     *
     * @var string|null $retailNetworkID
     *
     * @since 1.0.0
     */
    protected $retailNetworkID;

    /**
     * Partner name of the location
     *
     * @pattern ^.{0,35}%
     *
     * @example PostNL
     *
     * @var string|null $partnerName
     *
     * @since 1.0.0
     */
    protected $partnerName;

    /**
     * Location constructor.
     *
     * @param string|null           $zipcode
     * @param string|null           $deliveryDate
     * @param float|int|string|null $distance
     * @param array|null            $deliveryOptions
     * @param float|string|null     $latitude
     * @param float|string|null     $longitude
     * @param float|string|null     $latitudeNorth
     * @param float|string|null     $latitudeSouth
     * @param float|string|null     $longitudeWest
     * @param float|string|null     $longitudeEast
     * @param float|string|null     $countryCode
     * @param string|null           $city
     * @param string|null           $street
     * @param string|null           $houseNr
     * @param string|null           $locationCode
     * @param string|null           $saleschannel
     * @param string|null           $terminalType
     * @param string|null           $retailNetworkId
     * @param string|null           $downPartnerID
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $zipcode = null, ?string $deliveryDate = null, $distance = null, ?array $deliveryOptions = null, $latitude = null, $longitude = null, $latitudeNorth = null, $latitudeSouth = null, ?string $longitudeWest = null, ?string $longitudeEast = null, ?string $countryCode = null, ?string $city = null, ?string $street = null, ?string $houseNr = null, ?string $locationCode = null, ?string $saleschannel = null, ?string $terminalType = null, ?string $retailNetworkId = null, ?string $downPartnerID = null)
    {
        parent::__construct();

        $this->setDeliveryDate($deliveryDate ?: (new DateTime('next monday'))->format('d-m-Y'));
        $this->setDeliveryOptions($deliveryOptions);
        $this->setDistance($distance);
        $this->setPostalCode($zipcode);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setHouseNr($houseNr);
        $this->setLocationCode($locationCode);
        $this->setSaleschannel($saleschannel);
        $this->setTerminalType($terminalType);
        $this->setRetailNetworkID($retailNetworkId);
        $this->setPartnerName($downPartnerID);
        $this->setCountryCode($countryCode);
        $this->setLatitude($latitude);
        $this->setLatitudeNorth($latitudeNorth);
        $this->setLatitudeSouth($latitudeSouth);
        $this->setLongitude($longitude);
        $this->setLongitudeWest($longitudeWest);
        $this->setLongitudeEast($longitudeEast);
    }

    /**
     * Get zip / postal code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Location::$postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the postcode
     *
     * @pattern ^.{0,10}$
     *
     * @param string|null $postcode
     *
     * @return static
     *
     * @throws TypeError
     * @throws InvalidTypeException
     * @throws ReflectionException
     *
     * @example 1234AB
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$postalCode
     */
    public function setPostalCode(?string $postcode = null)
    {
        $this->postalCode = ValidateAndFix::postcode($postcode);

        return $this;
    }

    /**
     * Get distance
     *
     * @return int|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$distance
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * Set distance
     *
     * @pattern ^\d{1,10}$
     *
     * @param int|float|string|null $distance
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 1200
     *
     * @since   2.0.0
     *
     * @see     Location::$distance
     */
    public function setDistance($distance): Location
    {
        $this->distance = ValidateAndFix::distance($distance);

        return $this;
    }

    /**
     * Get delivery date
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Location::$deliveryDate
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date
     *
     * @pattern ^(?:0[1-9]|[1-2][0-9]|3[0-1])-(?:0[1-9]|1[0-2])-[0-9]{4}$
     *
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @throws TypeError
     * @throws InvalidTypeException
     *
     * @example 04-06-2019
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Location::$deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): Location
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get delivery options
     *
     * @return string[]|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see Location::$deliveryOptions
     */
    public function getDeliveryOptions(): ?array
    {
        return $this->deliveryOptions;
    }

    /**
     * Set delivery options
     *
     * @pattern ^.{0,35}$
     *
     * @param string[]|null $deliveryOptions
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example PGE
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$deliveryOptions
     */
    public function setDeliveryOptions(?array $deliveryOptions): Location
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }

    /**
     * Get opening time
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$openingTime
     */
    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    /**
     * Set opening time
     *
     * @pattern ^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$
     *
     * @param string|null $openingTime
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example 09:00:00
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$openingTime
     */
    public function setOpeningTime(?string $openingTime): Location
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    /**
     * Get city
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @pattern ^.0{0,35}$
     *
     * @param string|null $city
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example Hoofddorp
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$city
     */
    public function setCity(?string $city): Location
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get house number
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$houseNr
     */
    public function getHouseNr(): ?string
    {
        return $this->houseNr;
    }

    /**
     * Set house number
     *
     * @pattern ^\d{0,10}$
     *
     * @param string|null $houseNr
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 12
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$houseNr
     */
    public function setHouseNr(?string $houseNr): Location
    {
        $this->houseNr = ValidateAndFix::houseNumber($houseNr);

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$street
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @pattern ^.{0,95}$
     *
     * @param string|null $street
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example Siriusdreef
     *
     * @since 2.0.0 Strict typing
     *
     * @see     Location::$street
     */
    public function setStreet(?string $street): Location
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get country code
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$countryCode
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * Set country code
     *
     * @pattern ^(?:NL|BE)$
     *
     * @param string|null $countryCode
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example NL
     *
     * @since   2.0.0
     *
     * @see     Location::$countryCode
     */
    public function setCountryCode(?string $countryCode): Location
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$latitude
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @param string|null $latitude
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 52.156439
     *
     * @since   2.0.0
     *
     * @see     Location::$latitude
     */
    public function setLatitude($latitude): Location
    {
        $this->latitude = ValidateAndFix::coordinate($latitude);

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$longitude
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @param string|null $longitude
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 5.015643
     *
     * @since   2.0.0
     *
     * @see     Location::$longitude
     */
    public function setLongitude($longitude): Location
    {
        $this->longitude = ValidateAndFix::coordinate($longitude);

        return $this;
    }

    /**
     * Get latitude North
     *
     * @return string|null
     *
     * @since   2.0.0
     *
     * @see     Location::$latitudeNorth
     */
    public function getLatitudeNorth(): ?string
    {
        return $this->latitudeNorth;
    }

    /**
     * Set latitude North
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @param string|null $latitudeNorth
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 52.156439
     *
     * @since   2.0.0
     *
     * @see     Location::$latitudeNorth
     */
    public function setLatitudeNorth($latitudeNorth): Location
    {
        $this->latitudeNorth = ValidateAndFix::coordinate($latitudeNorth);

        return $this;
    }

    /**
     * Get longitude West
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$longitudeWest
     */
    public function getLongitudeWest(): ?string
    {
        return $this->longitudeWest;
    }

    /**
     * Set longitude West
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @param string|null $longitudeWest
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 5.015643
     *
     * @since   2.0.0
     *
     * @see     Location::$longitudeWest
     */
    public function setLongitudeWest($longitudeWest): Location
    {
        $this->longitudeWest = ValidateAndFix::coordinate($longitudeWest);

        return $this;
    }

    /**
     * Get latitude South
     *
     * @return string|null
     *
     * @since   2.0.0
     *
     * @see     Location::$latitudeSouth
     */
    public function getLatitudeSouth(): ?string
    {
        return $this->latitudeSouth;
    }

    /**
     * Set latitude South
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @param string|null $latitudeSouth
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 52.156439
     *
     * @since   2.0.0
     *
     * @see     Location::$latitudeSouth
     */
    public function setLatitudeSouth($latitudeSouth): Location
    {
        $this->latitudeSouth = ValidateAndFix::coordinate($latitudeSouth);

        return $this;
    }

    /**
     * Get longitude East
     *
     * @return float|null
     *
     * @since 2.0.0
     *
     * @see   Location::$longitudeEast
     */
    public function getLongitudeEast(): ?float
    {
        return $this->longitudeEast;
    }

    /**
     * Set longitude East
     *
     * @pattern ^\d{1,2}\.\d{1,15}$
     *
     * @param string|float|null $longitudeEast
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 5.015643
     *
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$longitudeEast
     */
    public function setLongitudeEast($longitudeEast): Location
    {
        $this->longitudeEast = ValidateAndFix::coordinate($longitudeEast);

        return $this;
    }

    /**
     * Get opening hours
     *
     * @return OpeningHours|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$openingHours
     */
    public function getOpeningHours(): ?OpeningHours
    {
        return $this->openingHours;
    }

    /**
     * Set opening hours
     *
     * @pattern N/A
     *
     * @param OpeningHours|null $openingHours
     *
     * @return static
     *
     * @throws TypeError
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$openingHours
     */
    public function setOpeningHours(?OpeningHours $openingHours): Location
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    /**
     * Get location code
     *
     * @return int|null
     *
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$locationCode
     */
    public function getLocationCode(): ?int
    {
        return $this->locationCode;
    }

    /**
     * Set location code
     *
     * @pattern ^.{0,35}$
     *
     * @param int|float|string|null $locationCode
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example 161503
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$locationCode
     */
    public function setLocationCode($locationCode): Location
    {
        $this->locationCode = ValidateAndFix::integer($locationCode);

        return $this;
    }

    /**
     * Get sales channel
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$saleschannel
     */
    public function getSaleschannel(): ?string
    {
        return $this->saleschannel;
    }

    /**
     * Set sales channel
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $saleschannel
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example PKT XL
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$saleschannel
     */
    public function setSaleschannel(?string $saleschannel): Location
    {
        $this->saleschannel = ValidateAndFix::genericString($saleschannel);

        return $this;
    }

    /**
     * Get terminal type
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$terminalType
     */
    public function getTerminalType(): ?string
    {
        return $this->terminalType;
    }

    /**
     * Set terminal type
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $terminalType
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example NRS
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$terminalType
     */
    public function setTerminalType(?string $terminalType): Location
    {
        $this->terminalType = ValidateAndFix::genericString($terminalType);

        return $this;
    }

    /**
     * Get retail network ID
     *
     * @return string|null
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     *
     * @see   Location::$retailNetworkID
     */
    public function getRetailNetworkID(): ?string
    {
        return $this->retailNetworkID;
    }

    /**
     * Set retail network ID
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $retailNetworkID
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example PNPNL-01
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     *
     * @see     Location::$retailNetworkID
     */
    public function setRetailNetworkID(?string $retailNetworkID): Location
    {
        $this->retailNetworkID = ValidateAndFix::genericString($retailNetworkID);

        return $this;
    }

    /**
     * Get partner name
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$partnerName
     */
    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    /**
     * Set partner name
     *
     * @pattern ^.{0,35}%
     *
     * @param string|null $partnerName
     *
     * @return static
     *
     * @throws TypeError
     * @throws ReflectionException
     *
     * @example PostNL
     *
     * @since   2.0.0
     *
     * @see     Location::$partnerName
     */
    public function setPartnerName(?string $partnerName): Location
    {
        $this->partnerName = ValidateAndFix::genericString($partnerName);

        return $this;
    }
}
