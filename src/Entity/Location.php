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

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use DateTime;
use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Location.
 */
class Location extends SerializableObject
{
    public const AVAILABLE_NETWORKS = ['PNPNL-01', 'LD-01'];

    /**
     * Location constructor.
     *
     * @param string                    $service
     * @param string                    $propType
     * @param string|null               $AllowSundaySorting
     * @param string|null               $DeliveryDate
     * @param array|null                $DeliveryOptions
     * @param string|null               $OpeningTime
     * @param array|null                $Options
     * @param string|null               $City
     * @param string|null               $HouseNr
     * @param string|null               $HouseNrExt
     * @param string|null               $Postalcode
     * @param string|null               $Street
     * @param Coordinates|null          $Coordinates
     * @param CoordinatesNorthWest|null $CoordinatesNorthWest
     * @param CoordinatesSouthEast|null $CoordinatesSouthEast
     * @param string|null               $LocationCode
     * @param string|null               $Saleschannel
     * @param string|null               $TerminalType
     * @param string|null               $RetailNetworkID
     * @param string|null               $DownPartnerID
     * @param string|null               $DownPartnerLocation
     *
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        protected string|null $AllowSundaySorting = null,
        protected string|null $DeliveryDate = null,
        protected array|null $DeliveryOptions = null,
        protected string|null $OpeningTime = null,
        protected array|null $Options = null,
        protected string|null $City = null,
        protected string|null $HouseNr = null,
        protected string|null $HouseNrExt = null,
        protected string|null $Postalcode = null,
        protected string|null $Street = null,
        protected Coordinates|null $Coordinates = null,
        protected CoordinatesNorthWest|null $CoordinatesNorthWest = null,
        protected CoordinatesSouthEast|null $CoordinatesSouthEast = null,
        protected string|null $LocationCode = null,
        protected string|null $Saleschannel = null,
        protected string|null $TerminalType = null,
        #[ExpectedValues(values: self::AVAILABLE_NETWORKS)]
        protected string|null $RetailNetworkID = null,
        protected string|null $DownPartnerID = null,
        protected string|null $DownPartnerLocation = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setAllowSundaySorting(AllowSundaySorting: $AllowSundaySorting);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate ?: (new DateTime(datetime: 'next monday'))->format(format: 'd-m-Y'));
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
        $this->setOptions(Options: $Options);
        $this->setPostalcode(Postalcode: $Postalcode);
        $this->setCoordinates(Coordinates: $Coordinates);
        $this->setCoordinatesNorthWest(CoordinatesNorthWest: $CoordinatesNorthWest);
        $this->setCoordinatesSouthEast(CoordinatesSouthEast: $CoordinatesSouthEast);
        $this->setCity(City: $City);
        $this->setStreet(Street: $Street);
        $this->setHouseNr(HouseNr: $HouseNr);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setSaleschannel(Saleschannel: $Saleschannel);
        $this->setTerminalType(TerminalType: $TerminalType);
        $this->setRetailNetworkID(RetailNetworkID: $RetailNetworkID);
        $this->setDownPartnerID(DownPartnerID: $DownPartnerID);
        $this->setDownPartnerLocation(DownPartnerLocation: $DownPartnerLocation);
    }

    /**
     * @return string|null
     */
    public function getPostalcode(): string|null
    {
        return $this->Postalcode;
    }

    /**
     * @param string|null $Postalcode
     *
     * @return static
     */
    public function setPostalcode(string|null $Postalcode = null): static
    {
        if (is_null(value: $Postalcode)) {
            $this->Postalcode = null;
        } else {
            $this->Postalcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $Postalcode));
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAllowSundaySorting(): string|null
    {
        return $this->AllowSundaySorting;
    }

    /**
     * @param string|null $AllowSundaySorting
     *
     * @return static
     */
    public function setAllowSundaySorting(string|null $AllowSundaySorting = null): static
    {
        $this->AllowSundaySorting = $AllowSundaySorting;

        return $this;
    }

