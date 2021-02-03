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
use Firstred\PostNL\HttpClient\HTTPClientInterface;
use Firstred\PostNL\RequestBuilder\LocationServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\LocationServiceResponseProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\CacheItemPoolInterface;

class LocationServiceGateway extends GatewayBase implements LocationServiceGatewayInterface
{
    #[Pure]
    public function __construct(
        protected HTTPClientInterface $httpClient,
        protected CacheItemPoolInterface|null $cache,
        protected int|DateTimeInterface|DateInterval|null $ttl,
        protected LocationServiceRequestBuilderInterface $requestBuilder,
        protected LocationServiceResponseProcessorInterface $responseProcessor,
    ) {
        parent::__construct(httpClient: $this->httpClient, cache: $cache, ttl: $ttl);
    }

    public function doLookupLocationRequest(LookupLocationRequestDTO $lookupLocationRequestDTO): GetLocationResponseDTO
    {
        $response = $this->getHttpClient()->doRequest(
            request: $this->getRequestBuilder()->buildLookupLocationRequest(
                lookupLocationRequestDTO: $lookupLocationRequestDTO,
            ),
        );

        return $this->getResponseProcessor()->processGetLocationResponse(response: $response);
    }

    public function doGetNearestLocationsRequest(
        GetNearestLocationsRequestDTO $getNearestLocationsRequestDTO,
    ): GetLocationsResponseDTO {
        $response = $this->getHttpClient()->doRequest(
                request: $this->getRequestBuilder()->buildGetNearestLocationsRequest(
                    getNearestLocationsRequestDTO: $getNearestLocationsRequestDTO,
            ),
        );

        return $this->getResponseProcessor()->processGetLocationsResponse(response: $response);
    }

    public function doGetNearestLocationsGeocodeRequest(
        GetNearestLocationsGeocodeRequestDTO $getNearestLocationsGeocodeRequestDTO,
    ): GetLocationsResponseDTO {
        $response = $this->getHttpClient()->doRequest(
            request: $this->getRequestBuilder()->buildGetNearestLocationsGeocodeRequest(
                getNearestLocationsGeocodeRequestDTO: $getNearestLocationsGeocodeRequestDTO,
            ),
        );

        return $this->getResponseProcessor()->processGetLocationsResponse(response: $response);
    }

    public function doGetLocationsInAreaRequest(
        GetLocationsInAreaRequestDTO $getLocationsInAreaRequestDTO,
    ): GetLocationsResponseDTO {
        $response = $this->getHttpClient()->doRequest(
            request: $this->getRequestBuilder()->buildGetLocationsInAreaRequest(
                    getLocationsInAreaRequestDTO: $getLocationsInAreaRequestDTO,
            ),
        );

        return $this->getResponseProcessor()->processGetLocationsResponse(response: $response);
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
