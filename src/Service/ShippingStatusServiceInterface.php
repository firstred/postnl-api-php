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
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Exception\ApiConnectionException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ShippingStatusService.
 *
 * @method CurrentStatusResponse         currentStatus(CurrentStatus|CurrentStatusByReference $currentStatus)
 * @method CurrentStatusResponse[]       currentStatuses(CurrentStatus[]|CurrentStatusByReference[] $currentStatuses)
 * @method RequestInterface              buildCurrentStatusRequest(CurrentStatus|CurrentStatusByReference $currentStatus)
 * @method CurrentStatusResponse         processCurrentStatusResponse(ResponseInterface $response)
 * @method CompleteStatusResponse        completeStatus(CompleteStatus|CompleteStatusByReference $completeStatus)
 * @method CompleteStatusResponse[]      completeStatuses(CompleteStatus[]|CompleteStatusByReference[] $completeStatuses)
 * @method RequestInterface              buildCompleteStatusRequest(CompleteStatus|CompleteStatusByReference $completeStatus)
 * @method CompleteStatusResponse        processCompleteStatusResponse(ResponseInterface $response)
 * @method GetSignatureResponseSignature getSignature(GetSignature $getSignature)
 * @method RequestInterface              buildGetSignatureRequest(GetSignature $getSignature)
 * @method GetSignature                  processGetSignatureResponse(ResponseInterface $response)
 * @method UpdatedShipmentsResponse[]    getUpdatedShipments(Customer $customer, DateTimeInterface|null $dateTimeFrom, DateTimeInterface|null $dateTimeTo)
 * @method RequestInterface              buildGetUpdatedShipmentsRequest(Customer $customer, DateTimeInterface|null $dateTimeFrom, DateTimeInterface|null $dateTimeTo)
 * @method UpdatedShipmentsResponse      processGetUpdatedShipmentsResponse(ResponseInterface $response)
 *
 * @since 1.2.0
 */
interface ShippingStatusServiceInterface extends ServiceInterface
{
    /**
     * Gets the current status.
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     *
     * @param CurrentStatus|CurrentStatusByReference $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiConnectionException
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function currentStatusREST($currentStatus);

    /**
     * Gets multiple current statuses.
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     *
     * @param CurrentStatus[]|CurrentStatusByReference[] $currentStatuses
     *
     * @return CurrentStatusResponse[]
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
          * @throws HttpClientException
     *
     * @since 1.0.0
     */
    public function currentStatusesREST(array $currentStatuses);

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
     * @return UpdatedShipmentsResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws ApiConnectionException
     *
     * @since 1.0.0
     */
    public function completeStatusREST($completeStatus);

    /**
     * Gets the complete status.
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     *
     * @param CompleteStatus[]|CompleteStatusByReference[] $completeStatuses
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
          * @throws HttpClientException
     *
     * @since 1.0.0
     */
    public function completeStatusesREST(array $completeStatuses);

    /**
     * Gets the complete status.
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
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
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws ApiConnectionException
     *
     * @since 1.0.0
     */
    public function getSignatureREST(GetSignature $getSignature);

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
    public function buildCurrentStatusRequestREST($currentStatus);

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
    public function processCurrentStatusResponseREST($response);

    /**
     * Build the CompleteStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     *
     * @param CompleteStatus $completeStatus
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildCompleteStatusRequestREST(CompleteStatus $completeStatus);

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
    public function processCompleteStatusResponseREST($response);

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
    */
    public function buildGetSignatureRequestREST(GetSignature $getSignature);

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
    public function processGetSignatureResponseREST($response);

    /**
     * Get updated shipments for customer REST.
     *
     * @param Customer               $customer
     * @param DateTimeInterface|null $dateTimeFrom
     * @param DateTimeInterface|null $dateTimeTo
     *
     * @return UpdatedShipmentsResponse[]
     *
     * @throws ApiConnectionException
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function getUpdatedShipmentsREST(
        Customer $customer,
        DateTimeInterface $dateTimeFrom = null,
        DateTimeInterface $dateTimeTo = null
    );

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
    );

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
    public function processGetUpdatedShipmentsResponseREST(ResponseInterface $response);
}
