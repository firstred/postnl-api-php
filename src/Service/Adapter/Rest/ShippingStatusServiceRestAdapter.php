<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service\Adapter\Rest;

use DateTimeInterface;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseEvent;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseOldStatus;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\ShippingStatusServiceAdapterInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function json_decode;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 * @internal
 */
class ShippingStatusServiceRestAdapter extends AbstractRestAdapter implements ShippingStatusServiceAdapterInterface
{
    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/${VERSION}/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/${VERSION}/status';

    /**
     * Build the CurrentStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CurrentStatus
     * - CurrentStatusByReference
     *
     * @since 2.0.0
     */
    public function buildCurrentStatusRequest(CurrentStatusByReference|CurrentStatus $currentStatus): RequestInterface
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
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $endDate));
            }
        } elseif ($currentStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = '/search';
            $query['phase'] = $currentStatus->getShipment()->getPhaseCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $endDate));
            }
        } else {
            $query = [];
            $endpoint = "/barcode/{$currentStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->postnl->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', value: $apiKey)
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Process CurrentStatus Response REST.
     *
     * @param ResponseInterface $response
     *
     * @return CurrentStatusResponse
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processCurrentStatusResponse(ResponseInterface $response): CurrentStatusResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        /** @var CurrentStatusResponse $object */
        return CurrentStatusResponse::jsonDeserialize(json: (object) [
            'CurrentStatusResponse' => (object) [
                'Shipments' => isset($body->CurrentStatus->Shipment) ? $body->CurrentStatus->Shipment : null,
                'Warnings'  => isset($body->Warnings) ? $body->Warnings : null,
            ]
        ]);
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
     * @since 2.0.0
     */
    public function buildCompleteStatusRequest(CompleteStatus $completeStatus): RequestInterface
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
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $endDate));
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
                $query['startDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date(format: 'd-m-Y', timestamp: strtotime(datetime: (string) $endDate));
            }
        } else {
            $query = [
                'detail' => 'true',
            ];
            $endpoint = "/barcode/{$completeStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->postnl->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', value: $apiKey)
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('Content-Type', value: 'application/json;charset=UTF-8');
    }

    /**
     * Process CompleteStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CompleteStatusResponse|null
     *
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processCompleteStatusResponse(mixed $response): ?CompleteStatusResponse
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        if (isset($body->CompleteStatus->Shipment)) {
            $body->CompleteStatus->Shipments = $body->CompleteStatus->Shipment;
        }
        unset($body->CompleteStatus->Shipment);

        if (isset($body->CompleteStatus->Shipments) && !is_array(value: $body->CompleteStatus->Shipments)) {
            $body->CompleteStatus->Shipments = [$body->CompleteStatus->Shipments];
        }

        if (isset($body->CompleteStatus->Shipments)) {
            foreach ($body->CompleteStatus->Shipments as &$shipment) {
                $shipment->Customer = Customer::jsonDeserialize(json: (object) ['Customer' => $shipment->Customer]);
            }
            unset($shipment);

            foreach ($body->CompleteStatus->Shipments as &$shipment) {
                if (isset($shipment->Address)) {
                    $shipment->Addresses = $shipment->Address;
                    unset($shipment->Address);
                }

                if (!isset($shipment->Addresses)) {
                    $shipment->Addresses = [];
                }

                if (!is_array(value: $shipment->Addresses)) {
                    $shipment->Addresses = [$shipment->Addresses];
                }

                if (isset($shipment->Event)) {
                    $shipment->Events = $shipment->Event;
                    unset($shipment->Event);
                }

                if (!is_array(value: $shipment->Events)) {
                    $shipment->Events = [$shipment->Events];
                }

                foreach ($shipment->Events as &$event) {
                    $event = CompleteStatusResponseEvent::jsonDeserialize(
                        json: (object) ['CompleteStatusResponseEvent' => $event]
                    );
                }

                if (isset($shipment->OldStatus)) {
                    $shipment->OldStatuses = $shipment->OldStatus;
                    unset($shipment->OldStatus);
                }
                if (!is_array(value: $shipment->OldStatuses)) {
                    $shipment->OldStatuses = [$shipment->OldStatuses];
                }

                foreach ($shipment->OldStatuses as &$oldStatus) {
                    $oldStatus = CompleteStatusResponseOldStatus::jsonDeserialize(
                        json: (object) ['CompleteStatusResponseOldStatus' => $oldStatus]
                    );
                }
            }
        }

        /** @var CompleteStatusResponse $object */
        return CompleteStatusResponse::jsonDeserialize(json: (object) [
            'CompleteStatusResponse' => (object) [
                'Shipments' => isset($body->CompleteStatus->Shipments) ? $body->CompleteStatus->Shipments : null,
                'Warnings'  => isset($body->Warnings) ? $body->Warnings : null,
            ]
        ]);
    }

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     *
     * @since 2.0.0
     */
    public function buildGetSignatureRequest(GetSignature $getSignature): RequestInterface
    {
        $apiKey = $this->postnl->getRestApiKey();

        return $this->postnl->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}"
        )
            ->withHeader('apikey', value: $apiKey)
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Process GetSignature Response REST.
     *
     * @param mixed $response
     *
     * @return GetSignatureResponseSignature|null
     *
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetSignatureResponse(mixed $response): ?GetSignatureResponseSignature
    {
        $body = json_decode(json: static::getResponseText(response: $response));

        /** @var GetSignatureResponseSignature $object */
        return GetSignatureResponseSignature::jsonDeserialize(json: (object) ['GetSignatureResponseSignature' => $body->Signature]);
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
     * @since 2.0.0
     */
    public function buildGetUpdatedShipmentsRequest(
        Customer          $customer,
        DateTimeInterface $dateTimeFrom = null,
        DateTimeInterface $dateTimeTo = null
    ): RequestInterface {
        $apiKey = $this->postnl->getRestApiKey();

        $range = '';
        if ($dateTimeFrom) {
            $range = "?period={$dateTimeFrom->format(format:'Y-m-d\TH:i:s')}&period={$dateTimeTo->format(format:'Y-m-d\TH:i:s')}";
        }

        return $this->postnl->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/{$customer->getCustomerNumber()}/updatedshipments$range"
        )
            ->withHeader('apikey', value: $apiKey)
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * Process updated shipments response REST.
     *
     * @param ResponseInterface $response
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws DeserializationException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @since 2.0.0
     */
    public function processGetUpdatedShipmentsResponse(ResponseInterface $response): array
    {
        $body = json_decode(json: static::getResponseText(response: $response));
        if (!is_array(value: $body)) {
            return [];
        }

        foreach ($body as &$item) {
            $item = UpdatedShipmentsResponse::jsonDeserialize(json: (object) ['UpdatedShipmentsResponse' => $item]);
        }

        return $body;
    }
}
