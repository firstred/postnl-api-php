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

use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ConfirmingService.
 *
 * @method ConfirmingResponseShipment   confirmShipment(Confirming $shipment)
 * @method ConfirmingResponseShipment[] confirmShipments(Confirming[] $shipments)
 * @method RequestInterface             buildConfirmShipmentRequest(Confirming $shipment)
 * @method ConfirmingResponseShipment   processConfirmShipmentResponse(mixed $response)
 *
 * @since 1.2.0
 */
interface ConfirmingServiceInterface extends ServiceInterface
{
    /**
     * Generate a single barcode via REST.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function confirmShipmentREST(Confirming $confirming);

    /**
     * Confirm multiple shipments.
     *
     * @param Confirming[] $confirms ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipmentsREST(array $confirms);

    /**
     * Generate a single label via SOAP.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipmentSOAP(Confirming $confirming);

    /**
     * Generate multiple labels at once.
     *
     * @param array $confirmings ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipmentsSOAP(array $confirmings);

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildConfirmRequestREST(Confirming $confirming);

    /**
     * Proces Confirm REST Response.
     *
     * @param mixed $response
     *
     * @return ConfirmingResponseShipment|null
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseREST($response);

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildConfirmRequestSOAP(Confirming $confirming);

    /**
     * Process Confirm SOAP response.
     *
     * @param ResponseInterface $response
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseSOAP(ResponseInterface $response);
}
