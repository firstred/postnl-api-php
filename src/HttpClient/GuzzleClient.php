<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\HttpClient;

use Firstred\PostNL\Exception\HttpClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Class GuzzleClient
 */
class GuzzleClient implements ClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 60;
    const DEFAULT_CONNECT_TIMEOUT = 20;

    /** @var static $instance */
    protected static $instance;
    /** @var array $defaultOptions */
    protected $defaultOptions = [];
    /**
     * List of pending PSR-7 requests
     *
     * @var Request[]
     */
    protected $pendingRequests = [];
    /** @var LoggerInterface $logger */
    protected $logger;
    /** @var int $timeout */
    private $timeout = self::DEFAULT_TIMEOUT;
    /** @var int $connectTimeout */
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;
    /** @var int $maxRetries */
    private $maxRetries = 5;
    /** @var int $concurrency */
    private $concurrency = 5;
    /** @var Client $client */
    private $client;

    /**
     * @return GuzzleClient|static
     *
     * @since 1.0.0
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Set Guzzle option
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function setOption(string $name, $value): self
    {
        // Set the default option
        $this->defaultOptions[$name] = $value;
        // Reset the non-mutable Guzzle client
        $this->client = null;

        return $this;
    }

    /**
     * Get Guzzle option
     *
     * @param string $name
     *
     * @return mixed|null
     *
     * @since 1.0.0
     */
    public function getOption(string $name)
    {
        if (isset($this->defaultOptions[$name])) {
            return $this->defaultOptions[$name];
        }

        return null;
    }

    /**
     * Set the verify setting
     *
     * @param bool|string $verify
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function setVerify($verify): self
    {
        // Set the verify option
        $this->defaultOptions['verify'] = $verify;
        // Reset the non-mutable Guzzle client
        $this->client = null;

        return $this;
    }

    /**
     * Return verify setting
     *
     * @return bool|string
     *
     * @since 1.0.0
     */
    public function getVerify()
    {
        if (isset($this->defaultOptions['verify'])) {
            return $this->defaultOptions['verify'];
        }

        return false;
    }

    /**
     * Return max retries
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    /**
     * Set the amount of retries
     *
     * @param int $maxRetries
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function setMaxRetries($maxRetries): self
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    /**
     * Return concurrency
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getConcurrency(): int
    {
        return $this->concurrency;
    }

    /**
     * Set the concurrency
     *
     * @param int $concurrency
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function setConcurrency($concurrency): self
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     *
     * @since 1.0.0
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set the logger
     *
     * @param LoggerInterface $logger
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function setLogger(LoggerInterface $logger = null): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request
     *
     * @param string  $id      Request ID
     * @param Request $request PSR-7 request
     *
     * @return string
     *
     * @since 1.0.0
     * @since 2.0.0 Returns `string`s only
     */
    public function addOrUpdateRequest(string $id, Request $request): string
    {
        if (is_null($id)) {
            return (string) array_push($this->pendingRequests, $request);
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests
     *
     * @param string $id
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function removeRequest(string $id): void
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * Do all async requests
     *
     * Exceptions are captured into the result array
     *
     * @param Request[] $requests
     *
     * @return Response|Response[]|HttpClientException|HttpClientException[]
     */
    public function doRequests(array $requests = [])
    {
        // If this is a single request, create the requests array
        if (!is_array($requests)) {
            if (!$requests instanceof Request) {
                return [];
            }

            $requests = [$requests];
        }

        // Handle pending requests
        $requests = $this->pendingRequests + $requests;
        $this->clearRequests();

        $guzzle = $this->getClient();
        // Concurrent requests
        $promises = call_user_func(
            function () use ($requests, $guzzle) {
                foreach ($requests as $index => $request) {
                    if ($request instanceof Request && $this->logger instanceof LoggerInterface) {
                        $this->logger->debug(\GuzzleHttp\Psr7\str($request));
                    }
                    yield $index => $guzzle->sendAsync($request);
                }
            }
        );

        $responses = [];
        (new EachPromise(
            $promises,
            [
                'concurrency' => $this->concurrency,
                'fulfilled'   => function ($response, $index) use (&$responses) {
                    $responses[$index] = $response;
                },
                'rejected'    => function ($response, $index) use (&$responses) {
                    $responses[$index] = $response;
                },
            ]
        ))->promise()->wait();
        foreach ($responses as &$response) {
            if (is_array($response) && !empty($response['value'])) {
                $response = $response['value'];
            } elseif (is_array($response) && !empty($response['reason'])) {
                if ($response['reason'] instanceof TransferException) {
                    if (method_exists($response['reason'], 'getMessage')
                        && method_exists($response['reason'], 'getCode')
                    ) {
                        $response = new HttpClientException(
                            $response['reason']->getMessage(),
                            $response['reason']->getCode(),
                            $response['reason']
                        );
                    } else {
                        $response = new HttpClientException(null, null, $response['reason']);
                    }
                } else {
                    $response = $response['reason'];
                }
            } elseif (!$response instanceof Response) {
                $response = new \Firstred\PostNL\Exception\ResponseException('Unknown response type');
            }
            if ($response instanceof Response && $this->logger instanceof LoggerInterface) {
                $this->logger->debug(\GuzzleHttp\Psr7\str($response));
            }
        }

        return $responses;
    }

    /**
     * Clear all pending requests
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function clearRequests(): void
    {
        $this->pendingRequests = [];
    }

    /**
     * Do a single request
     *
     * Exceptions are captured into the result array
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception|HttpClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @since 1.0.0
     */
    public function doRequest(Request $request)
    {
        // Initialize Guzzle, include the default options
        $guzzle = $this->getClient();
        try {
            $response = $guzzle->send($request);
        } catch (TransferException $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
        if ($response instanceof Response && $this->logger instanceof LoggerInterface) {
            $this->logger->debug(\GuzzleHttp\Psr7\str($response));
        }

        return $response;
    }

    /**
     * Get the Guzzle client
     *
     * @return Client
     *
     * @since 1.0.0
     */
    private function getClient(): Client
    {
        if (!$this->client) {
            // Initialize Guzzle and the retry middleware, include the default options
            $stack = HandlerStack::create(\GuzzleHttp\choose_handler());
            $stack->push(
                Middleware::retry(
                    function (
                        $retries,
                        /** @noinspection PhpUnusedParameterInspection */
                        Request $request,
                        Response $response = null,
                        RequestException $exception = null
                    ) {
                        // Limit the number of retries to 5
                        if ($retries >= 5) {
                            return false;
                        }

                        // Retry connection exceptions
                        if ($exception instanceof ConnectException) {
                            return true;
                        }

                        if ($response) {
                            // Retry on server errors
                            if ($response->getStatusCode() >= 500) {
                                return true;
                            }
                        }

                        return false;
                    },
                    function ($retries) {
                        return $retries * 1000;
                    }
                )
            );
            $guzzle = new Client(
                array_merge(
                    $this->defaultOptions,
                    [
                        'timeout'         => $this->timeout,
                        'connect_timeout' => $this->connectTimeout,
                        'http_errors'     => false,
                        'handler'         => $stack,
                    ]
                )
            );

            $this->client = $guzzle;
        }

        return $this->client;
    }
}
