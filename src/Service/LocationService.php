<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use DateInterval;
use DateTimeInterface;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Enum\PostNLApiMode;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Firstred\PostNL\Service\Adapter\LocationServiceAdapterInterface;
use Firstred\PostNL\Service\Adapter\Rest\BarcodeServiceRestAdapter;
use Firstred\PostNL\Service\Adapter\Rest\LocationServiceRestAdapter;
use Firstred\PostNL\Service\Adapter\ServiceAdapterSettersTrait;
use Firstred\PostNL\Service\Adapter\Soap\BarcodeServiceSoapAdapter;
use Firstred\PostNL\Service\Adapter\Soap\LocationServiceSoapAdapter;
use GuzzleHttp\Psr7\Message as PsrMessage;
use InvalidArgumentException;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @since 2.0.0
 */
class LocationService extends AbstractService implements LocationServiceInterface
{
    use ServiceAdapterSettersTrait;

    protected LocationServiceAdapterInterface $adapter;

    public function __construct(
        HiddenString $apiKey,
        PostNLApiMode $apiMode,
        bool $sandbox,
        HttpClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $version = LocationServiceInterface::DEFAULT_VERSION,
        CacheItemPoolInterface $cache = null,
        DateInterval|DateTimeInterface|int $ttl = null,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            apiMode: $apiMode,
            sandbox: $sandbox,
            httpClient: $httpClient,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            version: $version,
            cache: $cache,
            ttl: $ttl,
        );
    }

    /**
     * Get the nearest locations via REST.
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function getNearestLocations(GetNearestLocations $getNearestLocations): GetNearestLocationsResponse
    {
        $item = $this->retrieveCachedItem(uuid: $getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->getHttpClient()->doRequest(request: $this->adapter->buildGetNearestLocationsRequest(getNearestLocations: $getNearestLocations));
        }

        $object = $this->adapter->processGetNearestLocationsResponse(response: $response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: PsrMessage::toString(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new NotFoundException(message: 'Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via REST.
     *
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function getLocationsInArea(GetLocationsInArea $getLocations): GetLocationsInAreaResponse
    {
        $item = $this->retrieveCachedItem(uuid: $getLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->getHttpClient()->doRequest(request: $this->adapter->buildGetLocationsInAreaRequest(getLocations: $getLocations));
        }

        $object = $this->adapter->processGetLocationsInAreaResponse(response: $response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: PsrMessage::toString(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new NotFoundException(message: 'Unable to retrieve the nearest locations');
    }

    /**
     * Get the location via REST.
     *
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function getLocation(GetLocation $getLocation): GetLocationsInAreaResponse
    {
        $item = $this->retrieveCachedItem(uuid: $getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->getHttpClient()->doRequest(request: $this->adapter->buildGetLocationRequest(getLocation: $getLocation));
        }

        $object = $this->adapter->processGetLocationResponse(response: $response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: PsrMessage::toString(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new NotFoundException(message: 'Unable to retrieve the nearest locations');
    }

    /**
     * @since 2.0.0
     */
    public function setAPIMode(PostNLApiMode $mode): void
    {
        $this->adapter = $mode == PostNLApiMode::Rest
            ? new LocationServiceRestAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            )
            : new LocationServiceSoapAdapter(
                apiKey: $this->getApiKey(),
                sandbox: $this->isSandbox(),
                requestFactory: $this->getRequestFactory(),
                streamFactory: $this->getStreamFactory(),
                version: $this->getVersion(),
            );
    }
}
