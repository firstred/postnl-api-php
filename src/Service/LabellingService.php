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
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;

/**
 * Class LabellingService
 *
 * @method GenerateLabelResponse   generateLabel(GenerateLabel $generateLabel, bool $confirm)
 * @method Request                 buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm)
 * @method GenerateLabelResponse   processGenerateLabelResponse(mixed $response)
 * @method GenerateLabelResponse[] generateLabels(GenerateLabel[] $generateLabel, bool $confirm)
 */
class LabellingService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/label';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabel';
    const SOAP_ACTION_NO_CONFIRM = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabelWithoutConfirm';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

    /**
     * Namespaces uses for the SOAP version of this service
     *
     * @var array $namespaces
     */
    public static $namespaces = [
        self::ENVELOPE_NAMESPACE     => 'soap',
        self::OLD_ENVELOPE_NAMESPACE => 'env',
        self::SERVICES_NAMESPACE     => 'services',
        self::DOMAIN_NAMESPACE       => 'domain',
        self::XML_SCHEMA_NAMESPACE   => 'schema',
        self::COMMON_NAMESPACE       => 'common',
    ];

    /**
     * Generate a single barcode via REST
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Firstred\PostNL\Exception\ResponseException
     */
    public function generateLabelREST(GenerateLabel $generateLabel, $confirm = true)
    {
        $item = $this->retrieveCachedItem($generateLabel->getId());
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
                $this->buildGenerateLabelRequestREST($generateLabel, $confirm)
            );
            static::validateRESTResponse($response);
        }

        $object = $this->processGenerateLabelResponseREST($response);
        if ($object instanceof GenerateLabelResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        if ($response->getStatusCode() === 200) {
            throw new ResponseException('Invalid API response', 0, null, $response);
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Build the GenerateLabel request for the REST API
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return Request
     */
    public function buildGenerateLabelRequestREST(GenerateLabel $generateLabel, bool $confirm = true): Request
    {
        $this->setService($generateLabel);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(
                ['confirm' => $confirm]
            ),
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ],
            json_encode($generateLabel, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * Process the GenerateLabel REST Response
     *
     * @param Response $response
     *
     * @return GenerateLabelResponse|null
     *
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseREST($response): ?GenerateLabelResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ResponseShipments'])) {
            /** @var GenerateLabelResponse $object */
            $object = AbstractEntity::jsonDeserialize(['GenerateLabelResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Generate multiple labels at once
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     */
    public function generateLabelsREST(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $uuid = (string) $uuid;
            $item = $this->retrieveCachedItem($uuid);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                try {
                    $response = \GuzzleHttp\Psr7\parse_response($response);
                } catch (\InvalidArgumentException $e) {
                }
                if ($response instanceof Response) {
                    $responses[$uuid] = $response;

                    continue;
                }
            }

            $httpClient->addOrUpdateRequest(
                (string) $uuid,
                $this->buildGenerateLabelRequestREST($generateLabel[0], $generateLabel[1])
            );
        }
        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof Response
                && $newResponse->getStatusCode() === 200
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(\GuzzleHttp\Psr7\str($newResponse));
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
     * Generate a single label via SOAP
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
     * @throws \Sabre\Xml\LibXMLException
     *
     * @since 1.00
     */
    public function generateLabelSOAP(GenerateLabel $generateLabel, $confirm = true): GenerateLabelResponse
    {
        $item = $this->retrieveCachedItem($generateLabel->getId());
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
                $this->buildGenerateLabelRequestSOAP($generateLabel, $confirm)
            );
        }

        $object = static::processGenerateLabelResponseSOAP($response);

        if ($object instanceof GenerateLabelResponse
            && $item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        return $object;
    }

    /**
     * Build the GenerateLabel request for the SOAP API
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return Request
     */
    public function buildGenerateLabelRequestSOAP(GenerateLabel $generateLabel, bool $confirm = true): Request
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }

        $this->setService($generateLabel);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GenerateLabel' => $generateLabel,
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
     * @param Response $response
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseSOAP($response)
    {
        $xml = @simplexml_load_string(static::getResponseText($response));
        if (false === $xml) {
            if ($response->getStatusCode() === 200) {
                throw new ResponseException('Invalid API Response', 0, null, $response);
            }

            throw new ApiException('Invalid API Response');
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);


        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var GenerateLabelResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);
        $this->setService($object);

        return $object;
    }

    /**
     * Generate multiple labels at once via SOAP
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     */
    public function generateLabelsSOAP(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $uuid = (string) $uuid;
            $item = $this->retrieveCachedItem($uuid);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                try {
                    $response = \GuzzleHttp\Psr7\parse_response($response);
                } catch (\InvalidArgumentException $e) {
                }
                if ($response instanceof Response) {
                    $responses[$uuid] = $response;

                    continue;
                }
            }

            $httpClient->addOrUpdateRequest(
                (string) $uuid,
                $this->buildGenerateLabelRequestSOAP($generateLabel[0], $generateLabel[1])
            );
        }

        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof Response
                && $newResponse->getStatusCode() === 200
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(\GuzzleHttp\Psr7\str($newResponse));
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
}
