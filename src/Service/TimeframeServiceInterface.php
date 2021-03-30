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

use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Sabre\Xml\LibXMLException;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;

/**
 * Class TimeframeService.
 *
 * @method ResponseTimeframes getTimeframes(GetTimeframes $getTimeframes)
 * @method RequestInterface   buildGetTimeframesRequest(GetTimeframes $getTimeframes)
 * @method ResponseTimeframes processGetTimeframesResponse(mixed $response)
 *
 * @since 1.2.0
 */
interface TimeframeServiceInterface extends ServiceInterface
{
    /**
     * Get timeframes via REST.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws InvalidArgumentException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getTimeframesREST(GetTimeframes $getTimeframes);

    /**
     * Get timeframes via SOAP.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return ResponseTimeframes
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws InvalidArgumentException
     * @throws LibXMLException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getTimeframesSOAP(GetTimeframes $getTimeframes);

    /**
     * Build the GetTimeframes request for the REST API.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetTimeframesRequestREST(GetTimeframes $getTimeframes);

    /**
     * Process GetTimeframes Response REST.
     *
     * @param mixed $response
     *
     * @return ResponseTimeframes|null
     *
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGetTimeframesResponseREST($response);

    /**
     * Build the GetTimeframes request for the SOAP API.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetTimeframesRequestSOAP(GetTimeframes $getTimeframes);

    /**
     * Process GetTimeframes Response SOAP.
     *
     * @param ResponseInterface $response
     *
     * @return ResponseTimeframes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws LibXMLException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGetTimeframesResponseSOAP(ResponseInterface $response);
}
