<?php

namespace Firstred\PostNL\ResponseProcessor;

use Firstred\PostNL\DTO\Response\GetDeliveryInformationResponseDTO;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Psr\Http\Message\ResponseInterface;

interface CheckoutServiceResponseProcessorInterface extends ResponseProcessorInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return GetDeliveryInformationResponseDTO
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function processGetDeliveryInformationResponse(ResponseInterface $response): GetDeliveryInformationResponseDTO;
}
