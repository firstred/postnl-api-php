<?php
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

namespace ThirtyBees\PostNL\Service;

use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Coordinates;
use ThirtyBees\PostNL\Entity\Request\GetLocation;
use ThirtyBees\PostNL\Entity\Request\GetLocationsInArea;
use ThirtyBees\PostNL\Entity\Request\GetNearestLocations;
use ThirtyBees\PostNL\Entity\Response\GetLocationsInAreaResponse;
use ThirtyBees\PostNL\Entity\Response\GetNearestLocationsResponse;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class LocationService.
 *
 * @method GetNearestLocationsResponse getNearestLocations(GetNearestLocations $getNearestLocations)
 * @method RequestInterface                     buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations)
 * @method GetNearestLocationsResponse processGetNearestLocationsResponse(mixed $response)
 * @method GetLocationsInAreaResponse  getLocationsInArea(GetLocationsInArea $getLocationsInArea)
 * @method RequestInterface                     buildGetLocationsInAreaRequest(GetLocationsInArea $getLocationsInArea)
 * @method GetLocationsInAreaResponse  processGetLocationsInAreaResponse(mixed $response)
 * @method GetLocationsInAreaResponse  getLocation(GetLocation $getLocation)
 * @method RequestInterface                     buildGetLocationRequest(GetLocation $getLocation)
 * @method GetLocationsInAreaResponse  processGetLocationResponse(mixed $response)
 *
 * @since 1.0.0
 */
