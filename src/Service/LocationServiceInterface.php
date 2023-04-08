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

use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use JetBrains\PhpStorm\Deprecated;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;

/**
 * Class LocationService.
 *
 * @method GetNearestLocationsResponse getNearestLocations(GetNearestLocations $getNearestLocations)
 * @method RequestInterface            buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations)
 * @method GetNearestLocationsResponse processGetNearestLocationsResponse(mixed $response)
 * @method GetLocationsInAreaResponse  getLocationsInArea(GetLocationsInArea $getLocationsInArea)
 * @method RequestInterface            buildGetLocationsInAreaRequest(GetLocationsInArea $getLocationsInArea)
 * @method GetLocationsInAreaResponse  processGetLocationsInAreaResponse(mixed $response)
 * @method GetLocationsInAreaResponse  getLocation(GetLocation $getLocation)
 * @method RequestInterface            buildGetLocationRequest(GetLocation $getLocation)
 * @method GetLocationsInAreaResponse  processGetLocationResponse(mixed $response)
 *
 * @since 1.2.0
 * @internal
 */
interface LocationServiceInterface extends ServiceInterface
{
    /**
     * Get the nearest locations via REST.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws PsrCacheInvalidArgumentException
     * @throws ResponseException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getNearestLocations` instead
     * @internal
     */
    #[Deprecated]
    public function getNearestLocationsREST(GetNearestLocations $getNearestLocations);

    /**
     * Get the nearest locations via SOAP.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getNearestLocations` instead
     * @internal
     */
    #[Deprecated]
    public function getNearestLocationsSOAP(GetNearestLocations $getNearestLocations);

    /**
     * Get the nearest locations via REST.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getLocationsInArea` instead
     * @internal
     */
    #[Deprecated]
    public function getLocationsInAreaREST(GetLocationsInArea $getLocations);

    /**
     * Get the nearest locations via SOAP.
     *
     * @param GetLocationsInArea $getNearestLocations
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getLocationsInArea` instead
     * @internal
     */
    #[Deprecated]
    public function getLocationsInAreaSOAP(GetLocationsInArea $getNearestLocations);

    /**
     * Get the location via REST.
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getLocation` instead
     * @internal
     */
    #[Deprecated]
    public function getLocationREST(GetLocation $getLocation);

    /**
     * Get the nearest locations via SOAP.
     *
     * @param GetLocation $getLocation
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws PsrCacheInvalidArgumentException
     * @throws HttpClientException
     * @throws NotFoundException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use `getLocation` instead
     * @internal
     */
    #[Deprecated]
    public function getLocationSOAP(GetLocation $getLocation);

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GetNearestLocations $getNearestLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetNearestLocationsRequestREST(GetNearestLocations $getNearestLocations);

    /**
     * Process GetNearestLocations Response REST.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetNearestLocationsResponseREST($response);

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GetNearestLocations $getLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetNearestLocationsRequestSOAP(GetNearestLocations $getLocations);

    /**
     * Process GetNearestLocations Response SOAP.
     *
     * @param ResponseInterface $response
     *
     * @return GetNearestLocationsResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetNearestLocationsResponseSOAP(ResponseInterface $response);

    /**
     * Build the GetLocationsInArea request for the REST API.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetLocationsInAreaRequestREST(GetLocationsInArea $getLocations);

    /**
     * Proess GetLocationsInArea Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetLocationsInAreaResponseREST($response);

    /**
     * Build the GetLocationsInArea request for the SOAP API.
     *
     * @param GetLocationsInArea $getLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetLocationsInAreaRequestSOAP(GetLocationsInArea $getLocations);

    /**
     * @param ResponseInterface $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetLocationsInAreaResponseSOAP(ResponseInterface $response);

    /**
     * Build the GetLocation request for the REST API.
     *
     * @param GetLocation $getLocation
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetLocationRequestREST(GetLocation $getLocation);

    /**
     * Process GetLocation Response REST.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse|null
     *
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetLocationResponseREST($response);

    /**
     * Build the GetLocation request for the SOAP API.
     *
     * @param GetLocation $getLocations
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function buildGetLocationRequestSOAP(GetLocation $getLocations);

    /**
     * Process GetLocation Response SOAP.
     *
     * @param ResponseInterface $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @deprecated 1.4.0
     * @internal
     */
    #[Deprecated]
    public function processGetLocationResponseSOAP(ResponseInterface $response);
}
