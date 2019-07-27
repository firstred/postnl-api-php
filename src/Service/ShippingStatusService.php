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

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByPhase;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\CurrentStatusByStatus;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\SignatureResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\ClientException;
use Firstred\PostNL\Http\Client;
use Firstred\PostNL\Misc\Message;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * Gets the current status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->GenerateBarcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass GenerateBarcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ClientException
     * @throws CifDownException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function currentStatus($currentStatus): CurrentStatusResponse
    {
        $item = $this->retrieveCachedItem($currentStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            $response = Message::parseResponse($response);
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildCurrentStatusRequest($currentStatus);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processCurrentStatusResponse($response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ClientException('Unable to retrieve current status', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the CurrentStatus request for the REST API
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
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildCurrentStatusRequest($currentStatus): RequestInterface
    {
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
            $endpoint = "/search";
            $query['status'] = $currentStatus->getShipment()->getStatusCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } elseif ($currentStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = "/search";
            $query['phase'] = $currentStatus->getShipment()->getPhaseCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } else {
            $query = [];
            $endpoint = "/barcode/{$currentStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query($query);

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
     * Process CurrentStatus Response REST
     *
     * @param ResponseInterface $response
     *
     * @return CurrentStatusResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processCurrentStatusResponse(ResponseInterface $response): CurrentStatusResponse
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['CurrentStatus'])) {
            /** @var CurrentStatusResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CurrentStatusResponse' => $body]);

            return $object;
        }

        return null;
    }

    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->GenerateBarcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass GenerateBarcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CompleteStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws ClientException
     * @throws CifDownException
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function completeStatus(CompleteStatus $completeStatus): CompleteStatusResponse
    {
        $item = $this->retrieveCachedItem($completeStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildCompleteStatusRequest($completeStatus);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processCompleteStatusResponse($response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ClientException('Unable to retrieve complete status', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the CompleteStatus request for the REST API
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
     *
     * @since 1.0.0
     */
    public function buildCompleteStatusRequest(CompleteStatus $completeStatus): RequestInterface
    {
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
            $endpoint = "/search";
            $query['status'] = $completeStatus->getShipment()->getStatusCode();
            if ($startDate = $completeStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } elseif ($completeStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = "/search";
            $query['phase'] = $completeStatus->getShipment()->getPhaseCode();
            if ($startDate = $completeStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } else {
            $query = [
                'detail' => 'true',
            ];
            $endpoint = "/barcode/{$completeStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query($query);

        $factory = Psr17FactoryDiscovery::findRequestFactory();

        /** @var RequestInterface $request */
        $request = $factory->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        );
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json;charset=UTF-8');
        $request = $request->withHeader('apikey', $this->postnl->getApiKey());

        return $request;
    }

    /**
     * Process CompleteStatus Response REST
     *
     * @param ResponseInterface $response
     *
     * @return null|CompleteStatusResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processCompleteStatusResponse(ResponseInterface $response): ?CompleteStatusResponse
    {
        $body = json_decode((string) $response->getBody(), true);
        if (isset($body['CompleteStatus'])) {
            if (isset($body['CompleteStatus']['Shipment']['MainBarcode'])) {
                $body['CompleteStatus']['Shipments'] = [$body['CompleteStatus']['Shipment']];
            } else {
                $body['CompleteStatus']['Shipments'] = $body['CompleteStatus']['Shipment'];
            }

            unset($body['CompleteStatus']['Shipment']);

            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Customer'] = AbstractEntity::jsonDeserialize(['Customer' => $shipment['Customer']]);
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Addresses'] = $shipment['Address'];
                unset($shipment['Address']);
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Events'] = $shipment['Event'];
                unset($shipment['Event']);
                foreach ($shipment['Events'] as &$event) {
                    $event = AbstractEntity::jsonDeserialize(['CompleteStatusResponseEvent' => $event]);
                }
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['OldStatuses'] = $shipment['OldStatus'];
                unset($shipment['OldStatus']);
                foreach ($shipment['OldStatuses'] as &$oldStatus) {
                    $oldStatus = AbstractEntity::jsonDeserialize(['CompleteStatusResponseOldStatus' => $oldStatus]);
                }
            }

            /** @var CompleteStatusResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CompleteStatusResponse' => $body['CompleteStatus']]);

            return $object;
        }

        return null;
    }

    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->GenerateBarcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass GenerateBarcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param GetSignature $getSignature
     *
     * @return SignatureResponse
     *
     * @throws ClientException
     * @throws CifDownException
     *
     * @since 1.0.0
     */
    public function getSignature(GetSignature $getSignature): SignatureResponse
    {
        $item = $this->retrieveCachedItem($getSignature->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = Message::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $request = $this->buildGetSignatureRequest($getSignature);
            $response = Client::getInstance()->doRequest($request);
            static::validateResponse($response);
        }

        $object = $this->processGetSignatureResponse($response);
        if ($object instanceof SignatureResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && $response->getStatusCode() === 200
            ) {
                $item->set(Message::str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ClientException('Unable to get signature', 0, null, isset($request) && $request instanceof RequestInterface ? $request : null, $response);
    }

    /**
     * Build the GetSignature request for the REST API
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function buildGetSignatureRequest(GetSignature $getSignature): RequestInterface
    {
        $factory = Psr17FactoryDiscovery::findRequestFactory();

        /** @var RequestInterface $request */
        $request = $factory->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}"
        );
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json;charset=UTF-8');
        $request = $request->withHeader('apikey', $this->postnl->getApiKey());

        return $request;
    }

    /**
     * Process GetSignature Response REST
     *
     * @param ResponseInterface $response
     *
     * @return null|SignatureResponse
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function processGetSignatureResponse(ResponseInterface $response): ?SignatureResponse
    {
        $body = json_decode((string) $response->getBody(), true);
        if (!empty($body['Signature'])) {
            /** @var SignatureResponse $object */
            $object = AbstractEntity::jsonDeserialize(['SignatureResponse' => $body]);

            return $object;
        }

        return null;
    }
}
