<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
use Psr\Cache\CacheItemPoolInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Coordinates;
use ThirtyBees\PostNL\Entity\Location;
use ThirtyBees\PostNL\Entity\Request\GetLocation;
use ThirtyBees\PostNL\Entity\Request\GetLocationsInArea;
use ThirtyBees\PostNL\Entity\Request\GetNearestLocations;
use ThirtyBees\PostNL\Entity\Response\GenerateLabelResponse;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\Response\GetLocationsInAreaResponse;
use ThirtyBees\PostNL\Entity\Response\GetNearestLocationsResponse;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class LocationService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method GenerateLabelResponse   generateLabel(GenerateLabel $generateLabel, bool $confirm)
 * @method GenerateLabelResponse[] generateLabels(GenerateLabel[] $generateLabel, bool $confirm)
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
    const SOAP_ACTION_LOCATIONS_IN_AREA = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations';
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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetNearestLocationsRESTRequest($getNearestLocations));
            static::validateRESTResponse($response);
        }
        $body = json_decode(static::getResponseText($response), true);
        if (is_array($body)) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            /** @var GetNearestLocationsResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetNearestLocationsResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via SOAP
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \GuzzleHttp\Exception\GuzzleException
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetNearestLocationsSOAPRequest($getNearestLocations));
        }
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        if ($item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getGetLocationsInAreaREST(GetLocationsInArea $getLocations)
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationsInAreaRESTRequest($getLocations));
            static::validateRESTResponse($response);
        }
        $body = json_decode(static::getResponseText($response), true);
        if (is_array($body)) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            /** @var GetLocationsInAreaResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetLocationsInAreaResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via SOAP
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getLocationsInAreaSOAP(GetNearestLocations $getNearestLocations)
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationsInAreaSOAPRequest($getNearestLocations));
        }
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        if ($item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
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
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getGetLocationREST(GetLocation $getLocation)
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationRESTRequest($getLocation));
            static::validateRESTResponse($response);
        }
        $body = json_decode(static::getResponseText($response), true);
        if (is_array($body)) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            /** @var GetLocationsInAreaResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetLocationsInAreaResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        throw new ApiException('Unable to retrieve the nearest locations');
    }

    /**
     * Get the nearest locations via SOAP
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \GuzzleHttp\Exception\GuzzleException
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetLocationSOAPRequest($getLocation));
        }
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        if ($item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GenerateLabel request for the REST API
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return Request
     */
    public function buildGetNearestLocationsRESTRequest(GetNearestLocations $getNearestLocations)
    {
        $endpoint = '/nearest';
        $location = $getNearestLocations->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getNearestLocations);
        $query = [
            'CountryCode'     => $getNearestLocations->getCountryCode(),
            'PostalCode'      => $location->getPostalCode(),
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
            if ($option === 'PG') {
                continue;
            }
            $query['DeliveryOptions'] .= ",$option";
        }
        $endpoint .= '?'.http_build_query($query);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Build the GenerateLabel request for the SOAP API
     *
     * @param GetNearestLocations $getLocations
     *
     * @return Request
     */
    public function buildGetNearestLocationsSOAPRequest(GetNearestLocations $getLocations)
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

        $endpoint = $this->postnl->getSandbox()
            ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

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
     * Build the GetLocationsInArea request for the REST API
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return Request
     */
    public function buildGetLocationsInAreaRESTRequest(GetLocationsInArea $getLocations)
    {
        $location = $getLocations->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getLocations);
        $query = [
            'DeliveryOptions' => 'PG',
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
        foreach ($location->getDeliveryOptions() as $option) {
            if ($option === 'PG') {
                continue;
            }
            $query['DeliveryOptions'] .= ",$option";
        }
        $endpoint = '/area?'.http_build_query($query);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Build the GetLocationsInArea request for the SOAP API
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return Request
     */
    public function buildGetLocationsInAreaSOAPRequest(GetLocationsInArea $getLocations)
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

        $endpoint = $this->postnl->getSandbox()
            ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

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
     * Build the GetLocation request for the REST API
     *
     * @param GetLocation $getLocation
     *
     * @return Request
     */
    public function buildGetLocationRESTRequest(GetLocation $getLocation)
    {
        $location = $getLocation->getLocation();
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getLocation);
        $query = [
            'LocationCode' => $location->getLocationCode(),
        ];
        if ($id = $location->getRetailNetworkID()) {
            $query['RetailNetworkID'] = $id;
        }
        $endpoint = '/lookup?'.http_build_query($query);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Build the GetLocation request for the SOAP API
     *
     * @param GetLocation $getLocations
     *
     * @return Request
     */
    public function buildGetLocationSOAPRequest(GetLocation $getLocations)
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

        $endpoint = $this->postnl->getSandbox()
            ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

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
}
