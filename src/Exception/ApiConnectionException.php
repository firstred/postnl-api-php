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

namespace ThirtyBees\PostNL\Exception;

/**
 * Class ApiConnectionException
 *
 * @package ThirtyBees\PostNL\Exception
 */
class ApiConnectionException extends \Exception
{
    /** @var string $body */
    protected $body;
    /** @var object $jsonBody */
    protected $jsonBody;
    /** @var array $headers */
    protected $headers;

    /**
     * ApiConnectionException constructor.
     *
     * @param string      $message
     * @param int         $code
     * @param string|null $body
     * @param object|null $jsonBody
     * @param array|null  $headers
     */
    public function __construct($message = "", $code = 0, $body = null, $jsonBody = null, $headers = null)
    {
        parent::__construct($message, $code, null);

        $this->body = $body;
        $this->jsonBody = $jsonBody;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return object
     */
    public function getJsonBody()
    {
        return $this->jsonBody;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
