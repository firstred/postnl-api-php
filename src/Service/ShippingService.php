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

use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\Shipping;
use Firstred\PostNL\Entity\Response\GenerateShippingResponse;
use Firstred\PostNL\Exception\ApiDownException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\WithResponse;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function http_build_query;
use function json_encode;
use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_SLASHES;

class ShippingService extends ServiceBase implements ShippingServiceInterface
{
    use ServiceLoggerTrait;

    // API Version
    const VERSION = '1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/v1/shipment';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/v1/shipment';

    /**
     * Generate a single Shipping vai REST.
     *
     * @param Shipping $generateShipping
     * @param bool     $confirm
     *
     * @return GenerateShippingResponse|null
     *
     * @throws ApiException
     * @throws ApiDownException
     * @throws CifException
     * @throws WithResponse
     */
    public function generateShipping(Shipping $generateShipping, $confirm = true)
    {
        $item = $this->retrieveCachedItem(uuid: $generateShipping->getId());
        $response = null;

        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response(message: $response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGenerateShippingRequestREST(generateShipping: $generateShipping, confirm: $confirm));

            static::validateRESTResponse(response: $response);
        }

        $object = $this->processGenerateShippingResponseREST(response: $response);
        if ($object instanceof GenerateShippingResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: \GuzzleHttp\Psr7\str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new WithResponse(message: 'Invalid API response', code: null, previous: null, response: $response);
        }

        throw new ApiException('Unable to ship order');
    }

    /**
     * @param Shipping $generateShipping
     * @param bool     $confirm
     *
     * @return RequestInterface
     */
    public function buildGenerateShippingRequest(Shipping $generateShipping, $confirm = true)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $generateShipping);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'POST',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query(data: [
                'confirm' => $confirm,
            ])
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json')
            ->withHeader(name: 'Accept', value: 'application/json;charset=UTF-8')
            ->withBody(body: Psr17FactoryDiscovery::findStreamFactory()->createStream(content: json_encode(value: $generateShipping, flags: JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)));
    }

    /**
     * Process the GenerateShipping REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateShippingResponse|null
     *
     * @throws WithResponse
     */
    public function processGenerateShippingResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (isset($body['ResponseShipments'])) {
            /** @var GenerateShippingResponse $object */
            $object = JsonSerializableObject::JsonDeserialize(json: ['GenerateShippingResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->getGateway()->getHttpClient();
    }

    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->getGateway()->setHttpClient(httpClient: $httpClient);

        return $this;
    }
}
