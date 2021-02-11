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
use Firstred\PostNL\Entity\Addresses;
use Firstred\PostNL\Entity\CutOffTimes;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class GetDeliveryInformationRequestDTO.
 *
 * @see https://developer.postnl.nl/browse-apis/checkout/checkout-api/testtool-rest/#/default/post_checkout
 */
class GetDeliveryInformationRequestDTO extends CacheableDTO
{
    /**
     * The order date of the shipment.
     *
     * Example: 11-07-2019 12:34:54
     *
     * @var string|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected string|null $OrderDate = null;

    /**
     * The amount of days it takes for a parcel to be received by PostN. If you delivery the parcel the same day as the order is placed on the webshop, please use the value of 1. A value of 2 means the parcel will arrive at PostNL a day later etc.
     *
     * @var string|int|null
     */
    #[RequestProp(optionalFor: [CheckoutServiceInterface::class])]
    protected string|int|null $ShippingDuration = null;

    /**
     *  Array of CutOffTimes Type.
     *
     * @var CutOffTimes|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected CutOffTimes|null $CutOffTimes = null;

    /**
     * Specifies whether you are available during holidays.
     *
     * @var bool|null
     */
    #[RequestProp(optionalFor: [CheckoutServiceInterface::class])]
    protected bool|null $HolidaySorting = null;

    /**
     * Specifies the delivery and pickup options. For a list of possible values please refer to the guidelines.
     *
     * @var array|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected array|null $Options = null;

    /**
     * Specifies the number of locations you want returned. This can be a value of 1-3.
     *
     * @var int|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected int|null $Locations = null;

    /**
     * Specifies the number of days for which the timeframes are returned. This can be a value of 1-9.
     *
     * @var int|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected int|null $Days = null;

    /**
     * Array of Address type
     *
     * @var Addresses|null
     */
    #[RequestProp(requiredFor: [CheckoutServiceInterface::class])]
    protected Addresses|null $Addresses = null;

    /**
     * GetDeliveryInformationRequestDTO constructor.
     *
     * @param string                 $service
     * @param string                 $propType
     * @param string                 $cacheKey
     * @param string|null            $OrderDate
     * @param string|int|null        $ShippingDuration
     * @param CutOffTimes|array|null $CutOffTimes
     * @param bool|null              $HolidaySorting
     * @param array|null             $Options
     * @param int|null               $Locations
     * @param int|null               $Days
     * @param Addresses|array|null   $Addresses
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = CheckoutServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,

        string $cacheKey = '',

        string|null $OrderDate = null,
        string|int|null $ShippingDuration = null,
        CutOffTimes|array|null $CutOffTimes = null,
        bool|null $HolidaySorting = null,
        array|null $Options = null,
        int|null $Locations = null,
        int|null $Days = null,
        Addresses|array|null $Addresses = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setOrderDate(OrderDate: $OrderDate);
        $this->setShippingDuration(ShippingDuration: $ShippingDuration);
        $this->setCutOffTimes(CutOffTimes: $CutOffTimes);
        $this->setHolidaySorting(HolidaySorting: $HolidaySorting);
        $this->setOptions(Options: $Options);
        $this->setLocations(Locations: $Locations);
        $this->setDays(Days: $Days);
        $this->setAddresses(Addresses: $Addresses);
    }

    /**
     * @return Addresses|null
     */
    public function getAddresses(): Addresses|null
    {
        return $this->Addresses;
    }

    /**
     * @param Addresses|array|null $Addresses
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setAddresses(Addresses|array|null $Addresses = null): static
    {
        if (is_array(value: $Addresses)) {
            $Addresses = new Addresses(service: $this->getService(), propType: $this->getPropType(), addresses: $Addresses);
        }

        $this->Addresses = $Addresses;

        $this->Addresses?->setService(service: $this->getService());
        $this->Addresses?->setPropType(propType: $this->getPropType());

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderDate(): ?string
    {
        return $this->OrderDate;
    }

    /**
     * @param string|null $OrderDate
     *
     * @return static
     */
    public function setOrderDate(string|null $OrderDate = null): static
    {
        $this->OrderDate = $OrderDate;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getShippingDuration(): int|string|null
    {
        return $this->ShippingDuration;
    }

    /**
     * @param int|string|null $ShippingDuration
     *
     * @return static
     */
    public function setShippingDuration(int|string|null $ShippingDuration = null): static
    {
        $this->ShippingDuration = $ShippingDuration;

        return $this;
    }

    /**
     * @return CutOffTimes|null
     */
    public function getCutOffTimes(): CutOffTimes|null
    {
        return $this->CutOffTimes;
    }

    /**
     * @param CutOffTimes|array|null $CutOffTimes
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setCutOffTimes(CutOffTimes|array|null $CutOffTimes = null): static
    {
        if (is_array(value: $CutOffTimes)) {
            $CutOffTimes = new CutOffTimes(service: $this->getService(), propType: $this->getPropType(), cutOffTimes: $CutOffTimes);
        }

        $this->CutOffTimes = $CutOffTimes;

        $this->CutOffTimes?->setService(service: $this->getService());
        $this->CutOffTimes?->setPropType(propType: $this->getPropType());

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHolidaySorting(): ?bool
    {
        return $this->HolidaySorting;
    }

    /**
     * @param bool|null $HolidaySorting
     *
     * @return static
     */
    public function setHolidaySorting(bool|null $HolidaySorting = null): static
    {
        $this->HolidaySorting = $HolidaySorting;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptions(): array|null
    {
        return $this->Options;
    }

    /**
     * @param array|null $Options
     *
     * @return static
     */
    public function setOptions(array|null $Options = null): static
    {
        $this->Options = $Options;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLocations(): int|null
    {
        return $this->Locations;
    }

    /**
     * @param int|null $Locations
     *
     * @return static
     */
    public function setLocations(int|null $Locations = null): static
    {
        $this->Locations = $Locations;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDays(): int|null
    {
        return $this->Days;
    }

    /**
     * @param int|null $Days
     *
     * @return static
     */
    public function setDays(int|null $Days = null): static
    {
        $this->Days = $Days;

        return $this;
    }
}
