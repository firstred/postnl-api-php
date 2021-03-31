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

use Firstred\PostNL\Entity\Request\SendShipment;
use Firstred\PostNL\Entity\Response\SendShipmentResponse;
use Firstred\PostNL\Exception\ApiConnectionException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Message as PsrMessage;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use function http_build_query;
use function json_encode;

/**
 * Class ShippingService.
 *
 * @method SendShipmentResponse sendShipment(SendShipment $sendShipment, bool $confirm)
 * @method RequestInterface     buildSendShipmentRequest(SendShipment $sendShipment, bool $confirm)
 * @method SendShipmentResponse processSendShipmentResponse(mixed $response)
 *
 * @since 1.2.0
 */
class ShippingService extends AbstractService implements ShippingServiceInterface
{
    // API Version
    const VERSION = '1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/v1/shipment';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/v1/shipment';

    const DOMAIN_NAMESPACE = 'http://postnl.nl/';

    /**
     * Generate a single Shipping vai REST.
     *
     * @param SendShipment $sendShipment
     * @param bool         $confirm
     *
     * @return SendShipmentResponse|null
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ApiConnectionException
     *
     * @since 1.2.0
     */
    public function sendShipmentRest(SendShipment $sendShipment, $confirm = true)
    {
        $item = $this->retrieveCachedItem($sendShipment->getId());
        $response = null;

        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildSendShipmentRequestREST($sendShipment, $confirm)
            );

            static::validateRESTResponse($response);
        }

        $object = $this->processSendShipmentResponseREST($response);
        if ($object instanceof SendShipmentResponse) {
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

        throw new ApiException('Unable to create shipment');
    }

    /**
     * @param SendShipment $sendShipment
     * @param bool         $confirm
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.2.0
     */
    public function buildSendShipmentRequestREST(SendShipment $sendShipment, $confirm = true)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($sendShipment);

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).'?'.http_build_query([
                'confirm' => $confirm,
            ])
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream(json_encode($sendShipment)));
    }

    /**
     * Process the SendShipment REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return SendShipmentResponse|null
     *
     * @throws ReflectionException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function processSendShipmentResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        if (isset($body->ResponseShipments)) {
            /** @var SendShipmentResponse $object */
            $object = SendShipmentResponse::JsonDeserialize((object) ['SendShipmentResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }
}
