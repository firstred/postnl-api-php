<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Service\Adapter\Soap;

use DateTimeImmutable;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\LabellingServiceAdapterInterface;
use GuzzleHttp\Psr7\Message as PsrMessage;
use InvalidArgumentException;
use ParagonIE\HiddenString\HiddenString;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use function http_build_query;
use function in_array;
use function json_encode;
use function str_replace;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 */
class LabellingServiceSoapAdapter extends AbstractSoapAdapter implements LabellingServiceAdapterInterface
{
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/label';

    const SOAP_ACTION = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabel';
    const SOAP_ACTION_NO_CONFIRM = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabelWithoutConfirm';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

    public function __construct(
        HiddenString            $apiKey,
        bool                    $sandbox,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface  $streamFactory,
        string                  $version,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            version: $version,
        );

        $this->namespaces = array_merge($this->namespaces, [
            SoapNamespace::Services->value           => self::SERVICES_NAMESPACE,
            SoapNamespace::Domain->value             => self::DOMAIN_NAMESPACE,
        ]);
    }

    private static array $insuranceProductCodes = [3534, 3544, 3087, 3094];

    /**
     * Generate a single barcode via REST.
     *
     * @param GenerateLabel $generateLabel
     * @param bool $confirm
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
     * @since 2.0.0
     */
    public function generateLabelREST(GenerateLabel $generateLabel, bool $confirm = true): GenerateLabelResponse
    {
        $item = $this->retrieveCachedItem(uuid: $generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException $e) {
                // Invalid item in cache, skip
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGenerateLabelRequestREST(generateLabel: $generateLabel, confirm: $confirm));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processGenerateLabelResponseREST(response: $response);
        if ($object instanceof GenerateLabelResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: PsrMessage::toString(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException(
                message: 'Invalid API response',
                code: $response->getStatusCode(),
                previous: null,
                response: $response,
            );
        }

        throw new NotFoundException(message: 'Unable to generate label');
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
     * @since 2.0.0
     */
    public function generateLabelsREST(array $generateLabels): array
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $item = $this->retrieveCachedItem(uuid: $uuid);
            $response = null;
            if ($item instanceof CacheItemInterface && $item->isHit()) {
                $response = $item->get();
                $response = PsrMessage::parseResponse(message: $response);
                $responses[$uuid] = $response;
            }

            $httpClient->addOrUpdateRequest(
                id: $uuid,
                request: $this->buildGenerateLabelRequestREST(generateLabel: $generateLabel[0], confirm: $generateLabel[1])
            );
        }
        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem(uuid: $uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(value: PsrMessage::toString(message: $newResponse));
                    $this->cache->saveDeferred(item: $item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponseREST(response: $response);
            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }

    /**
     * Generate a single label via SOAP.
     *
     * @param GenerateLabel $generateLabel
     * @param bool $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    public function generateLabelSOAP(GenerateLabel $generateLabel, bool $confirm = true): GenerateLabelResponse
    {
        $item = $this->retrieveCachedItem(uuid: $generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface && $item->isHit()) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse(message: $response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGenerateLabelRequestSOAP(generateLabel: $generateLabel, confirm: $confirm));
        }

        $object = static::processGenerateLabelResponseSOAP(response: $response);

        if ($object instanceof GenerateLabelResponse
            && $item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && 200 === $response->getStatusCode()
        ) {
            $item->set(value: PsrMessage::toString(message: $response));
            $this->cacheItem(item: $item);
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
     * @throws PostNLInvalidArgumentException
     *
     * @since 2.0.0
     */
    public function generateLabelsSOAP(array $generateLabels): array
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $item = $this->retrieveCachedItem(uuid: $uuid);
            $response = null;
            if ($item instanceof CacheItemInterface && $item->isHit()) {
                $response = $item->get();
                $response = PsrMessage::parseResponse(message: $response);
                $responses[$uuid] = $response;
            }

            $httpClient->addOrUpdateRequest(
                id: $uuid,
                request: $this->buildGenerateLabelRequestSOAP(generateLabel: $generateLabel[0], confirm: $generateLabel[1])
            );
        }

        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem(uuid: $uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(value: PsrMessage::toString(message: $newResponse));
                    $this->cache->saveDeferred(item: $item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $generateLabelResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $generateLabelResponse = $this->processGenerateLabelResponseSOAP(response: $response);
            $generateLabelResponses[$uuid] = $generateLabelResponse;
        }

        return $generateLabelResponses;
    }

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool $confirm
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildGenerateLabelRequestREST(GenerateLabel $generateLabel, bool $confirm = true): RequestInterface
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $generateLabel);
        $endpoint = $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT;
        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array(needle: $shipment->getProductCodeDelivery(), haystack: static::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace(search: 'v2_2', replace: 'v2_1', subject: $endpoint);
            }
        }

        return $this->postnl->getRequestFactory()->createRequest(
            method: 'POST',
            uri: $endpoint.'?'.http_build_query(data: [
                'confirm' => ($confirm ? 'true' : 'false'),
            ], numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986))
            ->withHeader('apikey', value: $apiKey)
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('Content-Type', value: 'application/json;charset=UTF-8')
            ->withBody(body: $this->postnl->getStreamFactory()->createStream(content: json_encode(value: $generateLabel)));
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
     * @since 2.0.0
     */
    public function processGenerateLabelResponseREST(ResponseInterface $response): ?GenerateLabelResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));
        if (isset($body->ResponseShipments)) {
            /** @var GenerateLabelResponse $object */
            $object = GenerateLabelResponse::jsonDeserialize(json: (object) ['GenerateLabelResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool $confirm
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildGenerateLabelRequestSOAP(GenerateLabel $generateLabel, bool $confirm = true): RequestInterface
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

        $security = new Security(UserNameToken: $this->postnl->getToken());

        $this->setService(object: $security);
        $this->setService(object: $generateLabel);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
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
            if (in_array(needle: $shipment->getProductCodeDelivery(), haystack: self::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace(search: 'v2_2', replace: 'v2_1', subject: $endpoint);
            }
        }

        return $this->postnl->getRequestFactory()->createRequest(method: 'POST', uri: $endpoint)
            ->withHeader('SOAPAction', value: "\"$soapAction\"")
            ->withHeader('Accept', value: 'text/xml')
            ->withHeader('Content-Type', value: 'text/xml;charset=UTF-8')
            ->withBody(body: $this->postnl->getStreamFactory()->createStream(content: $request));
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
     * @since 2.0.0
     */
    public function processGenerateLabelResponseSOAP(ResponseInterface $response): GenerateLabelResponse
    {
        $xml = @simplexml_load_string(data: static::getResponseText(response: $response));
        if (false === $xml) {
            if (200 === $response->getStatusCode()) {
                throw new ResponseException(message: 'Invalid API Response', response: $response);
            } else {
                throw new ResponseException(message: 'Invalid API Response');
            }
        }

        static::registerNamespaces(element: $xml);
        static::validateSOAPResponse(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        try {
            $array = array_values(array: $reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
        $array = $array[0];

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }
}
