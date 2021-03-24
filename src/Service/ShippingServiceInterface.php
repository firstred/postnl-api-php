<?php

namespace ThirtyBees\PostNL\Service;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use ThirtyBees\PostNL\Entity\Request\GenerateShipping;
use ThirtyBees\PostNL\Entity\Response\GenerateShippingResponse;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class ShippingService.
 *
 * @method GenerateShippingResponse generateShipping(GenerateShipping $generateShipping, bool $confirm)
 * @method RequestInterface                  buildGenerateShippingRequest(GenerateShipping $generateShipping, bool $confirm)
 * @method GenerateShippingResponse processGenerateShippingResponse(mixed $response)
 *
 * @since 1.2.0
 */
interface ShippingServiceInterface
{
    /**
     * Generate a single Shipping vai REST.
     *
     * @param GenerateShipping $generateShipping
     * @param bool             $confirm
     *
     * @return GenerateShippingResponse|null
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ReflectionException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.2.0
     */
    public function generateShippingREST(GenerateShipping $generateShipping, $confirm = true);

    /**
     * @param GenerateShipping $generateShipping
     * @param bool             $confirm
     *
     * @return RequestInterface
     *
     * @throws ReflectionException
     *
     * @since 1.2.0
     */
    public function buildGenerateShippingRequestREST(GenerateShipping $generateShipping, $confirm = true);

    /**
     * Process the GenerateShipping REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateShippingResponse|null
     *
     * @throws ReflectionException
     * @throws ResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     *
     * @since 1.2.0
     */
    public function processGenerateShippingResponseREST($response);
}
