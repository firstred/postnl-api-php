<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Http;

use Http\Client\Exception as HttpClientException;
use Http\Client\HttpAsyncClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface HttpClientInterface.
 */
interface HttpClientInterface
{
    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id      Request ID
     * @param RequestInterface $request PSR-7 request
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function addOrUpdateRequest(string $id, RequestInterface $request): string;

    /**
     * Remove a request from the list of pending requests.
     *
     * @since 1.0.0
     * @since 2.0.0 Strict typing
     */
    public function removeRequest(string $id): void;

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface[] $requests
     *
     * @return ResponseInterface[]
     *
     * @throws HttpClientException
     *
     * @since 2.0.0 Strict typing
     */
    public function doRequests(array $requests = []): array;

    /**
     * Clear all pending requests.
     *
     * @since 1.0.0
     */
    public function clearRequests(): void;

    /**
     * Do a single request.
     *
     * Exceptions are captured into the result array
     *
     * @return ResponseInterface
     *
     * @throws HttpClientException
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function doRequest(RequestInterface $request);

    /**
     * Return concurrency.
     *
     * @since 1.0.0
     */
    public function getConcurrency(): int;

    /**
     * Set the concurrency.
     *
     * @since 1.0.0
     */
    public function setConcurrency(int $concurrency): HttpClientInterface;

    /**
     * Get the HttpAsynClient.
     *
     * @since 1.0.0
     */
    public function getAsyncClient(): HttpAsyncClient;

    /**
     * Set the HttpAsyncClient.
     *
     * @since 3.0.0
     */
    public function setHttpAsyncClient(HttpAsyncClient $client): HttpClientInterface;
}
