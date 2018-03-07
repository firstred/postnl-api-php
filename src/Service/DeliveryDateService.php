<?php
/**
 * The MIT License (MIT)
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
use ThirtyBees\PostNL\Entity\CutOffTime;
use ThirtyBees\PostNL\Entity\Request\GetDeliveryDate;
use ThirtyBees\PostNL\Entity\Request\GetSentDateRequest;
use ThirtyBees\PostNL\Entity\Response\GetDeliveryDateResponse;
use ThirtyBees\PostNL\Entity\Response\GetSentDateResponse;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class DeliveryDateService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method GetDeliveryDateResponse getDeliveryDate(GetDeliveryDate $getDeliveryDate)
 * @method Request                 buildGetDeliveryDateRequest(GetDeliveryDate $getDeliveryDate)
 * @method GetDeliveryDateResponse processGetDeliveryDateResponse(mixed $response)
 * @method GetSentDateResponse     getSentDate(GetSentDateRequest $getSentDate)
 * @method Request                 buildGetSentDateRequest(GetSentDateRequest $getSentDate)
 * @method GetSentDateResponse     processGetSentDateResponse(mixed $response)
 */
class DeliveryDateService extends AbstractService
{
    // API Version
    const VERSION = '2.2';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/calculate/date';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/calculate/date/';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/DeliveryDateWebService/2_1/DeliveryDateWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/DeliveryDateWebService/2_1/DeliveryDateWebService.svc';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/DeliveryDateWebService/IDeliveryDateWebService/GetDeliveryDate';
    const SOAP_ACTION_SENT = 'http://postnl.nl/cif/services/DeliveryDateWebService/IDeliveryDateWebService/GetSentDate';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/DeliveryDateWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/DeliveryDateWebService/';

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
     * Get a delivery date via REST
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ResponseException
     */
    public function getDeliveryDateREST(GetDeliveryDate $getDeliveryDate)
    {
        $item = $this->retrieveCachedItem($getDeliveryDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetDeliveryDateRequestREST($getDeliveryDate));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetDeliveryDateResponseREST($response);
        if ($object instanceof GetDeliveryDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve the delivery date');
    }

    /**
     * Get a delivery date via SOAP
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws ResponseException
     * @throws ApiException
     */
    public function getDeliveryDateSOAP(GetDeliveryDate $getDeliveryDate)
    {
        $item = $this->retrieveCachedItem($getDeliveryDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetDeliveryDateRequestSOAP($getDeliveryDate));
        }

        $object = $this->processGetDeliveryDateResponseSOAP($response);
        if ($object instanceof GetDeliveryDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;

        }

        throw new ApiException('Unable to retrieve delivery date');
    }

    /**
     * Get the sent date via REST
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ResponseException
     */
    public function getSentDateREST(GetSentDateRequest $getSentDate)
    {
        $item = $this->retrieveCachedItem($getSentDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSentDateRequestREST($getSentDate));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetSentDateResponseREST($response);
        if ($object instanceof GetSentDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve shipping date');
    }

    /**
     * Generate a single label via SOAP
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws ResponseException
     */
    public function getSentDateSOAP(GetSentDateRequest $getSentDate)
    {
        $item = $this->retrieveCachedItem($getSentDate->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSentDateRequestSOAP($getSentDate));
        }

        $object = $this->processGetSentDateResponseSOAP($response);
        if ($object instanceof GetSentDateResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve shipping date');
    }

    /**
     * Build the GetDeliveryDate request for the REST API
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return Request
     */
    public function buildGetDeliveryDateRequestREST(GetDeliveryDate $getDeliveryDate)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getDeliveryDate);
        $deliveryDate = $getDeliveryDate->getGetDeliveryDate();

