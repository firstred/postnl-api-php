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
use Firstred\PostNL\DTO\Request\GenerateLabelsRequestDTO;
use Firstred\PostNL\DTO\Response\GenerateLabelsResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\RequestBuilder\LabellingServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\LabellingServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;

class LabellingServiceGateway extends GatewayBase implements LabellingServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected LabellingServiceRequestBuilderInterface $requestBuilder,
        protected LabellingServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $this->httpClient, cache: $cache, ttl: $ttl);
    }

    public function doGenerateLabelsRequest(GenerateLabelsRequestDTO $generateLabelsRequestDTO): GenerateLabelsResponseDTO
    {
        $logger = $this->getLogger();
        $request = null;

        try {
            $request = $this->requestBuilder->buildGenerateLabelRequest(generateLabelRequestDTO: $generateLabelsRequestDTO);
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

            $dto = $this->responseProcessor->processGenerateLabelsResponse(response: $response);

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

    public function getRequestBuilder(): LabellingServiceRequestBuilderInterface
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder(LabellingServiceRequestBuilderInterface $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;

        return $this;
    }

    public function getResponseProcessor(): LabellingServiceResponseProcessorInterface
    {
        return $this->responseProcessor;
    }

    public function setResponseProcessor(LabellingServiceResponseProcessorInterface $responseProcessor): static
    {
        $this->responseProcessor = $responseProcessor;

        return $this;
    }
}
