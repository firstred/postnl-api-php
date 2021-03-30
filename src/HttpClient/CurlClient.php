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

use Exception;
use Firstred\PostNL\Exception\ApiException;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Firstred\PostNL\Exception\ApiConnectionException;
use Firstred\PostNL\Exception\HttpClientException;
use Psr\Log\LogLevel;

if (!defined('CURL_SSLVERSION_TLSv1')) {
    define('CURL_SSLVERSION_TLSv1', 1);
}
if (!defined('CURL_SSLVERSION_TLSv1_2')) {
    define('CURL_SSLVERSION_TLSv1_2', 6);
}
if (!defined('CURLE_SSL_CACERT_BADFILE')) {
    define('CURLE_SSL_CACERT_BADFILE', 77);  // constant not defined in PHP
}

/**
 * Class CurlClient.
 *
 * @since 1.0.0
 */
class CurlClient implements ClientInterface, LoggerAwareInterface
{
    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;

    /** @var int */
    private $timeout = self::DEFAULT_TIMEOUT;
    /** @var int */
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;
    /**
     * Verify the server SSL certificate.
     *
     * @var bool|string
     */
    private $verify = true;
    /** @var static */
    private static $instance;
    /** @var array|callable|null */
    protected $defaultOptions;
    /** @var array */
    protected $userAgentInfo;
    /** @var array */
    protected $pendingRequests = [];
    /** @var LoggerInterface */
    protected $logger;

