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

use Composer\CaBundle\CaBundle;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use function method_exists;

/**
 * Class GuzzleClient.
 *
 * @since 1.0.0
 */
class GuzzleClient extends BaseHttpClient implements ClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 60;
    const DEFAULT_CONNECT_TIMEOUT = 20;

    /** @var static */
    protected static $instance;

    /** @var array */
    protected $defaultOptions = [];

    /** @var Client */
    private $client;

    /**
     * Get the Guzzle client.
     *
     * @return Client
     */
    private function getClient()
    {
        if (!$this->client) {
            // Initialize Guzzle and the retry middleware, include the default options
            $handler = method_exists(Utils::class, 'chooseHandler') ? Utils::chooseHandler() : \GuzzleHttp\choose_handler();
            $stack = HandlerStack::create($handler);
            $stack->push(Middleware::retry(function (
                $retries,
                RequestInterface $request,
                ResponseInterface $response = null,
                RequestException $exception = null
            ) {
                // Limit the number of retries to 5
                if ($retries >= $this->getMaxRetries()) {
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
            }, function ($retries) {
                return $retries * 1000;
            }));
            $guzzle = new Client(array_merge(
                [
                    RequestOptions::TIMEOUT         => $this->timeout,
                    RequestOptions::CONNECT_TIMEOUT => $this->connectTimeout,
                    RequestOptions::HTTP_ERRORS     => false,
                    RequestOptions::ALLOW_REDIRECTS => false,
                    RequestOptions::VERIFY          => CaBundle::getSystemCaRootBundlePath(),
                    'handler'                       => $stack,
                ],
                $this->defaultOptions
            ));

            $this->client = $guzzle;
        }

        return $this->client;
    }

    /**
     * @return GuzzleClient|static
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
     * @return GuzzleClient
     */
    public function setOption($name, $value)
    {
        // Set the default option
        $this->defaultOptions[$name] = $value;
        // Reset the non-mutable Guzzle client
        $this->client = null;

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
        $guzzle = $this->getClient();
        try {
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
            $response = $guzzle->send($request);
            return $response;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e, $response);
        } catch (GuzzleException $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        } finally {
            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->logger->log($logLevel, PsrMessage::toString($request));
            if ($response instanceof ResponseInterface) {
                $this->logger->log($logLevel, PsrMessage::toString($response));
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
     * @return HttpClientException[]|ResponseInterface[]
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

        $guzzle = $this->getClient();
        // Concurrent requests
        $promises = call_user_func(function () use ($requests, $guzzle) {
            foreach ($requests as $index => $request) {
                yield $index => $guzzle->sendAsync($request);
            }
        });

        $responses = [];
        (new EachPromise($promises, [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index) use (&$responses) {
                $responses[$index] = $response;
            },
            'rejected'    => function ($response, $index) use (&$responses) {
                $responses[$index] = $response;
            },
        ]))->promise()->wait();
        foreach ($responses as $id => &$response) {
            $logLevel = LogLevel::DEBUG;

            if (is_array($response) && !empty($response['value'])) {
                $response = $response['value'];
            } elseif (is_array($response) && !empty($response['reason'])) {
                if ($response['reason'] instanceof RequestException) {
                    if (method_exists($response['reason'], 'getMessage')
                        && method_exists($response['reason'], 'getCode')
                    ) {
                        $response = new HttpClientException(
                            $response['reason']->getMessage(),
                            $response['reason']->getCode(),
                            $response['reason'],
                            $response['reason']->getResponse()
                        );
                    } else {
                        $response = new HttpClientException(null, null, $response['reason']);
                    }
                } elseif ($response['reason'] instanceof TransferException) {
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
            } elseif (!$response instanceof ResponseInterface) {
                $response = new ResponseException('Unknown response type');
            }

            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->logger->log($logLevel, PsrMessage::toString($requests[$id]));
            if ($response instanceof ResponseInterface) {
                $this->logger->log($logLevel, PsrMessage::toString($response));
            }
        }

        return $responses;
    }
}
