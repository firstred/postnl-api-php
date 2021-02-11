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

namespace Firstred\PostNL\DTO\Response;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\CacheableDTO;
use Firstred\PostNL\Entity\DeliveryOptions;
use Firstred\PostNL\Entity\PickupOptions;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class GetDeliveryInformationResponseDTO.
 */
class GetDeliveryInformationResponseDTO extends CacheableDTO
{
    #[ResponseProp(requiredFor: [CheckoutServiceInterface::class])]
    protected DeliveryOptions|null $DeliveryOptions = null;

    #[ResponseProp(requiredFor: [CheckoutServiceInterface::class])]
    protected PickupOptions|null $PickupOptions = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = DeliveryDateServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = ResponseProp::class,
        string $cacheKey = '',

        DeliveryOptions|array|null $DeliveryOptions = null,
        PickupOptions|array|null $PickupOptions = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setDeliveryOptions(DeliveryOptions: $DeliveryOptions);
        $this->setPickupOptions(PickupOptions: $PickupOptions);
    }

    /**
     * @return DeliveryOptions|null
     */
    public function getDeliveryOptions(): ?DeliveryOptions
    {
        return $this->DeliveryOptions;
    }

    /**
     * @param DeliveryOptions|array|null $DeliveryOptions
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setDeliveryOptions(DeliveryOptions|array|null $DeliveryOptions = null): static
    {
        if (is_array(value: $DeliveryOptions)) {
            $DeliveryOptions = new DeliveryOptions(
                service: $this->getService(),
                propType: $this->getPropType(),
                DeliveryOptions: $DeliveryOptions,
            );
        }

        $this->DeliveryOptions = $DeliveryOptions;

        $this->DeliveryOptions?->setService(service: $this->getService());
        $this->DeliveryOptions?->setPropType(propType: $this->getPropType());

        return $this;
    }

    /**
     * @return PickupOptions|null
     */
    public function getPickupOptions(): PickupOptions|null
    {
        return $this->PickupOptions;
    }

    /**
     * @param PickupOptions|array|null $PickupOptions
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setPickupOptions(PickupOptions|array|null $PickupOptions = null): static
    {
        if (is_array(value: $PickupOptions)) {
            $PickupOptions = new PickupOptions(
                service: $this->getService(),
                propType: $this->getPropType(),
                PickupOptions: $PickupOptions,
            );
        }

        $this->PickupOptions = $PickupOptions;

        $this->PickupOptions?->setService(service: $this->getService());
        $this->PickupOptions?->setPropType(propType: $this->getPropType());

        return $this;
    }
}
