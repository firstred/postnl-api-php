<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\ValidateAndFix;

/**
 * Class Location
 */
class Location extends AbstractEntity
{
    /**
     * Address
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var Address|null $address
     *
     * @since   2.0.0
     */
    protected $address;

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
     * @since   2.0.0
     */
    protected $deliveryOptions;

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
     * Code of the location
     *
     * @pattern ^.{0,35}$
     *
     * @example 161503
     *
     * @var int|null $locationCode
     *
     * @since   2.0.0
     */
    protected $locationCode;

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
     * Location name
     *
     * @pattern ^.{0,35}$
     *
     * @example Primera Sanders
     *
     * @var string|null $name
     *
     * @since   2.0.0
     */
    protected $name;

    /**
     * Opening hours
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var OpeningHours|null $openingHours
     *
     * @since   2.0.0
     */
    protected $openingHours;

    /**
     * Partner name of the location
     *
     * @pattern ^.{0,35}%
     *
     * @example PostNL
     *
     * @var string|null $partnerName
     *
     * @since   2.0.0
     */
    protected $partnerName;

    /**
     * Phone number of the location
     *
     * @pattern ^.{0,35}$
     *
     * @example 023-1234567
     *
     * @var string|null $phoneNumber
     *
     * @since   2.0.0
     */
    protected $phoneNumber;

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
     * The pickup date from when the parcel can be picked up, as returned by the Checkout API
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @example 03-08-2019
     *
     * @var string|null $pickupDate
     *
     * @since 2.0.0
     */
    protected $pickupDate;

    /**
     * Location constructor.
     *
     * @since 2.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get distance
     *
     * @return int|null
     *
     * @since 2.0.0
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
     * @throws InvalidArgumentException
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
     * Get delivery options
     *
     * @return string[]|null
     *
     * @since 2.0.0
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
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
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
     * Get opening hours
     *
     * @return OpeningHours|null
     *
     * @since 2.0.0
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
     * @since 2.0.0
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
     * @throws InvalidArgumentException
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
     * @since 2.0.0
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
     * @throws InvalidArgumentException
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
     * @since 2.0.0
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
     * @throws InvalidArgumentException
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
     * @since 2.0.0
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
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
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

    /**
     * Get address
     *
     * @return Address|null
     *
     * @since 2.0.0
     *
     * @see   Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @pattern N/A
     *
     * @param Address|null $address
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     *
     * @see     Address
     */
    public function setAddress(?Address $address): Location
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get location name
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set location name
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $name
     *
     * @return static
     *
     * @example Primera Sanders
     *
     * @since   2.0.0
     *
     * @see     Location::$name
     */
    public function setName(?string $name): Location
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get phone number
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$phoneNumber
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Set phone number
     *
     * @pattern ^.{0,35}$
     *
     * @param string|null $phoneNumber
     *
     * @return static
     *
     * @example 023-1234567
     *
     * @since   2.0.0
     *
     * @see     Location::$phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): Location
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get pick up date
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   Location::$pickupDate
     */
    public function getPickupDate(): ?string
    {
        return $this->pickupDate;
    }

    /**
     * Set pickup date
     *
     * @pattern ^(?:[0-3]\d-[01]\d-[12]\d{3})$
     *
     * @param string|null $pickupDate
     *
     * @return static
     *
     * @example 03-08-2019
     *
     * @since   2.0.0
     *
     * @see     Location::$pickupDate
     */
    public function setPickupDate(?string $pickupDate): Location
    {
        $this->pickupDate = $pickupDate;

        return $this;
    }
}
