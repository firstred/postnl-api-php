<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\LocationInterface;
use Firstred\PostNL\Entity\Request\FindLocationsInAreaRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsGeocodeRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsRequest;
use Firstred\PostNL\Entity\Request\LookupLocationRequest;
use Firstred\PostNL\Entity\Response\FindLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsGeocodeResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TypeError;

/**
 * Class LocationService.
 */
class LocationService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';

    /**
     * Get the nearest locations via REST.
     *
     * @param FindNearestLocationsRequest $getNearestLocations
     *
     * @return FindNearestLocationsResponse
     *
     * @throws InvalidArgumentException
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function findNearestLocations(FindNearestLocationsRequest $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
                // Ignore cached item
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildFindNearestLocationsRequest($getNearestLocations);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processFindNearestLocationsResponse($response);
        if ($item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && 200 === $response->getStatusCode()
        ) {
            $item->set(Message::str($response));
            $this->cacheItem($item);
        }

        return $object;
    }

    /**
     * Build the GenerateShipmentLabelRequest request for the REST API.
     *
     * @param FindNearestLocationsRequest $findNearestLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildFindNearestLocationsRequest(FindNearestLocationsRequest $findNearestLocations): RequestInterface
    {
        $query = [
            'CountryCode'     => $findNearestLocations->getCountrycode(),
            'PostalCode'      => $findNearestLocations->getPostalCode(),
            'DeliveryOptions' => implode(',', $findNearestLocations->getDeliveryOptions()),
        ];
        if ($city = $findNearestLocations->getCity()) {
            $query['City'] = $city;
        }
        if ($street = $findNearestLocations->getStreet()) {
            $query['Street'] = $street;
        }
        if ($houseNumber = $findNearestLocations->getHouseNumber()) {
            $query['HouseNumber'] = $houseNumber;
        }
        if ($deliveryDate = $findNearestLocations->getDeliveryDate()) {
            $query['DeliveryDate'] = $findNearestLocations->getDeliveryDate();
        }
        if ($openingTime = $findNearestLocations->getOpeningTime()) {
            $query['OpeningTime'] = $findNearestLocations->getOpeningTime();
        }

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'/nearest?'.http_build_query($query)
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey());
    }

    /**
     * Process FindNearestLocationsRequest Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return FindNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function processFindNearestLocationsResponse(ResponseInterface $response): FindNearestLocationsResponse
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);

        /** @var FindNearestLocationsResponse $object */
        $object = FindNearestLocationsResponse::jsonDeserialize(['FindNearestLocationsResponse' => $body]);

        return $object;
    }

    /**
     * Get the nearest locations via REST.
     *
     * @param FindNearestLocationsGeocodeRequest $getLocations
     *
     * @return FindNearestLocationsGeocodeResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function findNearestLocationsGeocode(FindNearestLocationsGeocodeRequest $getLocations): FindNearestLocationsGeocodeResponse
    {
        $item = $this->retrieveCachedItem($getLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildFindNearestLocationsGeocodeRequest($getLocations);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processFindNearestLocationsGeocodeResponse($response);
        if ($object instanceof FindNearestLocationsGeocodeResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new CifDownException('Unable to retrieve the nearest locations', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * @param FindNearestLocationsGeocodeRequest $findNearestLocationsGeocodeRequest
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildFindNearestLocationsGeocodeRequest(FindNearestLocationsGeocodeRequest $findNearestLocationsGeocodeRequest): RequestInterface
    {
        $query = [
            'Latitude'        => $findNearestLocationsGeocodeRequest->getLatitude(),
            'Longitude'       => $findNearestLocationsGeocodeRequest->getLongitude(),
            'CountryCode'     => $findNearestLocationsGeocodeRequest->getCountrycode(),
            'DeliveryOptions' => 'PG',
        ];
        if ($deliveryDate = $findNearestLocationsGeocodeRequest->getDeliveryDate()) {
            $query['DeliveryDate'] = $deliveryDate;
        }
        if ($openingTime = $findNearestLocationsGeocodeRequest->getOpeningTime()) {
            $query['OpeningTime'] = $openingTime;
        }
        foreach ($findNearestLocationsGeocodeRequest->getDeliveryOptions() as $option) {
            if ('PG' === $option) {
                continue;
            }
            $query['DeliveryOptions'] .= ",$option";
        }

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'/nearest/geocode/?'.http_build_query($query)
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey());
    }

    /**
     * Process FindNearestLocationsGeocode Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return FindNearestLocationsGeocodeResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processFindNearestLocationsGeocodeResponse(ResponseInterface $response): FindNearestLocationsGeocodeResponse
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);

        /* @var FindNearestLocationsGeocodeResponse $object */

        return FindNearestLocationsGeocodeResponse::jsonDeserialize(['FindNearestLocationsGeocodeResponse' => $body]);
    }

    /**
     * Find locations in the area.
     *
     * @param FindLocationsInAreaRequest $findLocations
     *
     * @return FindLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function findLocationsInArea(FindLocationsInAreaRequest $findLocations): FindLocationsInAreaResponse
    {
        $item = $this->retrieveCachedItem($findLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildFindLocationsInAreaRequest($findLocations);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processFindLocationsInAreaResponse($response);
        if ($object instanceof FindNearestLocationsGeocodeResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new CifDownException('Unable to retrieve the nearest locations', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * @param FindLocationsInAreaRequest $locationsInArea
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildFindLocationsInAreaRequest(FindLocationsInAreaRequest $locationsInArea): RequestInterface
    {
        $query = [
            'LatitudeNorth'   => $locationsInArea->getLatitudeNorth(),
            'LongitudeWest'   => $locationsInArea->getLongitudeWest(),
            'LatitudeSouth'   => $locationsInArea->getLatitudeSouth(),
            'LongitudeEast'   => $locationsInArea->getLongitudeEast(),
            'CountryCode'     => $locationsInArea->getCountrycode(),
            'DeliveryOptions' => 'PG',
        ];
        if ($deliveryDate = $locationsInArea->getDeliveryDate()) {
            $query['DeliveryDate'] = $deliveryDate;
        }
        if ($openingTime = $locationsInArea->getOpeningTime()) {
            $query['OpeningTime'] = $openingTime;
        }
        foreach ($locationsInArea->getDeliveryOptions() as $option) {
            if ('PG' === $option) {
                continue;
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'/area/?'.http_build_query($query)
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey());
    }

    /**
     * Process FindNearestLocationsGeocode Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return FindLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processFindLocationsInAreaResponse(ResponseInterface $response): FindLocationsInAreaResponse
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);

        /** @var FindLocationsInAreaResponse $object */
        $object = FindLocationsInAreaResponse::jsonDeserialize(['FindLocationsInAreaResponse' => $body]);

        return $object;
    }

    /**
     * Get the location via REST.
     *
     * @param LookupLocationRequest $getLocation
     *
     * @return LocationInterface
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function lookupLocation(LookupLocationRequest $getLocation): LocationInterface
    {
        $item = $this->retrieveCachedItem($getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildLookupLocationRequest($getLocation);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processLookupLocationResponse($response);
        if ($object instanceof Location) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new CifDownException('Unable to retrieve the nearest locations', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the LookupLocationRequest request for the REST API.
     *
     * @param LookupLocationRequest $getLocation
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildLookupLocationRequest(LookupLocationRequest $getLocation): RequestInterface
    {
        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query($query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $this->postnl->getApiKey())
        ;
    }

    /**
     * Process LookupLocationRequest Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return LocationInterface
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processLookupLocationResponse(ResponseInterface $response): LocationInterface
    {
        static::validateResponse($response);
        $body = @json_decode((string) $response->getBody(), true);
        if (is_array($body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation'])) {
                return Location::jsonDeserialize(['Location' => $body['GetLocationsResult']['ResponseLocation']]);
            }
        }

        throw new CifDownException('Unable to process lookup location response', 0, null, null, $response);
    }
}
