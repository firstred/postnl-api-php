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
use ThirtyBees\PostNL\Entity\Request\GetTimeframes;
use ThirtyBees\PostNL\Entity\Response\ResponseTimeframes;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class TimeframeService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method ResponseTimeframes getTimeframes(GetTimeframes $getTimeframes)
 * @method Request            buildGetTimeframesRequest(GetTimeframes $getTimeframes)
 * @method ResponseTimeframes processGetTimeframesResponse(mixed $response)
 */
class TimeframeService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/calculate/timeframes';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/calculate/timeframes';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/TimeframeWebService/2_0/TimeframeWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/TimeframeWebService/2_0/TimeframeWebService.svc';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/TimeframeWebService/ITimeframeWebService/GetTimeframes';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/TimeframeWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/TimeframeWebService/';

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
     * Get timeframes via REST
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getTimeframesREST(GetTimeframes $getTimeframes)
    {
        $item = $this->retrieveCachedItem($getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetTimeframesRequestREST($getTimeframes));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetTimeframesResponse($response);
        if ($object instanceof ResponseTimeframes) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve timeframes');
    }

    /**
     * Get timeframes via SOAP
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTimeframesSOAP(GetTimeframes $getTimeframes)
    {
        $item = $this->retrieveCachedItem($getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetTimeframesRequestSOAP($getTimeframes));
        }

        $object = $this->processGetTimeframesResponse($response);
        if ($object instanceof ResponseTimeframes) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve timeframes');
    }

    /**
     * Build the GetTimeframes request for the REST API
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return Request
     */
    public function buildGetTimeframesRequestREST(GetTimeframes $getTimeframes)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getTimeframes);
        $timeframe = $getTimeframes->getTimeframe()[0];
        $query = [
            'AllowSundaySorting' => $timeframe->getSundaySorting(),
            'StartDate'          => $timeframe->getStartDate(),
            'EndDate'            => $timeframe->getEndDate(),
            'PostalCode'         => $timeframe->getPostalCode(),
            'HouseNumber'        => $timeframe->getHouseNr(),
            'CountryCode'        => $timeframe->getCountryCode(),
            'Options'            => '',
        ];
        if ($interval = $timeframe->getInterval()) {
            $query['Interval'] = $interval;
        }
        if ($houseNrExt = $timeframe->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if ($timeframeRange = $timeframe->getTimeframeRange()) {
            $query['TimeframeRange'] = $timeframeRange;
        }
        if ($street = $timeframe->getStreet()) {
            $query['Street'] = $street;
        }
        if ($city = $timeframe->getCity()) {
            $query['City'] = $city;
        }
        foreach ($timeframe->getOptions() as $option) {
            if ($option === 'PG') {
                continue;
            }
            $query['Options'] .= ",$option";
        }
        $query['Options'] = ltrim(',', $query['Options']);
        $endpoint = '?'.http_build_query($query);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ],
            json_encode($getTimeframes, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * Process GetTimeframes Response REST
     *
     * @param mixed $response
     *
     * @return null|ResponseTimeframes
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetTimeframesResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['Timeframes'])) {


            /** @var ResponseTimeframes $object */
            $object = AbstractEntity::jsonDeserialize(['ResponseTimeframes' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetTimeframes request for the SOAP API
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return Request
     */
    public function buildGetTimeframesRequestSOAP(GetTimeframes $getTimeframes)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getTimeframes);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetTimeframes' => $getTimeframes,
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
     * Process GetTimeframes Response SOAP
     *
     * @param mixed $response
     *
     * @return ResponseTimeframes
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function processGetTimeframesResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);



        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var ResponseTimeframes $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
