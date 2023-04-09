<?php
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

use DateTimeImmutable;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use JetBrains\PhpStorm\Deprecated;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use SimpleXMLElement;
use function strcasecmp;
use const PHP_QUERY_RFC3986;

/**
 * Class DeliveryDateService.
 *
 * @method GetDeliveryDateResponse getDeliveryDate(GetDeliveryDate $getDeliveryDate)
 * @method RequestInterface        buildGetDeliveryDateRequest(GetDeliveryDate $getDeliveryDate)
 * @method GetDeliveryDateResponse processGetDeliveryDateResponse(mixed $response)
 * @method GetSentDateResponse     getSentDate(GetSentDateRequest $getSentDate)
 * @method RequestInterface        buildGetSentDateRequest(GetSentDateRequest $getSentDate)
 * @method GetSentDateResponse     processGetSentDateResponse(mixed $response)
 *
 * @since 1.0.0
 * @internal
 */
class DeliveryDateService extends AbstractService implements DeliveryDateServiceInterface
{
    // API Version
    /** @internal */
    const VERSION = '2.2';

    // Endpoints
    /** @internal */
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/calculate/date';
    /** @internal */
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/calculate/date';

    // SOAP API
    /** @internal */
    const SOAP_ACTION = 'http://postnl.nl/cif/services/DeliveryDateWebService/IDeliveryDateWebService/GetDeliveryDate';
    /** @internal */
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/DeliveryDateWebService/';
    /** @internal */
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/DeliveryDateWebService/';

    /**
     * Namespaces uses for the SOAP version of this service.
     *
     * @var array
     * @internal
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
     * Get a delivery date via REST.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getDeliveryDate` instead
     * @internal
     */
    #[Deprecated]
    public function getDeliveryDateREST(GetDeliveryDate $getDeliveryDate)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGetDeliveryDateRequestREST($getDeliveryDate));
        static::validateRESTResponse($response);

        $object = $this->processGetDeliveryDateResponseREST($response);
        if ($object instanceof GetDeliveryDateResponse) {
            return $object;
        }

        throw new NotFoundException('Unable to retrieve the delivery date');
    }

    /**
     * Get a delivery date via SOAP.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getDeliveryDate` instead
     * @internal
     */
    #[Deprecated]
    public function getDeliveryDateSOAP(GetDeliveryDate $getDeliveryDate)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGetDeliveryDateRequestSOAP($getDeliveryDate));
        $object = $this->processGetDeliveryDateResponseSOAP($response);
        if ($object instanceof GetDeliveryDateResponse) {
            return $object;
        }

        throw new NotFoundException('Unable to retrieve delivery date');
    }

    /**
     * Get the sent date via REST.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getSentDate` instead
     * @internal
     */
    #[Deprecated]
    public function getSentDateREST(GetSentDateRequest $getSentDate)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSentDateRequestREST($getSentDate));
        static::validateRESTResponse($response);

        $object = $this->processGetSentDateResponseREST($response);
        if ($object instanceof GetSentDateResponse) {
            return $object;
        }

        throw new NotFoundException('Unable to retrieve shipping date');
    }

    /**
     * Generate a single label via SOAP.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getSentDate` instead
     * @internal
     */
    #[Deprecated]
    public function getSentDateSOAP(GetSentDateRequest $getSentDate)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSentDateRequestSOAP($getSentDate));

        $object = $this->processGetSentDateResponseSOAP($response);
        if ($object instanceof GetSentDateResponse) {
            return $object;
        }

        throw new NotFoundException('Unable to retrieve shipping date');
    }

    /**
     * Build the GetDeliveryDate request for the REST API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetDeliveryDateRequestREST(GetDeliveryDate $getDeliveryDate)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getDeliveryDate);
        $deliveryDate = $getDeliveryDate->getGetDeliveryDate();

        $query = [
            'ShippingDate' => $deliveryDate->getShippingDate()->format('d-m-Y H:i:s'),
            'Options'      => 'Daytime',
        ];
        if ($shippingDuration = $deliveryDate->getShippingDuration()) {
            $query['ShippingDuration'] = $shippingDuration;
        }

        $times = $deliveryDate->getCutOffTimes();
        if (!is_array($times)) {
            $times = [];
        }

        $key = array_search('00', array_map(function ($time) {
            /* @var CutOffTime $time */
            return $time->getDay();
        }, $times));
        if (false !== $key) {
            $query['CutOffTime'] = date('H:i:s', strtotime($times[$key]->getTime()));
        } else {
            $query['CutOffTime'] = '15:30:00';
        }

        // There need to be more cut off times besides the default 00 one in order to override
        if (count($times) > 1) {
            foreach (range(1, 7) as $day) {
                $dayName = date('l', strtotime("Sunday +{$day} days"));
                $key = array_search(str_pad($day, 2, '0', STR_PAD_LEFT), array_map(function ($time) {
                    /* @var CutOffTime $time */
                    return $time->getDay();
                }, $times));
                if (false !== $key) {
                    $query["CutOffTime$dayName"] = date('H:i:s', strtotime($times[$key]->getTime()));
                    $query["Available$dayName"] = 'true';
                } else {
                    $query["CutOffTime$dayName"] = '00:00:00';
                    $query["Available$dayName"] = 'false';
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
                if (strcasecmp('Daytime', $option) === 0) {
                    continue;
                }

                $query['Options'] .= ",$option";
            }
        }

        $endpoint = '/delivery?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetDeliveryDate REST Response.
     *
     * @param mixed $response
     *
     * @return GetDeliveryDateResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetDeliveryDateResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        if (isset($body->DeliveryDate)) {
            /** @var GetDeliveryDateResponse $object */
            $object = GetDeliveryDateResponse::jsonDeserialize((object) ['GetDeliveryDateResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetDeliveryDate request for the SOAP API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetDeliveryDateRequestSOAP(GetDeliveryDate $getDeliveryDate)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

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
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetDeliveryDateResponseSOAP(ResponseInterface $response)
    {
        try {
            $xml = new SimpleXMLElement(static::getResponseText($response));
        } catch (HttpClientException $e) {
            throw $e;
        } catch (ResponseException $e) {
            throw new ResponseException($e->getMessage(), 0, $e, $response);
        } catch (Exception $e) {
            throw new ResponseException('Could not parse response', 0, $e, $response);
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        try {
            $array = array_values($reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException('Could not parse response', 0, $e, $response);
        }
        $array = $array[0];

        /** @var GetDeliveryDateResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetSentDate request for the REST API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
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

        $endpoint = '/shipping?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetSentDate REST Response.
     *
     * @param mixed $response
     *
     * @return GetSentDateResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetSentDateResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        if (isset($body->SentDate)) {
            /** @var GetSentDateResponse $object */
            $object = GetSentDateResponse::jsonDeserialize((object) ['GetSentDateResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetSentDate request for the SOAP API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetSentDateRequestSOAP(GetSentDateRequest $getSentDate)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

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
     * Process GetSentDate SOAP Response.
     *
     * @param ResponseInterface $response
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetSentDateResponseSOAP(ResponseInterface $response)
    {
        try {
            $xml = new SimpleXMLElement(static::getResponseText($response));
        } catch (HttpClientException $e) {
            throw $e;
        } catch (ResponseException $e) {
            throw new ResponseException($e->getMessage(), 0, $e, $response);
        } catch (Exception $e) {
            throw new ResponseException('Could not parse response', 0, $e, $response);
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        try {
            $array = array_values($reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException('Could not parse response', 0, $e, $response);
        }
        $array = $array[0];

        /** @var GetSentDateResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
