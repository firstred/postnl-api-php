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

class Location extends SerializableObject
{
    public const AVAILABLE_NETWORKS = ['PNPNL-01', 'LD-01'];

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

    public function getPostalcode(): string|null
    {
        return $this->Postalcode;
    }

    public function setPostalcode($Postalcode = null): static
    {
        if (is_null(value: $Postalcode)) {
            $this->Postalcode = null;
        } else {
            $this->Postalcode = strtoupper(string: str_replace(search: ' ', replace: '', subject: $Postalcode));
        }

        return $this;
    }

    public function getAllowSundaySorting(): string|null
    {
        return $this->AllowSundaySorting;
    }

    public function setAllowSundaySorting(string|null $AllowSundaySorting = null): static
    {
        $this->AllowSundaySorting = $AllowSundaySorting;

        return $this;
    }

    public function calculateDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    public function setDeliveryDate(string|null $DeliveryDate = null): static
    {
        $this->DeliveryDate = $DeliveryDate;

        return $this;
    }

    public function getDeliveryOptions(): array|null
    {
        return $this->DeliveryOptions;
    }

    public function setDeliveryOptions(array|null $DeliveryOptions = null): static
    {
        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    public function getOpeningTime(): string|null
    {
        return $this->OpeningTime;
    }

    public function setOpeningTime(string|null $OpeningTime = null): static
    {
        $this->OpeningTime = $OpeningTime;

        return $this;
    }

    public function getOptions(): array|null
    {
        return $this->Options;
    }

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

    public function getCity(): string|null
    {
        return $this->City;
    }

    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    public function getHouseNr(): string|null
    {
        return $this->HouseNr;
    }

    public function setHouseNr(string|null $HouseNr = null): static
    {
        $this->HouseNr = $HouseNr;

        return $this;
    }

    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    public function getStreet(): string|null
    {
        return $this->Street;
    }

    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

        return $this;
    }

    public function getCoordinates(): ?Coordinates
    {
        return $this->Coordinates;
    }

    public function setCoordinates(?Coordinates $Coordinates = null): static
    {
        $this->Coordinates = $Coordinates;

        return $this;
    }

    public function getCoordinatesNorthWest(): ?CoordinatesNorthWest
    {
        return $this->CoordinatesNorthWest;
    }

    public function setCoordinatesNorthWest(?CoordinatesNorthWest $CoordinatesNorthWest = null): static
    {
        $this->CoordinatesNorthWest = $CoordinatesNorthWest;

        return $this;
    }

    public function getCoordinatesSouthEast(): ?CoordinatesSouthEast
    {
        return $this->CoordinatesSouthEast;
    }

    public function setCoordinatesSouthEast(?CoordinatesSouthEast $CoordinatesSouthEast = null): static
    {
        $this->CoordinatesSouthEast = $CoordinatesSouthEast;

        return $this;
    }

    public function getLocationCode(): string|null
    {
        return $this->LocationCode;
    }

    public function setLocationCode(string|null $LocationCode = null): static
    {
        $this->LocationCode = $LocationCode;

        return $this;
    }

    public function getSaleschannel(): string|null
    {
        return $this->Saleschannel;
    }

    public function setSaleschannel(string|null $Saleschannel = null): static
    {
        $this->Saleschannel = $Saleschannel;

        return $this;
    }

    public function getTerminalType(): string|null
    {
        return $this->TerminalType;
    }

    public function setTerminalType(string|null $TerminalType = null): static
    {
        $this->TerminalType = $TerminalType;

        return $this;
    }

    public function getRetailNetworkID(): string|null
    {
        return $this->RetailNetworkID;
    }

    public function setRetailNetworkID(string|null $RetailNetworkID = null): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }

    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(string|null $DownPartnerID = null): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    public function setDownPartnerLocation(string|null $DownPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }
}
