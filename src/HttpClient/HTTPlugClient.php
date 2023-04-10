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

use Exception;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Util\EachPromise;
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
use Http\Discovery\NotFoundException;
use Http\Discovery\Psr18ClientDiscovery;
use JetBrains\PhpStorm\Deprecated;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use function is_array;
use function user_error;
use const E_USER_DEPRECATED;

/**
 * Class HTTPlugClient.
 *
 * @since 1.2.0
 */
class HTTPlugClient extends BaseHttpClient implements ClientInterface, LoggerAwareInterface
{
    /** @var static */
    protected static $instance;

    /**
     * @var HttpAsyncClient|HttpClient
     */
    protected $client;

    /**
     * HTTPlugClient constructor.
     *
     * @param HttpAsyncClient|HttpClient|null $client
     * @param LoggerInterface|null            $logger
     * @param int                             $concurrency
     *
     * @throws HttpClientException
     *
     * @since 1.0.0
     * @since 1.3.0 $maxRetries param
     */
    public function __construct(
        $client = null,
        $logger = null,
        $concurrency = 5,
        $maxRetries = 5
    ) {
        $this->logger = $logger;
        $this->concurrency = $concurrency;
        $this->maxRetries = $maxRetries;

        if (null === $client) {
            try {
                $client = HttpAsyncClientDiscovery::find();
            } catch (NotFoundException $e) {
            } catch (DiscoveryNotFoundException $e) {
            } catch (NoCandidateFoundException $e) {
            } catch (DiscoveryFailedException $e) {
            }
        }
        if (null === $client) {
            try {
                $client = Psr18ClientDiscovery::find();
            } catch (NotFoundException $e) {
            } catch (DiscoveryNotFoundException $e) {
            } catch (NoCandidateFoundException $e) {
            } catch (DiscoveryFailedException $e) {
            }
        }
        if (null === $client) {
            try {
                $client = HttpClientDiscovery::find();
            } catch (NotFoundException $e) {
            } catch (DiscoveryNotFoundException $e) {
            } catch (NoCandidateFoundException $e) {
            } catch (DiscoveryFailedException $e) {
            }
        }

        if (!$client) {
            throw new HttpClientException('HTTP Client could not be found');
        }

        $this->setClient($client);
    }

    /**
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param RequestInterface[]                    $requests
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
        $this->clearRequests();

        $client = $this->getClient();

        $responses = [];
        if ($client instanceof HttpAsyncClient) {
            // Concurrent requests
            $promises = call_user_func(function () use ($requests, $client) {
                foreach ($requests as $index => $request) {
                    try {
                        yield $index => $client->sendAsyncRequest($request);
                    } catch (Exception $e) {
                    }
                }
            });

            try {
                $promise = (new EachPromise(
                    $promises,
                    [
                        'concurrency' => $this->concurrency,
                        'fulfilled'   => function (ResponseInterface $response, $index) use (&$responses) {
                            $responses[$index] = $response;
                        },
                        'rejected'    => function (ResponseInterface $response, $index) use (&$responses) {
                            $responses[$index] = $response;
                        },
                    ]
                ))->promise();

                if ($promise) {
                    $promise->wait(true);
                }
            } catch (HttpException $e) {
                // Ignore HttpExceptions, we are going to handle them in the response validator
            } catch (TransferException $e) {
                // Other transfer exceptions should be thrown
                throw $e;
            } catch (Exception $e) {
                // Unreachable code, these kinds of exceptions should not be unwrapped
            }
        } else {
            foreach ($requests as $idx => $request) {
                try {
                    $responses[$idx] = $this->doRequest($request);
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

            $this->getLogger()->log($logLevel, PsrMessage::toString($requests[$id]));
            if ($response instanceof ResponseInterface) {
                $this->getLogger()->log($logLevel, PsrMessage::toString($response));
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
    public function doRequest(RequestInterface $request)
    {
        $logLevel = LogLevel::DEBUG;
        $response = null;

        // Initialize HttpAsyncClient, include the default options
        $client = $this->getClient();

        try {
            if ($client instanceof HttpAsyncClient) {
                $response = $client->sendAsyncRequest($request)->wait();
            } else {
                $response =  $client->sendRequest($request);
            }

            return $response;
        } catch (Exception $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        } catch (ClientExceptionInterface $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
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
     * @return HttpAsyncClient|HttpClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param HttpAsyncClient|HttpClient $client
     *
     * @return static
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param HttpAsyncClient|HttpClient|null $client
     *
     * @return HTTPlugClient
     *
     * @throws HttpClientException
     *
     * @deprecated Please instantiate a new client rather than using this singleton
     */
    #[Deprecated('Please instantiate a new client rather than using this singleton')]
    public static function getInstance($client = null)
    {
        if (!static::$instance) {
            static::$instance = new static($client);
        }

        return static::$instance;
    }

    /**
     * @param bool|string $verify
     *
     * @return HTTPlugClient
     *
     * @deprecated
     */
    #[Deprecated]
    public function setVerify($verify)
    {
        // Not supported by the HTTPlug client

        return $this;
    }

    /**
     * @return bool|string|void
     *
     * @deprecated
     */
    #[Deprecated]
    public function getVerify()
    {
        return true;
        // Not supported by the HTTPlug client
    }
}
