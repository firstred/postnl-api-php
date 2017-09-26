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

// If undefined, map the defines to cURL's codes
use AlgoliaSearch\Json;
use Hybridauth\Exception\Exception;
use ThirtyBees\PostNL\Exception\ApiConnectionException;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\PostNL;
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

    private $timeout = self::DEFAULT_TIMEOUT;
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;
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
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * CurlClient constructor.
     *
     * Pass in a callable to $defaultOptions that returns an array of CURLOPT_* values to start
     * off a request with, or an flat array with the same format used by curl_setopt_array() to
     * provide a static set of options. Note that many options are overridden later in the request
     * call, including timeouts, which can be set via setTimeout() and setConnectTimeout().
     *
     * Note that request() will silently ignore a non-callable, non-array $defaultOptions, and will
     * throw an exception if $defaultOptions returns a non-array value.
     *
     * @param array|callable|null $defaultOptions
     */
    protected function __construct($defaultOptions = null)
    {
        $this->defaultOptions = $defaultOptions;
        $this->initUserAgentInfo();
    }

    /**
     * Initialize user agent info
     */
    public function initUserAgentInfo()
    {
        $curlVersion = curl_version();
        $this->userAgentInfo = [
            'httplib' =>  'curl '.$curlVersion['version'],
            'ssllib'  => $curlVersion['ssl_version'],
        ];
    }

    /**
     * Get default options
     *
     * @return array|callable|null
     */
    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }

    /**
     * Get user agent info
     *
     * @return array
     */
    public function getUserAgentInfo()
    {
        return $this->userAgentInfo;
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
     * Do a single request
     *
     * @param string      $method
     * @param string      $absUrl
     * @param array       $headers
     * @param array       $params
     * @param string|null $body
     *
     * @return array
     * @throws ApiException
     */
    public function request($method, $absUrl, $headers, $params, $body = null)
    {
        $curl = curl_init();

        // Create a callback to capture HTTP headers for the response
        $rheaders = [];
        $headerCallback = function ($curl, $headerLine) use (&$rheaders) {
            // Ignore the HTTP request line (HTTP/1.1 200 OK)
            if (strpos($headerLine, ":") === false) {
                return strlen($headerLine);
            }
            list($key, $value) = explode(":", trim($headerLine), 2);
            $rheaders[trim($key)] = trim($value);

            return strlen($headerLine);
        };

        $this->prepareRequest($curl, $method, $absUrl, $headers, $params, $body, $headerCallback);

        $rbody = curl_exec($curl);

        if ($rbody === false) {
            $errno = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            $this->handleCurlError($absUrl, $errno, $message);
        }

        $rcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [$rbody, $rcode, $rheaders];
    }

    /**
     * Add async request
     *
     * @param string      $id
     * @param string      $method
     * @param string      $absUrl
     * @param array       $headers
     * @param array       $params
     * @param string|null $body
     *
     * @return void
     * @return void
     */
    public function addRequest($id, $method, $absUrl, $headers, $params, $body = null)
    {

        $this->pendingRequests[$id] = [$method, $absUrl, $headers, $params, $body];
    }

    /**
     * Do all async requests
     *
     * Exceptions are captured into the result array
     *
     * @return array($id => array($rawBody, $httpStatusCode, $httpHeader), ...)
     */
    public function doRequests()
    {
        // Reset request headers array
        $responseHeaders = [];
        $responseCodes = [];
        $curlHandles = [];

        $mh = curl_multi_init();

        foreach ($this->pendingRequests as $uuid => $request) {
            $curl = curl_init();
            $curlHandles[$uuid] = $curl;
            list($method, $absUrl, $headers, $params, $body) = $request;

            $headerCallback = function ($curl, $headerLine) use (&$id, $responseHeaders) {
                // Ignore the HTTP request line (HTTP/1.1 200 OK)
                if (strpos($headerLine, ":") === false) {
                    return strlen($headerLine);
                }
                list($key, $value) = explode(":", trim($headerLine), 2);
                if (!isset($responseHeaders[$id])) {
                    $responseHeaders[$id] = [];
                }
                $responseHeaders[$id][trim($key)] = trim($value);

                return strlen($headerLine);
            };

            $this->prepareRequest($curl, $method, $absUrl, $headers, $params, $body, $headerCallback);

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

        $results = [];
        foreach ($responseBodies as $uuid => $responseBody) {
            $results[$uuid] = [
                'body'    => $responseBody,
                'code'    => $responseCodes[$uuid],
                'headers' => isset($responseHeaders[$uuid]) ? $responseHeaders[$uuid] : [],
            ];
        }
        // Reset pending requests
        $this->pendingRequests = [];

        return $results;
    }

    /**
     * @param resource $curl
     * @param string   $method
     * @param string   $absUrl
     * @param array    $headers
     * @param array    $params
     * @param string   $body
     * @param callable $headerCallback
     *
     * @throws ApiException
     */
    protected function prepareRequest($curl, $method, $absUrl, $headers, $params, $body = null, &$headerCallback = null)
    {
        $method = strtolower($method);

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
            if (count($params) > 0) {
                $encoded = Util::urlEncode($params);
                $absUrl = "$absUrl?$encoded";
            }
        } elseif ($method == 'post') {
            $opts[CURLOPT_POST] = 1;
            if ($body) {
                $opts[CURLOPT_POSTFIELDS] = $body;
                if ($params) {
                    $encoded = Util::urlEncode($params);
                    $absUrl = "$absUrl?$encoded";
                }
            } else {
                $opts[CURLOPT_POSTFIELDS] = Util::urlEncode($params);
            }
        } elseif ($method == 'delete') {
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            if (count($params) > 0) {
                $encoded = Util::urlEncode($params);
                $absUrl = "$absUrl?$encoded";
            }
        } else {
            throw new ApiException("Unrecognized method $method");
        }

        $opts[CURLOPT_URL] = $absUrl;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $opts[CURLOPT_TIMEOUT] = $this->timeout;
        $opts[CURLOPT_HEADERFUNCTION] = $headerCallback;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_FAILONERROR] = false;
        $opts[CURLOPT_CAINFO] = __DIR__.'/../../data/cacert.pem';

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
