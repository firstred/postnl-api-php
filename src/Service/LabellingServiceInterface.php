<?php

namespace ThirtyBees\PostNL\Service;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\Response\GenerateLabelResponse;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class LabellingService.
 *
 * @method GenerateLabelResponse   generateLabel(GenerateLabel $generateLabel, bool $confirm)
 * @method RequestInterface        buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm)
 * @method GenerateLabelResponse   processGenerateLabelResponse(mixed $response)
 * @method GenerateLabelResponse[] generateLabels(GenerateLabel[] $generateLabel, bool $confirm)
 *
 * @since 1.0.0
 */
interface LabellingServiceInterface
{
    /**
     * Generate a single barcode via REST.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
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
    public function generateLabelREST(GenerateLabel $generateLabel, $confirm = true);

    /**
     * Generate multiple labels at once.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function generateLabelsREST(array $generateLabels);

    /**
     * Generate a single label via SOAP.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function generateLabelSOAP(GenerateLabel $generateLabel, $confirm = true);

    /**
     * Generate multiple labels at once via SOAP.
     *
     * @param array $generateLabels ['uuid' => [GenerateBarcode, confirm], ...]
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function generateLabelsSOAP(array $generateLabels);

    /**
     * Build the GenerateLabel request for the REST API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGenerateLabelRequestREST(GenerateLabel $generateLabel, $confirm = true);

    /**
     * Process the GenerateLabel REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse|null
     *
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseREST($response);

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @throws \ReflectionException
     *
     * @since 1.0.0
     */
    public function buildGenerateLabelRequestSOAP(GenerateLabel $generateLabel, $confirm = true);

    /**
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.0.0
     */
    public function processGenerateLabelResponseSOAP(ResponseInterface $response);
}
