<?php

namespace Firstred\PostNL\RequestBuilder;

use Firstred\PostNL\DTO\Request\GenerateLabelsRequestDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

/**
 * Class LabellingServiceRequestBuilder.
 */
interface LabellingServiceRequestBuilderInterface
{
    /**
     * @param GenerateLabelsRequestDTO $generateLabelRequestDTO
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public function buildGenerateLabelRequest(GenerateLabelsRequestDTO $generateLabelRequestDTO): RequestInterface;
}
