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

namespace Firstred\PostNL\DTO\Response;

use Firstred\PostNL\Entity\Address;

class ResponseLocation
{
    protected ?Address $Address = null;
    protected array|null $DeliveryOptions = null;
    protected string|null $Distance = null;
    protected string|null $Latitude = null;
    protected string|null $Longitude = null;
    protected string|null $Name = null;
    protected array|null $OpeningHours = null;
    protected string|null $PartnerName = null;
    protected string|null $PhoneNumber = null;
    protected string|null $LocationCode = null;
    protected string|null $RetailNetworkID = null;
    protected string|null $Saleschannel = null;
    protected string|null $TerminalType = null;
    protected array|null $Warnings = null;
    protected string|null $DownPartnerID = null;
    protected string|null $DownPartnerLocation = null;

    public function __construct(
        ?Address $address = null,
        array|null $deliveryOptions = null,
        string|null $distance = null,
        string|null $latitude = null,
        string|null $longitude = null,
        string|null $name = null,
        array|null $openingHours = null,
        string|null $partnerName = null,
        string|null $phoneNumber = null,
        string|null $locationCode = null,
        string|null $retailNetworkId = null,
        string|null $saleschannel = null,
        string|null $terminalType = null,
        array|null $warnings = null,
        string|null $downPartnerID = null,
        string|null $downPartnerLocation = null,
    ) {
        $this->setAddress(address: $address);
        $this->setDeliveryOptions(deliveryOptions: $deliveryOptions);
        $this->setDistance(distance: $distance);
        $this->setLatitude(latitude: $latitude);
        $this->setLongitude(longitude: $longitude);
        $this->setName(name: $name);
        $this->setOpeningHours(openingHours: $openingHours);
        $this->setPartnerName(partnerName: $partnerName);
        $this->setPhoneNumber(phoneNumber: $phoneNumber);
        $this->setLocationCode(locationCode: $locationCode);
        $this->setRetailNetworkID(retailNetworkID: $retailNetworkId);
        $this->setSaleschannel(salesChannel: $saleschannel);
        $this->setTerminalType(terminalType: $terminalType);
        $this->setWarnings(warnings: $warnings);
        $this->setDownPartnerID(downPartnerID: $downPartnerID);
        $this->setDownPartnerLocation(downPartnerLocation: $downPartnerLocation);
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $address = null): static
    {
        $this->Address = $address;

        return $this;
    }

    public function getDeliveryOptions(): array|null
    {
        return $this->DeliveryOptions;
    }

    public function setDeliveryOptions(array|null $deliveryOptions = null): static
    {
        $this->DeliveryOptions = $deliveryOptions;

        return $this;
    }

    public function getDistance(): string|null
    {
        return $this->Distance;
    }

    public function setDistance(string|null $distance = null): static
    {
        $this->Distance = $distance;

        return $this;
    }

    public function getLatitude(): string|null
    {
        return $this->Latitude;
    }

    public function setLatitude(string|null $latitude = null): static
    {
        $this->Latitude = $latitude;

        return $this;
    }

    public function getLongitude(): string|null
    {
        return $this->Longitude;
    }

    public function setLongitude(string|null $longitude = null): static
    {
        $this->Longitude = $longitude;

        return $this;
    }

    public function getName(): string|null
    {
        return $this->Name;
    }

    public function setName(string|null $name = null): static
    {
        $this->Name = $name;

        return $this;
    }

    public function getOpeningHours(): array|null
    {
        return $this->OpeningHours;
    }

    public function setOpeningHours(array|null $openingHours = null): static
    {
        $this->OpeningHours = $openingHours;

        return $this;
    }

    public function getPartnerName(): string|null
    {
        return $this->PartnerName;
    }

    public function setPartnerName(string|null $partnerName = null): static
    {
        $this->PartnerName = $partnerName;

        return $this;
    }

    public function getPhoneNumber(): string|null
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string|null $phoneNumber = null): static
    {
        $this->PhoneNumber = $phoneNumber;

        return $this;
    }

    public function getLocationCode(): string|null
    {
        return $this->LocationCode;
    }

    public function setLocationCode(string|null $locationCode = null): static
    {
        $this->LocationCode = $locationCode;

        return $this;
    }

    public function getRetailNetworkID(): string|null
    {
        return $this->RetailNetworkID;
    }

    public function setRetailNetworkID(string|null $retailNetworkID = null): static
    {
        $this->RetailNetworkID = $retailNetworkID;

        return $this;
    }

    public function getSaleschannel(): string|null
    {
        return $this->Saleschannel;
    }

    public function setSaleschannel(string|null $salesChannel = null): static
    {
        $this->Saleschannel = $salesChannel;

        return $this;
    }

    public function getTerminalType(): string|null
    {
        return $this->TerminalType;
    }

    public function setTerminalType(string|null $terminalType = null): static
    {
        $this->TerminalType = $terminalType;

        return $this;
    }

    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    public function setWarnings(array|null $warnings = null): static
    {
        $this->Warnings = $warnings;

        return $this;
    }

    public function getDownPartnerID(): string|null
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(string|null $downPartnerID = null): static
    {
        $this->DownPartnerID = $downPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): string|null
    {
        return $this->DownPartnerLocation;
    }

    public function setDownPartnerLocation(string|null $downPartnerLocation = null): static
    {
        $this->DownPartnerLocation = $downPartnerLocation;

        return $this;
    }
}
