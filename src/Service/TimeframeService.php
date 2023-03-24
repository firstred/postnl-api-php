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
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\TimeframeTimeFrame;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Message as PsrMessage;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use const PHP_QUERY_RFC3986;

/**
 * Class TimeframeService.
 *
 * @method ResponseTimeframes getTimeframes(GetTimeframes $getTimeframes)
 * @method RequestInterface   buildGetTimeframesRequest(GetTimeframes $getTimeframes)
 * @method ResponseTimeframes processGetTimeframesResponse(mixed $response)
 *
 * @since 1.0.0
 */
class TimeframeService extends AbstractService implements TimeframeServiceInterface
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/calculate/timeframes';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/calculate/timeframes';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/TimeframeWebService/ITimeframeWebService/GetTimeframes';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/TimeframeWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/TimeframeWebService/';

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
     * Get timeframes via REST.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws PsrCacheInvalidArgumentException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function getTimeframesREST(GetTimeframes $getTimeframes)
    {
        $item = $this->retrieveCachedItem($getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetTimeframesRequestREST($getTimeframes));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetTimeframesResponseREST($response);
        if ($object instanceof ResponseTimeframes) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new NotFoundException('Unable to retrieve timeframes');
    }

    /**
     * Get timeframes via SOAP.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function getTimeframesSOAP(GetTimeframes $getTimeframes)
    {
        $item = $this->retrieveCachedItem($getTimeframes->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetTimeframesRequestSOAP($getTimeframes));
        }

        $object = $this->processGetTimeframesResponseSOAP($response);
        if ($object instanceof ResponseTimeframes) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new NotFoundException('Unable to retrieve timeframes');
    }

    /**
     * Build the GetTimeframes request for the REST API.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildGetTimeframesRequestREST(GetTimeframes $getTimeframes)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getTimeframes);
        $timeframe = $getTimeframes->getTimeframe()[0];
        $query = [
            'AllowSundaySorting' => in_array($timeframe->getSundaySorting(), [true, 'true', 1], true) ? 'true' : 'false',
            'StartDate'          => $timeframe->getStartDate()->format('d-m-Y'),
            'EndDate'            => $timeframe->getEndDate()->format('d-m-Y'),
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
            $query['Options'] .= ",$option";
        }
        $query['Options'] = ltrim($query['Options'], ',');
        $query['Options'] = $query['Options'] ?: 'Daytime';

        $endpoint = '?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetTimeframes Response REST.
     *
     * @param mixed $response
     *
     * @return ResponseTimeframes|null
     *
     * @throws HttpClientException
     * @throws ResponseException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processGetTimeframesResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        // Standardize the object here
        if (isset($body->ReasonNoTimeframes)) {
            if (!isset($body->ReasonNoTimeframes->ReasonNoTimeframe)) {
                $body->ReasonNoTimeframes->ReasonNoTimeframe = [];
            }

            if (!is_array($body->ReasonNoTimeframes->ReasonNoTimeframe)) {
                $body->ReasonNoTimeframes->ReasonNoTimeframe = [$body->ReasonNoTimeframes->ReasonNoTimeframe];
            }

            $newNotimeframes = [];
            foreach ($body->ReasonNoTimeframes->ReasonNoTimeframe as $reasonNotimeframe) {
                $newNotimeframes[] = ReasonNoTimeframe::jsonDeserialize((object) ['ReasonNoTimeframe' => $reasonNotimeframe]);
            }

            $body->ReasonNoTimeframes = $newNotimeframes;
        } else {
            $body->ReasonNoTimeframes = [];
        }

        if (isset($body->Timeframes)) {
            if (!isset($body->Timeframes->Timeframe)) {
                $body->Timeframes->Timeframe = [];
            }

            if (!is_array($body->Timeframes->Timeframe)) {
                $body->Timeframes->Timeframe = [$body->Timeframes->Timeframe];
            }

            $newTimeframes = [];
            foreach ($body->Timeframes->Timeframe as $timeframe) {
                $newTimeframeTimeframe = [];
                if (!is_array($timeframe->Timeframes->TimeframeTimeFrame)) {
                    $timeframe->Timeframes->TimeframeTimeFrame = [$timeframe->Timeframes->TimeframeTimeFrame];
                }
                foreach ($timeframe->Timeframes->TimeframeTimeFrame as $timeframetimeframe) {
                    $newTimeframeTimeframe[] = TimeframeTimeFrame::jsonDeserialize(
                        (object) ['TimeframeTimeFrame' => $timeframetimeframe]
                    );
                }
                $timeframe->Timeframes = $newTimeframeTimeframe;

                $newTimeframes[] = Timeframe::jsonDeserialize((object) ['Timeframe' => $timeframe]);
            }
            $body->Timeframes = $newTimeframes;
        } else {
            $body->Timeframes = [];
        }

        /** @var ResponseTimeframes $object */

        $object = ResponseTimeframes::create();
        $object->setReasonNoTimeframes($body->ReasonNoTimeframes);
        $object->setTimeframes($body->Timeframes);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetTimeframes request for the SOAP API.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildGetTimeframesRequestSOAP(GetTimeframes $getTimeframes)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

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
     * Process GetTimeframes Response SOAP.
     *
     * @param ResponseInterface $response
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGetTimeframesResponseSOAP(ResponseInterface $response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        try {
            $array = array_values($reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException($e->getMessage(), $e->getCode(), $e);
        }
        foreach ($array[0]['value'][1]['value'] as &$timeframes) {
            foreach ($timeframes['value'] as &$item) {
                if (false !== strpos($item['name'], 'Timeframes')) {
                    foreach ($item['value'] as &$timeframeTimeframe) {
                        foreach ($timeframeTimeframe['value'] as &$thing) {
                            if (false !== strpos($thing['name'], 'Options')) {
                                $thing['value'] = [$thing['value'][0]['value']];
                            }
                        }
                    }
                }
            }
        }
        $array = $array[0];

        /** @var ResponseTimeframes $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
