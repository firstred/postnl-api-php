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

use DateTimeInterface;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CompleteStatusByReference;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseEvent;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseOldStatus;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Message as PsrMessage;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function json_decode;

/**
 * Class ShippingStatusService.
 *
 * @method CurrentStatusResponse           currentStatus(CurrentStatus|CurrentStatusByReference $currentStatus)
 * @method CurrentStatusResponse[]         currentStatuses(CurrentStatus[]|CurrentStatusByReference[] $currentStatuses)
 * @method RequestInterface                buildCurrentStatusRequest(CurrentStatus|CurrentStatusByReference $currentStatus)
 * @method CurrentStatusResponse           processCurrentStatusResponse(ResponseInterface $response)
 * @method UpdatedShipmentsResponse        completeStatus(CompleteStatus|CompleteStatusByReference $completeStatus)
 * @method UpdatedShipmentsResponse[]      completeStatuses(CompleteStatus[]|CompleteStatusByReference[] $completeStatuses)
 * @method RequestInterface                buildCompleteStatusRequest(CompleteStatus|CompleteStatusByReference $completeStatus)
 * @method UpdatedShipmentsResponse        processCompleteStatusResponse(ResponseInterface $response)
 * @method GetSignatureResponseSignature   getSignature(GetSignature $getSignature)
 * @method GetSignatureResponseSignature[] getSignatures(GetSignature[] $getSignatures)
 * @method RequestInterface                buildGetSignatureRequest(GetSignature $getSignature)
 * @method GetSignatureResponseSignature   processGetSignatureResponse(ResponseInterface $response)
 * @method UpdatedShipmentsResponse[]      getUpdatedShipments(Customer $customer, DateTimeInterface|null $dateTimeFrom, DateTimeInterface|null $dateTimeTo)
 * @method RequestInterface                buildGetUpdatedShipmentsRequest(Customer $customer, DateTimeInterface|null $dateTimeFrom, DateTimeInterface|null $dateTimeTo)
 * @method UpdatedShipmentsResponse        processGetUpdatedShipmentsResponse(ResponseInterface $response)
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
     * @param CurrentStatus|CurrentStatusByReference $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
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
            } catch (InvalidArgumentException $e) {
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

        throw new NotFoundException('Unable to retrieve current status');
    }

    /**
     * Get current statuses REST.
     *
     * @param CurrentStatus[]|CurrentStatusByReference[] $currentStatuses
     *
     * @return CurrentStatusResponse[]
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function currentStatusesREST(array $currentStatuses)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($currentStatuses as $index => $currentStatus) {
            $item = $this->retrieveCachedItem($index);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                $response = PsrMessage::parseResponse($response);
                $responses[$index] = $response;
            }

            $httpClient->addOrUpdateRequest(
                $index,
                $this->buildCurrentStatusRequestREST($currentStatus)
            );
        }

        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(PsrMessage::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $currentStatusResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $currentStatusResponses[$uuid] = $this->processCurrentStatusResponseREST($response);
        }

        return $currentStatusResponses;
    }

    /**
     * Gets the complete status.
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     *
     * @param CompleteStatus|CompleteStatusByReference $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function completeStatusREST($completeStatus)
    {
        try {
            $item = $this->retrieveCachedItem($completeStatus->getId());
        } catch (PsrCacheInvalidArgumentException $e) {
            $item = null;
        }
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
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

        throw new NotFoundException('Unable to retrieve complete status');
    }

    /**
     * Get complete statuses REST.
     *
     * @param CompleteStatus[]|CompleteStatusByReference[] $completeStatuses
     *
     * @return CompleteStatusResponse[]
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function completeStatusesREST(array $completeStatuses)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($completeStatuses as $index => $completeStatus) {
            $item = $this->retrieveCachedItem($index);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                $response = PsrMessage::parseResponse($response);
                $responses[$index] = $response;
            }

            $httpClient->addOrUpdateRequest(
                $index,
                $this->buildCompleteStatusRequestREST($completeStatus)
            );
        }

        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(PsrMessage::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $completeStatusResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $completeStatusResponses[$uuid] = $this->processCompleteStatusResponseREST($response);
        }

        return $completeStatusResponses;
    }

    /**
     * Gets the signature.
     *
     * @param GetSignature $getSignature
     *
     * @return GetSignatureResponseSignature
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws NotFoundException
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
            } catch (InvalidArgumentException $e) {
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

        throw new NotFoundException('Unable to get signature');
    }

    /**
     * Get multiple signatures.
     *
     * @param GetSignature[] $getSignatures
     *
     * @return GetSignatureResponseSignature[]
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function getSignaturesREST(array $getSignatures)
    {
        $httpClient = $this->postnl->getHttpClient();

        $responses = [];
        foreach ($getSignatures as $index => $getsignature) {
            $item = $this->retrieveCachedItem($index);
            $response = null;
            if ($item instanceof CacheItemInterface) {
                $response = $item->get();
                $response = PsrMessage::parseResponse($response);
                $responses[$index] = $response;
            }

            $httpClient->addOrUpdateRequest(
                $index,
                $this->buildGetSignatureRequestREST($getsignature)
            );
        }

        $newResponses = $httpClient->doRequests();
        foreach ($newResponses as $uuid => $newResponse) {
            if ($newResponse instanceof ResponseInterface
                && 200 === $newResponse->getStatusCode()
            ) {
                $item = $this->retrieveCachedItem($uuid);
                if ($item instanceof CacheItemInterface) {
                    $item->set(PsrMessage::toString($newResponse));
                    $this->cache->saveDeferred($item);
                }
            }
        }
        if ($this->cache instanceof CacheItemPoolInterface) {
            $this->cache->commit();
        }

        $signatureResponses = [];
        foreach ($responses + $newResponses as $uuid => $response) {
            $signatureResponses[$uuid] = $this->processGetSignatureResponseREST($response);
        }

        return $signatureResponses;
    }

    /**
     * Build the CurrentStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CurrentStatus
     * - CurrentStatusByReference
     *
     * @param CurrentStatus|CurrentStatusByReference $currentStatus
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildCurrentStatusRequestREST($currentStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();

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
        return CurrentStatusResponse::jsonDeserialize((object) ['CurrentStatusResponse' => (object) [
            'Shipments' => $body->CurrentStatus->Shipment,
        ]]);
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
     * @since 1.0.0
     */
    public function buildCompleteStatusRequestREST(CompleteStatus $completeStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();

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
     * @return UpdatedShipmentsResponse|null
     *
     * @throws ResponseException
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
        unset($shipment);

        /** @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection */
        foreach ($body->CompleteStatus->Shipments as &$shipment) {
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

        /** @var UpdatedShipmentsResponse $object */
        return UpdatedShipmentsResponse::jsonDeserialize(
            (object) ['CompleteStatusResponse' => $body->CompleteStatus]
        );
    }

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildGetSignatureRequestREST(GetSignature $getSignature)
    {
        $apiKey = $this->postnl->getRestApiKey();

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
        return GetSignatureResponseSignature::jsonDeserialize((object) ['GetSignatureResponseSignature' => $body->Signature]);
    }

    /**
     * Get updated shipments for customer REST.
     *
     * @param Customer               $customer
     * @param DateTimeInterface|null $dateTimeFrom
     * @param DateTimeInterface|null $dateTimeTo
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.2.0
     */
    public function getUpdatedShipmentsREST(
        Customer $customer,
        DateTimeInterface $dateTimeFrom = null,
        DateTimeInterface $dateTimeTo = null
    ) {
        if ((!$dateTimeFrom && $dateTimeTo) || ($dateTimeFrom && !$dateTimeTo)) {
            throw new NotSupportedException('Either pass both dates or none. A single date is not supported.');
        }

        $dateTimeFromString = $dateTimeFrom ? $dateTimeFrom->format('YmdHis') : '';
        $dateTimeToString = $dateTimeTo ? $dateTimeTo->format('YmdHis') : '';

        $item = $this->retrieveCachedItem("{$customer->getCustomerNumber()}-$dateTimeFromString-$dateTimeToString");
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = PsrMessage::parseResponse($response);
            } catch (InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetUpdatedShipmentsRequestREST($customer, $dateTimeFrom, $dateTimeTo));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetUpdatedShipmentsResponseREST($response);
        if (is_array($object) && !empty($object) && $object[0] instanceof UpdatedShipmentsResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(PsrMessage::toString($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new NotFoundException('Unable to retrieve updated shipments');
    }

    /**
     * Build get updated shipments request REST.
     *
     * @param Customer               $customer
     * @param DateTimeInterface|null $dateTimeFrom
     * @param DateTimeInterface|null $dateTimeTo
     *
     * @return RequestInterface
     *
     * @since 1.2.0
     */
    public function buildGetUpdatedShipmentsRequestREST(
        Customer $customer,
        DateTimeInterface $dateTimeFrom = null,
        DateTimeInterface $dateTimeTo = null
    ) {
        $apiKey = $this->postnl->getRestApiKey();

        $range = '';
        if ($dateTimeFrom) {
            $range = "?period={$dateTimeFrom->format('Y-m-d\TH:i:s')}&period={$dateTimeTo->format('Y-m-d\TH:i:s')}";
        }

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/{$customer->getCustomerNumber()}/updatedshipments$range"
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process updated shipments response REST.
     *
     * @param ResponseInterface $response
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.2.0
     */
    public function processGetUpdatedShipmentsResponseREST(ResponseInterface $response)
    {
        $body = json_decode(static::getResponseText($response));
        if (!is_array($body)) {
            return [];
        }

        foreach ($body as &$item) {
            $item = UpdatedShipmentsResponse::jsonDeserialize((object) ['UpdatedShipmentsResponse' => $item]);
        }

        return $body;
    }
}
