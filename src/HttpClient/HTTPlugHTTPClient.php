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
class HTTPlugHTTPClient implements HTTPClientInterface
{
    /**
     * List of pending PSR-7 requests.
     *
     * @var RequestInterface[]
     */
    protected array $pendingRequests = [];

    /**
     * HTTPlugClient constructor.
     */
    public function __construct(
        protected ?HttpAsyncClient $asyncClient = null,
        protected ?LoggerInterface $logger = null,
        protected int $concurrency = 5,
    ) {
        $this->setHttpAsyncClient(client: $this->asyncClient ?: HttpAsyncClientDiscovery::find());
    }

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id      Request ID
     * @param RequestInterface $request PSR-7 request
     *
     * @return string
     */
    public function addOrUpdateRequest(string $id, RequestInterface $request): string
    {
        if (is_null(value: $id)) {
            return (string) array_push($this->pendingRequests, $request);
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests.
     */
    public function removeRequest($id): void
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface[] $requests
     *
     * @return ResponseInterface[]
     *
     * @throws Exception
     */
    public function doRequests($requests = []): array
    {
        // If this is a single request, create the requests array
        if (!is_array(value: $requests)) {
            if (!$requests instanceof RequestInterface) {
                return [];
            }

            $requests = [$requests];
        }

        // Handle pending requests
        $requests = $this->pendingRequests + $requests;
        $this->clearRequests();

        $client = $this->getHttpAsyncClient();
        // Concurrent requests
        $promises = call_user_func(callback: function () use ($requests, $client) {
            foreach ($requests as $index => $request) {
                yield $index             => $client->sendAsyncRequest(request: $request);
            }
        });

        $responses = [];
        try {
            (new EachPromise(
                iterable: $promises,
                config: [
                    'concurrency' => $this->concurrency,
                    'fulfilled'   => function ($response, $index) use (&$responses) {
                        $responses[$index] = $response;
                    },
                    'rejected'    => function ($response, $index) use (&$responses) {
                        $responses[$index] = $response;
                    },
                ]
            ))->promise()->wait(unwrap: true);
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
     * @return ResponseInterface
     *
     * @throws Exception
     */
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        // Initialize HttpAsyncClient, include the default options
        $client = $this->getHttpAsyncClient();

        return $client->sendAsyncRequest(request: $request)->wait();
    }

    /**
     * Return concurrency.
     *
     * @return int
     */
    public function getConcurrency(): int
    {
        return $this->concurrency;
    }

    /**
     * Set the concurrency.
     */
    public function setConcurrency(int $concurrency): static
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    /**
     * Get the HttpAsyncClient.
     */
    public function getHttpAsyncClient(): HttpAsyncClient
    {
        return $this->asyncClient;
    }

    /**
     * Set the HttpAsyncClient.
     */
    public function setHttpAsyncClient(HttpAsyncClient $client): static
    {
        $this->asyncClient = $client;

        return $this;
    }
}
