<?php

namespace ThirtyBees\PostNL\Service;


use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\HttpClientException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class BarcodeService.
 *
 * @method string           generateBarcode(GenerateBarcode $generateBarcode)
 * @method RequestInterface buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode)
 * @method string           processGenerateBarcodeResponse(mixed $response)
 * @method string[]         generateBarcodes(GenerateBarcode[] $generateBarcode)
 *
 * @since 1.2.0
 */
interface BarcodeServiceInterface
{
    /**
     * Generate a single barcode.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string|null Barcode
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws GuzzleException
     * @throws HttpClientException
     * @throws ReflectionException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function generateBarcodeREST(GenerateBarcode $generateBarcode);

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[]|ResponseException[]|ApiException[]|CifDownException[]|CifException[] Barcodes
     *
     * @throws GuzzleException
     * @throws HttpClientException
     * @throws ReflectionException
     *
     * @noinspection PhpUnused
     */
    public function generateBarcodesREST(array $generateBarcodes);

    /**
     * Generate a single barcode.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string Barcode
     *
     * @throws CifDownException
     * @throws CifException
     * @throws GuzzleException
     * @throws HttpClientException
     * @throws ReflectionException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function generateBarcodeSOAP(GenerateBarcode $generateBarcode);

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[] Barcodes
     *
     * @throws GuzzleException
     * @throws HttpClientException
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function generateBarcodesSOAP(array $generateBarcodes);

    /**
     * Build the `generateBarcode` HTTP request for the REST API.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGenerateBarcodeRequestREST(GenerateBarcode $generateBarcode);

    /**
     * Process GenerateBarcode REST response.
     *
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws GuzzleException
     *
     * @since 1.0.0
     */
    public function processGenerateBarcodeResponseREST(ResponseInterface $response);

    /**
     * Build the `generateBarcode` HTTP request for the SOAP API.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGenerateBarcodeRequestSOAP(GenerateBarcode $generateBarcode);

    /**
     * Process GenerateBarcode SOAP response.
     *
     * @param ResponseInterface $response
     *
     * @return string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws GuzzleException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGenerateBarcodeResponseSOAP(ResponseInterface $response);
}
