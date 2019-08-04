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

use Firstred\PostNL\Entity\Request\RetrieveShipmentByBarcodeRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByKgidRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByReferenceRequest;
use Firstred\PostNL\Entity\Request\RetrieveSignatureByBarcodeRequest;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Client\Exception as HttpClientException;
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
    const VERSION = '2';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2/status';

    /**
     * Retrieve the shipment by barcode
     *
     * @param RetrieveShipmentByBarcodeRequest|RetrieveShipmentByReferenceRequest|RetrieveShipmentByKgidRequest $shipmentRequest
     *
     * @return Shipment
     *
     * @throws HttpClientException
     * @throws CifDownException
     * @throws CifErrorException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveShipment($shipmentRequest): Shipment
    {
        $item = $this->retrieveCachedItem($shipmentRequest->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildRetrieveShipmentRequest($shipmentRequest);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processRetrieveShipmentResponse($response);
        if ($item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && $response->getStatusCode() === 200
        ) {
            $item->set(Message::str($response));
            $this->cacheItem($item);
        }

        return $object;
    }

    /**
     * Build the RetrieveShipmentByBarcodeRequest request for the REST API
     *
     * @param RetrieveShipmentByBarcodeRequest|RetrieveShipmentByReferenceRequest|RetrieveShipmentByKgidRequest $shipmentRequest
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildRetrieveShipmentRequest($shipmentRequest): RequestInterface
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
        if ($shipmentRequest instanceof RetrieveShipmentByBarcodeRequest) {
            $endpoint = "/barcode/{$shipmentRequest->getBarcode()}";
        } elseif ($shipmentRequest instanceof RetrieveShipmentByReferenceRequest) {
            $query['customerCode'] = $this->postnl->getCustomer()->getCustomerCode();
            $query['customerNumber'] = $this->postnl->getCustomer()->getCustomerNumber();
            $endpoint = "/reference/{$shipmentRequest->getReference()}";
        } elseif ($shipmentRequest instanceof RetrieveShipmentByKgidRequest) {
            $endpoint = "/lookup/{$shipmentRequest->getKgid()}";
        } else {
            throw new InvalidArgumentException('Invalid request object given');
        }
        if (!empty($query)) {
            $endpoint .= '?'.http_build_query($query);
        }

        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
        ;
    }

    /**
     * Process RetrieveShipmentByBarcode Response REST
     *
     * @param ResponseInterface $response
     *
     * @return Shipment
     *
     * @throws InvalidArgumentException
     * @throws CifDownException
     *
     * @since 2.0.0
     */
    public function processRetrieveShipmentResponse(ResponseInterface $response): Shipment
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['CurrentStatus']['Shipment'])) {
            /** @var Shipment $object */
            $object = Shipment::jsonDeserialize(['Shipment' => $body['CurrentStatus']['Shipment']]);

            return $object;
        }
        if (isset($body['CompleteStatus']['Shipment'])) {
            /** @var Shipment $object */
            $object = Shipment::jsonDeserialize(['Shipment' => $body['CompleteStatus']['Shipment']]);

            return $object;
        }

        throw new CifDownException('Unable to process retrieve shipment response', 0, null, null, $response);
    }


    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param RetrieveSignatureByBarcodeRequest $getSignature
     *
     * @return Signature
     *
     * @throws CifDownException
     * @throws CifErrorException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function retrieveSignature(RetrieveSignatureByBarcodeRequest $getSignature): Signature
    {
        $item = $this->retrieveCachedItem($getSignature->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (TypeError $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildRetrieveSignatureRequest($getSignature);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }
        $object = $this->processRetrieveSignatureResponse($response);
        if ($item instanceof CacheItemInterface
            && $response instanceof ResponseInterface
            && $response->getStatusCode() === 200
        ) {
            $item->set(Message::str($response));
            $this->cacheItem($item);
        }

        return $object;
    }

    /**
     * Build the GetSignature request for the REST API
     *
     * @param RetrieveSignatureByBarcodeRequest $getSignature
     *
     * @return RequestInterface
     */
    public function buildRetrieveSignatureRequest(RetrieveSignatureByBarcodeRequest $getSignature)
    {
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        return $factory->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getBarcode()}"
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withHeader('apikey', $this->postnl->getApiKey())
        ;
    }

    /**
     * Process GetSignature Response REST
     *
     * @param mixed $response
     *
     * @return Signature
     *
     * @throws CifDownException
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function processRetrieveSignatureResponse(ResponseInterface $response): Signature
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['Signature']['Barcode'])) {
            /** @var Signature $object */
            $object = Signature::jsonDeserialize($body);

            return $object;
        }

        throw new CifDownException('Unable to process signature response', 0, null, null, $response);
    }
}
