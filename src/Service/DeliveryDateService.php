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
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;

/**
 * Class DeliveryDateService
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
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/calculate/date';

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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildGetDeliveryDateRequestREST($getDeliveryDate)
            );
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
     * Build the GetDeliveryDate request for the REST API
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return Request
     */
    public function buildGetDeliveryDateRequestREST(GetDeliveryDate $getDeliveryDate)
    {
        $this->setService($getDeliveryDate);
        $deliveryDate = $getDeliveryDate->getGetDeliveryDate();

        $query = [
            'ShippingDate' => $deliveryDate->getShippingDate(),
            'Options'      => 'Daytime',
        ];
        if ($shippingDuration = $deliveryDate->getShippingDuration()) {
            $query['ShippingDuration'] = $shippingDuration;
        }

        $times = $deliveryDate->getCutOffTimes();
        if (!is_array($times)) {
            $times = [];
        }

        $key = array_search(
            '00',
            array_map(
                function (CutOffTime $time) {
                    return $time->getDay();
                },
                $times
            )
        );
        if (false !== $key) {
            $query['CutOffTime'] = date('H:i:s', strtotime($times[$key]->getTime()));
        } else {
            $query['CutOffTime'] = '15:30:00';
        }

        // There need to be more cut off times besides the default 00 one in order to override
        if (count($times) > 1) {
            foreach (range(1, 7) as $day) {
                $dayName = date('l', strtotime("Sunday +{$day} days"));
                $key = array_search(
                    str_pad($day, 2, '0', STR_PAD_LEFT),
                    array_map(
                        function (CutOfftime $time) {
                            return $time->getDay();
                        },
                        $times
                    )
                );
                if (false !== $key) {
                    $query["CutOffTime{$dayName}"] = date('H:i:s', strtotime($times[$key]->getTime()));
                    $query["Available{$dayName}"] = 'true';
                } else {
                    $query["CutOffTime{$dayName}"] = '00:00:00';
                    $query["Available{$dayName}"] = 'false';
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
                if ('Daytime' === $option) {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $endpoint = '/delivery?'.http_build_query($query);

        return new Request(
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
     * Process GetDeliveryDate REST Response
     *
     * @param mixed $response
     *
     * @return null|GetDeliveryDateResponse
     *
     * @throws ResponseException
     *
     * @since 1.0.0
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
     * Get a delivery date via SOAP
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildGetDeliveryDateRequestSOAP($getDeliveryDate)
            );
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

        $this->setService($getDeliveryDate);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetDeliveryDate' => $getDeliveryDate,
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
                'apikey'       => $this->postnl->getApiKey(),
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

        /** @var GetDeliveryDateResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);
        $this->setService($object);

        return $object;
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
     * Build the GetSentDate request for the REST API
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return Request
     */
    public function buildGetSentDateRequestREST(GetSentDateRequest $getSentDate)
    {
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
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GetSentDate REST Response
     *
     * @param mixed $response
     *
     * @return null|GetSentDateResponse
     *
     * @throws ResponseException
     *
     * @since 1.0.0
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
     * Generate a single label via SOAP
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \Sabre\Xml\LibXMLException
     * @throws ResponseException
     *
     * @since 1.0.0
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

        $this->setService($getSentDate);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetSentDateRequest' => $getSentDate,
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
                'apikey'       => $this->postnl->getApiKey(),
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
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     *
     * @since 1.0.0
     */
    public function processGetSentDateResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);


        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var GetSentDateResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);
        $this->setService($object);

        return $object;
    }
}
