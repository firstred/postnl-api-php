<?php
declare(strict_types=1);
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

use Composer\CaBundle\CaBundle;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
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
use function is_array;
use function method_exists;
use function user_error;
use const E_USER_DEPRECATED;

/**
 * Class GuzzleClient.
 *
 * @since 1.0.0
 */
class GuzzleHttpClient extends BaseHttpClient implements HttpClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 60;
    const DEFAULT_CONNECT_TIMEOUT = 20;

    /**
     * @var array
     * @phpstan-var array{string, mixed}
     */
    protected array $defaultOptions = [];

    private ?Client $client;

    /**
     * GuzzleClient constructor.
     *
     * @since 1.3.0 Custom constructor
     */
    public function __construct(
        Client          $client = null,
        LoggerInterface $logger = null,
        int             $concurrency = 5,
        int             $maxRetries = 5
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->concurrency = $concurrency;
        $this->maxRetries = $maxRetries;
    }

    private function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the Guzzle client.
     *
     * @return Client
     */
    private function getClient(): Client
    {
        if (!isset($this->client)) {
            // Initialize Guzzle and the retry middleware, include the default options
            $handler = method_exists(object_or_class: Utils::class, method: 'chooseHandler') ? Utils::chooseHandler() : \GuzzleHttp\choose_handler();
            $stack = HandlerStack::create(handler: $handler);
            $stack->push(middleware: Middleware::retry(decider: function (
                $retries,
                RequestInterface $request,
                ResponseInterface $response = null,
                GuzzleException $exception = null
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
            }, delay: function ($retries) {
                return $retries * 1000;
            }));
            $guzzle = new Client(config: array_merge(
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
     * Set Guzzle option.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return GuzzleHttpClient
     */
    public function setOption(string $name, mixed $value): static
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
    public function getOption(string $name): mixed
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
     * @throws HttpClientException
     */
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        $logLevel = LogLevel::DEBUG;
        $response = null;

        // Initialize Guzzle, include the default options
        $guzzle = $this->getClient();
        try {
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
            $response = $guzzle->send(request: $request);

            return $response;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            throw new HttpClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e, response: $response);
        } catch (GuzzleException $e) {
            throw new HttpClientException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } finally {
            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->logger->log(level: $logLevel, message: PsrMessage::toString(message: $request));
            if ($response instanceof ResponseInterface) {
                $this->logger->log(level: $logLevel, message: PsrMessage::toString(message: $response));
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
     *
     * @throws InvalidArgumentException
     */
    public function doRequests(array $requests = []): array
    {
        if ($requests instanceof RequestInterface) {
            user_error(
                message: 'Passing a single request to HttpClientInterface::doRequests is deprecated',
                error_level: E_USER_DEPRECATED
            );
            $requests = [$requests];
        }
        if (!is_array(value: $requests)) {
            throw new InvalidArgumentException(message: 'Invalid requests array passed');
        }
        if (!is_array(value: $this->pendingRequests)) {
            $this->pendingRequests = [];
        }

        // Handle pending requests as well
        $requests = $this->pendingRequests + $requests;
        $this->clearRequests();

        $guzzle = $this->getClient();
        // Concurrent requests
        $promises = call_user_func(callback: function () use ($requests, $guzzle) {
            foreach ($requests as $index => $request) {
                yield $index => $guzzle->sendAsync(request: $request);
            }
        });

        $responses = [];
        (new EachPromise(iterable: $promises, config: [
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

            if (is_array(value: $response) && !empty($response['value'])) {
                $response = $response['value'];
            } elseif (is_array(value: $response) && !empty($response['reason'])) {
                if ($response['reason'] instanceof RequestException) {
                    if (method_exists(object_or_class: $response['reason'], method: 'getMessage')
                        && method_exists(object_or_class: $response['reason'], method: 'getCode')
                    ) {
                        $response = new HttpClientException(
                            message: $response['reason']->getMessage(),
                            code: $response['reason']->getCode(),
                            previous: $response['reason'],
                            response: $response['reason']->getResponse()
                        );
                    } else {
                        $response = new HttpClientException(message: (string) null, code: (int) null, previous: $response['reason']);
                    }
                } elseif ($response['reason'] instanceof TransferException) {
                    if (method_exists(object_or_class: $response['reason'], method: 'getMessage')
                        && method_exists(object_or_class: $response['reason'], method: 'getCode')
                    ) {
                        $response = new HttpClientException(
                            message: $response['reason']->getMessage(),
                            code: $response['reason']->getCode(),
                            previous: $response['reason']
                        );
                    } else {
                        $response = new HttpClientException(message: (string) null, code: (int) null, previous: $response['reason']);
                    }
                } else {
                    $response = $response['reason'];
                }
            } elseif (!$response instanceof ResponseInterface) {
                $response = new ResponseException(message: 'Unknown response type');
            }

            if (!$response instanceof ResponseInterface
                || $response->getStatusCode() < 200
                || $response->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->logger->log(level: $logLevel, message: PsrMessage::toString(message: $requests[$id]));
            if ($response instanceof ResponseInterface) {
                $this->logger->log(level: $logLevel, message: PsrMessage::toString(message: $response));
            }
        }

        return $responses;
    }
}
