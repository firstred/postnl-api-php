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
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MockClient
 */
class MockClient implements ClientInterface, LoggerAwareInterface
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
    /** @var HandlerStack $handler */
    private $handler;

    /** @var int $maxRetries */
    private $maxRetries = 1;

    /**
     * @return MockClient|static
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
    public function setOption($name, $value): self
    {
        $this->defaultOptions[$name] = $value;

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
    public function getOption($name)
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
        $this->defaultOptions['verify'] = $verify;

        return $this;
    }

    /**
     * Return verify setting
     *
     * @return bool|string
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
     */
    public function getMaxRetries()
    {
        return $this->maxRetries;
    }

    /**
     * Set the amount of retries
     *
     * @param int $maxRetries
     *
     * @return self
     */
    public function setMaxRetries($maxRetries)
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    /**
     * Get the logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Set the logger
     *
     * @param LoggerInterface $logger
     *
     * @return MockClient
     */
    public function setLogger(LoggerInterface $logger = null)
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
     * @return int|string
     */
    public function addOrUpdateRequest(string $id, Request $request)
    {
        if (is_null($id)) {
            return array_push($this->pendingRequests, $request);
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests
     *
     * @param string $id
     */
    public function removeRequest(string $id)
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * @return HandlerStack
     *
     * @since 1.0.0
     */
    public function getHandler(): HandlerStack
    {
        return $this->handler;
    }

    /**
     * @param HandlerStack $handler
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function setHandler(HandlerStack $handler): self
    {
        $this->handler = $handler;

        return $this;
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
     * @throws HttpClientException
     *
     * @since 1.0.0
     */
    public function doRequest(Request $request): Response
    {
        // Initialize Guzzle, include the default options
        $guzzle = new Client(
            array_merge(
                $this->defaultOptions,
                [
                    'timeout'         => $this->timeout,
                    'connect_timeout' => $this->connectTimeout,
                    'http_errors'     => false,
                    'handler'         => $this->handler,
                ]
            )
        );

        try {
            return $guzzle->send($request);
        } catch (GuzzleException $e) {
            throw new HttpClientException(null, null, $e);
        }
    }

    /**
     * Do all async requests
     *
     * Exceptions are captured into the result array
     *
     * @param Request[] $requests
     *
     * @return Response|Response[]|HttpClientException|HttpClientException[]
     *
     * @since 1.0.0
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

        // Initialize Guzzle and the retry middleware, include the default options
        $guzzle = new Client(
            array_merge(
                $this->defaultOptions,
                [
                    'timeout'         => $this->timeout,
                    'connect_timeout' => $this->connectTimeout,
                    'handler'         => $this->handler,
                ]
            )
        );

        // Concurrent requests
        $promises = [];
        foreach ($requests as $index => $request) {
            $promises[$index] = $guzzle->sendAsync($request);
        }

        $responses = \GuzzleHttp\Promise\settle($promises)->wait();
        foreach ($responses as &$response) {
            if (isset($response['value'])) {
                $response = $response['value'];
            } elseif (isset($response['reason'])) {
                $response = $response['reason'];
            } else {
                $response = new \Firstred\PostNL\Exception\ResponseException('Unknown reponse type');
            }
            if ($response instanceof Response && $this->logger instanceof LoggerInterface) {
                $this->logger->debug(\GuzzleHttp\Psr7\str($response));
            }
        }

        return $responses;
    }

    /**
     * Clear all pending requests
     */
    public function clearRequests()
    {
        $this->pendingRequests = [];
    }
}
