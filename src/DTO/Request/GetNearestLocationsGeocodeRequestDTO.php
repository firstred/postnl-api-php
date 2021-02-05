<?php

declare(strict_types=1);

namespace Firstred\PostNL\DTO\Request;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_numeric;

/**
 * Class GetNearestLocationsGeocodeRequestDTO
 */
class GetNearestLocationsGeocodeRequestDTO extends CacheableDTO
{
    /**
     * @var null|float
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $Latitude = null;

    /**
     * @var null|float
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $Longitude = null;

    /**
     * @var null|string
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $CountryCode = null;

    /**
     * @var null|mixed[]
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    /**
     * @var null|int
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected int|null $HouseNumber = null;

    /**
     * @var null|string
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    /**
     * @var null|string
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $OpeningTime = null;

    /**
     * GetNearestLocationsGeocodeRequestDTO constructor.
     *
     * @param string            $service
     * @param string            $propType
     * @param string            $cacheKey
     * @param float|string|null $Latitude
     * @param float|string|null $Longitude
     * @param string|null       $CountryCode
     * @param string|null       $DeliveryDate
     * @param string|null       $OpeningTime
     * @param array|null        $DeliveryOptions
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = LocationServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        float|string|null $Latitude = null,
        float|string|null $Longitude = null,
        string|null $CountryCode = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
        array|null $DeliveryOptions = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setLatitude(Latitude: $Latitude);
        $this->setLongitude(Longitude: $Longitude);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setOpeningTime(OpeningTime: $OpeningTime);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
    }

    /**
     * @return float|null
     */
    public function getLatitude(): float|null
    {
        return $this->Latitude;
    }

    /**
     * @param string|float|null $Latitude
     *
     * @return static
     *
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

    /**
     * @return float|null
     */
    public function getLongitude(): float|null
    {
        return $this->Longitude;
    }

    /**
     * @param string|float|null $Longitude
     *
     * @return static
     *
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

    /**
     * @return string|null
     */
    public function getCountryCode(): string|null
    {
        return $this->CountryCode;
    }

    /**
     * @param string|null $CountryCode
     *
     * @return static
     */
    public function setCountryCode(string|null $CountryCode = null): static
    {
        $this->CountryCode = $CountryCode;

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
     * @return int|null
     */
    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

    /**
     * @param int|null $HouseNumber
     *
     * @return static
     */
    public function setHouseNumber(int|null $HouseNumber = null): static
    {
        $this->HouseNumber = $HouseNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDate(): string|null
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
     * @return array
     *
     * @throws InvalidArgumentException
     */
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
