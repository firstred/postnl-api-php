<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Gateway;

use Firstred\PostNL\DTO\Request\CalculateTimeframesRequestDTO;
use Firstred\PostNL\DTO\Response\CalculateTimeframesResponseDTO;
use Firstred\PostNL\Exception\ApiClientException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\InvalidApiKeyException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotAvailableException;
use Firstred\PostNL\Exception\ParseError;
use Firstred\PostNL\RequestBuilder\TimeframeServiceRequestBuilderInterface;
use Firstred\PostNL\ResponseProcessor\TimeframeServiceResponseProcessorInterface;

/**
 * Interface TimeframeServiceGatewayInterface.
 */
interface TimeframeServiceGatewayInterface extends GatewayInterface
{
    /**
     * @param CalculateTimeframesRequestDTO $calculateTimeframesRequestDTO
     *
     * @return CalculateTimeframesResponseDTO
     *
     * @throws ApiClientException
     * @throws ApiException
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     * @throws NotAvailableException
     * @throws ParseError
     */
    public function doCalculateTimeframesRequest(
        CalculateTimeframesRequestDTO $calculateTimeframesRequestDTO,
    ): CalculateTimeframesResponseDTO;

    /**
     * @return TimeframeServiceRequestBuilderInterface
     */
    public function getRequestBuilder(): TimeframeServiceRequestBuilderInterface;

    /**
     * @param TimeframeServiceRequestBuilderInterface $requestBuilder
     *
     * @return static
     */
    public function setRequestBuilder(TimeframeServiceRequestBuilderInterface $requestBuilder): static;

    /**
     * @return TimeframeServiceResponseProcessorInterface
     */
    public function getResponseProcessor(): TimeframeServiceResponseProcessorInterface;

    /**
     * @param TimeframeServiceResponseProcessorInterface $responseProcessor
     *
     * @return static
     */
    public function setResponseProcessor(TimeframeServiceResponseProcessorInterface $responseProcessor): static;
}
