<?php

namespace ThirtyBees\PostNL\Service;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use ThirtyBees\PostNL\Entity\Request\GetDeliveryDate;
use ThirtyBees\PostNL\Entity\Request\GetSentDateRequest;
use ThirtyBees\PostNL\Entity\Response\GetDeliveryDateResponse;
use ThirtyBees\PostNL\Entity\Response\GetSentDateResponse;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;

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
 * @since 1.0.0
 */
interface DeliveryDateServiceInterface
{
    /**
     * Get a delivery date via REST.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return GetDeliveryDateResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
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
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @noinspection PhpUnused
     *
     * @since        1.0.0
     */
    public function getDeliveryDateSOAP(GetDeliveryDate $getDeliveryDate);

    /**
     * Get the sent date via REST.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return GetSentDateResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ReflectionException
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
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @noinspection PhpUnused
     *
     * @since        1.0.0
     */
    public function getSentDateSOAP(GetSentDateRequest $getSentDate);

    /**
     * Build the GetDeliveryDate request for the REST API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
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
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGetDeliveryDateRequestSOAP(GetDeliveryDate $getDeliveryDate);

    /**
     * @param ResponseInterface $response
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     */
    public function processGetDeliveryDateResponseSOAP(ResponseInterface $response);

    /**
     * Build the GetSentDate request for the REST API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     * @throws \ReflectionException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     */
    public function processGetSentDateResponseREST($response);

    /**
     * Build the GetSentDate request for the SOAP API.
     *
     * @param GetSentDateRequest $getSentDate
     *
     * @return RequestInterface
     * @throws \ReflectionException
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
     * @throws LibXMLException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     */
    public function processGetSentDateResponseSOAP(ResponseInterface $response);
}
