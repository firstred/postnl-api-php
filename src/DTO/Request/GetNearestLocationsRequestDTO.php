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
use function strtotime;

/**
 * Class GetNearestLocationsRequestDTO.
 *
 * @see https://developer.postnl.nl/browse-apis/delivery-options/location-webservice/testtool-rest/#/default/get_v2_1_locations_nearest
 */
class GetNearestLocationsRequestDTO extends CacheableDTO
{
    /**
     * The ISO2 country codes
     *
     * Available values: NL, BE
     *
     * Default: NL
     *
     * @var string|null
     */
    #[ExpectedValues(values: ['NL', 'BE'])]
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $CountryCode = null;

    /**
     * Zipcode of the address. Mandatory when no coordinates are entered.
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $PostalCode = null;

    /**
     * City of the address.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $City = null;

    /**
     * The street name of the delivery address.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Street = null;

    /**
     * The house number of the delivery address.
     *
     * @var int|null
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected int|null $HouseNumber = null;

    /**
     * The date of the earliest delivery date. Format: dd-mm-yyyy Note: this date cannot be in the past, otherwise an error is returned.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    /**
     * Time of opening. Format: hh:mm:ss. This field will be used to filter the locations on opening hours.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $OpeningTime = null;

    /**
     * One or more delivery options (related to the product). See Guidelines on this page for possible values
     *
     * Available values: PG
     *
     * Default: PG
     *
     * @var string[]|null
     */
    #[RequestProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    /**
     * GetNearestLocationsRequestDTO constructor.
     *
     * @param string          $service
     * @param string          $propType
     * @param string          $cacheKey
     * @param string|null     $CountryCode
     * @param string|null     $PostalCode
     * @param string|null     $City
     * @param string|null     $Street
     * @param int|string|null $HouseNumber
     * @param string|null     $DeliveryDate
     * @param string|null     $OpeningTime
     * @param array|null      $DeliveryOptions
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = LocationServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        string|null $CountryCode = null,
        string|null $PostalCode = null,
        string|null $City = null,
        string|null $Street = null,
        int|string|null $HouseNumber = null,
        string|null $DeliveryDate = null,
        string|null $OpeningTime = null,
        array|null $DeliveryOptions = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setCity(City: $City);
        $this->setStreet(Street: $Street);
        $this->setHouseNumber(HouseNumber: $HouseNumber);
        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setOpeningTime(OpeningTime: $OpeningTime);
        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
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
    public function getPostalCode(): string|null
    {
        return $this->PostalCode;
    }

    /**
     * @param string|null $PostalCode
     *
     * @return static
     */
    public function setPostalCode(string|null $PostalCode = null): static
    {
        $this->PostalCode = $PostalCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->City;
    }

    public function setCity(string|null $City = null): static
    {
        $this->City = $City;
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

    public function getHouseNumber(): int|null
    {
        return $this->HouseNumber;
    }

    /**
     * @param int|string|null $HouseNumber
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setHouseNumber(int|string|null $HouseNumber = null): static
    {
        if (is_string(value: $HouseNumber)) {
            if (!is_numeric(value: $HouseNumber)) {
                throw new InvalidArgumentException(message: "Invalid `HouseNumber` value passed: $HouseNumber");
            }

            $HouseNumber = (int) $HouseNumber;
        }

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
