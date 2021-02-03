<?php

declare(strict_types=1);

namespace Firstred\PostNL\DTO\Request;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_numeric;

class GetNearestLocationsGeocodeRequestDTO extends SerializableObject
{
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $Latitude = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $Longitude = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $CountryCode = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected int|null $HouseNumber = null;

    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $OpeningTime = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        float|string|null $Latitude = null,
        float|string|null $Longitude = null,
        string|null $CountryCode = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
        array|null $DeliveryOptions = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setLatitude(Latitude: $Latitude);
        $this->setLongitude(Longitude: $Longitude);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setOpeningTime(OpeningTime: $OpeningTime);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
    }

    public function getLatitude(): float|null
    {
        return $this->Latitude;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLatitude(string|float|null $Latitude = null): static
    {
        if (is_string(value: $Latitude)) {
            if (!is_numeric(value: $Latitude)) {
                throw new InvalidArgumentException(message: "Invalid `Latitude` value passed: $Latitude");
            }

            $Latitude = (float) $Latitude;
        }

        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): float|null
    {
        return $this->Longitude;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLongitude(string|float|null $Longitude = null): static
    {
        if (is_string(value: $Longitude)) {
            if (!is_numeric(value: $Longitude)) {
                throw new InvalidArgumentException(message: "Invalid `Longitude` value passed: $Longitude");
            }

            $Longitude = (float) $Longitude;
        }

        $this->Longitude = $Longitude;

        return $this;
    }

    public function getCountryCode(): string|null
    {
        return $this->CountryCode;
    }

    public function setCountryCode(string|null $CountryCode = null): static
    {
        $this->CountryCode = $CountryCode;

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

    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

    public function setHouseNumber(int|null $HouseNumber = null): static
    {
        $this->HouseNumber = $HouseNumber;

        return $this;
    }

    public function getDeliveryDate(): string|null
    {
        return $this->DeliveryDate;
    }

    public function setDeliveryDate(string|null $DeliveryDate = null): static
    {
        $this->DeliveryDate = $DeliveryDate;

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

    public function jsonSerialize(): array
    {
        $query = parent::jsonSerialize();

        if (!is_null(value: $deliveryOptions = $this->getDeliveryOptions())) {
            $query['DeliveryOptions'] = implode(separator: ',', array: $deliveryOptions);
        }
        if (!is_null(value: $deliveryDate = $this->getDeliveryDate())) {
            $query['DeliveryDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $deliveryDate));
        }
        if (!is_null(value: $openingTime = $this->getOpeningTime())) {
            $query['OpeningTime'] = date(format: 'H:i:s', timestamp: strtotime(datetime: $openingTime));
        }

        return $query;
    }
}
