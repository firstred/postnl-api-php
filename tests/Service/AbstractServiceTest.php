<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Tests\Service;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use ThirtyBees\PostNL\Service\AbstractService;

/**
 * Class AbstractServiceTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The AbstractService class
 */
class AbstractServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testdox can get the response text from the value property
     *
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function testGetResponseTextFromArray()
    {
        $response = new Response('POST', [], 'test');

        $this->assertEquals('test', AbstractService::getResponseText(['value' => $response]));
    }

    /**
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function testGetResponseTextFromException()
    {
        $response = new \GuzzleHttp\Exception\ClientException(null, new Request('POST', 'localhost', []), new Response(500, [], 'test'));

        $this->assertEquals('test', AbstractService::getResponseText(['value' => $response]));
    }
}
