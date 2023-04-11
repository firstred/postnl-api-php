<?php

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

declare(strict_types=1);

namespace Firstred\PostNL\Service\ResponseProcessor;

use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @since 2.0.0
 *
 * @internal
 */
abstract class AbstractResponseProcessor
{
    /**
     * Get the response.
     *
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 2.0.0
     */
    protected static function getResponseText(array|ResponseInterface|HttpClientException $response): string
    {
        // Guzzle returned promises
        if (is_array(value: $response)) {
            if (isset($response['reason'])) {
                $response = $response['reason'];
            } elseif (isset($response['value'])) {
                $response = $response['value'];
            }
        }

        if ($response instanceof ResponseInterface) {
            return (string) $response->getBody();
        } elseif (is_a(object_or_class: $response, class: HttpClientException::class)) {
            $exception = $response;
            if (method_exists(object_or_class: $response, method: 'getResponse')) {
                $response = $response->getResponse();
            }
            if (!$response || $response instanceof $exception) {
                throw $exception;
            }

            /* @var Response $response */
            return (string) $response->getBody();
        } else {
            throw new ResponseException(message: 'Unknown response type');
        }
    }
}
