<?php

namespace Firstred\PostNL\Entity\Request;

use Firstred\PostNL\Entity\AddressInterface;
use Firstred\PostNL\Entity\CutOffTimeInterface;

/**
 * Class FindDeliveryInfoRequest.
 */
interface FindDeliveryInfoRequestInterface
{
    /**
     * Get order date.
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$orderDate
     */
    public function getOrderDate(): ?string;

    /**
     * Set order date.
     *
     * @pattern N/A
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     FindDeliveryInfoRequest::$orderDate
     */
    public function setOrderDate(?string $orderDate): FindDeliveryInfoRequestInterface;

    /**
     * Get shipping duration.
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$shippingDuration
     */
    public function getShippingDuration(): ?int;

    /**
     * Set shipping duration.
     *
     * @pattern N/A
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     FindDeliveryInfoRequest::$shippingDuration
     */
    public function setShippingDuration(?int $shippingDuration): FindDeliveryInfoRequestInterface;

    /**
     * Get cut-off time.
     *
     * @return CutOffTimeInterface[]|null
     *
     * @since 2.0.0
     * @see   CutOffTime
     */
    public function getCutOffTimes(): ?array;

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
    public function setCutOffTimes(?array $cutOffTimes): FindDeliveryInfoRequestInterface;

    /**
     * Get holiday sorting setting.
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$holidaySorting
     */
    public function getHolidaySorting(): ?bool;

    /**
     * Set holiday sorting setting.
     *
     * @pattern N/A
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     FindDeliveryInfoRequest::$holidaySorting
     */
    public function setHolidaySorting(?bool $holidaySorting): FindDeliveryInfoRequestInterface;

    /**
     * Get options.
     *
     * @return string[]|null
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$options
     */
    public function getOptions(): ?array;

    /**
     * Set options.
     *
     * @pattern N/A
     *
     * @param string[]|null $options
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     FindDeliveryInfoRequest::$holidaySorting
     */
    public function setOptions(?array $options): FindDeliveryInfoRequestInterface;

    /**
     * Get locations.
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$locations
     */
    public function getLocations(): ?int;

    /**
     * Set locations.
     *
     * @pattern N/A
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     FindDeliveryInfoRequest::$locations
     */
    public function setLocations(?int $locations): FindDeliveryInfoRequestInterface;

    /**
     * Get days.
     *
     * @since 2.0.0
     * @see   FindDeliveryInfoRequest::$days
     */
    public function getDays(): ?int;

    /**
     * Set days.
     *
     * @pattern N/A
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0
     * @see     FindDeliveryInfoRequest::$days
     */
    public function setDays(?int $days): FindDeliveryInfoRequestInterface;

    /**
     * Get addresses.
     *
     * @return AddressInterface[]|null
     *
     * @since 2.0.0
     * @see   Address
     */
    public function getAddresses(): ?array;

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
    public function setAddresses(?array $addresses): FindDeliveryInfoRequestInterface;
}
