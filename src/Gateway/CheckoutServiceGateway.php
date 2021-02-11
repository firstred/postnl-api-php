<?php

declare(strict_types=1);

namespace Firstred\PostNL\Gateway;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\DTO\Request\GetDeliveryInformationRequestDTO;
use Firstred\PostNL\DTO\Response\GetDeliveryInformationResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\RequestBuilder\CheckoutServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\CheckoutServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;

class CheckoutServiceGateway extends GatewayBase implements CheckoutServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected CheckoutServiceRequestBuilderInterface $requestBuilder,
        protected CheckoutServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $this->httpClient, cache: $cache, ttl: $ttl);
    }

    public function doGetDeliveryInformationRequest(GetDeliveryInformationRequestDTO $getDeliveryInformationRequestDTO): GetDeliveryInformationResponseDTO
    {
        $logger = $this->getLogger();
        $request = null;

        try {
            $request = $this->requestBuilder->buildGetDeliveryInformationRequest(getDeliveryInformationRequestDTO: $getDeliveryInformationRequestDTO);
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

            $dto = $this->responseProcessor->processGetDeliveryInformationResponse(response: $response);

            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $logger?->debug("PostNL API - debug - RESPONSE:\n".Message::str(message: $response));

            return $dto;
        } catch (HttpClientException $e) {
            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $logger?->debug("PostNL API - critical/unhandled by HTTP client - REQUEST:\n".Message::str(message: $request));

            throw new ApiClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } catch (ApiException | ParseError $e) {
            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $logger?->critical("PostNL API - critical - RESPONSE:\n".Message::str(message: $request));
            $response = $e->getResponse();
            if ($response instanceof ResponseInterface) {
                /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
                $logger?->critical("PostNL API - critical - REQUEST:\n".Message::str(message: $response));
            }

            throw $e;
        } catch (NotAvailableException | InvalidArgumentException | InvalidApiKeyException $e) {
            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $logger?->error("PostNL API - error - REQUEST:\n".Message::str(message: $request));

            throw $e;
        }
    }

    public function getRequestBuilder(): CheckoutServiceRequestBuilderInterface
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder(CheckoutServiceRequestBuilderInterface $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;

        return $this;
    }

    public function getResponseProcessor(): CheckoutServiceResponseProcessorInterface
    {
        return $this->responseProcessor;
    }

    public function setResponseProcessor(CheckoutServiceResponseProcessorInterface $responseProcessor): static
    {
        $this->responseProcessor = $responseProcessor;

        return $this;
    }
}
