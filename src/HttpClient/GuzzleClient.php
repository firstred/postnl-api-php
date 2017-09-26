<?php
/**
 * Copyright (C) 2017 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @copyright 2017 thirty bees
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

namespace ThirtyBees\PostNL\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use ThirtyBees\PostNL\Exception\ApiConnectionException;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Util\Util;

/**
 * Class GuzzleClient
 *
 * @package ThirtyBees\PostNL\HttpClient
 */
class GuzzleClient implements ClientInterface
{
    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;
    /** @var GuzzleClient $instance */
    private static $instance;
    /** @var array|callable|null $defaultOptions */
    protected $defaultOptions;
    /** @var int $timeout */
    private $timeout = self::DEFAULT_TIMEOUT;
    /** @var int $connectTimeout */
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;

    /**
     * GuzzleClient constructor.
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
    public function __construct($defaultOptions = null)
    {
        $this->defaultOptions = $defaultOptions;
    }

    /**
     * @return GuzzleClient
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * @return array|callable|null
     *
     * @since 1.0.0
     */
    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }

    /**
     * @return int
     *
     * @since 1.0.0
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $seconds
     *
     * @return $this
     *
     * @since 1.0.0
     */
    public function setTimeout($seconds)
    {
        $this->timeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * @return int
     *
     * @since 1.0.0
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * @param int $seconds
     *
     * @return $this
     *
     * @since 1.0.0
     */
    public function setConnectTimeout($seconds)
    {
        $this->connectTimeout = (int) max($seconds, 0);

        return $this;
    }

    /**
     * @param string      $method  The HTTP method being used
     * @param string      $absUrl  The URL being requested, including domain and protocol
     * @param array       $headers Headers to be used in the request (full strings, not KV pairs)
     * @param array       $params  KV pairs for parameters. Can be nested for arrays and hashes
     * @param string|null $body
     *
     * @return array
     * @throws ApiConnectionException
     * @throws ApiException
     */
    public function request($method, $absUrl, $headers, $params, $body = null)
    {
        $method = strtoupper($method);
        $requestHeaders = [];
        foreach ($headers as $header) {
            $requestHeader = explode(': ', $header, 2);
            if (is_array($requestHeader) && count($requestHeader) === 2) {
                $requestHeaders[$requestHeader[0]] = $requestHeader[1];
            }
        }

        $options = [
            'headers' => $requestHeaders,
            'verify'  => __DIR__.'/../../data/cacert.pem',
        ];

        if ($method === 'GET') {
            if (count($params) > 0) {
                $encoded = Util::urlEncode($params);
                $absUrl = "$absUrl?$encoded";
            }
        } elseif ($method === 'DELETE') {
            if (count($params) > 0) {
                $encoded = Util::urlEncode($params);
                $absUrl = "$absUrl?$encoded";
            }
        } elseif ($method === 'POST') {
            if ($body) {
                $options['body'] = $body;
                if ($params) {
                    $encoded = Util::urlEncode($params);
                    $absUrl = "$absUrl?$encoded";
                }
            } else {
                $options['body'] = Util::urlEncode($params);
            }
        } else {
            throw new ApiException("Unrecognized method $method");
        }

        $guzzle = new Client(['http_errors' => false]);
        try {
            $response = $guzzle->request($method, $absUrl, $options);
            $rbody = $response->getBody();
            $rcode = $response->getStatusCode();
            $rheaders = [];
            foreach ($response->getHeaders() as $name => $values) {
                if (is_array($values)) {
                    $rheaders[$name] = implode(', ', $values);
                } elseif (is_string($values)) {
                    $rheaders[$name] = $values;
                }
            }
        } catch (BadResponseException $e) {
            $headers = [];
            foreach ($e->getResponse()->getHeaders() as $name => $values) {
                if (is_array($values)) {
                    $headers[$name] = implode(', ', $values);
                } elseif (is_string($values)) {
                    $headers[$name] = $values;
                }
            }
            throw new ApiConnectionException(
                'Could not connect with PostNL',
                $e->getResponse()->getStatusCode(),
                (string) $e->getResponse()->getBody(),
                json_encode((string) $e->getResponse()->getBody()),
                $headers
            );
        } catch (\Exception $e) {
            throw new ApiConnectionException('Could not connect with PostNL');
        }

        return [$rbody, $rcode, $rheaders];
    }

    /**
     * Add async request
     *
     * @param string $id
     * @param string $method
     * @param string $absUrl
     * @param array  $headers
     * @param array  $params
     * @param string $body
     *
     * @return void
     */
    public function addRequest($id, $method, $absUrl, $headers, $params, $body = null)
    {

    }

    /**
     * Do all async requests
     *
     * Exceptions are captured into the result array
     *
     * @return array(array($rawBody, $httpStatusCode, $httpHeader), ...)
     */
    public function doRequests()
    {

    }
}
