<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service\ResponseProcessor\Rest;

use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ResponseProcessor\LabellingServiceResponseProcessorInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 * @internal
 */
class LabellingServiceRestResponseProcessor extends AbstractRestResponseProcessor implements LabellingServiceResponseProcessorInterface
{
    /**
     * Process the GenerateLabel REST Response.
     *
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws ResponseException
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws ApiException
     * @throws InvalidConfigurationException
     * @since 2.0.0
     */
    public function processGenerateLabelResponse(ResponseInterface $response): GenerateLabelResponse
    {
        $this->validateResponse(response: $response);
        $responseContent = static::getResponseText(response: $response);
        $body = json_decode(json: $responseContent);
        if (isset($body->ResponseShipments)) {
            return GenerateLabelResponse::jsonDeserialize(json: (object) ['GenerateLabelResponse' => $body]);
        }

        throw new ApiException(message: "`GenerateLabelResponse` does not contain `ResponseShipments`");
    }
}
