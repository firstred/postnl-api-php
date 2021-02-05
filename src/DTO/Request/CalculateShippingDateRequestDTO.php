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

namespace Firstred\PostNL\DTO\Request;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_numeric;

/**
 * Class CalculateShippingDateRequestDTO.
 *
 * @see https://developer.postnl.nl/browse-apis/delivery-options/deliverydate-webservice/testtool-rest/
 */
class CalculateShippingDateRequestDTO extends CacheableDTO
{
    /**
     * Date of the expected delivery (to the final destination) of the shipment.
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $DeliveryDate = null;

    /**
     * The duration it takes for the shipment to be delivered to PostNL in days. A value of 1 means that the parcel will be delivered to PostNL on the same day as the date specified in ShippingDate. A value of 2 means the parcel will arrive at PostNL a day later etc.
     *
     * @var int|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected int|null $ShippingDuration = null;

    /**
     * Zipcode of the address.
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [DeliveryDateServiceInterface::class])]
    protected string|null $PostalCode = null;

    /**
     * The ISO2 country codes.
     *
     * Available values: NL, BE
     *
     * Default value: NL
     *
     * @var string|null
     */
    #[ExpectedValues(values: ['NL', 'BE', null])]
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $CountryCode = null;

    /**
     * The ISO2 country codes of the origin country.
     *
     * Available values: NL, BE
     *
     * Default value: NL
     *
     * @var string|null
     */
    #[ExpectedValues(values: ['NL', 'BE', null])]
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $OriginCountryCode = null;

    /**
     * City of the address.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $City = null;

    /**
     * The street name of the delivery address.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $Street = null;

    /**
     * The house number of the delivery address.
     *
     * @var int|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected int|null $HouseNumber = null;

    /**
     * House number extension.
     *
     * @var string|null
     */
    #[RequestProp(optionalFor: [DeliveryDateServiceInterface::class])]
    protected string|null $HouseNrExt = null;

    /**
     * CalculateShippingDateRequestDTO constructor.
     *
     * @param string          $service
     * @param string          $propType
     * @param string          $cacheKey
     * @param string|null     $DeliveryDate
     * @param int|string|null $ShippingDuration
     * @param string|null     $PostalCode
     * @param string|null     $CountryCode
     * @param string|null     $OriginCountryCode
     * @param string|null     $City
     * @param string|null     $Street
     * @param int|string|null $HouseNumber
     * @param string|null     $HouseNrExt
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = DeliveryDateServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        string|null $DeliveryDate = null,
        int|string|null $ShippingDuration = null,
        string|null $PostalCode = null,
        string|null $CountryCode = null,
        string|null $OriginCountryCode = null,
        string|null $City = null,
        string|null $Street = null,
        int|string|null $HouseNumber = null,
        string|null $HouseNrExt = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setDeliveryDate(DeliveryDate: $DeliveryDate);
        $this->setShippingDuration(ShippingDuration: $ShippingDuration);
        $this->setPostalCode(PostalCode: $PostalCode);
        $this->setCountryCode(CountryCode: $CountryCode);
        $this->setOriginCountryCode(OriginCountryCode: $OriginCountryCode);
        $this->setCity(City: $City);
        $this->setStreet(Street: $Street);
        $this->setHouseNumber(HouseNumber: $HouseNumber);
        $this->setHouseNrExt(HouseNrExt: $HouseNrExt);
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
     * @return int|null
     */
    public function getShippingDuration(): int|null
    {
        return $this->ShippingDuration;
    }

    /**
     * @param int|string|null $ShippingDuration
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setShippingDuration(int|string|null $ShippingDuration = null): static
    {
        if (is_string(value: $ShippingDuration)) {
            if (!is_numeric(value: $ShippingDuration)) {
                throw new InvalidArgumentException(message: "Invalid `ShippingDuration` value passed: $ShippingDuration");
            }

            $ShippingDuration = (int) $ShippingDuration;
        }

        $this->ShippingDuration = $ShippingDuration;

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
    public function getOriginCountryCode(): string|null
    {
        return $this->OriginCountryCode;
    }

    /**
     * @param string|null $OriginCountryCode
     *
     * @return static
     */
    public function setOriginCountryCode(string|null $OriginCountryCode = null): static
    {
        $this->OriginCountryCode = $OriginCountryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     *
     * @return static
     */
    public function setCity(string|null $City = null): static
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): string|null
    {
        return $this->Street;
    }

    /**
     * @param string|null $Street
     *
     * @return static
     */
    public function setStreet(string|null $Street = null): static
    {
        $this->Street = $Street;

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

    /**
     * @return string|null
     */
    public function getHouseNrExt(): string|null
    {
        return $this->HouseNrExt;
    }

    /**
     * @param string|null $HouseNrExt
     *
     * @return static
     */
    public function setHouseNrExt(string|null $HouseNrExt = null): static
    {
        $this->HouseNrExt = $HouseNrExt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return "{$this->getShortClassName()}-{$this->getDeliveryDate()}|{$this->getShippingDuration()}|{$this->getPostalCode()}|{$this->getCountryCode()}|{$this->getOriginCountryCode()}|{$this->getCity()}|{$this->getStreet()}|{$this->getHouseNumber()}|{$this->getHouseNrExt()}";
    }
}
