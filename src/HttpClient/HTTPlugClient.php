<?php

namespace ThirtyBees\PostNL\HttpClient;

use Exception;
use Http\Client\Exception as HttpClientException;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpAsyncClient;
use Http\Discovery\HttpAsyncClientDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Util\EachPromise;

/**
 * Class HTTPlugClient.
 */
class HTTPlugClient implements ClientInterface
{
    /**
     * List of pending PSR-7 requests.
     *
     * @var RequestInterface[]
     */
    protected $pendingRequests = [];

    /** @var int */
    private $concurrency = 5;

    /** @var HttpAsyncClient */
    private $asyncClient;

    /**
     * HTTPlugClient constructor.
     */
    public function __construct(HttpAsyncClient $client = null)
    {
        $this->setHttpAsyncClient($client ?: HttpAsyncClientDiscovery::find());
    }

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id      Request ID
     * @param RequestInterface $request PSR-7 request
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function addOrUpdateRequest($id, RequestInterface $request)
    {
        if (is_null($id)) {
            return (string) array_push($this->pendingRequests, $request);
        }

        $this->pendingRequests[$id] = $request;

        return $id;
    }

    /**
     * Remove a request from the list of pending requests.
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
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
     * @param RequestInterface[] $requests
     *
     * @return ResponseInterface[]
     *
     * @throws HttpClientException
     *
     * @since 2.0.0 Strict typing
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

        $client = $this->getAsyncClient();
        // Concurrent requests
        $promises = call_user_func(
            function () use ($requests, $client) {
                foreach ($requests as $index => $request) {
                    yield $index             => $client->sendAsyncRequest($request);
                }
            }
        );

        $responses = [];
        try {
            (new EachPromise(
                $promises,
                [
                    'concurrency' => $this->concurrency,
                    'fulfilled'   => function ($response, $index) use (&$responses) {
                        $responses[$index] = $response;
                    },
                    'rejected' => function ($response, $index) use (&$responses) {
                        $responses[$index] = $response;
                    },
                ]
            ))->promise()->wait(true);
        } catch (HttpException $e) {
            // Ignore HttpExceptions, we are going to handle them in the response validator
        } catch (TransferException $e) {
            // Other transfer exceptions should be thrown
            throw $e;
        } catch (Exception $e) {
            // Unreachable code, these kinds of exceptions should not be unwrapped
        }

        return $responses;
    }

    /**
     * Clear all pending requests.
     *
     * @since 1.0.0
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
     * @throws Exception
     *
     * @since 2.0.0 Strict typing
     * @since 1.0.0
     */
    public function doRequest(RequestInterface $request)
    {
        // Initialize HttpAsyncClient, include the default options
        $client = $this->getAsyncClient();

        return $client->sendAsyncRequest($request)->wait();
    }

    /**
     * Return concurrency.
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getConcurrency()
    {
        return $this->concurrency;
    }

    /**
     * Set the concurrency.
     *
     * @since 1.0.0
     */
    public function setConcurrency($concurrency)
    {
        $this->concurrency = $concurrency;

        return $this;
    }

    /**
     * Get the HttpAsyncClient.
     *
     * @since 1.0.0
     */
    public function getAsyncClient()
    {
        return $this->asyncClient;
    }

    /**
     * Set the HttpAsyncClient.
     *
     * @since 2.0.0
     */
    public function setHttpAsyncClient(HttpAsyncClient $client)
    {
        $this->asyncClient = $client;

        return $this;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @deprecated 1.2.0 Configure the HTTPlug HTTP client implementation instead
     */
    public function setLogger(LoggerInterface $logger)
    {
        // TODO: Implement setLogger() method.
    }

    /**
     * @return HTTPlugClient|void
     */
    public static function getInstance()
    {
        // TODO: Implement getInstance() method.
    }

    /**
     * @param bool|string $verify
     *
     * @return HTTPlugClient|void
     *
     * @deprecated 1.2.0 Configure the HTTPlug HTTP client implementation instead
     */
    public function setVerify($verify)
    {
        // TODO: Implement setVerify() method.
    }

    /**
     * @return bool|string|void
     *
     * @deprecated 1.2.0 Configure the HTTPlug HTTP client implementation instead
     */
    public function getVerify()
    {
        // TODO: Implement getVerify() method.
    }

    public function getLogger()
    {
        // TODO: Implement getLogger() method.
    }
}
