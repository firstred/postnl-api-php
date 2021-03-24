<?php

namespace ThirtyBees\PostNL\Service;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use ThirtyBees\PostNL\Entity\Request\GetTimeframes;
use ThirtyBees\PostNL\Entity\Response\ResponseTimeframes;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;

/**
 * Class TimeframeService.
 *
 * @method ResponseTimeframes getTimeframes(GetTimeframes $getTimeframes)
 * @method RequestInterface   buildGetTimeframesRequest(GetTimeframes $getTimeframes)
 * @method ResponseTimeframes processGetTimeframesResponse(mixed $response)
 *
 * @since 1.2.0
 */
interface TimeframeServiceInterface
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processGetTimeframesResponseSOAP(ResponseInterface $response);
}
