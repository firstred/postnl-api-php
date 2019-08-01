<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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

use Exception;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByBarcodeRequest;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TypeError;

/**
 * Class ShippingStatusService
 */
class ShippingStatusService extends AbstractService
{
    // API Version
    const VERSION = '1.6';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_6/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_6/status';

    /**
     * Retrieve the shipment by barcode
     *
     * @param RetrieveShipmentByBarcodeRequest $shipmentRequest
     *
     * @return Shipment
     *
     * @throws Exception
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function retrieveShipmentByBarcode(RetrieveShipmentByBarcodeRequest $shipmentRequest): Shipment
    {
        $item = $this->retrieveCachedItem($shipmentRequest->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException | TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildRetrieveShipmentByBarcodeRequest($shipmentRequest);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processRetrieveShipmentByBarcodeResponse($response);
        if ($object instanceof Shipment) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new HttpClientException('Unable to retrieve current status', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the RetrieveShipmentByBarcodeRequest request for the REST API
     *
     * @param RetrieveShipmentByBarcodeRequest $shipmentRequest
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildRetrieveShipmentByBarcodeRequest(RetrieveShipmentByBarcodeRequest $shipmentRequest): RequestInterface
    {
        $query = [];
        if (!is_null($shipmentRequest->getDetail())) {
            $query['detail'] = $shipmentRequest->getDetail() ? 'true' : 'false';
        }
        if ($language = $shipmentRequest->getLanguage()) {
            $query['language'] = $language;
        }
        if ($maxDays = $shipmentRequest->getMaxDays()) {
            $query['maxDays'] = $maxDays;
        }
        $endpoint = "/barcode/{$shipmentRequest->getBarcode()}";
        if (!empty($query)) {
            $endpoint .= '?'.http_build_query($query);
        }

        $factory = Psr17FactoryDiscovery::findRequestFactory();

        /** @var RequestInterface $request */
        $request = $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        );
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json;charset=UTF-8');
        $request = $request->withHeader('apikey', $this->postnl->getApiKey());

        return $request;
    }

    /**
     * Process RetrieveShipmentByBarcode Response REST
     *
     * @param ResponseInterface $response
     *
     * @return Shipment
     *
     * @throws InvalidArgumentException
     * @throws \ReflectionException
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processRetrieveShipmentByBarcodeResponse(ResponseInterface $response): Shipment
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['CurrentStatus']['Shipment'])) {
            /** @var Shipment $object */
            $object = Shipment::jsonDeserialize(['Shipment' => $body['CurrentStatus']['Shipment']]);

            return $object;
        }

        return null;
    }
}
