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

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\DTO\Request\CalculateDeliveryDateRequestDTO;
use Firstred\PostNL\DTO\Request\CalculateShippingDateRequestDTO;
use Firstred\PostNL\DTO\Response\CalculateDeliveryDateResponseDTO;
use Firstred\PostNL\DTO\Response\CalculateShippingDateResponseDTO;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\RequestBuilder\DeliveryDateServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\DeliveryDateServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;

class DeliveryDateServiceGateway extends GatewayBase implements DeliveryDateServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected DeliveryDateServiceRequestBuilderInterface $requestBuilder,
        protected DeliveryDateServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $httpClient, cache: $cache, ttl: $ttl);
    }

    public function doCalculateDeliveryDateRequest(CalculateDeliveryDateRequestDTO $calculateDeliveryDateRequestDTO): CalculateDeliveryDateResponseDTO
    {
        $response = $this->httpClient->doRequest(
            request: $this->requestBuilder->buildCalculateDeliveryDateRequest(
                calculateDeliveryDateRequestDTO: $calculateDeliveryDateRequestDTO
            ),
        );

        return $this->responseProcessor->processCalculateDeliveryDateResponse(response: $response);
    }

    public function doCalculateShippingDateRequest(CalculateShippingDateRequestDTO $calculateShippingDateRequestDTO): CalculateShippingDateResponseDTO
    {
        $response = $this->httpClient->doRequest(
                request: $this->requestBuilder->buildCalculateShippingDateRequest(
                    calculateShippingDateRequestDTO: $calculateShippingDateRequestDTO,
            ),
        );

        return $this->responseProcessor->processGetShippingDateResponse(response: $response);
    }

    public function getRequestBuilder(): DeliveryDateServiceRequestBuilderInterface
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder(DeliveryDateServiceRequestBuilderInterface $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;

        return $this;
    }

    public function getResponseProcessor(): DeliveryDateServiceResponseProcessorInterface
    {
        return $this->responseProcessor;
    }

    public function setResponseProcessor(DeliveryDateServiceResponseProcessorInterface $responseProcessor): static
    {
        $this->responseProcessor = $responseProcessor;

        return $this;
    }
}