        $query = [
            'ShippingDate' => $deliveryDate->getShippingDate(),
            'Options'      => 'Daytime',
        ];
        if ($shippingDuration = $deliveryDate->getShippingDuration()) {
            $query['ShippingDuration'] = $shippingDuration;
        }
        if ($times = $cutOffTime = $deliveryDate->getCutOffTimes()) {
            foreach ($times as $time) {
                /** @var CutOffTime $time */
                switch ($time->getDay()) {
                    case '00':
                        $query['CutOffTime'] = date('H:i:s', strtotime($time->getTime()));
                        break;
                    case '01':
                        $query['CutOffTimeMonday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableMonday'] = $time->getAvailable() ? 'true' : false;
                        break;
                    case '02':
                        $query['CutOffTimeTuesday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableTuesday'] = $time->getAvailable() ? 'true' : false;
                        break;
                    case '03':
                        $query['CutOffTimeWednesday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableWednesday'] = $time->getAvailable() ? 'true' : false;
                        break;
                    case '04':
                        $query['CutOffTimeThursday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableThursday'] = $time->getAvailable() ? 'true' : false;
                        break;
                    case '05':
                        $query['CutOffTimeFriday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableFriday'] = $time->getAvailable() ? 'true' : false;
                        break;
                    case '06':
                        $query['CutOffTimeSaturday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableSaturday'] = $time->getAvailable() ? 'true' : false;
                        break;
                    case '07':
                        $query['CutOffTimeSunday'] = date('H:i:s', strtotime($time->getTime()));
                        $query['AvailableSunday'] = $time->getAvailable() ? 'true' : false;
                        break;
                }
            }
        }
        if ($postcode = $deliveryDate->getPostalCode()) {
            $query['PostalCode'] = $postcode;
        }
        $query['CountryCode'] = $deliveryDate->getCountryCode();
        if ($originCountryCode = $deliveryDate->getOriginCountryCode()) {
            $query['OriginCountryCode'] = $originCountryCode;
        }
        if ($city = $deliveryDate->getCity()) {
            $query['City'] = $city;
        }
        if ($houseNr = $deliveryDate->getHouseNr()) {
            $query['HouseNr'] = $houseNr;
        }
        if ($houseNrExt = $deliveryDate->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if (is_array($deliveryDate->getOptions())) {
            foreach ($deliveryDate->getOptions() as $option) {
                if ($option === 'Daytime') {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $endpoint = '/delivery?'.http_build_query($query);

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
     * Process GetDeliveryDate REST Response
     *
     * @param mixed $response
     *
     * @return null|GetDeliveryDateResponse
     * @throws ResponseException
     */
    public function processGetDeliveryDateResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['DeliveryDate'])) {
            /** @var GetDeliveryDateResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetDeliveryDateResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetDeliveryDate request for the SOAP API
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return Request
     */
    public function buildGetDeliveryDateRequestSOAP(GetDeliveryDate $getDeliveryDate)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getDeliveryDate);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetDeliveryDate' => $getDeliveryDate,
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
     * @param mixed $response
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     */
    public function processGetDeliveryDateResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetDeliveryDateResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetSentDate request for the REST API
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return Request
     */
    public function buildGetSentDateRequestREST(GetSentDateRequest $getSentDate)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getSentDate);

        $sentDate = $getSentDate->getGetSentDate();
        $query = [
            'ShippingDate' => $sentDate->getDeliveryDate(),
        ];
        $query['CountryCode'] = $sentDate->getCountryCode();
        if ($duration = $sentDate->getShippingDuration()) {
            $query['ShippingDuration'] = $duration;
        }
        if ($postcode = $sentDate->getPostalCode()) {
            $query['PostalCode'] = $postcode;
        }
        if ($city = $sentDate->getCity()) {
            $query['City'] = $city;
        }
        if ($houseNr = $sentDate->getHouseNr()) {
            $query['HouseNr'] = $houseNr;
        }
        if ($houseNrExt = $sentDate->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }

        $endpoint = '/shipping?'.http_build_query($query);

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT.$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Process GetSentDate REST Response
     *
     * @param mixed $response
     *
     * @return null|GetSentDateResponse
     * @throws ResponseException
     */
    public function processGetSentDateResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['SentDate'])) {


            /** @var GetSentDateResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GetSentDateResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetSentDate request for the SOAP API
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return Request
     */
    public function buildGetSentDateRequestSOAP(GetSentDateRequest $getSentDate)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getSentDate);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetSentDateRequest' => $getSentDate,
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
     * Process GetSentDate SOAP Response
     *
     * @param mixed $response
     *
     * @return GetSentDateResponse
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     */
    public function processGetSentDateResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);



        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetSentDateResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
