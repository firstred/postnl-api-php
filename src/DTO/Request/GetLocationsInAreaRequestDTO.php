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
use function date;
use function is_null;
use function is_numeric;
use function is_string;
use function str_replace;
use function strtotime;

class GetLocationsInAreaRequestDTO extends SerializableObject
{
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LatitudeNorth = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LongitudeWest = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LatitudeSouth = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LongitudeEast = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $CountryCode = null;

    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $OpeningTime = null;

    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = '',
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = '',

        float|string|null $LatitudeNorth = null,
        float|string|null $LongitudeWest = null,
        float|string|null $LatitudeSouth = null,
        float|string|null $LongitudeEast = null,
        string|null $CountryCode = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
        array|null $DeliveryOptions = null,
    ) {
        parent::__construct(service: $service, propType: $propType);

        $this->setLatitudeNorth(LatitudeNorth: $LatitudeNorth);
        $this->setLongitudeWest(LongitudeWest: $LongitudeWest);
        $this->setLatitudeSouth(LatitudeSouth: $LatitudeSouth);
        $this->setLongitudeEast(LongitudeEast: $LongitudeEast);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setOpeningTime(OpeningTime: $OpeningTime);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
    }

    public function getLatitudeNorth(): float|null
    {
        return $this->LatitudeNorth;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLatitudeNorth(float|string|null $LatitudeNorth = null): static
    {
        if (is_string(value: $LatitudeNorth)) {
            if (!is_numeric(value: $LatitudeNorth)) {
                throw new InvalidArgumentException(message: "Invalid `LatitudeNorth` value passed: $LatitudeNorth");
            }

            $LatitudeNorth = (float) str_replace(search: ',', replace: '.', subject: $LatitudeNorth);
        }

        $this->LatitudeNorth = $LatitudeNorth;

        return $this;
    }

    public function getLongitudeWest(): float|null
    {
        return $this->LongitudeWest;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLongitudeWest(float|string|null $LongitudeWest = null): static
    {
        if (is_string(value: $LongitudeWest)) {
            if (!is_numeric(value: $LongitudeWest)) {
                throw new InvalidArgumentException(message: "Invalid `LongitudeWest` value passed: $LongitudeWest");
            }

            $LongitudeWest = (float) str_replace(search: ',', replace: '.', subject: $LongitudeWest);
        }

        $this->LongitudeWest = $LongitudeWest;

        return $this;
    }

    public function getLatitudeSouth(): float|null
    {
        return $this->LatitudeSouth;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLatitudeSouth(float|string|null $LatitudeSouth = null): static
    {
        if (is_string(value: $LatitudeSouth)) {
            if (!is_numeric(value: $LatitudeSouth)) {
                throw new InvalidArgumentException(message: "Invalid `LatitudeSouth` value passed: $LatitudeSouth");
            }

            $LatitudeSouth = (float) str_replace(search: ',', replace: '.', subject: $LatitudeSouth);
        }

        $this->LatitudeSouth = $LatitudeSouth;

        return $this;
    }

    public function getLongitudeEast(): float|null
    {
        return $this->LongitudeEast;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLongitudeEast(float|string|null $LongitudeEast = null): static
    {
        if (is_string(value: $LongitudeEast)) {
            if (!is_numeric(value: $LongitudeEast)) {
                throw new InvalidArgumentException(message: "Invalid `LongitudeEast` value passed: $LongitudeEast");
            }

            $LongitudeEast = (float) str_replace(search: ',', replace: '.', subject: $LongitudeEast);
        }

        $this->LongitudeEast = $LongitudeEast;

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

    public function getDeliveryOptions(): array|null
    {
        return $this->DeliveryOptions;
    }

    public function setDeliveryOptions(array|null $DeliveryOptions = null): static
    {
        $this->DeliveryOptions = $DeliveryOptions;

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
