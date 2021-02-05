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

use Firstred\PostNL\Entity\JsonSerializableObject;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Exception\ApiDownException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\WithResponse;
use Firstred\PostNL\HttpClient\HttpClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ShippingStatusService.
 */
class ShippingStatusService extends ServiceBase implements ShippingStatusServiceInterface
{
    use ServiceLoggerTrait;

    // API Version
    const VERSION = '1.6';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_6/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_6/status';

    /**
     * Gets the current status.
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
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiException
     * @throws ApiDownException
     * @throws CifException
     * @throws WithResponse
     */
    public function currentStatus($currentStatus)
    {
        $item = $this->retrieveCachedItem(uuid: $currentStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response(message: $response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildCurrentStatusRequestREST(currentStatus: $currentStatus));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processCurrentStatusResponseREST(response: $response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: \GuzzleHttp\Psr7\str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve current status');
    }

    /**
     * Gets the complete status.
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
     * @param CompleteStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws ApiException
     * @throws ApiDownException
     * @throws CifException
     * @throws WithResponse
     */
    public function completeStatus(CompleteStatus $completeStatus)
    {
        $item = $this->retrieveCachedItem(uuid: $completeStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response(message: $response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildCompleteStatusRequestREST(completeStatus: $completeStatus));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processCompleteStatusResponseREST(response: $response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: \GuzzleHttp\Psr7\str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve complete status');
    }

    /**
     * Gets the complete status.
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
     * @param GetSignature $getSignature
     *
     * @return GetSignatureResponseSignature
     *
     * @throws ApiException
     * @throws ApiDownException
     * @throws CifException
     * @throws WithResponse
     */
    public function getSignature(GetSignature $getSignature)
    {
        $item = $this->retrieveCachedItem(uuid: $getSignature->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response(message: $response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest(request: $this->buildGetSignatureRequestREST(getSignature: $getSignature));
            static::validateRESTResponse(response: $response);
        }

        $object = $this->processGetSignatureResponseREST(response: $response);
        if ($object instanceof GetSignatureResponseSignature) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(value: \GuzzleHttp\Psr7\str(message: $response));
                $this->cacheItem(item: $item);
            }

            return $object;
        }

        throw new ApiException('Unable to get signature');
    }

    /**
     * Build the CurrentStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CurrentStatus
     * - CurrentStatusByReference
     * - CurrentStatusByPhase
     * - CurrentStatusByStatus
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return RequestInterface
     */
    public function buildCurrentStatusRequest($currentStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $currentStatus);

        if ($currentStatus->getShipment()->getReference()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = "/reference/{$currentStatus->getShipment()->getReference()}";
        } elseif ($currentStatus->getShipment()->getStatusCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = '/search';
            $query['status'] = $currentStatus->getShipment()->getStatusCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $endDate));
            }
        } elseif ($currentStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = '/search';
            $query['phase'] = $currentStatus->getShipment()->getPhaseCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $endDate));
            }
        } else {
            $query = [];
            $endpoint = "/barcode/{$currentStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query(data: $query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json');
    }

    /**
     * Process CurrentStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CurrentStatusResponse
     *
     * @throws WithResponse
     */
    public function processCurrentStatusResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (isset($body['CurrentStatus'])) {
            /** @var CurrentStatusResponse $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['CurrentStatusResponse' => $body]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    /**
     * Build the CompleteStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     * - CompleteStatusByPhase
     * - CompleteStatusByStatus
     *
     * @param CompleteStatus $completeStatus
     *
     * @return RequestInterface
     */
    public function buildCompleteStatusRequest(CompleteStatus $completeStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $completeStatus);

        if ($completeStatus->getShipment()->getReference()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = "/reference/{$completeStatus->getShipment()->getReference()}";
        } elseif ($completeStatus->getShipment()->getStatusCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = '/search';
            $query['status'] = $completeStatus->getShipment()->getStatusCode();
            if ($startDate = $completeStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $endDate));
            }
        } elseif ($completeStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = '/search';
            $query['phase'] = $completeStatus->getShipment()->getPhaseCode();
            if ($startDate = $completeStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: $endDate));
            }
        } else {
            $query = [
                'detail' => 'true',
            ];
            $endpoint = "/barcode/{$completeStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query(data: $query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json')
            ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8');
    }

    /**
     * Process CompleteStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CompleteStatusResponse|null
     *
     * @throws WithResponse
     */
    public function processCompleteStatusResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (isset($body['CompleteStatus'])) {
            if (isset($body['CompleteStatus']['Shipment']['MainBarcode'])) {
                $body['CompleteStatus']['Shipments'] = [$body['CompleteStatus']['Shipment']];
            } else {
                $body['CompleteStatus']['Shipments'] = $body['CompleteStatus']['Shipment'];
            }

            unset($body['CompleteStatus']['Shipment']);

            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Customer'] = JsonSerializableObject::jsonDeserialize(json: ['Customer' => $shipment['Customer']]);
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Addresses'] = $shipment['Address'];
                unset($shipment['Address']);
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Events'] = $shipment['Event'];
                unset($shipment['Event']);
                foreach ($shipment['Events'] as &$event) {
                    $event = JsonSerializableObject::jsonDeserialize(json: ['CompleteStatusResponseEvent' => $event]);
                    //$event = ['CompleteStatusResponseEvent' => $event];
                }
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['OldStatuses'] = $shipment['OldStatus'];
                unset($shipment['OldStatus']);
                foreach ($shipment['OldStatuses'] as &$oldStatus) {
                    $oldStatus = JsonSerializableObject::jsonDeserialize(json: ['CompleteStatusResponseOldStatus' => $oldStatus]);
                }
            }

            /** @var CompleteStatusResponse $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['CompleteStatusResponse' => $body['CompleteStatus']]);
            $this->setService(object: $object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     */
    public function buildGetSignatureRequest(GetSignature $getSignature)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService(object: $getSignature);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}"
        )
            ->withHeader(name: 'apikey', value: $apiKey)
            ->withHeader(name: 'Accept', value: 'application/json');
    }

    /**
     * Process GetSignature Response REST.
     *
     * @param mixed $response
     *
     * @return GetSignatureResponseSignature|null
     */
    public function processGetSignatureResponse($response)
    {
        $body = @json_decode(json: static::getResponseText(response: $response), associative: true);
        if (!empty($body['Signature'])) {
            /** @var GetSignatureResponseSignature $object */
            $object = JsonSerializableObject::jsonDeserialize(json: ['GetSignatureResponseSignature' => $body]);
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
     * @return $this
     */
    public function setHttpClient(HttpClientInterface $httpClient): static
    {
        $this->getGateway()->setHttpClient(httpClient: $httpClient);

        return $this;
    }
}
