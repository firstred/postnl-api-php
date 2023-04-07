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

declare(strict_types=1);

namespace Firstred\PostNL\HttpClient;

use Composer\CaBundle\CaBundle;
use Firstred\PostNL\Exception\ApiConnectionException;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LogLevel;

use function define;
use function defined;
use function is_array;

use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_PROTOCOLS;
use const CURLOPT_REDIR_PROTOCOLS;
use const CURLOPT_SSL_VERIFYPEER;

if (!defined(constant_name: 'CURL_SSLVERSION_TLSv1')) {
    define(constant_name: 'CURL_SSLVERSION_TLSv1', value: 1);
}
if (!defined(constant_name: 'CURL_SSLVERSION_TLSv1_2')) {
    define(constant_name: 'CURL_SSLVERSION_TLSv1_2', value: 6);
}
if (!defined(constant_name: 'CURLE_SSL_CACERT_BADFILE')) {
    define(constant_name: 'CURLE_SSL_CACERT_BADFILE', value: 77);  // constant not defined in PHP
}

/**
 * Class CurlClient.
 *
 * @since 1.0.0
 *
 * @internal
 */
class CurlHttpClient extends BaseHttpClient implements HttpClientInterface, LoggerAwareInterface
{
    /** @var array|callable|null */
    protected $defaultOptions;

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

        try {
            $curl = curl_init();
            // Create a callback to capture HTTP headers for the response
            $this->prepareRequest(curl: $curl, request: $request);
            $responseBody = curl_exec(handle: $curl);
            if (false === $responseBody) {
                $errno = curl_errno(handle: $curl);
                $message = curl_error(handle: $curl);
                curl_close(handle: $curl);
                $logLevel = LogLevel::ERROR;
                $this->handleCurlError(url: $request->getUri(), errno: $errno, message: $message);
            }
            curl_close(handle: $curl);

            $response = PsrMessage::parseResponse(message: $responseBody);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
                $logLevel = LogLevel::ERROR;
            }

            return $response;
        } catch (ApiException $e) {
            $logLevel = LogLevel::ERROR;
            throw new HttpClientException(message: 'Connection error', code: 0, previous: $e, response: $response);
        } finally {
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
        if (!is_array(value: $requests)) {
            throw new InvalidArgumentException(message: 'Invalid requests array passed');
        }

        // Reset request headers array
        $curlHandles = [];
        $mh = curl_multi_init();

        // Handle pending requests as well
        $requests = $this->pendingRequests + $requests;
        foreach ($requests as $uuid => $request) {
            $curl = curl_init();
            $curlHandles[$uuid] = $curl;
            try {
                $this->prepareRequest(curl: $curl, request: $request);
            } catch (HttpClientException $e) {
                // Handle later
            }
            curl_multi_add_handle(multi_handle: $mh, handle: $curl);
        }
        // execute the handles
        $running = null;
        do {
            curl_multi_exec(multi_handle: $mh, still_running: $running);
        } while ($running > 0);
        // get content and remove handles
        $responseBodies = [];
        foreach ($curlHandles as $id => &$c) {
            $responseBodies[$id] = curl_multi_getcontent(handle: $c);
            curl_multi_remove_handle(multi_handle: $mh, handle: $c);
            $responseCodes[$id] = curl_getinfo(handle: $c, option: CURLINFO_HTTP_CODE);
        }
        // all done
        if (isset($this->multiCurlHandle) && 'curl_multi' === get_resource_type(resource: $this->multiCurlHandle)) {
            curl_multi_close(multi_handle: $this->multiCurlHandle);
        }
        $responses = [];
        foreach ($responseBodies as $uuid => $responseBody) {
            $logLevel = LogLevel::DEBUG;
            $response = PsrMessage::parseResponse(message: $responseBody);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
                $logLevel = LogLevel::ERROR;
            }
            $this->getLogger()->log(level: $logLevel, message: PsrMessage::toString(message: $requests[$uuid]));
            $this->getLogger()->log(level: $logLevel, message: PsrMessage::toString(message: $response));

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
        $method = strtolower(string: $request->getMethod());
        $body = (string) $request->getBody();
        $headers = [];
        foreach (array_keys(array: $request->getHeaders()) as $key) {
            $value = $request->getHeaderLine($key);
            $headers[] = "$key: $value";
        }
        $headers[] = 'Expect:';
        $defaultOptions = [];
        if (is_callable(value: $this->defaultOptions)) { // call defaultOptions callback, set options to return value
            $defaultOptions = call_user_func_array(callback: $this->defaultOptions, args: func_get_args());
            if (!is_array(value: $defaultOptions)) {
                throw new HttpClientException(message: 'Non-array value returned by defaultOptions CurlClient callback');
            }
        } elseif (is_array(value: $this->defaultOptions)) { // set default curlopts from array
            $defaultOptions = $this->defaultOptions;
        }
        if ('get' == $method) {
            $options[CURLOPT_HTTPGET] = 1;
        } elseif ('post' == $method) {
            $options[CURLOPT_POST] = 1;
            if ($body) {
                $options[CURLOPT_POSTFIELDS] = $body;
            }
        } elseif ('delete' == $method) {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        } else {
            throw new HttpClientException(message: "Unrecognized method $method");
        }
        $options[CURLOPT_URL] = (string) $request->getUri();
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_VERBOSE] = false;
        $options[CURLOPT_HEADER] = true;
        $options[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $options[CURLOPT_TIMEOUT] = $this->timeout;
        $options[CURLOPT_HTTPHEADER] = $headers;
        $options[CURLOPT_FAILONERROR] = false;
        $options[CURLOPT_PROTOCOLS] = CURLPROTO_HTTPS;
        $options[CURLOPT_REDIR_PROTOCOLS] = CURLPROTO_HTTPS;
        $options[CURLOPT_FOLLOWLOCATION] = false;
        $options[CURLOPT_SSL_VERIFYHOST] = 2;
        $options[CURLOPT_SSL_VERIFYPEER] = true;
        $caPathOrFile = CaBundle::getSystemCaRootBundlePath();
        if (is_dir(filename: $caPathOrFile)) {
            $options[CURLOPT_CAPATH] = $caPathOrFile;
        } else {
            $options[CURLOPT_CAINFO] = $caPathOrFile;
        }

        curl_setopt_array(handle: $curl, options: $defaultOptions + $options);
    }

    /**
     * @param        $url
     * @param number $errno
     * @param string $message
     *
     * @throws ApiConnectionException
     */
    private function handleCurlError($url, $errno, string $message)
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
        throw new ApiConnectionException(message: $msg);
    }
}
