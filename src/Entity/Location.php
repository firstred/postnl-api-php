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
use Exception;

/**
 * Class Location
 */
class Location extends AbstractEntity
{
    /** @var bool|null $allowSundaySorting */
    protected $allowSundaySorting;
    /** @var string|null $deliveryDate */
    protected $deliveryDate;
    /** @var string[]|null $deliveryOptions */
    protected $deliveryOptions;
    /** @var string|null $openingTime */
    protected $openingTime;
    /** @var string[]|null $options */
    protected $options;
    /** @var string|null $city */
    protected $city;
    /** @var string|null $houseNr */
    protected $houseNr;
    /** @var string|null $houseNrExt */
    protected $houseNrExt;
    /** @var string|null $postalcode */
    protected $postalcode;
    /** @var string|null $street */
    protected $street;
    /** @var Coordinates|null $coordinates */
    protected $coordinates;
    /** @var CoordinatesNorthWest|null $coordinatesNorthWest */
    protected $coordinatesNorthWest;
    /** @var CoordinatesSouthEast|null $coordinatesSouthEast */
    protected $coordinatesSouthEast;
    /** @var string|null $locationCode */
    protected $locationCode;
    /** @var string|null $saleschannel */
    protected $saleschannel;
    /** @var string|null $terminalType */
    protected $terminalType;
    /** @var string|null $retailNetworkID */
    protected $retailNetworkID;
    /** @var string|null $downPartnerID */
    protected $downPartnerID;
    /** @var string|null $downPartnerLocation */
    protected $downPartnerLocation;

    /**
     * @param string|null               $zipcode
     * @param bool|null                 $allowSundaySorting
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
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function __construct(?string $zipcode = null, ?bool $allowSundaySorting = null, ?string $deliveryDate = null, ?array $deliveryOptions = null, ?array $options = null, ?Coordinates $coordinates = null, ?CoordinatesNorthWest $coordinatesNW = null, ?CoordinatesSouthEast $coordinatesSE = null, ?string $city = null, ?string $street = null, ?string $houseNr = null, ?string $houseNrExt = null, ?string $locationCode = null, ?string $saleschannel = null, ?string $terminalType = null, ?string $retailNetworkId = null, ?string $downPartnerID = null, ?string $downPartnerLocation = null)
    {
        parent::__construct();

        $this->setAllowSundaySorting($allowSundaySorting);
        $this->setDeliveryDate($deliveryDate ?: (new DateTime('next monday'))->format('d-m-Y'));
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
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    /**
     * Set the postcode
     *
     * @param string|null $postcode
     *
     * @return static
     */
    public function setPostalcode($postcode = null)
    {
        if (is_null($postcode)) {
            $this->postalcode = null;
        } else {
            $this->postalcode = strtoupper(str_replace(' ', '', $postcode));
        }

        return $this;
    }

    /**
     * @return bool|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAllowSundaySorting(): ?bool
    {
        return $this->allowSundaySorting;
    }

    /**
     * @param bool|null $allowSundaySorting
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAllowSundaySorting(?bool $allowSundaySorting): Location
    {
        $this->allowSundaySorting = $allowSundaySorting;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * @param string|null $deliveryDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDeliveryDate(?string $deliveryDate): Location
    {
        $this->deliveryDate = $deliveryDate;

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
    public function setDeliveryOptions(?array $deliveryOptions): Location
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    /**
     * @param string|null $openingTime
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOpeningTime(?string $openingTime): Location
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    /**
     * @return string[]|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param string[]|null $options
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setOptions(?array $options): Location
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCity(?string $city): Location
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNr(): ?string
    {
        return $this->houseNr;
    }

    /**
     * @param string|null $houseNr
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNr(?string $houseNr): Location
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getHouseNrExt(): ?string
    {
        return $this->houseNrExt;
    }

    /**
     * @param string|null $houseNrExt
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setHouseNrExt(?string $houseNrExt): Location
    {
        $this->houseNrExt = $houseNrExt;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setStreet(?string $street): Location
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return Coordinates|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCoordinates(): ?Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinates|null $coordinates
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCoordinates(?Coordinates $coordinates): Location
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * @return CoordinatesNorthWest|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCoordinatesNorthWest(): ?CoordinatesNorthWest
    {
        return $this->coordinatesNorthWest;
    }

    /**
     * @param CoordinatesNorthWest|null $coordinatesNorthWest
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCoordinatesNorthWest(?CoordinatesNorthWest $coordinatesNorthWest): Location
    {
        $this->coordinatesNorthWest = $coordinatesNorthWest;

        return $this;
    }

    /**
     * @return CoordinatesSouthEast|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCoordinatesSouthEast(): ?CoordinatesSouthEast
    {
        return $this->coordinatesSouthEast;
    }

    /**
     * @param CoordinatesSouthEast|null $coordinatesSouthEast
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCoordinatesSouthEast(?CoordinatesSouthEast $coordinatesSouthEast): Location
    {
        $this->coordinatesSouthEast = $coordinatesSouthEast;

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
    public function setLocationCode(?string $locationCode): Location
    {
        $this->locationCode = $locationCode;

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
    public function setSaleschannel(?string $saleschannel): Location
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
    public function setTerminalType(?string $terminalType): Location
    {
        $this->terminalType = $terminalType;

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
    public function setRetailNetworkID(?string $retailNetworkID): Location
    {
        $this->retailNetworkID = $retailNetworkID;

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
    public function setDownPartnerID(?string $downPartnerID): Location
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
    public function setDownPartnerLocation(?string $downPartnerLocation): Location
    {
        $this->downPartnerLocation = $downPartnerLocation;

        return $this;
    }
}
