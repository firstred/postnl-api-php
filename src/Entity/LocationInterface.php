<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class Location.
 */
interface LocationInterface extends EntityInterface
{
    /**
     * Get distance.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   Location::$distance
     */
    public function getDistance(): ?int;

    /**
     * Set distance.
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
     * @see     Location::$distance
     */
    public function setDistance($distance): LocationInterface;

    /**
     * Get delivery options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   Location::$deliveryOptions
     */
    public function getDeliveryOptions(): ?array;

    /**
     * Set delivery options.
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
     * @see     Location::$deliveryOptions
     */
    public function setDeliveryOptions(?array $deliveryOptions): LocationInterface;

    /**
     * Get latitude.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$latitude
     */
    public function getLatitude(): ?string;

    /**
     * Set latitude.
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
     * @see     Location::$latitude
     */
    public function setLatitude($latitude): LocationInterface;

    /**
     * Get longitude.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$longitude
     */
    public function getLongitude(): ?string;

    /**
     * Set longitude.
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
     * @see     Location::$longitude
     */
    public function setLongitude($longitude): LocationInterface;

    /**
     * Get opening hours.
     *
     * @return OpeningHoursInterface|null
     *
     * @since 2.0.0
     * @see   Location::$openingHours
     */
    public function getOpeningHours(): ?OpeningHoursInterface;

    /**
     * Set opening hours.
     *
     * @pattern N/A
     *
     * @param OpeningHoursInterface|null $openingHours
     *
     * @return static
     *
     * @example N/A
     *
     * @since   1.0.0
     * @since   2.0.0 Strict typing
     * @see     Location::$openingHours
     */
    public function setOpeningHours(?OpeningHoursInterface $openingHours): LocationInterface;

    /**
     * Get location code.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   Location::$locationCode
     */
    public function getLocationCode(): ?int;

    /**
     * Set location code.
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
     * @see     Location::$locationCode
     */
    public function setLocationCode($locationCode): LocationInterface;

    /**
     * Get sales channel.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$saleschannel
     */
    public function getSaleschannel(): ?string;

    /**
     * Set sales channel.
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
     * @see     Location::$saleschannel
     */
    public function setSaleschannel(?string $saleschannel): LocationInterface;

    /**
     * Get terminal type.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$terminalType
     */
    public function getTerminalType(): ?string;

    /**
     * Set terminal type.
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
     * @see     Location::$terminalType
     */
    public function setTerminalType(?string $terminalType): LocationInterface;

    /**
     * Get retail network ID.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$retailNetworkID
     */
    public function getRetailNetworkID(): ?string;

    /**
     * Set retail network ID.
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
     * @see     Location::$retailNetworkID
     */
    public function setRetailNetworkID(?string $retailNetworkID): LocationInterface;

    /**
     * Get partner name.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$partnerName
     */
    public function getPartnerName(): ?string;

    /**
     * Set partner name.
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
     * @see     Location::$partnerName
     */
    public function setPartnerName(?string $partnerName): LocationInterface;

    /**
     * Get address.
     *
     * @return AddressInterface|null
     *
     * @since 2.0.0
     * @see   Address
     */
    public function getAddress(): ?AddressInterface;

    /**
     * Set address.
     *
     * @pattern N/A
     *
     * @param AddressInterface|null $address
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     Address
     */
    public function setAddress(?AddressInterface $address): LocationInterface;

    /**
     * Get location name.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$name
     */
    public function getName(): ?string;

    /**
     * Set location name.
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
     * @see     Location::$name
     */
    public function setName(?string $name): LocationInterface;

    /**
     * Get phone number.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$phoneNumber
     */
    public function getPhoneNumber(): ?string;

    /**
     * Set phone number.
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
     * @see     Location::$phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): LocationInterface;

    /**
     * Get pick up date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   Location::$pickupDate
     */
    public function getPickupDate(): ?string;

    /**
     * Set pickup date.
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
     * @see     Location::$pickupDate
     */
    public function setPickupDate(?string $pickupDate): LocationInterface;
}
