<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

/**
 * Class PickupOption
 */
class PickupOption extends AbstractEntity
{
    /**
     * @var string|null $pickupDate
     *
     * @since 2.0.0
     */
    protected $pickupDate;

    /**
     * @var string|null $shippingDate
     *
     * @since 2.0.0
     */
    protected $shippingDate;

    /**
     * @var string|null $option
     *
     * @since 2.0.0
     */
    protected $options;

    /**
     * @var Locations|null $locations
     *
     * @since 2.0.0
     */
    protected $locations;

    /**
     * PickupOption constructor.
     *
     * @param string|null    $pickupDate
     * @param string|null    $shippingDate
     * @param string|null    $option
     * @param Locations|null $locations
     *
     * @since 2.0.0
     */
    public function __construct(?string $pickupDate = null, ?string $shippingDate = null, ?string $option = null, ?Locations $locations = null)
    {
        parent::__construct();

        $this->setPickupDate($pickupDate);
        $this->setShippingDate($shippingDate);
        $this->setOption($option);
        $this->setLocations($locations);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getPickupDate(): ?string
    {
        return $this->pickupDate;
    }

    /**
     * @param string|null $pickupDate
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setPickupDate(?string $pickupDate): PickupOption
    {
        $this->pickupDate = $pickupDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    /**
     * @param string|null $shippingDate
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setShippingDate(?string $shippingDate): PickupOption
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getOptions(): ?string
    {
        return $this->options;
    }

    /**
     * @param string|null $options
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setOption(?string $options): PickupOption
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Locations|null
     *
     * @since 2.0.0
     */
    public function getLocations(): ?Locations
    {
        return $this->locations;
    }

    /**
     * @param Locations|null $locations
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setLocations(?Locations $locations): PickupOption
    {
        $this->locations = $locations;

        return $this;
    }
}
