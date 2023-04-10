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

namespace Firstred\PostNL\HttpClient;

use Exception;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\NoCandidateFoundException;
use Http\Discovery\Exception\NotFoundException as DiscoveryNotFoundException;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class HTTPlugClient.
 *
 * @since 1.2.0
 *
 * @internal
 */
class HTTPlugHttpClient extends BaseHttpClient implements HttpClientInterface
{
    /** @var static */
    protected static HTTPlugHttpClient $instance;

    /**
     * @var HttpAsyncClient|HttpClient
     */
    protected HttpClient|HttpAsyncClient $client;

    /**
     * HTTPlugClient constructor.
     *
     * @param HttpAsyncClient|HttpClient|null $client
     * @param LoggerInterface|null            $logger
     * @param int                             $concurrency
     * @param int                             $maxRetries
     *
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 1.3.0 $maxRetries param
     */
    public function __construct(
        HttpAsyncClient|HttpClient $client = null,
        LoggerInterface $logger = null,
        int $concurrency = 5,
        int $maxRetries = 5,
    ) {
        $this->logger = $logger;
        $this->concurrency = $concurrency;
        $this->maxRetries = $maxRetries;

        if (null === $client) {
            try {
                $client = HttpAsyncClientDiscovery::find();
            } catch (DiscoveryNotFoundException|NoCandidateFoundException|DiscoveryFailedException) {
            }
        }
        if (null === $client) {
            try {
                $client = Psr18ClientDiscovery::find();
            } catch (DiscoveryNotFoundException|NoCandidateFoundException|DiscoveryFailedException) {
            }
        }
        if (null === $client) {
            try {
                $client = HttpClientDiscovery::find();
            } catch (DiscoveryNotFoundException|NoCandidateFoundException|DiscoveryFailedException) {
            }
        }

        if (!$client) {
            throw new HttpClientException(message: 'HTTP Client could not be found');
        }

        $this->setClient(client: $client);
    }

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface[] $requests
     *
     * @return HttpClientException[]|ResponseInterface[]
     *
     * @throws InvalidArgumentException
     */
    public function doRequests(array $requests = []): array
    {
        // Handle pending requests as well
        $requests = $this->pendingRequests + $requests;
        $this->clearRequests();

        $client = $this->getClient();

        $responses = [];
        if ($client instanceof HttpAsyncClient) {
            // Concurrent requests
            $promises = call_user_func(callback: function () use ($requests, $client) {
                foreach ($requests as $index => $request) {
                    try {
                        yield $index => $client->sendAsyncRequest(request: $request);
                    } catch (Exception) {
                    }
                }
            });

            try {
                $promise = (new EachPromise(
                    iterable: $promises,
                    config: [
                        'concurrency' => $this->concurrency,
                        'fulfilled'   => function (ResponseInterface $response, $index) use (&$responses) {
                            $responses[$index] = $response;
                        },
                        'rejected'    => function (ResponseInterface $response, $index) use (&$responses) {
                            $responses[$index] = $response;
                        },
                    ]
                ))->promise();

                $promise?->wait(unwrap: true);
            } catch (HttpException) {
                // Ignore HttpExceptions, we are going to handle them in the response validator
            } catch (TransferException $e) {
                // Other transfer exceptions should be thrown
                throw $e;
            } catch (Exception) {
                // Unreachable code, these kinds of exceptions should not be unwrapped
            }
        } else {
            foreach ($requests as $idx => $request) {
                try {
                    $responses[$idx] = $this->doRequest(request: $request);
                } catch (HttpClientException $e) {
                    $responses[$idx] = $e;
                }
            }
        }

        foreach ($responses as $id => $response) {
            $logLevel = LogLevel::DEBUG;
            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->getLogger()->log(level: $logLevel, message: PsrMessage::toString(message: $requests[$id]));
            if ($response instanceof ResponseInterface) {
                $this->getLogger()->log(level: $logLevel, message: PsrMessage::toString(message: $response));
            }
        }

        return $responses;
    }

    /**
     * Do a single request.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws HttpClientException
     */
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        $logLevel = LogLevel::DEBUG;
        $response = null;

        // Initialize HttpAsyncClient, include the default options
        $client = $this->getClient();

        try {
            if ($client instanceof HttpAsyncClient) {
                $response = $client->sendAsyncRequest(request: $request)->wait();
            } else {
                $response = $client->sendRequest(request: $request);
            }

            return $response;
        } catch (Exception $e) {
            throw new HttpClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new HttpClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } finally {
            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->getLogger()->log(level: $logLevel, message: PsrMessage::toString(message: $request));
            if ($response instanceof ResponseInterface) {
                $this->getLogger()->log(level: $logLevel, message: PsrMessage::toString(message: $response));
            }
        }
    }

    /**
     * @return HttpAsyncClient|HttpClient
     */
    public function getClient(): HttpAsyncClient|HttpClient
    {
        return $this->client;
    }

    /**
     * @param HttpAsyncClient|HttpClient $client
     *
     * @return static
     */
    public function setClient(HttpAsyncClient|HttpClient $client): static
    {
        $this->client = $client;

        return $this;
    }
}
