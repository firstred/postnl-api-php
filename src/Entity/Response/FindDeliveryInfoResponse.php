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

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\Error;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Locations;
use Firstred\PostNL\Entity\PickupOption;
use Firstred\PostNL\Entity\PickupOptionInterface;
use Firstred\PostNL\Entity\PickupOptions;
use Firstred\PostNL\Entity\PickupOptionsInterface;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\TimeframeInterface;
use Firstred\PostNL\Entity\Timeframes;
use Firstred\PostNL\Entity\TimeframesInterface;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class FindDeliveryInfoResponse.
 */
final class FindDeliveryInfoResponse extends AbstractResponse
{
    /**
     * Delivery options (timeframes).
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var TimeframesInterface
     *
     * @since   2.0.0
     */
    private $deliveryOptions;

    /**
     * Pickup options.
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var PickupOptionsInterface
     *
     * @since   2.0.0
     */
    private $pickupOptions;

    /**
     * Get delivery options.
     *
     * @return TimeframesInterface|null
     *
     * @since 2.0.0 Strict typing
     * @see   Timeframe
     * @see   Timeframes
     */
    public function getDeliveryOptions(): ?TimeframesInterface
    {
        return $this->deliveryOptions;
    }

    /**
     * Add delivery option.
     *
     * @param TimeframeInterface $deliveryOption
     *
     * @return FindDeliveryInfoResponse
     *
     * @see Timeframe
     * @see Timeframes
     */
    public function addDeliveryOption(TimeframeInterface $deliveryOption): FindDeliveryInfoResponse
    {
        if (!$this->deliveryOptions instanceof Timeframes) {
            $this->deliveryOptions = new Timeframes();
        }

        $this->deliveryOptions[] = $deliveryOption;

        return $this;
    }

    /**
     * Set delivery options.
     *
     * @pattern N/A
     *
     * @param TimeframesInterface|null $deliveryOptions
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     Timeframe
     * @see     Timeframes
     */
    public function setDeliveryOptions(?TimeframesInterface $deliveryOptions): FindDeliveryInfoResponse
    {
        $this->deliveryOptions = $deliveryOptions;

        return $this;
    }

    /**
     * Get pickup options.
     *
     * @return PickupOptionsInterface|null
     *
     * @since 2.0.0 Strict typing
     * @see   PickupOption
     * @see   PickupOptions
     */
    public function getPickupOptions(): ?PickupOptionsInterface
    {
        return $this->pickupOptions;
    }

    /**
     * Add a pickup option.
     *
     * @pattern N/A
     *
     * @param PickupOptionInterface $pickupOption
     *
     * @return FindDeliveryInfoResponse
     *
     * @example N/A
     *
     * @see     Location
     * @see     Locations
     */
    public function addPickupOption(PickupOptionInterface $pickupOption): FindDeliveryInfoResponse
    {
        if (!$this->pickupOptions instanceof PickupOptions) {
            $this->pickupOptions = new PickupOption();
        }

        $this->pickupOptions[] = $pickupOption;

        return $this;
    }

    /**
     * Set pickup options.
     *
     * @pattern N/A
     *
     * @param PickupOptionsInterface|null $pickupOptions
     *
     * @return static
     *
     * @example N/A
     *
     * @since   2.0.0 Strict typing
     * @see     PickupOption
     * @see     PickupOptions
     */
    public function setPickupOptions(?PickupOptionsInterface $pickupOptions): FindDeliveryInfoResponse
    {
        $this->pickupOptions = $pickupOptions;

        return $this;
    }

    /**
     * Deserialize JSON.
     *
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @param array $json JSON as associative array
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since        1.0.0
     */
    public static function jsonDeserialize(array $json)
    {
        $object = new static();
        reset($json);
        $shortClassName = key($json);

        if (isset($json[$shortClassName]['Error'])) {
            $value = $json[$shortClassName]['Error'];
            if (isset($value['ErrorsMsg'])) {
                $value = [$value];
            }
            foreach ($value as $error) {
                $object->addError(Error::jsonDeserialize(['Error' => $error]));
            }
        }

        if (isset($json[$shortClassName]['Warnings'])) {
            $value = $json[$shortClassName]['Warnings']['Warning'];
            if (isset($value['Code'])) {
                $value = [$value];
            }
            foreach ($value as $option) {
                $object->addWarning(Warning::jsonDeserialize(['Warning' => $option]));
            }
        }

        if (isset($json[$shortClassName]['DeliveryOptions'])) {
            foreach ($json[$shortClassName]['DeliveryOptions'] as $option) {
                $object->addDeliveryOption(Timeframe::jsonDeserialize(['Timeframe' => $option]));
            }
        }

        if (isset($json[$shortClassName]['PickupOptions'])) {
            foreach ($json[$shortClassName]['PickupOptions'] as $option) {
                $object->addPickupOption(Warning::jsonDeserialize(['PickupOption' => $option]));
            }
        }

        return $object;
    }
}
