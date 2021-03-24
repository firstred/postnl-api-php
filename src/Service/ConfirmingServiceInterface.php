<?php

namespace ThirtyBees\PostNL\Service;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Sabre\Xml\LibXMLException;
use ThirtyBees\PostNL\Entity\Request\Confirming;
use ThirtyBees\PostNL\Entity\Response\ConfirmingResponseShipment;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class ConfirmingService.
 *
 * @method ConfirmingResponseShipment   confirmShipment(Confirming $shipment)
 * @method RequestInterface             buildConfirmShipmentRequest(Confirming $shipment)
 * @method ConfirmingResponseShipment   processConfirmShipmentResponse(mixed $response)
 * @method ConfirmingResponseShipment[] confirmShipments(Confirming[] $shipments)
 *
 * @since 1.2.0
 */
interface ConfirmingServiceInterface
{
    /**
     * Generate a single barcode via REST.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
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
     * @throws ReflectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
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
     * @throws LibXMLException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
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
     * @throws ReflectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @since 1.0.0
     */
    public function confirmShipmentsSOAP(array $confirmings);

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
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
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseREST($response);

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
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
     * @throws LibXMLException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseSOAP(ResponseInterface $response);
}
