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
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\Request\GenerateBarcodeRequestDTO;
use Firstred\PostNL\DTO\Request\GenerateBarcodesRequestDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodesResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\RequestBuilder\BarcodeServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\BarcodeServiceResponseProcessorInterface;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;

class BarcodeServiceGateway extends GatewayBase implements BarcodeServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected BarcodeServiceRequestBuilderInterface $requestBuilder,
        protected BarcodeServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $this->httpClient, cache: $cache, ttl: $ttl);
    }

    /**
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doGenerateBarcodeRequest(GenerateBarcodeRequestDTO $generateBarcodeRequestDTO): GenerateBarcodeResponseDTO
    {
        $logger = $this->getLogger();
        $request = null;

        try {
            $request = $this->requestBuilder->buildGenerateBarcodeRequest(generateBarcodeRequestDTO: $generateBarcodeRequestDTO);
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

            $dto = $this->responseProcessor->processGenerateBarcodeResponse(response: $response);

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
                $this->getLogger()?->critical("PostNL API - critical - REQUEST:\n".Message::str(message: $response));
            }

            throw $e;
        } catch (NotAvailableException | InvalidArgumentException $e) {
            /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
            $logger?->error("PostNL API - error - REQUEST:\n".Message::str(message: $request));

            throw $e;
        }
    }

    public function doGenerateBarcodesRequest(GenerateBarcodesRequestDTO $generateBarcodesRequestDTO): GenerateBarcodesResponseDTO
    {
        foreach ($generateBarcodesRequestDTO as $id => $generateBarcodeRequestDTO) {
            $this->getHttpClient()->addOrUpdateRequest(
                id: $id,
                request: $this->getRequestBuilder()->buildGenerateBarcodeRequest(
                    generateBarcodeRequestDTO: $generateBarcodeRequestDTO,
                ),
            );
        }
        unset($id);

        $barcodes = new GenerateBarcodesResponseDTO(service: BarcodeServiceInterface::class, propType: ResponseProp::class);
        foreach ($this->httpClient->doRequests() as $id => $response) {
            if ($response instanceof ResponseInterface) {
                $barcodes[$id] = $this->getResponseProcessor()->processGenerateBarcodeResponse(response: $response);
            } else {
                $barcodes[$id] = $response;
            }
        }

        return $barcodes;
    }

    public function getRequestBuilder(): BarcodeServiceRequestBuilderInterface
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder(BarcodeServiceRequestBuilderInterface $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;

        return $this;
    }

    public function getResponseProcessor(): BarcodeServiceResponseProcessorInterface
    {
        return $this->responseProcessor;
    }

    public function setResponseProcessor(BarcodeServiceResponseProcessorInterface $responseProcessor): static
    {
        $this->responseProcessor = $responseProcessor;

        return $this;
    }
}