class LocationService extends AbstractService implements LocationServiceInterface
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations';
    const SOAP_ACTION_LOCATIONS_IN_AREA = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetLocationsInArea';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LocationWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LocationWebService/';

    /**
     * Namespaces uses for the SOAP version of this service.
     *
     * @var array
     */
    public static $namespaces = [
        self::ENVELOPE_NAMESPACE                                    => 'soap',
        self::OLD_ENVELOPE_NAMESPACE                                => 'env',
        self::SERVICES_NAMESPACE                                    => 'services',
        self::DOMAIN_NAMESPACE                                      => 'domain',
        Security::SECURITY_NAMESPACE                                => 'wsse',
        self::XML_SCHEMA_NAMESPACE                                  => 'schema',
        self::COMMON_NAMESPACE                                      => 'common',
        'http://schemas.microsoft.com/2003/10/Serialization/Arrays' => 'arr',
    ];

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
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function getNearestLocationsREST(GetNearestLocations $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetNearestLocationsRequestREST($getNearestLocations));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetNearestLocationsResponseREST($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via SOAP.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function getNearestLocationsSOAP(GetNearestLocations $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetNearestLocationsRequestSOAP($getNearestLocations));
        }

        $object = $this->processGetNearestLocationsResponseSOAP($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve nearest locations');
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function getLocationsInAreaREST(GetLocationsInArea $getLocations)
    {
        $item = $this->retrieveCachedItem($getLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationsInAreaRequest($getLocations));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetLocationsInAreaResponseREST($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via SOAP.
     *
     * @param GetLocationsInArea $getNearestLocations
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function getLocationsInAreaSOAP(GetLocationsInArea $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }

        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationsInAreaRequestSOAP($getNearestLocations));
        }

        $object = $this->processGetLocationsInAreaResponseSOAP($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve locations in area');
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function getLocationREST(GetLocation $getLocation)
    {
        $item = $this->retrieveCachedItem($getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationRequestREST($getLocation));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetLocationResponseREST($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via SOAP.
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function getLocationSOAP(GetLocation $getLocation)
    {
        $item = $this->retrieveCachedItem($getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationRequestSOAP($getLocation));
        }

        $object = $this->processGetLocationResponseSOAP($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve locations in area');
    }

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetNearestLocationsRequestREST(GetNearestLocations $getNearestLocations)
    {
        $endpoint = '/nearest';
        $location = $getNearestLocations->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getNearestLocations);
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
        if ($deliveryOptions = $location->getDeliveryOptions()) {
            foreach ($deliveryOptions as $option) {
                if ($option === 'PGE') {
                    continue; // No longer supported
                }

                if (!array_key_exists('DeliveryOptions', $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
            if (!isset($query['DeliveryOptions'])) {
                $query['DeliveryOptions'] = 'PG';
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }

        $endpoint .= '?'.http_build_query($query);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetNearestLocations Response REST.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse|null
     *
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGetNearestLocationsResponseREST($response)
    {
        $body = @json_decode(static::getResponseText($response), true);
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

                        $location['OpeningHours'] = AbstractEntity::jsonDeserialize(['OpeningHours' => $location['OpeningHours']]);
                    }

                    $newLocations[] = AbstractEntity::jsonDeserialize(['ResponseLocation' => $location]);
                }
                $body['GetLocationsResult'] = $newLocations;
            }

            /** @var GetNearestLocationsResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetNearestLocationsResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GetNearestLocations $getLocations
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetNearestLocationsRequestSOAP(GetNearestLocations $getLocations)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getLocations);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetNearestLocations' => $getLocations,
                ],
            ]
        );

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream($request));
    }

    /**
     * Process GetNearestLocations Response SOAP.
     *
     * @param ResponseInterface $response
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGetNearestLocationsResponseSOAP(ResponseInterface $response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (false !== strpos($item['name'], 'DeliveryOptions')) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (false !== strpos($item['name'], 'OpeningHours')) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }
        $array = $array[0];

        /** @var GetNearestLocationsResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetLocationsInArea request for the REST API.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetLocationsInAreaRequestREST(GetLocationsInArea $getLocations)
    {
        $location = $getLocations->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getLocations);
        $query = [
            'LatitudeNorth' => $location->getCoordinatesNorthWest()->getLatitude(),
            'LongitudeWest' => $location->getCoordinatesNorthWest()->getLongitude(),
            'LatitudeSouth' => $location->getCoordinatesSouthEast()->getLatitude(),
            'LongitudeEast' => $location->getCoordinatesSouthEast()->getLongitude(),
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
        if ($deliveryOptions = $location->getDeliveryOptions()) {
            foreach ($deliveryOptions as $option) {
                if (!array_key_exists('DeliveryOptions', $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }
        $endpoint = '/area?'.http_build_query($query);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Proess GetLocationsInArea Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGetLocationsInAreaResponseREST($response)
    {
        $body = @json_decode(static::getResponseText($response), true);
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

                        $location['OpeningHours'] = AbstractEntity::jsonDeserialize(['OpeningHours' => $location['OpeningHours']]);
                    }

                    $newLocations[] = AbstractEntity::jsonDeserialize(['ResponseLocation' => $location]);
                }
                $body['GetLocationsResult'] = $newLocations;
            }

            /** @var GetLocationsInAreaResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetLocationsInAreaResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetLocationsInArea request for the SOAP API.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetLocationsInAreaRequestSOAP(GetLocationsInArea $getLocations)
    {
        $soapAction = static::SOAP_ACTION_LOCATIONS_IN_AREA;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getLocations);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetLocationsInArea' => $getLocations,
                ],
            ]
        );

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream($request));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGetLocationsInAreaResponseSOAP(ResponseInterface $response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (false !== strpos($item['name'], 'DeliveryOptions')) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (false !== strpos($item['name'], 'OpeningHours')) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetLocation request for the REST API.
     *
     * @param GetLocation $getLocation
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetLocationRequestREST(GetLocation $getLocation)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getLocation);
        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query($query);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetLocation Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGetLocationResponseREST($response)
    {
        $body = @json_decode(static::getResponseText($response), true);
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

                    $location['OpeningHours'] = AbstractEntity::jsonDeserialize(['OpeningHours' => $location['OpeningHours']]);
                }

                $newLocations[] = AbstractEntity::jsonDeserialize(['ResponseLocation' => $location]);
            }
            $body['GetLocationsResult'] = $newLocations;

            /** @var GetLocationsInAreaResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetLocationsInAreaResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetLocation request for the SOAP API.
     *
     * @param GetLocation $getLocations
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetLocationRequestSOAP(GetLocation $getLocations)
    {
        $soapAction = static::SOAP_ACTION_LOCATIONS_IN_AREA;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getLocations);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetLocation' => $getLocations,
                ],
            ]
        );

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream($request));
    }

    /**
     * Process GetLocation Response SOAP.
     *
     * @param ResponseInterface $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGetLocationResponseSOAP(ResponseInterface $response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
