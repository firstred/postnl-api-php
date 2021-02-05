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
use Firstred\PostNL\DTO\Request\GetLocationsInAreaRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsGeocodeRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsRequestDTO;
use Firstred\PostNL\DTO\Request\LookupLocationRequestDTO;
use Firstred\PostNL\DTO\Response\GetLocationResponseDTO;
use Firstred\PostNL\DTO\Response\GetLocationsResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\RequestBuilder\LocationServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\LocationServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LocationServiceGateway extends GatewayBase implements LocationServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected LocationServiceRequestBuilderInterface $requestBuilder,
        protected LocationServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $this->httpClient, cache: $cache, ttl: $ttl);
    }

    /**
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doLookupLocationRequest(LookupLocationRequestDTO $lookupLocationRequestDTO): GetLocationResponseDTO
    {
        $logger = $this->getLogger();
        $request = null;

        $response = $this->retrieveCachedItem(cacheKey: $lookupLocationRequestDTO->getCacheKey());
        if (!$response instanceof ResponseInterface) {
            try {
                $request = $this->getRequestBuilder()->buildLookupLocationRequest(
                    lookupLocationRequestDTO: $lookupLocationRequestDTO,
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
            $dto = $this->getResponseProcessor()->processGetLocationResponse(response: $response);

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

    /**
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doGetNearestLocationsRequest(
        GetNearestLocationsRequestDTO $getNearestLocationsRequestDTO,
    ): GetLocationsResponseDTO {
        $logger = $this->getLogger();
        $request = null;

        $response = $this->retrieveCachedItem(cacheKey: $getNearestLocationsRequestDTO->getCacheKey());
        if (!$response instanceof ResponseInterface) {
            try {
                $request = $this->getRequestBuilder()->buildGetNearestLocationsRequest(
                    getNearestLocationsRequestDTO: $getNearestLocationsRequestDTO,
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
            $dto = $this->getResponseProcessor()->processGetLocationsResponse(response: $response);

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

    /**
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doGetNearestLocationsGeocodeRequest(
        GetNearestLocationsGeocodeRequestDTO $getNearestLocationsGeocodeRequestDTO,
    ): GetLocationsResponseDTO {
        $logger = $this->getLogger();
        $request = null;

        $response = $this->retrieveCachedItem(cacheKey: $getNearestLocationsGeocodeRequestDTO->getCacheKey());
        if (!$response instanceof ResponseInterface) {
            try {
                $request = $this->getRequestBuilder()->buildGetNearestLocationsGeocodeRequest(
                    getNearestLocationsGeocodeRequestDTO: $getNearestLocationsGeocodeRequestDTO,
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
            $dto = $this->getResponseProcessor()->processGetLocationsResponse(response: $response);

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

    /**
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doGetLocationsInAreaRequest(
        GetLocationsInAreaRequestDTO $getLocationsInAreaRequestDTO,
    ): GetLocationsResponseDTO {
        $logger = $this->getLogger();
        $request = null;

        $response = $this->retrieveCachedItem(cacheKey: $getLocationsInAreaRequestDTO->getCacheKey());
        if (!$response instanceof ResponseInterface) {
            try {
                $request = $this->getRequestBuilder()->buildGetLocationsInAreaRequest(
                    getLocationsInAreaRequestDTO: $getLocationsInAreaRequestDTO,
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
            $dto = $this->getResponseProcessor()->processGetLocationsResponse(response: $response);

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

    public function getRequestBuilder(): LocationServiceRequestBuilderInterface
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder(LocationServiceRequestBuilderInterface $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;

        return $this;
    }

    public function getResponseProcessor(): LocationServiceResponseProcessorInterface
    {
        return $this->responseProcessor;
    }

    public function setResponseProcessor(LocationServiceResponseProcessorInterface $responseProcessor): static
    {
        $this->responseProcessor = $responseProcessor;

        return $this;
    }
}
