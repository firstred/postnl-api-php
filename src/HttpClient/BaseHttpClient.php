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

use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use function max;

abstract class BaseHttpClient implements LoggerAwareInterface
{
    public const DEFAULT_TIMEOUT = 80;
    public const DEFAULT_CONNECT_TIMEOUT = 30;

    protected int $timeout = self::DEFAULT_TIMEOUT;
    protected int $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;
    protected array $pendingRequests = [];
    protected ?LoggerInterface $logger;
    protected int $maxRetries = 5;
    protected int $concurrency = 5;
    protected RequestFactoryInterface $requestFactory;
    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setTimeout(int $seconds): static
    {
        $this->timeout = (int) max($seconds, 0);

        return $this;
    }

    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    public function setConnectTimeout(int $seconds): static
    {
        $this->connectTimeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * Get logger.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Return max retries.
     *
     * @return int
     */
    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    /**
     * Set the amount of retries.
     *
     * @param int $maxRetries
     *
     * @return static
     */
    public function setMaxRetries(int $maxRetries): static
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    /**
     * Set the concurrency.
     *
     * @param int $concurrency
     *
     * @return static
     */
    public function setConcurrency(int $concurrency): static
    {
        $this->concurrency = $concurrency;

        return $this;
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
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id      Request ID
     * @param RequestInterface $request PSR-7 request
     *
     * @return int|string
     *
     * @throws InvalidArgumentException
     */
    public function addOrUpdateRequest(string $id, RequestInterface $request): int|string
    {
        if (!in_array(needle: $request->getUri()->getHost(), haystack: ['api.postnl.nl', 'api-sandbox.postnl.nl'])) {
            throw new InvalidArgumentException(message: 'Unsupported domain');
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests.
     *
     * @param string $id
     */
    public function removeRequest(string $id): void
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * Clear all pending requests.
     */
    public function clearRequests(): void
    {
        $this->pendingRequests = [];
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

        $responses = [];
        foreach ($requests as $id => $request) {
            try {
                $response = $this->doRequest(request: $request);
            } catch (HttpClientException $e) {
                $response = $e;
            }
            $responses[$id] = $response;
        }

        return $responses;
    }

    /**
     * Get PSR-7 Request factory.
     *
     * @throws NotSupportedException
     *
     * @since 1.3.0
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        if (!isset($this->requestFactory)) {
            throw new NotSupportedException(message: 'Request factory has to be set first');
        }

        return $this->requestFactory;
    }

    /**
     * Set PSR-7 Request factory.
     *
     * @since 1.3.0
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): static
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * Get PSR-7 Response factory.
     *
     * @throws NotSupportedException
     *
     * @since 1.3.0
     */
    public function getResponseFactory(): ResponseFactoryInterface
    {
        if (!isset($this->responseFactory)) {
            throw new NotSupportedException(message: 'Response factory has to be set first');
        }

        return $this->responseFactory;
    }

    /**
     * Set PSR-7 Response factory.
     *
     * @since 1.3.0
     */
    public function setResponseFactory(ResponseFactoryInterface $responseFactory): static
    {
        $this->responseFactory = $responseFactory;

        return $this;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @throws NotSupportedException
     *
     * @since 1.3.0
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        if (!isset($this->streamFactory)) {
            throw new NotSupportedException(message: 'Stream factory has to be set first');
        }

        return $this->streamFactory;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @since 1.3.0
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): static
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }
}
