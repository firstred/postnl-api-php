<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use DateTimeImmutable;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\SOAP\Security;
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
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use function http_build_query;
use function in_array;
use function json_encode;
use function str_replace;

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

    private static $insuranceProductCodes =  [3534, 3544, 3087, 3094];

    /**
     * Generate a single barcode via REST.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws NotFoundException
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
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
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
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException('Invalid API response', null, null, $response);
        }

        throw new NotFoundException('Unable to generate label');
    }

    /**
     * Generate multiple labels at once.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
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
                $response = PsrMessage::parseResponse($response);
                $responses[$uuid] = $response;
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
                    $item->set(PsrMessage::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponseREST($response);
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
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
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
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
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
            $item->set(PsrMessage::toString($response));
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
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
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
                $response = PsrMessage::parseResponse($response);
                $responses[$uuid] = $response;
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
                    $item->set(PsrMessage::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $generateLabelResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponseSOAP($response);
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
     * @since 1.0.0
     */
    public function buildGenerateLabelRequestREST(GenerateLabel $generateLabel, $confirm = true)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateLabel);
        $endpoint = $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;
        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array($shipment->getProductCodeDelivery(), static::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace('v2_2', 'v2_1', $endpoint);
            }
        }

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $endpoint.'?'.http_build_query([
                'confirm' => $confirm,
            ]))
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream(json_encode($generateLabel)));
    }

    /**
     * Process the GenerateLabel REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        if (isset($body->ResponseShipments)) {
            /** @var GenerateLabelResponse $object */
            $object = GenerateLabelResponse::jsonDeserialize((object) ['GenerateLabelResponse' => $body]);
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
     * @since 1.0.0
     */
    public function buildGenerateLabelRequestSOAP(GenerateLabel $generateLabel, $confirm = true)
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

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

        $endpoint = $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;

        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array($shipment->getProductCodeDelivery(), self::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace('v2_2', 'v2_1', $endpoint);
            }
        }

        return $this->postnl->getRequestFactory()->createRequest('POST', $endpoint)
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
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
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
                throw new ResponseException('Invalid API Response');
            }
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        try {
            $array = array_values($reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException($e->getMessage(), $e->getCode(), $e);
        }
        $array = $array[0];

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
