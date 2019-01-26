<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Coordinates;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;

/**
 * Class LocationService
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

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations';
    const SOAP_ACTION_LOCATIONS_IN_AREA = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetLocationsInArea';
    const SOAP_ACTION_LOCATION = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetLocation';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LocationWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LocationWebService/';

    /**
     * Namespaces uses for the SOAP version of this service
     *
     * @var array $namespaces
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
     * Get the nearest locations via REST
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \Firstred\PostNL\Exception\ResponseException
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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildGetNearestLocationsRequestREST($getNearestLocations)
            );
            static::validateRESTResponse($response);
        }

        $object = $this->processGetNearestLocationsResponseREST($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @return Request
     */
    public function buildGetNearestLocationsRequestREST(GetNearestLocations $getNearestLocations)
    {
        $endpoint = '/nearest';
        $location = $getNearestLocations->getLocation();
        $apiKey = $this->postnl->getApiKey();
        $this->setService($getNearestLocations);
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
     * Process GetNearestLocations Response REST
     *
     * @param mixed $response
     *
     * @return null|GetNearestLocationsResponse
     *
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processGetNearestLocationsResponseREST($response): ?GetNearestLocationsResponse
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
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Get the nearest locations via SOAP
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\ResponseException
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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildGetNearestLocationsRequestSOAP($getNearestLocations)
            );
        }

        $object = $this->processGetNearestLocationsResponseSOAP($response);
        if ($object instanceof GetNearestLocationsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve nearest locations');
    }

    /**
     * Build the GenerateLabel request for the SOAP API
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
        $security = new Security($this->postnl->getApiKey());

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

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * Process GetNearestLocations Response SOAP
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\ResponseException
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
                if (strpos($item['name'], 'DeliveryOptions') !== false) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (strpos($item['name'], 'OpeningHours') !== false) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }

        /** @var GetNearestLocationsResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) $array[0]);
        $this->setService($object);

        return $object;
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
     * @throws \Firstred\PostNL\Exception\ResponseException
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
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Proess GetLocationsInArea Response REST
     *
     * @param mixed $response
     *
     * @return null|GetLocationsInAreaResponse
     *
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processGetLocationsInAreaResponseREST($response): GetLocationsInAreaResponse
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
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Get the nearest locations via SOAP
     *
     * @param GetLocationsInArea $getNearestLocations
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\ResponseException
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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildGetLocationsInAreaRequestSOAP($getNearestLocations)
            );
        }

        $object = $this->processGetLocationsInAreaResponseSOAP($response);
        if ($object instanceof GetLocationsInAreaResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve locations in area');
    }

    /**
     * Build the GetLocationsInArea request for the SOAP API
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return Request
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
        $security = new Security($this->postnl->getApiKey());

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

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
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
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processGetLocationsInAreaResponseSOAP($response): GetLocationsInAreaResponse
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);


        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (strpos($item['name'], 'DeliveryOptions') !== false) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (strpos($item['name'], 'OpeningHours') !== false) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) $array[0]);
        $this->setService($object);

        return $object;
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
     * @throws \Firstred\PostNL\Exception\ResponseException
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
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
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
     * @return Request
     *
     * @since 1.0.0
     */
    public function buildGetLocationRequestREST(GetLocation $getLocation): Request
    {
        $apiKey = $this->postnl->getApiKey();
        $this->setService($getLocation);
        $query = [
            'LocationCode' => $getLocation->getLocationCode(),
        ];
        if ($id = $getLocation->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query($query);

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
     * Process GetLocation Response REST
     *
     * @param mixed $response
     *
     * @return null|GetLocationsInAreaResponse
     *
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processGetLocationResponseREST($response): ?GetLocationsInAreaResponse
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
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Get the nearest locations via SOAP
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\ResponseException
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
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve locations in area');
    }

    /**
     * Build the GetLocation request for the SOAP API
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
        $security = new Security($this->postnl->getApiKey());

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

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * Process GetLocation Response SOAP
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processGetLocationResponseSOAP($response): GetLocationsInAreaResponse
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);


        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetLocationsInArea request for the REST API
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return Request
     */
    public function buildGetLocationsInAreaRequestREST(GetLocationsInArea $getLocations)
    {
        $location = $getLocations->getLocation();
        $apiKey = $this->postnl->getApiKey();
        $this->setService($getLocations);
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
}
