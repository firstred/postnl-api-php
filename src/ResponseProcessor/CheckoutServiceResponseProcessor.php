<?php

declare(strict_types=1);

namespace Firstred\PostNL\ResponseProcessor;

use Firstred\PostNL\DTO\Response\GetDeliveryInformationResponseDTO;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Psr\Http\Message\ResponseInterface;

class CheckoutServiceResponseProcessor extends ResponseProcessorBase implements CheckoutServiceResponseProcessorInterface
{

    /**
     * @inheritDoc
     */
    public function processGetDeliveryInformationResponse(ResponseInterface $response): GetDeliveryInformationResponseDTO
    {
        /** @var GetDeliveryInformationResponseDTO $dto */
        $dto = $this->fullyProcessResponse(
            className: GetDeliveryInformationResponseDTO::class,
            response: $response,
        );

        return $dto;
    }
}
