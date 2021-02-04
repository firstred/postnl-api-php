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

namespace Firstred\PostNL\HttpClient;

use Firstred\PostNL\Exception\HttpClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

interface HttpClientInterface
{
    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     */
    public function addOrUpdateRequest(string $id, RequestInterface $request): string;

    /**
     * Remove a request from the list of pending requests.
     */
    public function removeRequest(string $id): void;

    /**
     * Clear all requests.
     */
    public function clearRequests(): void;

    /**
     * Do a single request.
     *
     * Exceptions are captured into the result array
     *
     * @throws HttpClientException
     */
    public function doRequest(RequestInterface $request): ResponseInterface;

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @psalm-param array<string, RequestInterface> $requests
     *
     * @psalm-return array<string, ResponseInterface|HttpClientException>
     */
    public function doRequests(array $requests = []): array;

    public function getConcurrency(): int;

    public function setConcurrency(int $concurrency): static;

    public function getLogger(): LoggerInterface|null;

    public function setLogger(LoggerInterface|null $logger = null): static;
}
