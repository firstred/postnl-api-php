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

use Exception;
use Firstred\PostNL\Misc\EachPromise;
use Http\Client\Exception as HttpClientException;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpAsyncClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClient.
 *
 * @since 2.0.0 Removed timeout options, you should configure this in your HTTP client implementation
 *              Depends on HTTPlug for HTTP Client autodiscovery
 */
class HttpClient implements HttpClientInterface
{
    /**
     * List of pending PSR-7 requests.
     *
     * @var RequestInterface[]
     */
    protected $pendingRequests = [];

    /** @var int */
    private $concurrency = 5;

    /** @var HttpAsyncClient */
    private $asyncClient;

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id      Request ID
     * @param RequestInterface $request PSR-7 request
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function addOrUpdateRequest(string $id, RequestInterface $request): string
    {
        if (is_null($id)) {
            return (string) array_push($this->pendingRequests, $request);
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests.
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
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
     * @param RequestInterface[] $requests
     *
     * @return ResponseInterface[]
     *
     * @throws HttpClientException
     *
     * @since 2.0.0 Strict typing
     */
    public function doRequests(array $requests = []): array
    {
        // If this is a single request, create the requests array
        if (!is_array($requests)) {
            if (!$requests instanceof RequestInterface) {
                return [];
            }

            $requests = [$requests];
        }

        // Handle pending requests
        $requests = $this->pendingRequests + $requests;
        $this->clearRequests();

        $client = $this->getAsyncClient();
        // Concurrent requests
        $promises = call_user_func(
            function () use ($requests, $client) {
                foreach ($requests as $index => $request) {
                    yield $index             => $client->sendAsyncRequest($request);
                }
            }
        );

        $responses = [];
        try {
            (new EachPromise(
                $promises,
                [
                    'concurrency' => $this->concurrency,
                    'fulfilled'   => function ($response, $index) use (&$responses) {
                        $responses[$index] = $response;
                    },
                    'rejected' => function ($response, $index) use (&$responses) {
                        $responses[$index] = $response;
                    },
                ]
            ))->promise()->wait(true);
        } catch (HttpException $e) {
            // Ignore HttpExceptions, we are going to handle them in the response validator
        } catch (TransferException $e) {
            // Other transfer exceptions should be thrown
            throw $e;
        } catch (Exception $e) {
            // Unreachable code, these kinds of exceptions should not be unwrapped
        }

        return $responses;
    }

    /**
     * Clear all pending requests.
     *
     * @since 1.0.0
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
     * @throws Exception
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        // Initialize HttpAsyncClient, include the default options
        $client = $this->getAsyncClient();

        return $client->sendAsyncRequest($request)->wait();
    }

    /**
     * Return concurrency.
     *
     * @since 1.0.0
     */
    public function getConcurrency(): int
    {
        return $this->concurrency;
    }

    /**
     * Set the concurrency.
     *
     * @since 1.0.0
     */
    public function setConcurrency(int $concurrency): HttpClientInterface
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    /**
     * Get the HttpAsynClient.
     *
     * @since 1.0.0
     */
    public function getAsyncClient(): HttpAsyncClient
    {
        return $this->asyncClient;
    }

    /**
     * Set the HttpAsyncClient.
     *
     * @since 2.0.0
     */
    public function setHttpAsyncClient(HttpAsyncClient $client): HttpClientInterface
    {
        $this->asyncClient = $client;

        return $this;
    }
}
