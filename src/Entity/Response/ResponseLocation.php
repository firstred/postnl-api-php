<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Enum\SoapNamespace;
use stdClass;

/**
 * @since 1.0.0
 */
class ResponseLocation extends AbstractEntity
{
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?Address $Address = null;

    /** @var string[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $DeliveryOptions = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Distance = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Latitude = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Longitude = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Name = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?OpeningHours $OpeningHours = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $PartnerName = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $PhoneNumber = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $LocationCode = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $RetailNetworkID = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $Saleschannel = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $TerminalType = null;

    /** @var Warning[]|null */
    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?array $Warnings = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerID = null;

    #[SerializableProperty(namespace: SoapNamespace::Domain)]
    protected ?string $DownPartnerLocation = null;

    public function __construct(
        Address       $Address = null,
        /** @param string[]|null $DeliveryOptions */
        array         $DeliveryOptions = null,
        ?string       $Distance = null,
        ?string       $Latitude = null,
        ?string       $Longitude = null,
        ?string       $Name = null,
        ?OpeningHours $OpeningHours = null,
        ?string       $PartnerName = null,
        ?string       $PhoneNumber = null,
        ?string       $LocationCode = null,
        ?string       $RetailNetworkID = null,
        ?string       $Saleschannel = null,
        ?string       $TerminalType = null,
        /** @param Warning[]|null $Warnings */
        ?array        $Warnings = null,
        ?string       $DownPartnerID = null,
        ?string       $DownPartnerLocation = null
    ) {
        parent::__construct();

        $this->setAddress(Address: $Address);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
        $this->setDistance(Distance: $Distance);
        $this->setLatitude(Latitude: $Latitude);
        $this->setLongitude(Longitude: $Longitude);
        $this->setName(Name: $Name);
        $this->setOpeningHours(OpeningHours: $OpeningHours);
        $this->setPartnerName(PartnerName: $PartnerName);
        $this->setPhoneNumber(PhoneNumber: $PhoneNumber);
        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setRetailNetworkID(RetailNetworkID: $RetailNetworkID);
        $this->setSaleschannel(Saleschannel: $Saleschannel);
        $this->setTerminalType(TerminalType: $TerminalType);
        $this->setWarnings(Warnings: $Warnings);
        $this->setDownPartnerID(DownPartnerID: $DownPartnerID);
        $this->setDownPartnerLocation(DownPartnerLocation: $DownPartnerLocation);
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getDeliveryOptions(): ?array
    {
        return $this->DeliveryOptions;
    }

    public function setDeliveryOptions(?array $DeliveryOptions): static
    {
        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->Distance;
    }

    public function setDistance(int|float|string|null $Distance): static
    {
        if (is_int(value: $Distance) || is_float(value: $Distance)) {
            $Distance = (string) $Distance;
        }

        $this->Distance = $Distance;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(float|string|null $Latitude): static
    {
        if (is_float(value: $Latitude)) {
            $Latitude = (string) $Latitude;
        }

        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(float|string|null $Longitude): static
    {
        if (is_float(value: $Longitude)) {
            $Longitude = (string) $Longitude;
        }

        $this->Longitude = $Longitude;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getOpeningHours(): ?OpeningHours
    {
        return $this->OpeningHours;
    }

    public function setOpeningHours(?OpeningHours $OpeningHours): static
    {
        $this->OpeningHours = $OpeningHours;

        return $this;
    }

    public function getPartnerName(): ?string
    {
        return $this->PartnerName;
    }

    public function setPartnerName(?string $PartnerName): static
    {
        $this->PartnerName = $PartnerName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(?string $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getLocationCode(): ?string
    {
        return $this->LocationCode;
    }

    public function setLocationCode(int|string|null $LocationCode): static
    {
        if (is_int(value: $LocationCode)) {
            $LocationCode = (string) $LocationCode;
        }

        $this->LocationCode = $LocationCode;

        return $this;
    }

    public function getRetailNetworkID(): ?string
    {
        return $this->RetailNetworkID;
    }

    public function setRetailNetworkID(?string $RetailNetworkID): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }

    public function getSaleschannel(): ?string
    {
        return $this->Saleschannel;
    }

    public function setSaleschannel(?string $Saleschannel): static
    {
        $this->Saleschannel = $Saleschannel;

        return $this;
    }

    public function getTerminalType(): ?string
    {
        return $this->TerminalType;
    }

    public function setTerminalType(?string $TerminalType): static
    {
        $this->TerminalType = $TerminalType;

        return $this;
    }

    /**
     * @return Warning[]|null
     */
    public function getWarnings(): ?array
    {
        return $this->Warnings;
    }

    /**
     * @param Warning[]|null $Warnings
     * @return static
     */
    public function setWarnings(?array $Warnings): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }

    public function getDownPartnerID(): ?string
    {
        return $this->DownPartnerID;
    }

    public function setDownPartnerID(?string $DownPartnerID): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    public function getDownPartnerLocation(): ?string
    {
        return $this->DownPartnerLocation;
    }

    public function setDownPartnerLocation(?string $DownPartnerLocation): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }

    public static function jsonDeserialize(stdClass $json): static
    {
        if (isset($json->ResponseLocation->DeliveryOptions)) {
            /** @psalm-var list<string> $deliveryOptions */
            $deliveryOptions = [];
            if (!is_array(value: $json->ResponseLocation->DeliveryOptions)) {
                $json->ResponseLocation->DeliveryOptions = [$json->ResponseLocation->DeliveryOptions];
            }

            foreach ($json->ResponseLocation->DeliveryOptions as $deliveryOption) {
                if (isset($deliveryOption->string)) {
                    if (!is_array(value: $deliveryOption->string)) {
                        $deliveryOption->string = [$deliveryOption->string];
                    }
                    foreach ($deliveryOption->string as $optionString) {
                        $deliveryOptions[] = $optionString;
                    }
                } elseif (is_array(value: $deliveryOption)) {
                    $deliveryOptions = array_merge($deliveryOptions, $deliveryOption);
                } elseif (is_string(value: $deliveryOption)) {
                    $deliveryOptions[] = $deliveryOption;
                }
            }

            $json->ResponseLocation->DeliveryOptions = $deliveryOptions;
        }

        return parent::jsonDeserialize(json: $json);
    }
}
