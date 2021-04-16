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

namespace Firstred\PostNL\HttpClient;

use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LogLevel;

/**
 * Class MockClient.
 *
 * @since 1.0.0
 */
class MockClient extends BaseHttpClient implements ClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 60;
    const DEFAULT_CONNECT_TIMEOUT = 20;

    /** @var static */
    protected static $instance;

    /** @var array */
    protected $defaultOptions = [];

    /** @var HandlerStack */
    private $handler;

    /**
     * @return MockClient|static
     *
     * @deprecated Please instantiate a new client rather than using this singleton
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Set Guzzle option.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return MockClient
     */
    public function setOption($name, $value)
    {
        $this->defaultOptions[$name] = $value;

        return $this;
    }

    /**
     * Get Guzzle option.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function getOption($name)
    {
        if (isset($this->defaultOptions[$name])) {
            return $this->defaultOptions[$name];
        }

        return null;
    }

    /**
     * @return MockClient
     */
    public function setHandler(HandlerStack $handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * @return HandlerStack
     */
    public function getHandler()
    {
        return $this->handler;
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
    public function doRequest(RequestInterface $request)
    {
        $logLevel = LogLevel::DEBUG;
        $response = null;

        // Initialize Guzzle, include the default options
        $guzzle = new Client(array_merge(
            $this->defaultOptions,
            [
                'timeout'         => $this->timeout,
                'connect_timeout' => $this->connectTimeout,
                'http_errors'     => false,
                'handler'         => $this->handler,
            ]
        ));

        try {
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
            $response = $guzzle->send($request);
            return $response;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $logLevel = LogLevel::ERROR;
            throw new HttpClientException(null, null, $e, $response);
        } catch (GuzzleException $e) {
            $logLevel = LogLevel::ERROR;
            throw new HttpClientException(null, null, $e);
        } finally {
            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->getLogger()->log($logLevel, PsrMessage::toString($request));
            if ($response instanceof ResponseInterface) {
                $this->getLogger()->log($logLevel, PsrMessage::toString($response));
            }
        }
    }

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface[] $requests
     *
     * @return ResponseInterface[]|HttpClientException[]
     */
    public function doRequests($requests = [])
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

        // Initialize Guzzle and the retry middleware, include the default options
        $guzzle = new Client(array_merge(
            $this->defaultOptions,
            [
                'timeout'         => $this->timeout,
                'connect_timeout' => $this->connectTimeout,
                'handler'         => $this->handler,
            ]
        ));

        // Concurrent requests
        $promises = [];
        foreach ($requests as $id => $request) {
            $promises[$id] = $guzzle->sendAsync($request);
        }

        $responses = Utils::settle($promises)->wait();
        foreach ($responses as $id => &$response) {
            $logLevel = LogLevel::DEBUG;
            if (isset($response['value'])) {
                $response = $response['value'];
            } elseif (isset($response['reason'])) {
                $logLevel = LogLevel::ERROR;
                $response = $response['reason'];
            } else {
                $logLevel = LogLevel::ERROR;
                $response = new ResponseException('Unknown response type');
            }

            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->getLogger()->log($logLevel, PsrMessage::toString($requests[$id]));
            if ($response instanceof ResponseInterface) {
                $this->getLogger()->log($logLevel, PsrMessage::toString($response));
            }
        }

        return $responses;
    }
}
