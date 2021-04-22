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
use Firstred\PostNL\Exception\NotSupportedException;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface as SymfonyHttpClientResponseInterface;
use function array_merge;

/**
 * Class SymfonyHttpClientInterface.
 *
 * @since 1.0.0
 */
class SymfonyHttpClient extends BaseHttpClient implements ClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 60;
    const DEFAULT_CONNECT_TIMEOUT = 20;

    /** @var static */
    protected static $instance;

    /** @var array */
    protected $defaultOptions = [];

    /** @var HttpClientInterface */
    private $client;

    /**
     * SymfonyHttpClient constructor.
     *
     * @param HttpClientInterface|null $client
     * @param LoggerInterface|null     $logger
     * @param int                      $concurrency
     * @param int                      $maxRetries
     *
     * @since 1.3.0 Custom constructor
     */
    public function __construct(
        HttpClientInterface $client = null,
        LoggerInterface $logger = null,
        $concurrency = 5,
        $maxRetries = 5
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->concurrency = $concurrency;
        $this->maxRetries = $maxRetries;
    }

    /**
     * Get the Symfony HTTP Client.
     *
     * @return HttpClientInterface
     */
    private function getClient()
    {
        if (!$this->client) {
            $retryStrategy = new GenericRetryStrategy(
                [0, 423, 425, 429, 500, 502, 503, 504, 507, 510],
                1000,
                3.0,
                5000,
                0.3
            );
            $client = new RetryableHttpClient(HttpClient::create(array_merge(
                [
                    'max_duration'  => $this->getTimeout(),
                    'timeout'       => $this->getConnectTimeout(),
                    'max_redirects' => 0,
                    'cafile'        => CaBundle::getSystemCaRootBundlePath(),
                    'verify_host'   => true,
                    'verify_peer'   => true,
                ],
                $this->defaultOptions
            ), $this->getConcurrency()), $retryStrategy, $this->getMaxRetries());

            $this->client = $client;
        }

        return $this->client;
    }

    /**
     * @return static
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
     * Set Symfony HTTP Client option.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return static
     */
    public function setOption($name, $value)
    {
        // Set the default option
        $this->defaultOptions[$name] = $value;
        // Reset the non-mutable Symfony HTTP client
        $this->client = null;

        return $this;
    }

    /**
     * Get Symfony HTTP Client option.
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
        $psrResponse = null;

        // Initialize Symfony HTTP Client, include the default options
        $httpClient = $this->getClient();
        try {
            $symfonyHttpClientRequestParts = $this->convertPsrRequestToSymfonyHttpClientRequestParams($request);

            try {
                return $this->convertSymfonyHttpClientResponseToPsrResponse($httpClient->request(
                    $symfonyHttpClientRequestParts['method'],
                    $symfonyHttpClientRequestParts['url'],
                    $symfonyHttpClientRequestParts['options']
                ));
            } catch (NotSupportedException $e) {
                throw new HttpClientException($e->getMessage(), null, $e);
            } catch (ClientExceptionInterface $e) {
                throw new HttpClientException($e->getMessage(), null, $e);
            } catch (RedirectionExceptionInterface $e) {
                throw new HttpClientException($e->getMessage(), null, $e);
            } catch (ServerExceptionInterface $e) {
                throw new HttpClientException($e->getMessage(), null, $e);
            } catch (TransportExceptionInterface $e) {
                throw new HttpClientException($e->getMessage(), null, $e);
            }
        } catch (TransportExceptionInterface $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        } finally {
            if (!$psrResponse instanceof ResponseInterface
                || $psrResponse->getStatusCode() < 200
                || $psrResponse->getStatusCode() >= 400
            ) {
                $logLevel = LogLevel::ERROR;
            }

            $this->logger->log($logLevel, PsrMessage::toString($request));
            if ($psrResponse instanceof ResponseInterface) {
                $this->logger->log($logLevel, PsrMessage::toString($psrResponse));
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
        $httpClient = $this->getClient();
        $responses = [];

        foreach ($requests as $id => $request) {
            $symfonyHttpClientRequestParts = $this->convertPsrRequestToSymfonyHttpClientRequestParams($request);
            $symfonyHttpClientRequestParts['options']['user_data'] = $id;

            try {
                $responses[$id] = $httpClient->request(
                    $symfonyHttpClientRequestParts['method'],
                    $symfonyHttpClientRequestParts['url'],
                    $symfonyHttpClientRequestParts['options']
                );
            } catch (TransportExceptionInterface $e) {
                $responses[$id] = new HttpClientException($e->getMessage(), $e->getCode(), $e);
            }
        }

        foreach ($this->client->stream($responses) as $response => $chunk) {
            $id = $response->getInfo('user_data');
            try {
                if ($chunk->isLast()) {
                    // the full content of $response just completed
                    // $response->getContent() is now a non-blocking call
                    $responses[$id] = $this->convertSymfonyHttpClientResponseToPsrResponse($response);
                }
            } catch (TransportExceptionInterface $e) {
                $responses[$id] = new HttpClientException($e->getMessage(), $e->getCode(), $e);
            } catch (NotSupportedException $e) {
                $responses[$id] = new HttpClientException($e->getMessage(), $e->getCode(), $e);
            } catch (ClientExceptionInterface $e) {
                $responses[$id] = new HttpClientException($e->getMessage(), $e->getCode(), $e);
            } catch (RedirectionExceptionInterface $e) {
                $responses[$id] = new HttpClientException($e->getMessage(), $e->getCode(), $e);
            } catch (ServerExceptionInterface $e) {
                $responses[$id] = new HttpClientException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return $responses;
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
        // Reset immutable client
        $this->client = null;

        return parent::setMaxRetries($maxRetries);
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
        // Reset immutable client
        $this->client = null;

        return parent::setConcurrency($concurrency);
    }

    /**
     * @param RequestInterface $psrRequest
     *
     * @return array
     *
     * @since 1.3.0
     */
    private function convertPsrRequestToSymfonyHttpClientRequestParams($psrRequest)
    {
        $options = [];

        if ($psrRequest->getHeaders()) {
            $options['headers'] = $psrRequest->getHeaders();
        }

        if ($psrRequest->getBody()->getContents()) {
            $options['body'] = $psrRequest->getBody()->getContents();
        }

        return [
            'url'     => (string) $psrRequest->getUri(),
            'method'  => $psrRequest->getMethod(),
            'options' => $options,
        ];
    }

    /**
     * @param SymfonyHttpClientResponseInterface $symfonyHttpClientResponse
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     * @throws NotSupportedException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     *
     * @since 1.3.0
     */
    private function convertSymfonyHttpClientResponseToPsrResponse($symfonyHttpClientResponse)
    {
        $psrResponse = $this->getResponseFactory()->createResponse($symfonyHttpClientResponse->getStatusCode())
            ->withBody($this->getStreamFactory()->createStream($symfonyHttpClientResponse->getContent()));
        foreach ($symfonyHttpClientResponse->getHeaders() as $name => $value) {
            $psrResponse = $psrResponse->withHeader($name, $value);
        }

        return $psrResponse;
    }
}
