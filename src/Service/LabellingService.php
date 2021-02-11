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

declare(strict_types=1);

namespace Firstred\PostNL\Service;

use Exception;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\parse_response;
use function GuzzleHttp\Psr7\str;
use function http_build_query;
use function json_encode;
use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_SLASHES;

/**
 * Class LabellingService.
 *
 * @see https://developer.postnl.nl/browse-apis/send-and-track/labelling-webservice/
 */
class LabellingService extends ServiceBase implements LabellingServiceInterface
{
    use ServiceLoggerTrait;
    use ServiceHttpClientTrait;

    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/label';

    public function generateLabel(LabellingResponseDto $generateLabel, $confirm = true)
    {
        $item = $this->retrieveCachedItem(uuid: $generateLabel->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = parse_response(message: $response);
            } catch (\InvalidArgumentException $e) {
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
                $item->set(value: str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new ApiClientException(message: 'Invalid API response', response: $response);
        }

        throw new ApiClientException(message: 'Unable to generate label', response: $response);
    }

    /**
     * Generate multiple labels at once.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     */
    public function generateLabels(array $generateLabels)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($generateLabels as $uuid => $generateLabel) {
            $item = $this->retrieveCachedItem(uuid: $uuid);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                try {
                    $response = parse_response(message: $response);
                } catch (\InvalidArgumentException) {
                }
                if ($response instanceof ResponseInterface) {
                    $responses[$uuid] = $response;

                    continue;
                }
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
                    $item->set(value: str(message: $newResponse));
                    $this->cache->saveDeferred(item: $item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $labels = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            try {
                $generateLabelResponse = $this->processGenerateLabelResponseREST(response: $response);
            } catch (Exception $e) {
                $generateLabelResponse = $e;
            }

            $labels[$uuid] = $generateLabelResponse;
        }

        return $labels;
    }

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param LabellingResponseDto $generateLabel
     * @param                      $confirm
     *
     * @return RequestInterface
     */
    public function buildGenerateLabelRequest(LabellingResponseDto $generateLabel, $confirm = true)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $generateLabel);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'POST',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(data: [
                'confirm' => $confirm,
            ]))
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody(body: Psr17FactoryDiscovery::findStreamFactory()->createStream(content: json_encode(value: $generateLabel, flags: JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)));
    }

    /**
     * Process the GenerateLabel REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse|null
     *
     * @throws WithResponse
     */
    public function processGenerateLabelResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (isset($body['ResponseShipments'])) {
            /** @var GenerateLabelResponse $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['GenerateLabelResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->getGateway()->getHttpClient();
    }

    /**
     * @param HttpClientInterface $httpClient
     *
     * @return static
     */
    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->getGateway()->setHttpClient(httpClient: $httpClient);

        return $this;
    }
}
