<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\NotSupportedException;
use stdClass;

/**
 * @since 1.0.0
 */
class ResponseLocation extends AbstractEntity
{
    /** @var Address|null $Address */
    #[SerializableProperty(type: Address::class)]
    protected ?Address $Address = null;

    /** @var string[]|null $DeliveryOptions */
    #[SerializableProperty(type: 'string', isArray: true)]
    protected ?array $DeliveryOptions = null;

    /** @var string|null $Distance */
    #[SerializableProperty(type: 'string')]
    protected ?string $Distance = null;

    /** @var string|null $Latitude */
    #[SerializableProperty(type: 'string')]
    protected ?string $Latitude = null;

    /** @var string|null $Longitude */
    #[SerializableProperty(type: 'string')]
    protected ?string $Longitude = null;

    /** @var string|null $Name */
    #[SerializableProperty(type: 'string')]
    protected ?string $Name = null;

    /** @var OpeningHours|null $OpeningHours */
    #[SerializableProperty(type: OpeningHours::class)]
    protected ?OpeningHours $OpeningHours = null;

    /** @var string|null $PartnerName */
    #[SerializableProperty(type: 'string')]
    protected ?string $PartnerName = null;

    /** @var string|null $PhoneNumber */
    #[SerializableProperty(type: 'string')]
    protected ?string $PhoneNumber = null;

    /** @var string|null $LocationCode */
    #[SerializableProperty(type: 'string')]
    protected ?string $LocationCode = null;

    /** @var string|null $RetailNetworkID */
    #[SerializableProperty(type: 'string')]
    protected ?string $RetailNetworkID = null;

    /** @var string|null $Saleschannel */
    #[SerializableProperty(type: 'string')]
    protected ?string $Saleschannel = null;

    /** @var string|null $TerminalType */
    #[SerializableProperty(type: 'string')]
    protected ?string $TerminalType = null;

    /** @var Warning[]|null $Warnings */
    #[SerializableProperty(type: 'string')]
    protected ?array $Warnings = null;

    /** @var string|null $DownPartnerID */
    #[SerializableProperty(type: 'string')]
    protected ?string $DownPartnerID = null;

    /** @var string|null $DownPartnerLocation */
    #[SerializableProperty(type: 'string')]
    protected ?string $DownPartnerLocation = null;

    /**
     * @param Address|null      $Address
     * @param array|null        $DeliveryOptions
     * @param string|null       $Distance
     * @param string|null       $Latitude
     * @param string|null       $Longitude
     * @param string|null       $Name
     * @param OpeningHours|null $OpeningHours
     * @param string|null       $PartnerName
     * @param string|null       $PhoneNumber
     * @param string|null       $LocationCode
     * @param string|null       $RetailNetworkID
     * @param string|null       $Saleschannel
     * @param string|null       $TerminalType
     * @param array|null        $Warnings
     * @param string|null       $DownPartnerID
     * @param string|null       $DownPartnerLocation
     */
    public function __construct(
        Address $Address = null,
        /* @param string[]|null $DeliveryOptions */
        array $DeliveryOptions = null,
        ?string $Distance = null,
        ?string $Latitude = null,
        ?string $Longitude = null,
        ?string $Name = null,
        ?OpeningHours $OpeningHours = null,
        ?string $PartnerName = null,
        ?string $PhoneNumber = null,
        ?string $LocationCode = null,
        ?string $RetailNetworkID = null,
        ?string $Saleschannel = null,
        ?string $TerminalType = null,
        /* @param Warning[]|null $Warnings */
        ?array $Warnings = null,
        ?string $DownPartnerID = null,
        ?string $DownPartnerLocation = null
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

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    /**
     * @param Address|null $Address
     *
     * @return static
     */
    public function setAddress(?Address $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getDeliveryOptions(): ?array
    {
        return $this->DeliveryOptions;
    }

    /**
     * @param array|null $DeliveryOptions
     *
     * @return static
     */
    public function setDeliveryOptions(?array $DeliveryOptions): static
    {
        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistance(): ?string
    {
        return $this->Distance;
    }

    /**
     * @param int|float|string|null $Distance
     *
     * @return static
     */
    public function setDistance(int|float|string|null $Distance): static
    {
        if (is_int(value: $Distance) || is_float(value: $Distance)) {
            $Distance = (string) $Distance;
        }

        $this->Distance = $Distance;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    /**
     * @param float|string|null $Latitude
     *
     * @return static
     */
    public function setLatitude(float|string|null $Latitude): static
    {
        if (is_float(value: $Latitude)) {
            $Latitude = (string) $Latitude;
        }

        $this->Latitude = $Latitude;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    /**
     * @param float|string|null $Longitude
     *
     * @return static
     */
    public function setLongitude(float|string|null $Longitude): static
    {
        if (is_float(value: $Longitude)) {
            $Longitude = (string) $Longitude;
        }

        $this->Longitude = $Longitude;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     *
     * @return static
     */
    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return OpeningHours|null
     */
    public function getOpeningHours(): ?OpeningHours
    {
        return $this->OpeningHours;
    }

    /**
     * @param OpeningHours|null $OpeningHours
     *
     * @return static
     */
    public function setOpeningHours(?OpeningHours $OpeningHours): static
    {
        $this->OpeningHours = $OpeningHours;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartnerName(): ?string
    {
        return $this->PartnerName;
    }

    /**
     * @param string|null $PartnerName
     *
     * @return static
     */
    public function setPartnerName(?string $PartnerName): static
    {
        $this->PartnerName = $PartnerName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    /**
     * @param string|null $PhoneNumber
     *
     * @return static
     */
    public function setPhoneNumber(?string $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocationCode(): ?string
    {
        return $this->LocationCode;
    }

    /**
     * @param int|string|null $LocationCode
     *
     * @return static
     */
    public function setLocationCode(int|string|null $LocationCode): static
    {
        if (is_int(value: $LocationCode)) {
            $LocationCode = (string) $LocationCode;
        }

        $this->LocationCode = $LocationCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRetailNetworkID(): ?string
    {
        return $this->RetailNetworkID;
    }

    /**
     * @param string|null $RetailNetworkID
     *
     * @return static
     */
    public function setRetailNetworkID(?string $RetailNetworkID): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaleschannel(): ?string
    {
        return $this->Saleschannel;
    }

    /**
     * @param string|null $Saleschannel
     *
     * @return static
     */
    public function setSaleschannel(?string $Saleschannel): static
    {
        $this->Saleschannel = $Saleschannel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTerminalType(): ?string
    {
        return $this->TerminalType;
    }

    /**
     * @param string|null $TerminalType
     *
     * @return static
     */
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
     *
     * @return static
     */
    public function setWarnings(?array $Warnings): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerID(): ?string
    {
        return $this->DownPartnerID;
    }

    /**
     * @param string|null $DownPartnerID
     *
     * @return static
     */
    public function setDownPartnerID(?string $DownPartnerID): static
    {
        $this->DownPartnerID = $DownPartnerID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDownPartnerLocation(): ?string
    {
        return $this->DownPartnerLocation;
    }

    /**
     * @param string|null $DownPartnerLocation
     *
     * @return static
     */
    public function setDownPartnerLocation(?string $DownPartnerLocation): static
    {
        $this->DownPartnerLocation = $DownPartnerLocation;

        return $this;
    }

    /**
     * @param stdClass $json
     *
     * @return static
     *
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws NotSupportedException
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        if (isset($json->ResponseLocation->DeliveryOptions)) {
            /** @var list<string> $deliveryOptions */
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
