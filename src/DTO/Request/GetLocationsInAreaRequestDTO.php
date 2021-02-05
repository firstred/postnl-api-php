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
use function date;
use function is_null;
use function is_numeric;
use function is_string;
use function str_replace;
use function strtotime;

/**
 * Class GetLocationsInAreaRequestDTO.
 *
 * @see https://developer.postnl.nl/browse-apis/delivery-options/location-webservice/testtool-rest/#/default/get_v2_1_locations_area
 */
class GetLocationsInAreaRequestDTO extends CacheableDTO
{
    /**
     * The coordinates of the north point of the area.
     *
     * @var float|null $LatitudeNorth
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LatitudeNorth = null;

    /**
     * The coordinates of the west point of the area.
     *
     * @var float|null $LongitudeWest
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LongitudeWest = null;

    /**
     * The coordinates of the south point of the area.
     *
     * @var float|null $LatitudeSouth
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LatitudeSouth = null;

    /**
     * The coordinates of the east point of the area.
     *
     * @var float|null $LongitudeEast
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected float|null $LongitudeEast = null;

    /**
     * Country code.
     *
     * Available values: NL, BE
     *
     * Default value: NL
     *
     * @var string|null $CountryCode
     */
    #[ExpectedValues(values: ['NL', 'BE'])]
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $CountryCode = null;

    /**
     * The date of the earliest delivery date. Format: dd-mm-yyyy Note: this date cannot be in the past, otherwise an error is returned.
     *
     * @var string|null $DeliveryDate
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    /**
     * Time of opening. Format: hh:mm:ss. This field will be used to filter the locations on opening hours.
     *
     * @var string|null $OpeningTime
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $OpeningTime = null;

    /**
     * The delivery options (timeframes) for which locations should be returned. See Guidelines.
     *
     * Available values: PG
     *
     * Default value: PG
     *
     * @var array|null $DeliveryOptions
     */
    #[ExpectedValues(values: ['PG'])]
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    /**
     * GetLocationsInAreaRequestDTO constructor.
     *
     * @param string            $service
     * @param string            $propType
     * @param string            $cacheKey
     * @param float|string|null $LatitudeNorth
     * @param float|string|null $LongitudeWest
     * @param float|string|null $LatitudeSouth
     * @param float|string|null $LongitudeEast
     * @param string|null       $CountryCode
     * @param string|null       $DeliveryDate
     * @param string|null       $OpeningTime
     * @param array|null        $DeliveryOptions
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = LocationServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        float|string|null $LatitudeNorth = null,
        float|string|null $LongitudeWest = null,
        float|string|null $LatitudeSouth = null,
        float|string|null $LongitudeEast = null,
        string|null $CountryCode = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
        array|null $DeliveryOptions = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setLatitudeNorth(LatitudeNorth: $LatitudeNorth);
        $this->setLongitudeWest(LongitudeWest: $LongitudeWest);
        $this->setLatitudeSouth(LatitudeSouth: $LatitudeSouth);
        $this->setLongitudeEast(LongitudeEast: $LongitudeEast);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setOpeningTime(OpeningTime: $OpeningTime);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
    }

    /**
     * @return float|null
     */
    public function getLatitudeNorth(): float|null
    {
        return $this->LatitudeNorth;
    }

    /**
     * @param float|string|null $LatitudeNorth
     *
     * @return static
     *
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

    /**
     * @return float|null
     */
    public function getLongitudeWest(): float|null
    {
        return $this->LongitudeWest;
    }

    /**
     * @param float|string|null $LongitudeWest
     *
     * @return static
     *
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

    /**
     * @return float|null
     */
    public function getLatitudeSouth(): float|null
    {
        return $this->LatitudeSouth;
    }

    /**
     * @param float|string|null $LatitudeSouth
     *
     * @return static
     *
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

    /**
     * @return float|null
     */
    public function getLongitudeEast(): float|null
    {
        return $this->LongitudeEast;
    }

    /**
     * @param float|string|null $LongitudeEast
     *
     * @return static
     *
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
