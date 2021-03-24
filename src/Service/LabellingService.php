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
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\Response\GenerateLabelResponse;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;
use function http_build_query;
use function json_encode;
use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_SLASHES;

/**
 * Class LabellingService.
 *
 * @method GenerateLabelResponse   generateLabel(GenerateLabel $generateLabel, bool $confirm)
 * @method RequestInterface        buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm)
 * @method GenerateLabelResponse   processGenerateLabelResponse(mixed $response)
 * @method GenerateLabelResponse[] generateLabels(GenerateLabel[] $generateLabel, bool $confirm)
 *
 * @since 1.0.0
 */
class LabellingService extends AbstractService implements LabellingServiceInterface
{
    // API Version
    const VERSION = '2.2';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/label';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabel';
    const SOAP_ACTION_NO_CONFIRM = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabelWithoutConfirm';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

    /**
     * Namespaces uses for the SOAP version of this service.
     *
     * @var array
     */
    public static $namespaces = [
        self::ENVELOPE_NAMESPACE     => 'soap',
        self::OLD_ENVELOPE_NAMESPACE => 'env',
        self::SERVICES_NAMESPACE     => 'services',
        self::DOMAIN_NAMESPACE       => 'domain',
        Security::SECURITY_NAMESPACE => 'wsse',
        self::XML_SCHEMA_NAMESPACE   => 'schema',
        self::COMMON_NAMESPACE       => 'common',
    ];

    /**
     * Generate a single barcode via REST.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function generateLabelREST(GenerateLabel $generateLabel, $confirm = true)
    {
        $item = $this->retrieveCachedItem($generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
                // Invalid item in cache, skip
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGenerateLabelRequestREST($generateLabel, $confirm));
            static::validateRESTResponse($response);
        }

        $object = $this->processGenerateLabelResponseREST($response);
        if ($object instanceof GenerateLabelResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\Message::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException('Invalid API response', null, null, $response);
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Generate multiple labels at once.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function generateLabelsREST(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $item = $this->retrieveCachedItem($uuid);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                try {
                    $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
                } catch (\InvalidArgumentException $e) {
                }
                if ($response instanceof ResponseInterface) {
                    $responses[$uuid] = $response;

                    continue;
                }
            }

            $httpClient->addOrUpdateRequest(
                $uuid,
                $this->buildGenerateLabelRequestREST($generateLabel[0], $generateLabel[1])
            );
        }
        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(\GuzzleHttp\Psr7\Message::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            try {
                $generateLabelResponse = $this->processGenerateLabelResponseREST($response);
            } catch (\Exception $e) {
                $generateLabelResponse = $e;
            }

            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }

    /**
     * Generate a single label via SOAP.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function generateLabelSOAP(GenerateLabel $generateLabel, $confirm = true)
    {
        $item = $this->retrieveCachedItem($generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGenerateLabelRequestSOAP($generateLabel, $confirm));
        }

        $object = static::processGenerateLabelResponseSOAP($response);

        if ($object instanceof GenerateLabelResponse
            && $item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && 200 === $response->getStatusCode()
        ) {
            $item->set(\GuzzleHttp\Psr7\Message::toString($response));
            $this->cacheItem($item);
        }

        return $object;
    }

    /**
     * Generate multiple labels at once via SOAP.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function generateLabelsSOAP(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $item = $this->retrieveCachedItem($uuid);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                try {
                    $response = \GuzzleHttp\Psr7\Message::parseResponse($response);
                } catch (\InvalidArgumentException $e) {
                }
                if ($response instanceof ResponseInterface) {
                    $responses[$uuid] = $response;

                    continue;
                }
            }

            $httpClient->addOrUpdateRequest(
                $uuid,
                $this->buildGenerateLabelRequestSOAP($generateLabel[0], $generateLabel[1])
            );
        }

        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(\GuzzleHttp\Psr7\Message::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $generateLabelResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            try {
                $generateLabelResponse = $this->processGenerateLabelResponseSOAP($response);
            } catch (\Exception $e) {
                $generateLabelResponse = $e;
            }

            $generateLabelResponses[$uuid] = $generateLabelResponse;
        }

        return $generateLabelResponses;
    }

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGenerateLabelRequestREST(GenerateLabel $generateLabel, $confirm = true)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateLabel);

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query([
                'confirm' => $confirm,
            ]))
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream(json_encode($generateLabel, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)));
    }

    /**
     * Process the GenerateLabel REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse|null
     *
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseREST($response)
    {
        $body = @json_decode(static::getResponseText($response), true);
        if (isset($body['ResponseShipments'])) {
            /** @var GenerateLabelResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GenerateLabelResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGenerateLabelRequestSOAP(GenerateLabel $generateLabel, $confirm = true)
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($generateLabel);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GenerateLabel' => $generateLabel,
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
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseSOAP(ResponseInterface $response)
    {
        $xml = @simplexml_load_string(static::getResponseText($response));
        if (false === $xml) {
            if (200 === $response->getStatusCode()) {
                throw new ResponseException('Invalid API Response', null, null, $response);
            } else {
                throw new ApiException('Invalid API Response');
            }
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
