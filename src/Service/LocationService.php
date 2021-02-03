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

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Coordinates;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\JsonSerializableObject;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use function GuzzleHttp\Psr7\parse_response;
use function GuzzleHttp\Psr7\str;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LocationService implements LocationServiceInterface
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';

    /**
     * Get the nearest locations via REST.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws ResponseException
     */
    public function getNearestLocations(GetNearestLocations $getNearestLocations)
    {
        $item = $this->retrieveCachedItem(uuid: $getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = parse_response(message: $response);
            } catch (InvalidArgumentException) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGetNearestLocationsRequestREST(getNearestLocations: $getNearestLocations));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processGetNearestLocationsResponseREST(response: $response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via REST.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function getLocationsInArea(GetLocationsInArea $getLocations)
    {
        $item = $this->retrieveCachedItem(uuid: $getLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = parse_response(message: $response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGetLocationsInAreaRequest(getLocations: $getLocations));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processGetLocationsInAreaResponseREST(response: $response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the location via REST.
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function getLocation(GetLocation $getLocation)
    {
        $item = $this->retrieveCachedItem(uuid: $getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = parse_response(message: $response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGetLocationRequestREST(getLocation: $getLocation));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processGetLocationResponseREST(response: $response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return RequestInterface
     */
    public function buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations)
    {
        $endpoint = '/nearest';
        $location = $getNearestLocations->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $getNearestLocations);
        $query = [
            'CountryCode' => $getNearestLocations->getCountrycode(),
            'PostalCode'  => $location->getPostalcode(),
        ];
        if ($city = $location->getCity()) {
            $query['City'] = $city;
        }
        if ($street = $location->getStreet()) {
            $query['Street'] = $street;
        }
        if ($houseNumber = $location->getHouseNr()) {
            $query['HouseNumber'] = $houseNumber;
        }
        if ($deliveryDate = $location->calculateDeliveryDate()) {
            $query['DeliveryDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $deliveryDate));
        }
        if ($openingTime = $location->getOpeningTime()) {
            $query['OpeningTime'] = date(format: 'H:i:00', timestamp: strtotime(datetime: $openingTime));
        }
        if ($location->getCoordinates() instanceof Coordinates) {
            $endpoint .= '/geocode';
            unset($query['Street']);
            unset($query['PostalCode']);
            unset($query['City']);
            unset($query['HouseNumber']);
            $query['Latitude'] = $location->getCoordinates()->getLatitude();
            $query['Longitude'] = $location->getCoordinates()->getLongitude();
        }
        if ($deliveryOptions = $location->getDeliveryOptions()) {
            foreach ($deliveryOptions as $option) {
                if (!array_key_exists(key: 'DeliveryOptions', array: $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }

        $endpoint .= '?'.http_build_query(data: $query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json');
    }

    /**
     * Process GetNearestLocations Response REST.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse|null
     *
     * @throws ResponseException
     */
    public function processGetNearestLocationsResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (is_array(value: $body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation'])
                && is_array(value: $body['GetLocationsResult']['ResponseLocation'])
            ) {
                if (isset($body['GetLocationsResult']['ResponseLocation']['Address'])) {
                    $body['GetLocationsResult']['ResponseLocation'] = [$body['GetLocationsResult']['ResponseLocation']];
                }

                $newLocations = [];
                foreach ($body['GetLocationsResult']['ResponseLocation'] as $location) {
                    if (isset($location['Address'])) {
                        $location['Address'] = JsonSerializableObject::jsonDeserialize(json: ['Address' => $location['Address']]);
                    }

                    if (isset($location['DeliveryOptions']['string'])) {
                        $location['DeliveryOptions'] = $location['DeliveryOptions']['string'];
                    }

                    if (isset($location['OpeningHours'])) {
                        foreach ($location['OpeningHours'] as $day => $hour) {
                            if (isset($hour['string'])) {
                                $location['OpeningHours'][$day] = $hour['string'];
                            }
                        }

                        $location['OpeningHours'] = JsonSerializableObject::jsonDeserialize(json: ['OpeningHours' => $location['OpeningHours']]);
                    }

                    $newLocations[] = JsonSerializableObject::jsonDeserialize(json: ['ResponseLocation' => $location]);
                }
                $body['GetLocationsResult'] = $newLocations;
            }

            /** @var GetNearestLocationsResponse $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['GetNearestLocationsResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetLocationsInArea request for the REST API.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     */
    public function buildGetLocationsInAreaRequest(GetLocationsInArea $getLocations)
    {
        $location = $getLocations->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $getLocations);
        $query = [
            'LatitudeNorth' => $location->getCoordinatesNorthWest()->getLatitude(),
            'LongitudeWest' => $location->getCoordinatesNorthWest()->getLongitude(),
            'LatitudeSouth' => $location->getCoordinatesSouthEast()->getLatitude(),
            'LongitudeEast' => $location->getCoordinatesSouthEast()->getLongitude(),
        ];
        if ($countryCode = $getLocations->getCountryCode()) {
            $query['CountryCode'] = $countryCode;
        }
        if ($deliveryDate = $location->calculateDeliveryDate()) {
            $query['DeliveryDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $deliveryDate));
        }
        if ($openingTime = $location->getOpeningTime()) {
            $query['OpeningTime'] = date(format: 'H:i:00', timestamp: strtotime(datetime: $openingTime));
        }
        if ($deliveryOptions = $location->getDeliveryOptions()) {
            foreach ($deliveryOptions as $option) {
                if (!array_key_exists(key: 'DeliveryOptions', array: $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }
        $endpoint = '/area?'.http_build_query(data: $query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json');
    }

    /**
     * Proess GetLocationsInArea Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws ResponseException
     */
    public function processGetLocationsInAreaResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (is_array(value: $body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation'])
                && is_array(value: $body['GetLocationsResult']['ResponseLocation'])
            ) {
                if (isset($body['GetLocationsResult']['ResponseLocation']['Address'])) {
                    $body['GetLocationsResult']['ResponseLocation'] = [$body['GetLocationsResult']['ResponseLocation']];
                }

                $newLocations = [];
                foreach ($body['GetLocationsResult']['ResponseLocation'] as $location) {
                    if (isset($location['Address'])) {
                        $location['Address'] = JsonSerializableObject::jsonDeserialize(json: ['Address' => $location['Address']]);
                    }

                    if (isset($location['DeliveryOptions']['string'])) {
                        $location['DeliveryOptions'] = $location['DeliveryOptions']['string'];
                    }

                    if (isset($location['OpeningHours'])) {
                        foreach ($location['OpeningHours'] as $day => $hour) {
                            if (isset($hour['string'])) {
                                $location['OpeningHours'][$day] = $hour['string'];
                            }
                        }

                        $location['OpeningHours'] = JsonSerializableObject::jsonDeserialize(json: ['OpeningHours' => $location['OpeningHours']]);
                    }

                    $newLocations[] = JsonSerializableObject::jsonDeserialize(json: ['ResponseLocation' => $location]);
                }
                $body['GetLocationsResult'] = $newLocations;
            }

            /** @var GetLocationsInAreaResponse $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['GetLocationsInAreaResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetLocation request for the REST API.
     *
     * @param GetLocation $getLocation
     *
     * @return RequestInterface
     */
    public function buildGetLocationRequest(GetLocation $getLocation)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $getLocation);
        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query(data: $query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json');
    }

    /**
     * Process GetLocation Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws ResponseException
     */
    public function processGetLocationResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (is_array(value: $body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation']['Address'])) {
                $body['GetLocationsResult']['ResponseLocation'] = [$body['GetLocationsResult']['ResponseLocation']];
            }

            $newLocations = [];
            foreach ($body['GetLocationsResult']['ResponseLocation'] as $location) {
                if (isset($location['Address'])) {
                    $location['Address'] = JsonSerializableObject::jsonDeserialize(json: ['Address' => $location['Address']]);
                }

                if (isset($location['DeliveryOptions']['string'])) {
                    $location['DeliveryOptions'] = $location['DeliveryOptions']['string'];
                }

                if (isset($location['OpeningHours'])) {
                    foreach ($location['OpeningHours'] as $day => $hour) {
                        if (isset($hour['string'])) {
                            $location['OpeningHours'][$day] = $hour['string'];
                        }
                    }

                    $location['OpeningHours'] = JsonSerializableObject::jsonDeserialize(json: ['OpeningHours' => $location['OpeningHours']]);
                }

                $newLocations[] = JsonSerializableObject::jsonDeserialize(json: ['ResponseLocation' => $location]);
            }
            $body['GetLocationsResult'] = $newLocations;

            /** @var GetLocationsInAreaResponse $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['GetLocationsInAreaResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    public function getCustomer(): Customer
    {
        // TODO: Implement getCustomer() method.
    }

    public function setCustomer(Customer $customer): static
    {
        // TODO: Implement setCustomer() method.
    }

    public function getApiKey(): string
    {
        // TODO: Implement getApiKey() method.
    }

    public function setApiKey(string $apiKey): static
    {
        // TODO: Implement setApiKey() method.
    }

    public function isSandbox(): bool
    {
        // TODO: Implement isSandbox() method.
    }

    public function setSandbox(bool $sandbox): static
    {
        // TODO: Implement setSandbox() method.
    }
}
