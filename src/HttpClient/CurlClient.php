<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\HttpClient;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use ThirtyBees\PostNL\Exception\ApiConnectionException;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\NotImplementedException;
use ThirtyBees\PostNL\Util\Util;

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
 * Class CurlClient
 *
 * @package ThirtyBees\PostNL\HttpClient
 */
class CurlClient implements ClientInterface
{
    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;

    /** @var int $timeout */
    private $timeout = self::DEFAULT_TIMEOUT;
    /** @var int $connectTimeout */
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;
    /**
     * Verify the server SSL certificate
     *
     * @var bool|string $verify
     */
    private $verify = true;
    /** @var static $instance */
    private static $instance;
    /** @var array|callable|null $defaultOptions */
    protected $defaultOptions;
    /** @var array $userAgentInfo */
    protected $userAgentInfo;
    /** @var array $p */
    protected $pendingRequests = [];

    /**
     * CurlClient Singleton
     *
     * @return CurlClient
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * Set timeout
     *
     * @param int $seconds
     *
     * @return $this
     */
    public function setTimeout($seconds)
    {
        $this->timeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * Set connection timeout
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
     * Set the verify setting
     *
     * @param bool|string $verify
     *
     * @return $this
     */
    public function setVerify($verify)
    {
        $this->verify = $verify;

        return $this;
    }

    /**
     * Get timeout
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Get connection timeout
     *
     * @return int
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * Return verify setting
     *
     * @return bool|string
     */
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request
     *
     * @param string $id      Request ID
     * @param string $request PSR-7 request
     *
     * @return int|string
     */
    public function addOrUpdateRequest($id, $request)
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
    public function removeRequest($id)
    {
        unset($this->pendingRequests[$id]);
    }

    /**
     * Clear all pending requests
     */
    public function clearRequests()
    {
        $this->pendingRequests = [];
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
     * @throws \Exception
     */
    public function doRequest(Request $request)
    {
        $curl = curl_init();
        // Create a callback to capture HTTP headers for the response
        $this->prepareRequest($curl, $request);
        $rbody = curl_exec($curl);
        if ($rbody === false) {
            $errno = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            $this->handleCurlError($request->getUri(), $errno, $message);
        }
        curl_close($curl);

        return \GuzzleHttp\Psr7\parse_response($rbody);
    }

    /**
     * Do all async requests
     *
     * Exceptions are captured into the result array
     *
     * @param Request[] $requests
     *
     * @return Response|Response[]|\Exception|\Exception[]
     * @throws ApiException
     */
    public function doRequests($requests = [])
    {
        // Reset request headers array
        $curlHandles = [];
        $mh = curl_multi_init();
        foreach ($this->pendingRequests as $uuid => $request) {
            $curl = curl_init();
            $curlHandles[$uuid] = $curl;
            $this->prepareRequest($curl, $request);
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
        if (isset($this->multiCurlHandle) && get_resource_type($this->multiCurlHandle) === 'curl_multi') {
            curl_multi_close($this->multiCurlHandle);
        }
        $responses = [];
        foreach ($responseBodies as $uuid => $responseBody) {
            $responses[$uuid] = \GuzzleHttp\Psr7\parse_response($responseBody);
        }

        // Reset pending requests
        $this->pendingRequests = [];

        return $responses;
    }
    /**
     * @param resource $curl
     * @param Request   $request
     *
     * @throws ApiException
     */
    protected function prepareRequest($curl, Request $request)
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
                throw new ApiException("Non-array value returned by defaultOptions CurlClient callback");
            }
        } elseif (is_array($this->defaultOptions)) { // set default curlopts from array
            $opts = $this->defaultOptions;
        }
        if ($method == 'get') {
            $opts[CURLOPT_HTTPGET] = 1;
        } elseif ($method == 'post') {
            $opts[CURLOPT_POST] = 1;
            if ($body) {
                $opts[CURLOPT_POSTFIELDS] = $body;
            }
        } elseif ($method == 'delete') {
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        } else {
            throw new ApiException("Unrecognized method $method");
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
            $opts[CURLOPT_SSL_VERIFYPEER] = 1;
            $opts[CURLOPT_SSL_VERIFYHOST] = 2;
            if (is_string($this->verify)) {
                $opts[CURLOPT_CAINFO] = $this->verify;
            }
        } else {
            $opts[CURLOPT_SSL_VERIFYPEER] = 0;
            $opts[CURLOPT_SSL_VERIFYHOST] = 0;
        }
        curl_setopt_array($curl, $opts);
    }
    /**
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
                    ."internet connection and try again.  If this problem persists, "
                    ."you should check PostNL's service status at "
                    ."https://developer.postnl.nl, or";
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = "Could not verify PostNL's SSL certificate.  Please make sure "
                    ."that your network is not intercepting certificates.  "
                    ."(Try going to $url in your browser.)  "
                    ."If this problem persists,";
                break;
            default:
                $msg = "Unexpected error communicating with PostNL.  "
                    ."If this problem persists,";
        }
        $msg .= " contact developer@postnl.nl";
        $msg .= "\n\n(Network error [errno $errno]: $message)";
        throw new ApiConnectionException($msg);
    }
}
