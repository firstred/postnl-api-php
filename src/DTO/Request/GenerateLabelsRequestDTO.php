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
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\LabellingMessage;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use function is_array;

/**
 * Class GenerateLabelsRequestDTO.
 *
 * @see https://developer.postnl.nl/browse-apis/send-and-track/labelling-webservice/testtool-rest/#/default/post_label
 */
class GenerateLabelsRequestDTO extends CacheableDTO
{
    /**
     * @var Customer|null
     */
    #[RequestProp(requiredFor: [LabellingServiceInterface::class])]
    protected Customer|null $Customer = null;

    /**
     * @var LabellingMessage|null
     */
    #[RequestProp(requiredFor: [LabellingServiceInterface::class])]
    protected LabellingMessage|null $LabellingMessage = null;

    /**
     * @var array|null
     */
    #[RequestProp(requiredFor: [LabellingServiceInterface::class])]
    protected array|null $Shipments = null;

    public function __construct(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service = DeliveryDateServiceInterface::class,
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType = RequestProp::class,
        string $cacheKey = '',

        Customer|null $Customer = null,
        LabellingMessage|null $LabellingMessage = null,
        Shipment|array|null $Shipments = null,
    ) {
        parent::__construct(service: $service, propType: $propType, cacheKey: $cacheKey);

        $this->setCustomer(Customer: $Customer);
        $this->setLabellingMessage(LabellingMessage: $LabellingMessage);
        $this->setShipments(Shipments: $Shipments);
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): Customer|null
    {
        return $this->Customer;
    }

    /**
     * @param Customer|null $Customer
     *
     * @return static
     */
    public function setCustomer(Customer|null $Customer = null): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return LabellingMessage|null
     */
    public function getLabellingMessage(): LabellingMessage|null
    {
        return $this->LabellingMessage;
    }

    /**
     * @param LabellingMessage|null $LabellingMessage
     *
     * @return static
     */
    public function setLabellingMessage(LabellingMessage|null $LabellingMessage = null): static
    {
        $this->LabellingMessage = $LabellingMessage;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getShipments(): array|null
    {
        return $this->Shipments;
    }

    /**
     * @param Shipment|array|null $Shipments
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setShipments(Shipment|array|null $Shipments = null): static
    {
        if (!is_array(value: $Shipments) && !is_null(value: $Shipments)) {
            $Shipments = [$Shipments];
        }

        $this->Shipments = $Shipments;
        
        if (is_array(value: $this->Shipments)) {
            foreach ($this->Shipments as $shipment) {
                /** @var Shipment $shipment */
                $shipment->setService(service: $this->getService());
                $shipment->setPropType(propType: $this->getPropType());
            }
        }

        return $this;
    }
}
