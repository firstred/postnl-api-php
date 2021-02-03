<?php

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_numeric;

class ResponseLocation extends SerializableObject
{
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected int|null $LocationCode = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $Name = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected int|null $Distance = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $Latitude = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $Longitude = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected Address|null $Address = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected OpeningHours|null $OpeningHours = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $PartnerName = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $PhoneNumber = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $RetailNetworkID = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $Saleschannel = null;

    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $TerminalType = null;

    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected array|null $Warnings = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        int|string|null $LocationCode = null,
        string|null $Name = null,
        int|string|null $Distance = null,
        float|string|null $Latitude = null,
        float|string|null $Longitude = null,
        Address|array|null $Address = null,
        array|null $DeliveryOptions = null,
        OpeningHours|array|null $OpeningHours = null,
        string|null $PartnerName = null,
        string|null $PhoneNumber = null,
        string|null $RetailNetworkID = null,
        string|null $Saleschannel = null,
        string|null $TerminalType = null,
        array|null $Warnings = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setLocationCode(LocationCode: $LocationCode);
        $this->setName(Name: $Name);
        $this->setDistance(Distance: $Distance);
        $this->setLatitude(Latitude: $Latitude);
        $this->setLongitude(Longitude: $Longitude);
        $this->setAddress(Address: $Address);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
        $this->setOpeningHours(OpeningHours: $OpeningHours);
        $this->setPartnerName(PartnerName: $PartnerName);
        $this->setPhoneNumber(PhoneNumber: $PhoneNumber);
        $this->setRetailNetworkID(RetailNetworkID: $RetailNetworkID);
        $this->setSaleschannel(Saleschannel: $Saleschannel);
        $this->setTerminalType(TerminalType: $TerminalType);

        $this->setWarnings(Warnings: $Warnings);
    }

    public function getLocationCode(): ?int
    {
        return $this->LocationCode;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLocationCode(int|string|null $LocationCode = null): static
    {
        if (is_string(value: $LocationCode)) {
            if (!is_numeric(value: $LocationCode)) {
                throw new InvalidArgumentException(message: "Invalid `LocationCode` value passed: $LocationCode");
            }

            $LocationCode = (int) $LocationCode;
        }

        $this->LocationCode = $LocationCode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name = null): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->Distance;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setDistance(int|string|null $Distance = null): static
    {
        if (is_string(value: $Distance)) {
            if (!is_numeric(value: $Distance)) {
                throw new InvalidArgumentException(message: "Invalid `Distance` value passed: $Distance");
            }

            $Distance = (int) $Distance;
        }

        $this->Distance = $Distance;

        return $this;
    }

    public function getLatitude(): float|string|null
    {
        return $this->Latitude;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLatitude(float|string|null $Latitude = null): static
    {
        if (is_string(value: $Latitude)) {
            if (!is_numeric(value: $Latitude)) {
                throw new InvalidArgumentException(message: "Invalid `Latitude` value passed: $Latitude");
            }

            $Latitude = (float) str_replace(search: ',', replace: '.', subject: $Latitude);
        }

        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): float|string|null
    {
        return $this->Longitude;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLongitude(float|string|null $Longitude = null): static
    {
        if (is_string(value: $Longitude)) {
            if (!is_numeric(value: $Longitude)) {
                throw new InvalidArgumentException(message: "Invalid `Longitude` value passed: $Longitude");
            }

            $Longitude = (float) str_replace(search: ',', replace: '.', subject: $Longitude);
        }

        $this->Longitude = $Longitude;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(Address|array|null $Address = null): static
    {
        if (is_array(value: $Address)) {
            $Address['service'] = LocationServiceInterface::class;
            $Address['propType'] = ResponseProp::class;
            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $Address = new Address(...$Address);
        }

        $this->Address = $Address;

        return $this;
    }

    public function getDeliveryOptions(): ?array
    {
        return $this->DeliveryOptions;
    }

    public function setDeliveryOptions(?array $DeliveryOptions = null): static
    {
        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    public function getOpeningHours(): ?OpeningHours
    {
        return $this->OpeningHours;
    }

    public function setOpeningHours(OpeningHours|array|null $OpeningHours = null): static
    {
        if (is_array(value: $OpeningHours)) {
            $OpeningHours['service'] = LocationServiceInterface::class;
            $OpeningHours['propType'] = ResponseProp::class;
            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $OpeningHours = new OpeningHours(...$OpeningHours);
        }

        $this->OpeningHours = $OpeningHours;

        return $this;
    }

    public function getPartnerName(): string|null
    {
        return $this->PartnerName;
    }

    public function setPartnerName(string|null $PartnerName = null): static
    {
        $this->PartnerName = $PartnerName;

        return $this;
    }

    public function getPhoneNumber(): string|null
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string|null $PhoneNumber = null): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getRetailNetworkID(): string|null
    {
        return $this->RetailNetworkID;
    }

    public function setRetailNetworkID(?string $RetailNetworkID = null): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

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

    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    public function setWarnings(array|null $Warnings = null): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }
}
