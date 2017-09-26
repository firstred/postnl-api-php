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

/**
 * Interface ClientInterface
 *
 * @package ThirtyBees\PostNL\HttpClient
 */
interface ClientInterface
{
    /**
     * Single sync request
     *
     * @param string      $method  The HTTP method being used
     * @param string      $absUrl  The URL being requested, including domain and protocol
     * @param array       $headers Headers to be used in the request (full strings, not KV pairs)
     * @param array       $params  KV pairs for parameters. Can be nested for arrays and hashes
     * @param string|null $body
     *
     * @throws \ThirtyBees\PostNL\Exception\ApiException | \ThirtyBees\PostNL\Exception\ApiConnectionException
     * @return array($rawBody, $httpStatusCode, $httpHeader)
     */
    public function request($method, $absUrl, $headers, $params, $body = null);

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
     */
    public function addRequest($id, $method, $absUrl, $headers, $params, $body = null);

    /**
     * Do all async requests
     *
     * Exceptions are captured into the result array
     *
     * @return array(array($rawBody, $httpStatusCode, $httpHeader), ...)
     */
    public function doRequests();
}
