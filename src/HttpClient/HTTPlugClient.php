<?php

namespace Firstred\PostNL\HttpClient;

use Exception;
use Firstred\PostNL\Exception\HttpClientException;
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
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class HTTPlugClient.
 *
 * @since 1.2.0
 */
class HTTPlugClient implements ClientInterface
{
    /** @var static */
    private static $instance;

    /**
     * @var HttpAsyncClient|HttpClient
     */
    protected $client;

    /**
     * List of pending PSR-7 requests.
     *
     * @var RequestInterface[]
     */
    protected $pendingRequests = [];

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * @var int
     */
    protected $concurrency;

    /**
     * HTTPlugClient constructor.
     *
     * @param HttpAsyncClient|HttpClient|null $client
     * @param LoggerInterface|null            $logger
     * @param int                             $concurrency
     *
     * @throws HttpClientException
     */
    public function __construct(
        $client = null,
        $logger = null,
        $concurrency = 5
    ) {
        $this->logger = $logger;
        $this->concurrency = $concurrency;

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
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id
     * @param RequestInterface $request
     *
     * @return string
     */
    public function addOrUpdateRequest($id, RequestInterface $request)
    {
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
     * Do all async requests.
     *
     * Exceptions are captured into the result array
     *
     * @param array                                 $requests
     *
     * @psalm-param array<string, RequestInterface> $requests
     *
     * @return array
     */
    public function doRequests($requests = [])
    {
        // Handle pending requests
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
     * Clear all pending requests.
     */
    public function clearRequests()
    {
        $this->pendingRequests = [];
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
     * @return int
     */
    public function getConcurrency()
    {
        return $this->concurrency;
    }

    /**
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
     * @return LoggerInterface|null
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface|null $logger
     *
     * @return static
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
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
    public function setVerify($verify)
    {
        return $this;
    }

    /**
     * @return bool|string|void
     *
     * @deprecated
     */
    public function getVerify()
    {
        return true;
        // Not supported by the HTTPlug client
    }
}