    /**
     * @return string|null
     */
    public function calculateDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    /**
     * @param string|null $DeliveryDate
     *
     * @return static
     */
    public function setDeliveryDate(string|null $DeliveryDate = null): static
    {
        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getDeliveryOptions(): array|null
    {
        return $this->DeliveryOptions;
    }

    /**
     * @param array|null $DeliveryOptions
     *
     * @return static
     */
    public function setDeliveryOptions(array|null $DeliveryOptions = null): static
    {
        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOpeningTime(): string|null
    {
        return $this->OpeningTime;
    }

    /**
     * @param string|null $OpeningTime
     *
     * @return static
     */
    public function setOpeningTime(string|null $OpeningTime = null): static
    {
        $this->OpeningTime = $OpeningTime;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): array|null
    {
        return $this->Options;
    }

    /**
     * @param array|null $Options
     *
     * @return static
     */
    public function setOptions(array|null $Options = null): static
    {
        if (isset($Options['string'])) {
            if (is_array(value: $Options['string'])) {
                $Options = $Options['string'];
            } elseif (is_string(value: $Options['string'])) {
                $Options = [$Options['string']];
            }
        }

        $this->Options = $Options;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNr(): string|null
    {
        return $this->HouseNr;
    }

    /**
     * @param string|null $HouseNr
     *
     * @return static
     */
    public function setHouseNr(string|null $HouseNr = null): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): string|null
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

        return $this;
    }

    /**
     * @return Coordinates|null
     */
    public function getCoordinates(): ?Coordinates
    {
        return $this->Coordinates;
    }

    /**
     * @param Coordinates|null $Coordinates
     *
     * @return static
     */
    public function setCoordinates(?Coordinates $Coordinates = null): static
    {
        $this->Coordinates = $Coordinates;

        return $this;
    }

    /**
     * @return CoordinatesNorthWest|null
     */
    public function getCoordinatesNorthWest(): ?CoordinatesNorthWest
    {
        return $this->CoordinatesNorthWest;
    }

    /**
     * @param CoordinatesNorthWest|null $CoordinatesNorthWest
     *
     * @return static
     */
    public function setCoordinatesNorthWest(?CoordinatesNorthWest $CoordinatesNorthWest = null): static
    {
        $this->CoordinatesNorthWest = $CoordinatesNorthWest;

        return $this;
    }

    /**
     * @return CoordinatesSouthEast|null
     */
    public function getCoordinatesSouthEast(): ?CoordinatesSouthEast
    {
        return $this->CoordinatesSouthEast;
    }

    /**
     * @param CoordinatesSouthEast|null $CoordinatesSouthEast
     *
     * @return static
     */
    public function setCoordinatesSouthEast(?CoordinatesSouthEast $CoordinatesSouthEast = null): static
    {
        $this->CoordinatesSouthEast = $CoordinatesSouthEast;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocationCode(): string|null
    {
        return $this->LocationCode;
    }

    /**
     * @param string|null $LocationCode
     *
     * @return static
     */
    public function setLocationCode(string|null $LocationCode = null): static
    {
        $this->LocationCode = $LocationCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaleschannel(): string|null
    {
        return $this->Saleschannel;
    }

    /**
     * @param string|null $Saleschannel
     *
     * @return static
     */
    public function setSaleschannel(string|null $Saleschannel = null): static
    {
        $this->Saleschannel = $Saleschannel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTerminalType(): string|null
    {
        return $this->TerminalType;
    }

    /**
     * @param string|null $TerminalType
     *
     * @return static
     */
    public function setTerminalType(string|null $TerminalType = null): static
    {
        $this->TerminalType = $TerminalType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRetailNetworkID(): string|null
    {
        return $this->RetailNetworkID;
    }

    /**
     * @param string|null $RetailNetworkID
     *
     * @return static
     */
    public function setRetailNetworkID(string|null $RetailNetworkID = null): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    /**
     * @param string|null $DownPartnerID
     *
     * @return static
     */
    public function setDownPartnerID(string|null $DownPartnerID = null): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    /**
     * @param string|null $DownPartnerLocation
     *
     * @return static
     */
    public function setDownPartnerLocation(string|null $DownPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }
}
