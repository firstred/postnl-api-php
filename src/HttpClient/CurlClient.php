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
use ThirtyBees\PostNL\Exception\NotImplementedException;

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
     * Adds a request to the list of pending requests
     * Using the ID you can replace a request
     *
     * @param string $id      Request ID
     * @param string $request PSR-7 request
     *
     * @return int|string
     * @throws NotImplementedException
     */
    public function addOrUpdateRequest($id, $request)
    {
        throw new NotImplementedException('The cURL client is unavailable at the moment');
    }

    /**
     * Remove a request from the list of pending requests
     *
     * @param string $id
     *
     * @throws NotImplementedException
     */
    public function removeRequest($id)
    {
        throw new NotImplementedException('The cURL client is unavailable at the moment');
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
    public function doRequest($request)
    {
        throw new NotImplementedException('The cURL client is unavailable at the moment');
    }

    /**
     * Do all async requests at once
     *
     * Exceptions are captured into the result array
     *
     * @param Request[] $requests
     *
     * @return Response|Response[]|\Exception|\Exception[]
     *
     * @throws NotImplementedException
     */
    public function doRequests($requests = [])
    {
        throw new NotImplementedException('The cURL client is unavailable at the moment');
    }
}
