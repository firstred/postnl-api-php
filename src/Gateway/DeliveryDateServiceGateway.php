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
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\RequestBuilder\DeliveryDateServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\DeliveryDateServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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

    /**
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doCalculateDeliveryDateRequest(CalculateDeliveryDateRequestDTO $calculateDeliveryDateRequestDTO): CalculateDeliveryDateResponseDTO
    {
        $logger = $this->getLogger();
        $request = null;

        $response = $this->retrieveCachedItem(cacheKey: $calculateDeliveryDateRequestDTO->getCacheKey());
        if (!$response instanceof ResponseInterface) {
            try {
                $request = $this->requestBuilder->buildCalculateDeliveryDateRequest(
                    calculateDeliveryDateRequestDTO: $calculateDeliveryDateRequestDTO,
                );
            } catch (InvalidArgumentException $e) {
                if ($request) {
                    /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                    $logger?->debug("PostNL API - critical - REQUEST:\n".Message::str(message: $request));
                }

                throw $e;
            }

            try {
                $response = $this->getHttpClient()->doRequest(request: $request);

                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $logger?->debug("PostNL API - debug - REQUEST:\n".Message::str(message: $request));
            } catch (HttpClientException $e) {
                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $logger?->debug("PostNL API - critical/unhandled by HTTP client - REQUEST:\n".Message::str(message: $request));

                throw new ApiClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
            }
        }


        try {
            $dto = $this->responseProcessor->processCalculateDeliveryDateResponse(response: $response);

            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $logger?->debug("PostNL API - debug - RESPONSE:\n".Message::str(message: $response));

            return $dto;
        } catch (ApiException | ParseError $e) {
            if ($request instanceof RequestInterface) {
                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $logger?->critical("PostNL API - critical - RESPONSE:\n".Message::str(message: $request));
            }

            $response = $e->getResponse();
            if ($response instanceof ResponseInterface) {
                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $this->getLogger()?->critical("PostNL API - critical - REQUEST:\n".Message::str(message: $response));
            }

            throw $e;
        } catch (NotAvailableException | InvalidArgumentException | InvalidApiKeyException $e) {
            if ($request instanceof RequestInterface) {
                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $logger?->error("PostNL API - error - REQUEST:\n".Message::str(message: $request));
            }

            throw $e;
        }
    }

    public function doCalculateShippingDateRequest(CalculateShippingDateRequestDTO $calculateShippingDateRequestDTO): CalculateShippingDateResponseDTO
    {
        $logger = $this->getLogger();
        $request = null;

        $response = $this->retrieveCachedItem(cacheKey: $calculateShippingDateRequestDTO->getCacheKey());

        $request = $this->requestBuilder->buildCalculateShippingDateRequest(
            calculateShippingDateRequestDTO: $calculateShippingDateRequestDTO,
        );

        $response = $this->httpClient->doRequest(request: $request);

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
