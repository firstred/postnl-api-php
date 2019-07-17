<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Coordinates;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Util\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LocationService
 */
class LocationService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';

    /**
     * Get the nearest locations via REST
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getNearestLocations(GetNearestLocations $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest(
                $this->buildGetNearestLocationsRequest($getNearestLocations)
            );
            static::validateResponse($response);
        }

        $object = $this->processGetNearestLocationsResponse($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Build the GenerateLabel request for the REST API
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations): RequestInterface
    {
        $endpoint = '/nearest';
        $location = $getNearestLocations->getLocation();
        $query = [
            'CountryCode'     => $getNearestLocations->getCountrycode(),
            'PostalCode'      => $location->getPostalcode(),
            'DeliveryOptions' => 'PG',
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
        if ($deliveryDate = $location->getDeliveryDate()) {
            $query['DeliveryDate'] = date('d-m-Y', strtotime($deliveryDate));
        }
        if ($openingTime = $location->getOpeningTime()) {
            $query['OpeningTime'] = date('H:i:00', strtotime($openingTime));
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
        foreach ($location->getDeliveryOptions() as $option) {
            if ('PG' === $option) {
                continue;
            }
            $query['DeliveryOptions'] .= ",$option";
        }
        $endpoint .= '?'.http_build_query($query);

        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GetNearestLocations Response REST
     *
     * @param mixed $response
     *
     * @return null|GetNearestLocationsResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetNearestLocationsResponse($response): ?GetNearestLocationsResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (is_array($body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation'])
                && is_array($body['GetLocationsResult']['ResponseLocation'])
            ) {
                if (isset($body['GetLocationsResult']['ResponseLocation']['Address'])) {
                    $body['GetLocationsResult']['ResponseLocation'] = [$body['GetLocationsResult']['ResponseLocation']];
                }

                $newLocations = [];
                foreach ($body['GetLocationsResult']['ResponseLocation'] as $location) {
                    if (isset($location['Address'])) {
                        $location['Address'] = AbstractEntity::jsonDeserialize(['Address' => $location['Address']]);
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

                        $location['OpeningHours'] = AbstractEntity::jsonDeserialize(
                            ['OpeningHours' => $location['OpeningHours']]
                        );
                    }

                    $newLocations[] = AbstractEntity::jsonDeserialize(['ResponseLocation' => $location]);
                }
                $body['GetLocationsResult'] = $newLocations;
            }

            /** @var GetNearestLocationsResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetNearestLocationsResponse' => $body]);

            return $object;
        }

        return null;
    }

    /**
     * Get the nearest locations via REST
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLocationsInArea(GetLocationsInArea $getLocations)
    {
        $item = $this->retrieveCachedItem($getLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest($this->buildGetLocationsInAreaRequest($getLocations));
            static::validateResponse($response);
        }

        $object = $this->processGetLocationsInAreaResponse($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Process GetLocationsInArea Response REST
     *
     * @param mixed $response
     *
     * @return null|GetLocationsInAreaResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetLocationsInAreaResponse($response): GetLocationsInAreaResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (is_array($body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation'])
                && is_array($body['GetLocationsResult']['ResponseLocation'])
            ) {
                if (isset($body['GetLocationsResult']['ResponseLocation']['Address'])) {
                    $body['GetLocationsResult']['ResponseLocation'] = [$body['GetLocationsResult']['ResponseLocation']];
                }

                $newLocations = [];
                foreach ($body['GetLocationsResult']['ResponseLocation'] as $location) {
                    if (isset($location['Address'])) {
                        $location['Address'] = AbstractEntity::jsonDeserialize(['Address' => $location['Address']]);
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

                        $location['OpeningHours'] = AbstractEntity::jsonDeserialize(
                            ['OpeningHours' => $location['OpeningHours']]
                        );
                    }

                    $newLocations[] = AbstractEntity::jsonDeserialize(['ResponseLocation' => $location]);
                }
                $body['GetLocationsResult'] = $newLocations;
            }

            /** @var GetLocationsInAreaResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetLocationsInAreaResponse' => $body]);

            return $object;
        }

        return null;
    }

    /**
     * Get the location via REST
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function getLocation(GetLocation $getLocation): GetLocationsInAreaResponse
    {
        $item = $this->retrieveCachedItem($getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = Client::getInstance()->doRequest($this->buildGetLocationRequest($getLocation));
            static::validateResponse($response);
        }

        $object = $this->processGetLocationResponse($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Build the GetLocation request for the REST API
     *
     * @param GetLocation $getLocation
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildGetLocationRequest(GetLocation $getLocation): RequestInterface
    {
        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query($query);

        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GetLocation Response REST
     *
     * @param mixed $response
     *
     * @return null|GetLocationsInAreaResponse
     *

     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetLocationResponse($response): ?GetLocationsInAreaResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (is_array($body)) {
            if (isset($body['GetLocationsResult']['ResponseLocation']['Address'])) {
                $body['GetLocationsResult']['ResponseLocation'] = [$body['GetLocationsResult']['ResponseLocation']];
            }

            $newLocations = [];
            foreach ($body['GetLocationsResult']['ResponseLocation'] as $location) {
                if (isset($location['Address'])) {
                    $location['Address'] = AbstractEntity::jsonDeserialize(['Address' => $location['Address']]);
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

                    $location['OpeningHours'] = AbstractEntity::jsonDeserialize(
                        ['OpeningHours' => $location['OpeningHours']]
                    );
                }

                $newLocations[] = AbstractEntity::jsonDeserialize(['ResponseLocation' => $location]);
            }
            $body['GetLocationsResult'] = $newLocations;

            /** @var GetLocationsInAreaResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetLocationsInAreaResponse' => $body]);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetLocationsInArea request for the REST API
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     */
    public function buildGetLocationsInAreaRequest(GetLocationsInArea $getLocations): RequestInterface
    {
        $location = $getLocations->getLocation();
        $query = [
            'DeliveryOptions' => 'PG',
            'LatitudeNorth'   => $location->getCoordinatesNorthWest()->getLatitude(),
            'LongitudeWest'   => $location->getCoordinatesNorthWest()->getLongitude(),
            'LatitudeSouth'   => $location->getCoordinatesSouthEast()->getLatitude(),
            'LongitudeEast'   => $location->getCoordinatesSouthEast()->getLongitude(),
        ];
        if ($countryCode = $getLocations->getCountryCode()) {
            $query['CountryCode'] = $countryCode;
        }
        if ($deliveryDate = $location->getDeliveryDate()) {
            $query['DeliveryDate'] = date('d-m-Y', strtotime($deliveryDate));
        }
        if ($openingTime = $location->getOpeningTime()) {
            $query['OpeningTime'] = date('H:i:00', strtotime($openingTime));
        }
        foreach ($location->getDeliveryOptions() as $option) {
            if ('PG' === $option) {
                continue;
            }
            $query['DeliveryOptions'] .= ",$option";
        }
        $endpoint = '/area?'.http_build_query($query);

        /** @var RequestFactory $factory */
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }
}