    /**
     * CurlClient Singleton.
     *
     * @return CurlClient
     *
     * @deprecated Please instantiate a new client rather than using this singleton
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * Set timeout.
     *
     * @param int $seconds
     *
     * @return CurlClient
     */
    public function setTimeout($seconds)
    {
        $this->timeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * Set connection timeout.
     *
     * @param int $seconds
     *
     * @return CurlClient
     */
    public function setConnectTimeout($seconds)
    {
        $this->connectTimeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * Set the verify setting.
     *
     * @param bool|string $verify
     *
     * @return CurlClient
     */
    public function setVerify($verify)
    {
        $this->verify = $verify;

        return $this;
    }

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     *
     * @return CurlClient
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Get timeout.
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Get connection timeout.
     *
     * @return int
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * Return verify setting.
     *
     * @return bool|string
     */
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     * Get logger.
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request.
     *
     * @param string           $id      Request ID
     * @param RequestInterface $request PSR-7 request
     *
     * @return int|string
     */
    public function addOrUpdateRequest($id, RequestInterface $request)
    {
        if (is_null($id)) {
            return array_push($this->pendingRequests, $request);
        }

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
     * @throws ApiConnectionException
     * @throws HttpClientException
     */
    public function doRequest(RequestInterface $request)
    {
        $logLevel = LogLevel::DEBUG;
        $response = null;

        try {
            $curl = curl_init();
            // Create a callback to capture HTTP headers for the response
            $this->prepareRequest($curl, $request);
            $responseBody = curl_exec($curl);
            if (false === $responseBody) {
                $errno = curl_errno($curl);
                $message = curl_error($curl);
                curl_close($curl);
                $logLevel = LogLevel::ERROR;
                $this->handleCurlError($request->getUri(), $errno, $message);
            }
            curl_close($curl);

            $response = PsrMessage::parseResponse($responseBody);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
                $logLevel = LogLevel::ERROR;
            }

            return $response;
        } catch (ApiException $e) {
            $logLevel = LogLevel::ERROR;
            throw new HttpClientException('Connection error', 0, $e, $response);
        } finally {
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
        // Reset request headers array
        $curlHandles = [];
        $mh = curl_multi_init();
        foreach ($this->pendingRequests + $requests as $uuid => $request) {
            $curl = curl_init();
            $curlHandles[$uuid] = $curl;
            try {
                $this->prepareRequest($curl, $request);
            } catch (HttpClientException $e) {
                // Handle later
            }
            curl_multi_add_handle($mh, $curl);
        }
        // execute the handles
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);
        // get content and remove handles
        $responseBodies = [];
        foreach ($curlHandles as $id => &$c) {
            $responseBodies[$id] = curl_multi_getcontent($c);
            curl_multi_remove_handle($mh, $c);
            $responseCodes[$id] = curl_getinfo($c, CURLINFO_HTTP_CODE);
        }
        // all done
        if (isset($this->multiCurlHandle) && 'curl_multi' === get_resource_type($this->multiCurlHandle)) {
            curl_multi_close($this->multiCurlHandle);
        }
        $responses = [];
        foreach ($responseBodies as $uuid => $responseBody) {
            $logLevel = LogLevel::DEBUG;
            $response = PsrMessage::parseResponse($responseBody);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
                $logLevel = LogLevel::ERROR;
            }
            $this->getLogger()->log($logLevel, PsrMessage::toString($requests[$uuid]));
            $this->getLogger()->log($logLevel, PsrMessage::toString($response));

            $responses[$uuid] = $response;
        }

        // Reset pending requests
        $this->pendingRequests = [];

        return $responses;
    }

    /**
     * @param resource         $curl
     * @param RequestInterface $request
     *
     * @throws HttpClientException
     */
    protected function prepareRequest($curl, RequestInterface $request)
    {
        $method = strtolower($request->getMethod());
        $body = (string) $request->getBody();
        $headers = [];
        foreach (array_keys($request->getHeaders()) as $key) {
            $value = $request->getHeaderLine($key);
            $headers[] = "$key: $value";
        }
        $headers[] = 'Expect:';
        $opts = [];
        if (is_callable($this->defaultOptions)) { // call defaultOptions callback, set options to return value
            $opts = call_user_func_array($this->defaultOptions, func_get_args());
            if (!is_array($opts)) {
                throw new HttpClientException('Non-array value returned by defaultOptions CurlClient callback');
            }
        } elseif (is_array($this->defaultOptions)) { // set default curlopts from array
            $opts = $this->defaultOptions;
        }
        if ('get' == $method) {
            $opts[CURLOPT_HTTPGET] = 1;
        } elseif ('post' == $method) {
            $opts[CURLOPT_POST] = 1;
            if ($body) {
                $opts[CURLOPT_POSTFIELDS] = $body;
            }
        } elseif ('delete' == $method) {
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        } else {
            throw new HttpClientException("Unrecognized method $method");
        }
        $opts[CURLOPT_URL] = $request->getUri();
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_VERBOSE] = false;
        $opts[CURLOPT_HEADER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $opts[CURLOPT_TIMEOUT] = $this->timeout;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_FAILONERROR] = false;
        if ($this->verify) {
            $opts[64] = 1;
            $opts[CURLOPT_SSL_VERIFYHOST] = 2;
            if (is_string($this->verify)) {
                $opts[CURLOPT_CAINFO] = $this->verify;
            }
        } else {
            $opts[64] = 0;
            $opts[CURLOPT_SSL_VERIFYHOST] = 0;
        }
        curl_setopt_array($curl, $opts);
    }

    /**
     * @param        $url
     * @param number $errno
     * @param string $message
     *
     * @throws ApiConnectionException
     */
    private function handleCurlError($url, $errno, $message)
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = "Could not connect to PostNL ($url).  Please check your "
                    .'internet connection and try again.  If this problem persists, '
                    ."you should check PostNL's service status at "
                    .'https://developer.postnl.nl, or';
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = "Could not verify PostNL's SSL certificate.  Please make sure "
                    .'that your network is not intercepting certificates.  '
                    ."(Try going to $url in your browser.)  "
                    .'If this problem persists,';
                break;
            default:
                $msg = 'Unexpected error communicating with PostNL.  '
                    .'If this problem persists,';
        }
        $msg .= ' contact developer@postnl.nl';
        $msg .= "\n\n(Network error [errno $errno]: $message)";
        throw new ApiConnectionException($msg);
    }
}
