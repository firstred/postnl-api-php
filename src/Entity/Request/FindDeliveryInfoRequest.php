<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\AddressInterface;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\CutOffTimeInterface;

/**
 * Class FindDeliveryInfoRequest.
 */
final class FindDeliveryInfoRequest extends AbstractEntity implements FindDeliveryInfoRequestInterface
{
    /**
     * The order date of the shipment.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null
     *
     * @since 2.0.0
     */
    private $orderDate;

    /**
     * The amount of days it takes for a parcel to be received by PostN. If you delivery the parcel the same day as the order is placed on the webshop, please use the value of 1. A value of 2 means
     * the parcel will arrive at PostNL a day later etc.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var int|null
     *
     * @since 2.0.0
     */
    private $shippingDuration;

    /**
     * Array of CutOffTimes Type.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var CutOffTimeInterface[]|null
     *
     * @since   2.0.0
     */
    private $cutOffTimes;

    /**
     * Specifies whether you are available during holidays.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var bool|null
     *
     * @since 2.0.0
     */
    private $holidaySorting;

    /**
     * Specifies the delivery and pickup options. For a list of possible values please refer to the guidelines.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string[]|null
     *
     * @since 2.0.0
     */
    private $options;

    /**
     * Specifies the number of locations you want returned. This can be a value of 1-3.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @pattern ^[1-3]$
     *
     * @example 3
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $locations;

    /**
     * Specifies the number of days for which the timeframes are returned. This can be a value of 1-9.
     *
     * @pattern ^\d[1-9]$
     *
     * @example 9
     *
     * @var int|null
     *
     * @since   2.0.0
     */
    private $days;

    /**
     * Array of Address type.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var AddressInterface[]|null
     *
     * @since   2.0.0
     */
    private $addresses;

    /**
     * Get order date.
     *
     * @return string|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$orderDate
     */
    public function getOrderDate(): ?string
    {
        return $this->orderDate;
    }

    /**
     * Set order date.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $orderDate
     *
     * @return static
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$orderDate
     */
    public function setOrderDate(?string $orderDate): FindDeliveryInfoRequestInterface
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get shipping duration.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$shippingDuration
     */
    public function getShippingDuration(): ?int
    {
        return $this->shippingDuration;
    }

    /**
     * Set shipping duration.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param int|null $shippingDuration
     *
     * @return static
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$shippingDuration
     */
    public function setShippingDuration(?int $shippingDuration): FindDeliveryInfoRequestInterface
    {
        $this->shippingDuration = $shippingDuration;

        return $this;
    }

    /**
     * Get cut-off time.
     *
     * @return CutOffTimeInterface[]|null
     *
     * @since 2.0.0
     * @see   CutOffTime
     */
    public function getCutOffTimes(): ?array
    {
        return $this->cutOffTimes;
    }

    /**
     * Set cut-off time.
     *
     * @pattern N/A
     *
     * @param CutOffTimeInterface[]|null $cutOffTimes
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     CutOffTime
     */
    public function setCutOffTimes(?array $cutOffTimes): FindDeliveryInfoRequestInterface
    {
        $this->cutOffTimes = $cutOffTimes;

        return $this;
    }

    /**
     * Get holiday sorting setting.
     *
     * @return bool|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$holidaySorting
     */
    public function getHolidaySorting(): ?bool
    {
        return $this->holidaySorting;
    }

    /**
     * Set holiday sorting setting.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param bool|null $holidaySorting
     *
     * @return static
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$holidaySorting
     */
    public function setHolidaySorting(?bool $holidaySorting): FindDeliveryInfoRequestInterface
    {
        $this->holidaySorting = $holidaySorting;

        return $this;
    }

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$options
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set options.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$holidaySorting
     */
    public function setOptions(?array $options): FindDeliveryInfoRequestInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get locations.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$locations
     */
    public function getLocations(): ?int
    {
        return $this->locations;
    }

    /**
     * Set locations.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param int|null $locations
     *
     * @return static
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$locations
     */
    public function setLocations(?int $locations): FindDeliveryInfoRequestInterface
    {
        $this->locations = $locations;

        return $this;
    }

    /**
     * Get days.
     *
     * @return int|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$days
     */
    public function getDays(): ?int
    {
        return $this->days;
    }

    /**
     * Set days.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param int|null $days
     *
     * @return static
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$days
     */
    public function setDays(?int $days): FindDeliveryInfoRequestInterface
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get addresses.
     *
     * @return AddressInterface[]|null
     *
     * @since 2.0.0
     * @see   Address
     */
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }

    /**
     * Set addresses.
     *
     * @pattern N/A
     *
     * @param AddressInterface[]|null $addresses
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     Address
     */
    public function setAddresses(?array $addresses): FindDeliveryInfoRequestInterface
    {
        $this->addresses = $addresses;

        return $this;
    }
}
