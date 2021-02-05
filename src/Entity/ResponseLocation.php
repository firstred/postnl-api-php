<?php

declare(strict_types=1);

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_array;
use function is_numeric;
use function is_string;

/**
 * Class ResponseLocation
 */
class ResponseLocation extends CacheableDTO
{
    /**
     * @var int|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected int|null $LocationCode = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $Name = null;

    /**
     * @var int|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected int|null $Distance = null;

    /**
     * @var float|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected float|null $Latitude = null;

    /**
     * @var float|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected float|null $Longitude = null;

    /**
     * @var Address|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected Address|null $Address = null;

    /**
     * @var mixed[]|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected array|null $DeliveryOptions = null;

    /**
     * @var OpeningHours|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected OpeningHours|null $OpeningHours = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $PartnerName = null;

    /**
     * @var string|null
     */
    #[ResponseProp(requiredFor: [LocationServiceInterface::class])]
    protected string|null $PhoneNumber = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $RetailNetworkID = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $Saleschannel = null;

    /**
     * @var string|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected string|null $TerminalType = null;

    /**
     * @var mixed[]|null
     */
    #[ResponseProp(optionalFor: [LocationServiceInterface::class])]
    protected array|null $Warnings = null;

    /**
     * ResponseLocation constructor.
     *
     * @param string                  $service
     * @param string                  $propType
     * @param string                  $cacheKey
     * @param int|string|null         $LocationCode
     * @param string|null             $Name
     * @param int|string|null         $Distance
     * @param float|string|null       $Latitude
     * @param float|string|null       $Longitude
     * @param Address|array|null      $Address
     * @param array|null              $DeliveryOptions
     * @param OpeningHours|array|null $OpeningHours
     * @param string|null             $PartnerName
     * @param string|null             $PhoneNumber
     * @param string|null             $RetailNetworkID
     * @param string|null             $Saleschannel
     * @param string|null             $TerminalType
     * @param array|null              $Warnings
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES + [''])]
        string $service = LocationServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES + [''])]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

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
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

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

    /**
     * @return int|null
     */
    public function getLocationCode(): int|null
    {
        return $this->LocationCode;
    }

    /**
     * @param int|string|null $LocationCode
     *
     * @return static
     *                         
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

    /**
     * @return string|null
     */
    public function getName(): string|null
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     *
     * @return static
     */
    public function setName(string|null $Name = null): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDistance(): int|null
    {
        return $this->Distance;
    }

    /**
     * @param int|string|null $Distance
     *
     * @return static
     *
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

    /**
     * @return float|string|null
     */
    public function getLatitude(): float|string|null
    {
        return $this->Latitude;
    }

    /**
     * @param float|string|null $Latitude
     *                                   
     * @return static
     *                         
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
     * @param float|string|null $Longitude
     *                                    
     * @return static
     *               
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

    /**
     * @return Address|null
     */
    public function getAddress(): Address|null
    {
        return $this->Address;
    }

    /**
     * @param Address|array|null $Address
     *
     * @return static
     * @throws InvalidArgumentException
     */
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
        if (isset($DeliveryOptions['string'])) {
            if (is_array(value: $DeliveryOptions['string'])) {
                $DeliveryOptions = $DeliveryOptions['string'];
            } elseif (is_string(value: $DeliveryOptions['string'])) {
                $DeliveryOptions = [$DeliveryOptions['string']];
            }
        }

        $this->DeliveryOptions = $DeliveryOptions;

        return $this;
    }

    /**
     * @return OpeningHours|null
     */
    public function getOpeningHours(): OpeningHours|null
    {
        return $this->OpeningHours;
    }

    /**
     * @param OpeningHours|array|null $OpeningHours
     *
     * @return static
     * @throws InvalidArgumentException
     */
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

    /**
     * @return string|null
     */
    public function getPartnerName(): string|null
    {
        return $this->PartnerName;
    }

    /**
     * @param string|null $PartnerName
     *
     * @return static
     */
    public function setPartnerName(string|null $PartnerName = null): static
    {
        $this->PartnerName = $PartnerName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): string|null
    {
        return $this->PhoneNumber;
    }

    /**
     * @param string|null $PhoneNumber
     *
     * @return static
     */
    public function setPhoneNumber(string|null $PhoneNumber = null): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRetailNetworkID(): string|null
    {
        return $this->RetailNetworkID;
    }

    /**
     * @param string|null $RetailNetworkID
     *
     * @return static
     */
    public function setRetailNetworkID(string|null $RetailNetworkID = null): static
    {
        $this->RetailNetworkID = $RetailNetworkID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaleschannel(): string|null
    {
        return $this->Saleschannel;
    }

    /**
     * @param string|null $Saleschannel
     *
     * @return static
     */
    public function setSaleschannel(string|null $Saleschannel = null): static
    {
        $this->Saleschannel = $Saleschannel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTerminalType(): string|null
    {
        return $this->TerminalType;
    }

    /**
     * @param string|null $TerminalType
     *
     * @return static
     */
    public function setTerminalType(string|null $TerminalType = null): static
    {
        $this->TerminalType = $TerminalType;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getWarnings(): array|null
    {
        return $this->Warnings;
    }

    /**
     * @param array|null $Warnings
     *
     * @return static
     */
    public function setWarnings(array|null $Warnings = null): static
    {
        $this->Warnings = $Warnings;

        return $this;
    }

    /**
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function jsonSerialize(): array
    {
        $json =  parent::jsonSerialize();

        $deliveryOptions = $this->getDeliveryOptions();
        if ($deliveryOptions) {
            $json['DeliveryOptions'] = ['string' => $deliveryOptions];
        }

        return $json;
    }
}
