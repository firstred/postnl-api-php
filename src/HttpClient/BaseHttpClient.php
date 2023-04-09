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

namespace Firstred\PostNL\HttpClient;

use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Factory\RequestFactoryInterface as BackwardCompatibleRequestFactoryInterface;
use Firstred\PostNL\Factory\ResponseFactoryInterface as BackwardCompatibleResponseFactoryInterface;
use Firstred\PostNL\Factory\StreamFactoryInterface as BackwardCompatibleStreamFactoryInterface;
use JetBrains\PhpStorm\Deprecated;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use function array_push;
use function is_null;
use function max;
use function user_error;
use const E_USER_DEPRECATED;

abstract class BaseHttpClient
{
    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;

    /** @var int */
    protected $timeout = self::DEFAULT_TIMEOUT;

    /** @var int */
    protected $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;

    /**
     * Verify the server SSL certificate.
     *
     * @var bool|string
     */
    protected $verify = true;

    /** @var array */
    protected $pendingRequests = [];

    /** @var LoggerInterface */
    protected $logger;

    /** @var int */
    protected $maxRetries = 5;

    /** @var int */
    protected $concurrency = 5;

    /**
     * @var RequestFactoryInterface|BackwardCompatibleRequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var ResponseFactoryInterface|BackwardCompatibleResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @var StreamFactoryInterface|BackwardCompatibleStreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * Get timeout.
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set timeout.
     *
     * @param int $seconds
     *
     * @return static
     */
    public function setTimeout($seconds)
    {
        $this->timeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * Get connection timeout.
     *
     * @return int
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * Set connection timeout.
     *
     * @param int $seconds
     *
     * @return static
     */
    public function setConnectTimeout($seconds)
    {
        $this->connectTimeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * Return verify setting.
     *
     * @return bool|string
     *
     * @deprecated
     */
    #[Deprecated]
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     * Set the verify setting.
     *
     * @param bool|string $verify
     *
     * @return static
     *
     * @deprecated
     */
    #[Deprecated]
    public function setVerify($verify)
    {
        $this->verify = $verify;

        return $this;
    }

    /**
     * Get logger.
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     *
     * @return static
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Return max retries.
     *
     * @return int
     */
    public function getMaxRetries()
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
    public function setMaxRetries($maxRetries)
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
    public function setConcurrency($concurrency)
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    /**
     * Return concurrency.
     *
     * @return int
     */
    public function getConcurrency()
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
    public function addOrUpdateRequest($id, RequestInterface $request)
    {
        if (is_null($id)) {
            return array_push($this->pendingRequests, $request);
        }

        if (!in_array($request->getUri()->getHost(), ['api.postnl.nl', 'api-sandbox.postnl.nl'])) {
            throw new InvalidArgumentException('Unsupported domain');
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests.
     *
     * @param string $id
     */
    public function removeRequest($id)
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * Clear all pending requests.
     */
    public function clearRequests()
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
    public function doRequests($requests = [])
    {
        if ($requests instanceof RequestInterface) {
            user_error(
                'Passing a single request to HttpClientInterface::doRequests is deprecated',
                E_USER_DEPRECATED
            );
            $requests = [$requests];
        }
        if (!is_array($requests)) {
            throw new InvalidArgumentException('Invalid requests array passed');
        }
        if (!is_array($this->pendingRequests)) {
            $this->pendingRequests = [];
        }

        // Handle pending requests as well
        $requests = $this->pendingRequests + $requests;

        $responses = [];
        foreach ($requests as $id => $request) {
            try {
                $response = $this->doRequest($request);
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
     * @return RequestFactoryInterface|BackwardCompatibleRequestFactoryInterface
     *
     * @throws NotSupportedException
     *
     * @since 1.3.0
     */
    public function getRequestFactory()
    {
        if (!$this->requestFactory) {
            throw new NotSupportedException('Request factory has to be set first');
        }

        return $this->requestFactory;
    }

    /**
     * Set PSR-7 Request factory.
     *
     * @param RequestFactoryInterface|BackwardCompatibleRequestFactoryInterface $requestFactory
     *
     * @return static
     *
     * @since 1.3.0
     */
    public function setRequestFactory($requestFactory)
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * Get PSR-7 Response factory.
     *
     * @return ResponseFactoryInterface|BackwardCompatibleResponseFactoryInterface
     *
     * @throws NotSupportedException
     *
     * @since 1.3.0
     */
    public function getResponseFactory()
    {
        if (!$this->responseFactory) {
            throw new NotSupportedException('Response factory has to be set first');
        }

        return $this->responseFactory;
    }

    /**
     * Set PSR-7 Response factory.
     *
     * @param ResponseFactoryInterface|BackwardCompatibleResponseFactoryInterface $responseFactory
     *
     * @return static
     *
     * @since 1.3.0
     */
    public function setResponseFactory($responseFactory)
    {
        $this->responseFactory = $responseFactory;

        return $this;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @return StreamFactoryInterface|BackwardCompatibleStreamFactoryInterface
     *
     * @throws NotSupportedException
     *
     * @since 1.3.0
     */
    public function getStreamFactory()
    {
        if (!$this->streamFactory) {
            throw new NotSupportedException('Stream factory has to be set first');
        }

        return $this->streamFactory;
    }

    /**
     * Set PSR-7 Stream factory.
     *
     * @param StreamFactoryInterface|BackwardCompatibleStreamFactoryInterface $streamFactory
     *
     * @return static
     *
     * @since 1.3.0
     */
    public function setStreamFactory($streamFactory)
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }
}
