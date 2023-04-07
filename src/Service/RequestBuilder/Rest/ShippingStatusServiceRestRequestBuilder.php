<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Service\RequestBuilder\Rest;

use DateTimeInterface;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\RequestBuilder\ShippingStatusServiceRequestBuilderInterface;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use Psr\Http\Message\RequestInterface;

use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 *
 * @internal
 */
class ShippingStatusServiceRestRequestBuilder extends AbstractRestRequestBuilder implements ShippingStatusServiceRequestBuilderInterface
{
    // Endpoints
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2/status';
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2/status';

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
        $this->setService(entity: $currentStatus);

        if ($currentStatus->getShipment()->getReference()) {
            $query = [
                'customerCode'   => $currentStatus->getCustomer()->getCustomerCode(),
                'customerNumber' => $currentStatus->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = "/reference/{$currentStatus->getShipment()->getReference()}";
        } elseif ($currentStatus->getShipment()->getStatusCode()) {
            $query = [
                'customerCode'   => $currentStatus->getCustomer()->getCustomerCode(),
                'customerNumber' => $currentStatus->getCustomer()->getCustomerNumber(),
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
                'customerCode'   => $currentStatus->getCustomer()->getCustomerCode(),
                'customerNumber' => $currentStatus->getCustomer()->getCustomerNumber(),
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

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
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
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildCompleteStatusRequest(CompleteStatus $completeStatus): RequestInterface
    {
        $this->setService(entity: $completeStatus);

        if ($completeStatus->getShipment()->getReference()) {
            $query = [
                'customerCode'   => $completeStatus->getCustomer()->getCustomerCode(),
                'customerNumber' => $completeStatus->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = "/reference/{$completeStatus->getShipment()->getReference()}";
        } elseif ($completeStatus->getShipment()->getStatusCode()) {
            $query = [
                'customerCode'   => $completeStatus->getCustomer()->getCustomerCode(),
                'customerNumber' => $completeStatus->getCustomer()->getCustomerNumber(),
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
                'customerCode'   => $completeStatus->getCustomer()->getCustomerCode(),
                'customerNumber' => $completeStatus->getCustomer()->getCustomerNumber(),
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

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json')
            ->withHeader('Content-Type', value: 'application/json;charset=UTF-8');
    }

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildGetSignatureRequest(GetSignature $getSignature): RequestInterface
    {
        $this->setService(entity: $getSignature);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}",
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
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
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function buildGetUpdatedShipmentsRequest(
        Customer $customer,
        DateTimeInterface $dateTimeFrom = null,
        DateTimeInterface $dateTimeTo = null,
    ): RequestInterface {
        $range = '';
        if ($dateTimeFrom) {
            $range = "?period={$dateTimeFrom->format(format: 'Y-m-d\TH:i:s')}&period={$dateTimeTo->format(format: 'Y-m-d\TH:i:s')}";
        }

        $this->setService(entity: $customer);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: ($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/{$customer->getCustomerNumber()}/updatedshipments$range"
        )
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * @param AbstractEntity $entity
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    protected function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(currentService: ShippingStatusServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
