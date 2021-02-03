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

namespace Firstred\PostNL\Gateway;

use Firstred\PostNL\DTO\Request\CalculateDeliveryDateRequestDTO;
use Firstred\PostNL\DTO\Request\CalculateShippingDateRequestDTO;
use Firstred\PostNL\DTO\Response\CalculateDeliveryDateResponseDTO;
use Firstred\PostNL\DTO\Response\CalculateShippingDateResponseDTO;
use Firstred\PostNL\RequestBuilder\DeliveryDateServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\DeliveryDateServiceResponseProcessorInterface;

interface DeliveryDateServiceGatewayInterface extends GatewayInterface
{
    public function doCalculateDeliveryDateRequest(CalculateDeliveryDateRequestDTO $calculateDeliveryDateRequestDTO): CalculateDeliveryDateResponseDTO;

    public function doCalculateShippingDateRequest(CalculateShippingDateRequestDTO $calculateShippingDateRequestDTO): CalculateShippingDateResponseDTO;

    public function getRequestBuilder(): DeliveryDateServiceRequestBuilderInterface;

    public function setRequestBuilder(DeliveryDateServiceRequestBuilderInterface $requestBuilder): static;

    public function getResponseProcessor(): DeliveryDateServiceResponseProcessorInterface;

    public function setResponseProcessor(DeliveryDateServiceResponseProcessorInterface $responseProcessor): static;
}
