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
use Firstred\PostNL\DTO\Request\CalculateTimeframesRequestDTO;
use Firstred\PostNL\DTO\Response\CalculateTimeframesResponseDTO;
use Firstred\PostNL\HttpClient\HTTPClientInterface;
use Firstred\PostNL\RequestBuilder\TimeframeServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\TimeframeServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;

class TimeframeServiceGateway extends GatewayBase implements TimeframeServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HTTPClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected TimeframeServiceRequestBuilderInterface $requestBuilder,
        protected TimeframeServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $this->httpClient, cache: $cache, ttl: $ttl);
    }

    public function doCalculateTimeframesRequest(
        CalculateTimeframesRequestDTO $calculateTimeframesRequestDTO,
    ): CalculateTimeframesResponseDTO {
        $response = $this->getHttpClient()->doRequest(
                request: $this->getRequestBuilder()->buildCalculateTimeframesRequest(
                    calculateTimeframesRequestDTO: $calculateTimeframesRequestDTO,
            ),
        );

        return $this->getResponseProcessor()->processCalculateTimeframesResponse(response: $response);
    }

    public function getRequestBuilder(): TimeframeServiceRequestBuilderInterface
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder(TimeframeServiceRequestBuilderInterface $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;

        return $this;
    }

    public function getResponseProcessor(): TimeframeServiceResponseProcessorInterface
    {
        return $this->responseProcessor;
    }

    public function setResponseProcessor(TimeframeServiceResponseProcessorInterface $responseProcessor): static
    {
        $this->responseProcessor = $responseProcessor;

        return $this;
    }
}
