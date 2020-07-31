<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
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
use ThirtyBees\PostNL\PostNL;

/**
 * Class LocationService.
 *
 * @method GetNearestLocationsResponse getNearestLocations(GetNearestLocations $getNearestLocations)
 * @method Request                     buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations)
 * @method GetNearestLocationsResponse processGetNearestLocationsResponse(mixed $response)
 * @method GetLocationsInAreaResponse  getLocationsInArea(GetLocationsInArea $getLocationsInArea)
 * @method Request                     buildGetLocationsInAreaRequest(GetLocationsInArea $getLocationsInArea)
 * @method GetLocationsInAreaResponse  processGetLocationsInAreaResponse(mixed $response)
 * @method GetLocationsInAreaResponse  getLocation(GetLocation $getLocation)
 * @method Request                     buildGetLocationRequest(GetLocation $getLocation)
 * @method GetLocationsInAreaResponse  processGetLocationResponse(mixed $response)
 */
class LocationService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/LocationWebService/2_1/LocationWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/LocationWebService/2_1/LocationWebService.svc';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations';
    const SOAP_ACTION_LOCATIONS_IN_AREA = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetLocationsInArea';
    const SOAP_ACTION_LOCATION = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetLocation';
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
     * @throws \Exception
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getNearestLocationsREST(GetNearestLocations $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetNearestLocationsRequestREST($getNearestLocations));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetNearestLocationsResponseREST($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getNearestLocationsSOAP(GetNearestLocations $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetNearestLocationsRequestSOAP($getNearestLocations));
        }

        $object = $this->processGetNearestLocationsResponseSOAP($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getLocationsInAreaREST(GetLocationsInArea $getLocations)
    {
        $item = $this->retrieveCachedItem($getLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationsInAreaRequest($getLocations));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetLocationsInAreaResponseREST($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getLocationsInAreaSOAP(GetLocationsInArea $getNearestLocations)
    {
        $item = $this->retrieveCachedItem($getNearestLocations->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }

        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationsInAreaRequestSOAP($getNearestLocations));
        }

        $object = $this->processGetLocationsInAreaResponseSOAP($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getLocationREST(GetLocation $getLocation)
    {
        $item = $this->retrieveCachedItem($getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationRequestREST($getLocation));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetLocationResponseREST($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getLocationSOAP(GetLocation $getLocation)
    {
        $item = $this->retrieveCachedItem($getLocation->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationRequestSOAP($getLocation));
        }

        $object = $this->processGetLocationResponseSOAP($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @return Request
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
                if (!array_key_exists('DeliveryOptions', $query)) {
                    $query['DeliveryOptions'] = $option;
                } else {
                    $query['DeliveryOptions'] .= ','.$option;
                }
            }
        } else {
            $query['DeliveryOptions'] = 'PG';
        }

        $endpoint .= '?'.\GuzzleHttp\Psr7\build_query($query, PHP_QUERY_RFC1738);

        return new Request(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Process GetNearestLocations Response REST.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse|null
     *
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetNearestLocationsResponseREST($response)
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
     * @return Request
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
                '{'.static::ENVELOPE_NAMESPACE.'}Body' => [
                    '{'.static::SERVICES_NAMESPACE.'}GetNearestLocations' => $getLocations,
                ],
            ]
        );

        $endpoint = $this->postnl->getSandbox()
            ? (PostNL::MODE_LEGACY === $this->postnl->getMode() ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : (PostNL::MODE_LEGACY === $this->postnl->getMode() ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

        return new Request(
            'POST',
            $endpoint,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * Process GetNearestLocations Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetNearestLocationsResponseSOAP($response)
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
     * @return Request
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
        $endpoint = '/area?'.\GuzzleHttp\Psr7\build_query($query, PHP_QUERY_RFC1738);

        return new Request(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Proess GetLocationsInArea Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetLocationsInAreaResponseREST($response)
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
     * @return Request
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
                '{'.static::ENVELOPE_NAMESPACE.'}Body' => [
                    '{'.static::SERVICES_NAMESPACE.'}GetLocationsInArea' => $getLocations,
                ],
            ]
        );

        $endpoint = $this->postnl->getSandbox()
            ? (PostNL::MODE_LEGACY === $this->postnl->getMode() ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : (PostNL::MODE_LEGACY === $this->postnl->getMode() ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

        return new Request(
            'POST',
            $endpoint,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetLocationsInAreaResponseSOAP($response)
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
     * @return Request
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
        $endpoint = '/lookup?'.\GuzzleHttp\Psr7\build_query($query);

        return new Request(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Process GetLocation Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetLocationResponseREST($response)
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
     * @return Request
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
                '{'.static::ENVELOPE_NAMESPACE.'}Body' => [
                    '{'.static::SERVICES_NAMESPACE.'}GetLocation' => $getLocations,
                ],
            ]
        );

        $endpoint = $this->postnl->getSandbox()
            ? (PostNL::MODE_LEGACY === $this->postnl->getMode() ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : (PostNL::MODE_LEGACY === $this->postnl->getMode() ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

        return new Request(
            'POST',
            $endpoint,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * Process GetLocation Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetLocationResponseSOAP($response)
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
