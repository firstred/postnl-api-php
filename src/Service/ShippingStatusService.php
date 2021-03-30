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

use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CompleteStatusByPhase;
use Firstred\PostNL\Entity\Request\CompleteStatusByReference;
use Firstred\PostNL\Entity\Request\CompleteStatusByStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByPhase;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\CurrentStatusByStatus;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseEvent;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseOldStatus;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;

/**
 * Class ShippingStatusService.
 *
 * @method CurrentStatusResponse  currentStatus(CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus)
 * @method RequestInterface       buildCurrentStatusRequest(CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus)
 * @method CurrentStatusResponse  processCurrentStatusResponse(mixed $response)
 * @method CompleteStatusResponse completeStatus(CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus)
 * @method RequestInterface       buildCompleteStatusRequest(CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus)
 * @method CompleteStatusResponse processCompleteStatusResponse(mixed $response)
 * @method GetSignature           getSignature(GetSignature $getSignature)
 * @method RequestInterface       buildGetSignatureRequest(GetSignature $getSignature)
 * @method GetSignature           processGetSignatureResponse(mixed $response)
 *
 * @since 1.0.0
 */
class ShippingStatusService extends AbstractService implements ShippingStatusServiceInterface
{
    // API Version
    const VERSION = '2';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2/status';

    const DOMAIN_NAMESPACE = 'http://postnl.nl/';

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
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function currentStatusREST($currentStatus)
    {
        $item = $this->retrieveCachedItem($currentStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusRequestREST($currentStatus));
            static::validateRESTResponse($response);
        }

        $object = $this->processCurrentStatusResponseREST($response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
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
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CompleteStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function completeStatusREST(CompleteStatus $completeStatus)
    {
        $item = $this->retrieveCachedItem($completeStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCompleteStatusRequestREST($completeStatus));
            static::validateRESTResponse($response);
        }

        $object = $this->processCompleteStatusResponseREST($response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
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
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param GetSignature $getSignature
     *
     * @return GetSignatureResponseSignature
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getSignatureREST(GetSignature $getSignature)
    {
        $item = $this->retrieveCachedItem($getSignature->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureRequestREST($getSignature));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetSignatureResponseREST($response);
        if ($object instanceof GetSignatureResponseSignature) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
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
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function buildCurrentStatusRequestREST($currentStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($currentStatus);

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
            $endpoint = '/search';
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

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process CurrentStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CurrentStatusResponse
     *
     * @throws ResponseException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processCurrentStatusResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        /** @var CurrentStatusResponse $object */
        $object = CurrentStatusResponse::jsonDeserialize((object) ['CurrentStatusResponse' => (object) [
            'Shipments' => $body->CurrentStatus->Shipment,
        ]]);
        $this->setService($object);

        return $object;
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
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function buildCompleteStatusRequestREST(CompleteStatus $completeStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($completeStatus);

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
            $endpoint = '/search';
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

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8');
    }

    /**
     * Process CompleteStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CompleteStatusResponse|null
     *
     * @throws ResponseException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processCompleteStatusResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));

        if (isset($body->CompleteStatus->Shipment)) {
            $body->CompleteStatus->Shipments = $body->CompleteStatus->Shipment;
        }
        unset($body->CompleteStatus->Shipment);

        if (!is_array($body->CompleteStatus->Shipments)) {
            $body->CompleteStatus->Shipments = [$body->CompleteStatus->Shipments];
        }

        foreach ($body->CompleteStatus->Shipments as &$shipment) {
            $shipment->Customer = Customer::jsonDeserialize((object) ['Customer' => $shipment->Customer]);
        }
        foreach ($body->CompleteStatus->Shipments as $shipment) {
            if (isset($shipment->Address)) {
                $shipment->Addresses = $shipment->Address;
                unset($shipment->Address);
            }
            if (!is_array($shipment->Addresses)) {
                $shipment->Addresses = [$shipment->Addresses];
            }

            if (isset($shipment->Event)) {
                $shipment->Events = $shipment->Event;
                unset($shipment->Event);
            }

            if (!is_array($shipment->Events)) {
                $shipment->Events = [$shipment->Events];
            }

            foreach ($shipment->Events as &$event) {
                $event = CompleteStatusResponseEvent::jsonDeserialize(
                    (object) ['CompleteStatusResponseEvent' => $event]
                );
            }

            if (isset($shipment->OldStatus)) {
                $shipment->OldStatuses = $shipment->OldStatus;
                unset($shipment->OldStatus);
            }
            if (!is_array($shipment->OldStatuses)) {
                $shipment->OldStatuses = [$shipment->OldStatuses];
            }

            foreach ($shipment->OldStatuses as &$oldStatus) {
                $oldStatus = CompleteStatusResponseOldStatus::jsonDeserialize(
                    (object) ['CompleteStatusResponseOldStatus' => $oldStatus]
                );
            }
        }

        /** @var CompleteStatusResponse $object */
        $object = CompleteStatusResponse::jsonDeserialize(
            (object) ['CompleteStatusResponse' => $body->CompleteStatus]
        );
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     * @throws ReflectionException
     */
    public function buildGetSignatureRequestREST(GetSignature $getSignature)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getSignature);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}"
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetSignature Response REST.
     *
     * @param mixed $response
     *
     * @return GetSignatureResponseSignature|null
     *
     * @throws ResponseException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processGetSignatureResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response));
        /** @var GetSignatureResponseSignature $object */
        $object = GetSignatureResponseSignature::jsonDeserialize((object) ['GetSignatureResponseSignature' => $body->Signature]);
        $this->setService($object);

        return $object;
    }
}
