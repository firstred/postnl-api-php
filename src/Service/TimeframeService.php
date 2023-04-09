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
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\TimeframeTimeFrame;
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
use const PHP_QUERY_RFC3986;

/**
 * Class TimeframeService.
 *
 * @method ResponseTimeframes getTimeframes(GetTimeframes $getTimeframes)
 * @method RequestInterface   buildGetTimeframesRequest(GetTimeframes $getTimeframes)
 * @method ResponseTimeframes processGetTimeframesResponse(mixed $response)
 *
 * @since 1.0.0
 * @internal
 */
class TimeframeService extends AbstractService implements TimeframeServiceInterface
{
    // API Version
    /** @internal */
    const VERSION = '2.1';

    // Endpoints
    /** @internal */
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/calculate/timeframes';
    /** @internal */
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/calculate/timeframes';

    // SOAP API
    /** @internal */
    const SOAP_ACTION = 'http://postnl.nl/cif/services/TimeframeWebService/ITimeframeWebService/GetTimeframes';
    /** @internal */
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/TimeframeWebService/';
    /** @internal */
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/TimeframeWebService/';

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
     * Get timeframes via REST.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getTimeframes` instead
     * @internal
     */
    #[Deprecated]
    public function getTimeframesREST(GetTimeframes $getTimeframes)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGetTimeframesRequestREST($getTimeframes));
        static::validateRESTResponse($response);

        $object = $this->processGetTimeframesResponseREST($response);
        if ($object instanceof ResponseTimeframes) {
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
     * @throws HttpClientException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getTimeframes` instead
     * @internal
     */
    #[Deprecated]
    public function getTimeframesSOAP(GetTimeframes $getTimeframes)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGetTimeframesRequestSOAP($getTimeframes));

        $object = $this->processGetTimeframesResponseSOAP($response);
        if ($object instanceof ResponseTimeframes) {
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
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
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
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
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

        $object = new ResponseTimeframes();
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
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
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
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetTimeframesResponseSOAP(ResponseInterface $response)
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
