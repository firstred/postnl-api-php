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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Warning;

/**
 * Class ResponseLocation
 */
class ResponseLocation extends AbstractEntity
{
    /** @var Address|null $address */
    protected $address;
    /** @var string[]|null $deliveryOptions */
    protected $deliveryOptions;
    /** @var string|null $distance */
    protected $distance;
    /** @var string|null $latitude */
    protected $latitude;
    /** @var string|null $longitude */
    protected $longitude;
    /** @var string|null $name */
    protected $name;
    /** @var string[]|null $openingHours */
    protected $openingHours;
    /** @var string|null $partnerName */
    protected $partnerName;
    /** @var string|null $phoneNumber */
    protected $phoneNumber;
    /** @var string|null $locationCode */
    protected $locationCode;
    /** @var string|null $retailNetworkID */
    protected $retailNetworkID;
    /** @var string|null $saleschannel */
    protected $saleschannel;
    /** @var string|null $terminalType */
    protected $terminalType;
    /** @var Warning[]|null $warnings */
    protected $warnings;
    /** @var string|null $downPartnerID */
    protected $downPartnerID;
    /** @var string|null $downPartnerLocation */
    protected $downPartnerLocation;

    /**
     * ResponseLocation constructor.
     *
     * @param Address|null   $address
     * @param string[]|null  $deliveryOptions
     * @param string|null    $distance
     * @param string|null    $latitude
     * @param string|null    $longitude
     * @param string|null    $name
     * @param string[]|null  $openingHours
     * @param string|null    $partnerName
     * @param string|null    $phoneNumber
     * @param string|null    $locationCode
     * @param string|null    $retailNetworkId
     * @param string|null    $saleschannel
     * @param string|null    $terminalType
     * @param Warning[]|null $warnings
     * @param string|null    $downPartnerID
     * @param string|null    $downPartnerLocation
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?Address $address = null, ?array $deliveryOptions = null, ?string $distance = null, ?string $latitude = null, ?string $longitude = null, ?string $name = null, ?array $openingHours = null, ?string $partnerName = null, ?string $phoneNumber = null, ?string $locationCode = null, ?string $retailNetworkId = null, ?string $saleschannel = null, ?string $terminalType = null, ?array $warnings = null, ?string $downPartnerID = null, ?string $downPartnerLocation = null)
    {
        parent::__construct();

        $this->setAddress($address);
        $this->setDeliveryOptions($deliveryOptions);
        $this->setDistance($distance);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setName($name);
        $this->setOpeningHours($openingHours);
        $this->setPartnerName($partnerName);
        $this->setPhoneNumber($phoneNumber);
        $this->setLocationCode($locationCode);
        $this->setRetailNetworkID($retailNetworkId);
        $this->setSaleschannel($saleschannel);
        $this->setTerminalType($terminalType);
        $this->setWarnings($warnings);
        $this->setDownPartnerID($downPartnerID);
        $this->setDownPartnerLocation($downPartnerLocation);
    }

    /**
     * @return Address|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAddress(?Address $address): ResponseLocation
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryOptions(): ?array
    {
        return $this->deliveryOptions;
    }

    /**
     * @param string[]|null $deliveryOptions
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryOptions(?array $deliveryOptions): ResponseLocation
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDistance(): ?string
    {
        return $this->distance;
    }

    /**
     * @param string|null $distance
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDistance(?string $distance): ResponseLocation
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLatitude(?string $latitude): ResponseLocation
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLongitude(?string $longitude): ResponseLocation
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setName(?string $name): ResponseLocation
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getOpeningHours(): ?array
    {
        return $this->openingHours;
    }

    /**
     * @param string[]|null $openingHours
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOpeningHours(?array $openingHours): ResponseLocation
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    /**
     * @param string|null $partnerName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPartnerName(?string $partnerName): ResponseLocation
    {
        $this->partnerName = $partnerName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPhoneNumber(?string $phoneNumber): ResponseLocation
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLocationCode(): ?string
    {
        return $this->locationCode;
    }

    /**
     * @param string|null $locationCode
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLocationCode(?string $locationCode): ResponseLocation
    {
        $this->locationCode = $locationCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRetailNetworkID(): ?string
    {
        return $this->retailNetworkID;
    }

    /**
     * @param string|null $retailNetworkID
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRetailNetworkID(?string $retailNetworkID): ResponseLocation
    {
        $this->retailNetworkID = $retailNetworkID;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getSaleschannel(): ?string
    {
        return $this->saleschannel;
    }

    /**
     * @param string|null $saleschannel
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSaleschannel(?string $saleschannel): ResponseLocation
    {
        $this->saleschannel = $saleschannel;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getTerminalType(): ?string
    {
        return $this->terminalType;
    }

    /**
     * @param string|null $terminalType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setTerminalType(?string $terminalType): ResponseLocation
    {
        $this->terminalType = $terminalType;

        return $this;
    }

    /**
     * @return Warning[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getWarnings(): ?array
    {
        return $this->warnings;
    }

    /**
     * @param Warning[]|null $warnings
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setWarnings(?array $warnings): ResponseLocation
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerID(): ?string
    {
        return $this->downPartnerID;
    }

    /**
     * @param string|null $downPartnerID
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerID(?string $downPartnerID): ResponseLocation
    {
        $this->downPartnerID = $downPartnerID;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDownPartnerLocation(): ?string
    {
        return $this->downPartnerLocation;
    }

    /**
     * @param string|null $downPartnerLocation
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDownPartnerLocation(?string $downPartnerLocation): ResponseLocation
    {
        $this->downPartnerLocation = $downPartnerLocation;

        return $this;
    }
}
