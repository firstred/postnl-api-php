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

use Exception;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Misc\EachPromise;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpAsyncClient;
use Http\Discovery\HttpAsyncClientDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class HTTPlugClient.
 */
class HTTPlugHttpClient implements HttpClientInterface
{
    protected HttpAsyncClient $asyncClient;

    /**
     * List of pending PSR-7 requests.
     */
    protected array $pendingRequests = [];

    /**
     * HTTPlugClient constructor.
     */
    public function __construct(
        HttpAsyncClient|null $asyncClient = null,
        protected LoggerInterface|null $logger = null,
        protected int $concurrency = 5,
    ) {
        $this->setHttpAsyncClient(client: $asyncClient ?: HttpAsyncClientDiscovery::find());
    }

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     */
    public function addOrUpdateRequest(string $id, RequestInterface $request): string
    {
        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests.
     */
    public function removeRequest(string $id): void
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @psalm-param array<string, RequestInterface> $requests
     *
     * @psalm-return array<string, ResponseInterface|HttpClientException>
     */
    public function doRequests(array $requests = []): array
    {
        // Handle pending requests
        $requests = $this->pendingRequests + $requests;
        $this->clearRequests();

        $client = $this->getHttpAsyncClient();
        // Concurrent requests
        $promises = call_user_func(callback: function () use ($requests, $client) {
            foreach ($requests as $index => $request) {
                try {
                    yield $index => $client->sendAsyncRequest(request: $request);
                } catch (Exception) {
                }
            }
        });

        $responses = [];
        try {
            (new EachPromise(
                iterable: $promises,
                config: [
                    'concurrency' => $this->concurrency,
                    'fulfilled'   => function (ResponseInterface $response, string $index) use (&$responses): void {
                        $responses[$index] = $response;
                    },
                    'rejected'    => function (ResponseInterface $response, string $index) use (&$responses): void {
                        $responses[$index] = $response;
                    },
                ]
            ))->promise()?->wait(unwrap: true);
        } catch (HttpException) {
            // Ignore HttpExceptions, we are going to handle them in the response validator
        } catch (TransferException $e) {
            // Other transfer exceptions should be thrown
            throw $e;
        } catch (Exception) {
            // Unreachable code, these kinds of exceptions should not be unwrapped
        }

        return $responses;
    }

    /**
     * Clear all pending requests.
     */
    public function clearRequests(): void
    {
        $this->pendingRequests = [];
    }

    /**
     * Do a single request.
     *
     * Exceptions are captured into the result array
     *
     * @throws HttpClientException
     */
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        // Initialize HttpAsyncClient, include the default options
        $client = $this->getHttpAsyncClient();

        try {
            return $client->sendAsyncRequest(request: $request)->wait();
        } catch (Exception $e) {
            throw new HttpClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    public function getConcurrency(): int
    {
        return $this->concurrency;
    }

    public function setConcurrency(int $concurrency): static
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(?LoggerInterface $logger = null): static
    {
        $this->logger = $logger;
        return $this;
    }

    public function getHttpAsyncClient(): HttpAsyncClient
    {
        return $this->asyncClient;
    }

    public function setHttpAsyncClient(HttpAsyncClient $client): static
    {
        $this->asyncClient = $client;

        return $this;
    }
}
