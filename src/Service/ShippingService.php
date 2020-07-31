<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 KeenDelivery, LLC
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
 * @author    Jan-Wilco peters <info@keendelivery.com>
 * @copyright 2017-2020 KeenDelivery, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Request\GenerateShipping;
use ThirtyBees\PostNL\Entity\Response\GenerateShippingResponse;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class ShippingService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method GenerateShippingResponse   generateShipping(GenerateShipping $generateShipping, bool $confirm)
 * @method Request                    buildGenerateShippingRequest(GenerateShipping $generateShipping, bool $confirm)
 * @method GenerateShippingResponse   processGenerateShippingResponse(mixed $response)
 */
class ShippingService extends AbstractService
{
    // API Version
    const VERSION = '1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/v1/shipment';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/v1/shipment';

    const DOMAIN_NAMESPACE = 'http://postnl.nl/';

    /**
     * Generate a single Shipping vai REST
     *
     * @param GenerateShipping $generateShipping
     * @param bool $confirm
     *
     * @return GenerateShippingResponse|null
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function generateShippingREST(GenerateShipping $generateShipping, $confirm = true): ?GenerateShippingResponse
    {
        $item = $this->retrieveCachedItem($generateShipping->getId());
        $response = null;

        if ($item instanceof CachedItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            }catch(\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGenerateShippingRequestREST($generateShipping, $confirm));

            static::validateRESTResponse($response);
        }

        $object = $this->processGenerateShippingResponseREST($response);
        if ($object instanceof GenerateShippingResponse) {
            if ($item instanceof CachedItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        if ($response->getStatusCode() === 200) {
            throw new ResponseException('Invalid API response', null, null, $response);
        }

        throw new ApiException('Unable to ship order');
    }

    public function buildGenerateShippingRequestREST(GenerateShipping $generateShipping, $confirm = true): Request
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateShipping);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.\GuzzleHttp\Psr7\build_query([
                'confirm' => $confirm
            ]),
            [
                'apikey' => $apiKey,
                'Accept' => 'application/json',
                'Content-type' => 'application/json;charset=UTF-8',
            ],
            json_encode($generateShipping, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * Process the GenerateShipping REST Response
     *
     * @param Response $response
     *
     * @return GenerateShippingResponse|null
     * @throws ResponseException
     */
    public function processGenerateShippingResponseREST($response): ?GenerateShippingResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ResponseShipments'])) {
            /** @var GenerateShippingResponse $object */
            $object = AbstractEntity::JsonDeserialize(['GenerateShippingResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }
}
