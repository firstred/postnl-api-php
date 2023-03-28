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

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DeliveryDateService.
 *
 * @method GetDeliveryDateResponse getDeliveryDate(GetDeliveryDate $getDeliveryDate)
 * @method RequestInterface        buildGetDeliveryDateRequest(GetDeliveryDate $getDeliveryDate)
 * @method GetDeliveryDateResponse processGetDeliveryDateResponse(mixed $response)
 * @method GetSentDateResponse     getSentDate(GetSentDateRequest $getSentDate)
 * @method RequestInterface        buildGetSentDateRequest(GetSentDateRequest $getSentDate)
 * @method GetSentDateResponse     processGetSentDateResponse(mixed $response)
 *
 * @since 1.2.0
 * @internal
 */
interface DeliveryDateServiceInterface extends ServiceInterface
{
    /**
     * Get a delivery date via REST.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws PostNLInvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getDeliveryDateREST(GetDeliveryDate $getDeliveryDate);

    /**
     * Get a delivery date via SOAP.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     */
    public function getDeliveryDateSOAP(GetDeliveryDate $getDeliveryDate);

    /**
     * Get the sent date via REST.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function getSentDateREST(GetSentDateRequest $getSentDate);

    /**
     * Generate a single label via SOAP.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotFoundException
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     */
    public function getSentDateSOAP(GetSentDateRequest $getSentDate);

    /**
     * Build the GetDeliveryDate request for the REST API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildGetDeliveryDateRequestREST(GetDeliveryDate $getDeliveryDate);

    /**
     * Process GetDeliveryDate REST Response.
     *
     * @param mixed $response
     *
     * @return GetDeliveryDateResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processGetDeliveryDateResponseREST($response);

    /**
     * Build the GetDeliveryDate request for the SOAP API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     */
    public function buildGetDeliveryDateRequestSOAP(GetDeliveryDate $getDeliveryDate);

    /**
     * @param ResponseInterface $response
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     */
    public function processGetDeliveryDateResponseSOAP(ResponseInterface $response);

    /**
     * Build the GetSentDate request for the REST API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildGetSentDateRequestREST(GetSentDateRequest $getSentDate);

    /**
     * Process GetSentDate REST Response.
     *
     * @param mixed $response
     *
     * @return GetSentDateResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws PostNLInvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processGetSentDateResponseREST($response);

    /**
     * Build the GetSentDate request for the SOAP API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     */
    public function buildGetSentDateRequestSOAP(GetSentDateRequest $getSentDate);

    /**
     * Process GetSentDate SOAP Response.
     *
     * @param ResponseInterface $response
     *
     * @return GetSentDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     */
    public function processGetSentDateResponseSOAP(ResponseInterface $response);
}
