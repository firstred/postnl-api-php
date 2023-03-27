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

use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
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
use function is_array;
use function user_error;
use const E_USER_DEPRECATED;

/**
 * Class MockClient.
 *
 * @since 1.0.0
 * @internal
 */
class MockHttpClient extends BaseHttpClient implements HttpClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 60;
    const DEFAULT_CONNECT_TIMEOUT = 20;

    /** @var array */
    protected array $defaultOptions = [];

    /** @var HandlerStack */
    private HandlerStack $handler;

    /**
     * Set Guzzle option.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return MockHttpClient
     */
    public function setOption(string $name, mixed $value): static
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
    public function getOption(string $name): mixed
    {
        if (isset($this->defaultOptions[$name])) {
            return $this->defaultOptions[$name];
        }

        return null;
    }

    public function setHandler(HandlerStack $handler): static
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandler(): HandlerStack
    {
        return $this->handler;
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
        $guzzle = new Client(config: array_merge(
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
            $response = $guzzle->send(request: $request);

            return $response;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $logLevel = LogLevel::ERROR;
            throw new HttpClientException(message: (string) null, code: (int) null, previous: $e, response: $response);
        } catch (GuzzleException $e) {
            $logLevel = LogLevel::ERROR;
            throw new HttpClientException(message: (string) null, code: (int) null, previous: $e);
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
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface[] $requests
     *
     * @return ResponseInterface[]|HttpClientException[]
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

        // Initialize Guzzle and the retry middleware, include the default options
        $guzzle = new Client(config: array_merge(
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
            $promises[$id] = $guzzle->sendAsync(request: $request);
        }

        $responses = Utils::settle(promises: $promises)->wait();
        foreach ($responses as $id => &$response) {
            $logLevel = LogLevel::DEBUG;
            if (isset($response['value'])) {
                $response = $response['value'];
            } elseif (isset($response['reason'])) {
                $logLevel = LogLevel::ERROR;
                $response = $response['reason'];
            } else {
                $logLevel = LogLevel::ERROR;
                $response = new ResponseException(message: 'Unknown response type');
            }

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
}
