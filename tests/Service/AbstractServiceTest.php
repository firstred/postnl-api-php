<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker
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
 * @copyright 2017-2019 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Service;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\AbstractService;
use Firstred\PostNL\Service\LabellingService;

/**
 * Class AbstractServiceTest
 *
 * @package Firstred\PostNL\Tests\Service
 *
 * @testdox The AbstractService class
 */
class AbstractServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testdox can get the response text from the value property
     *
     * @throws \Firstred\PostNL\Exception\ResponseException
     */
    public function testGetResponseTextFromArray()
    {
        $response = new Response(200, [], 'test');

        $result = AbstractService::getResponseText(['value' => $response]);

        $this->assertEquals('test', $result);
    }

    /**
     * @throws \Firstred\PostNL\Exception\ResponseException
     */
    public function testGetResponseTextFromException()
    {
        $response = new \GuzzleHttp\Exception\ClientException(null, new Request('POST', 'localhost', []), new Response(500, [], 'test'));

        $this->assertEquals('test', AbstractService::getResponseText(['value' => $response]));
    }

    /**
     * @testdox can detect and throw a CifDownException (REST)
     *
     * @throws \Firstred\PostNL\Exception\ApiException
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     * @throws \Firstred\PostNL\Exception\ResponseException
     */
    public function testCifDownExceptionRest()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\CifDownException');

        $response = new Response(500, [], json_encode([
            'Envelope' => ['Body' => ['Fault' => ['Reason' => ['Text' => ['' => 'error']]]]],
        ]));

        AbstractService::validateRESTResponse($response);
    }

    /**
     * @testdox can detect and throw a CifException (REST)
     *
     * @throws \Firstred\PostNL\Exception\ApiException
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     * @throws \Firstred\PostNL\Exception\ResponseException
     */
    public function testCifExceptionRest()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\CifException');

        $response = new Response(500, [], json_encode([
            'Errors' => [
                'Error' => [
                    [
                        'Description' => 'desc',
                        'ErrorMsg'    => 'Description',
                        'ErrorNumber' => 200,
                    ],
                ],
            ],
        ]));

        AbstractService::validateRESTResponse($response);
    }

    /**
     * @testdox can detect and throw a CifDownException (SOAP)
     *
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     */
    public function testCifDownExceptionSoap()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\CifDownException');

        $response = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>
<Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope">
    <encodingStyle>http://schemas.xmlsoap.org/soap/encoding/</encodingStyle>
    <env:Body>
        <env:Fault>
            <faultcode>soap:Server</faultcode>
            <faultstring>Failed to execute the ExtractVariables: payloadExtractVariables</faultstring>
            <faultactor/>
            <env:Reason>
                <env:Text>steps.extractvariables.ExecutionFailed</env:Text>
            </env:Reason>
        </env:Fault>
    </env:Body>
</Envelope>');
        $response->registerXPathNamespace('env', 'http://www.w3.org/2003/05/soap-envelope');
        $response->registerXPathNamespace('common', 'http://postnl.nl/cif/services/common/');

        AbstractService::validateSOAPResponse($response);
    }

    /**
     * @testdox can detect and throw a CifException (SOAP)
     *
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     */
    public function testCifExceptionSoap()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\CifException');

        $response = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>
<Envelope xmlns:common="http://postnl.nl/cif/services/common/">
    <encodingStyle>http://schemas.xmlsoap.org/soap/encoding/</encodingStyle>
    <common:CifException>
        <common:Errors>
            <common:ExceptionData>
                <common:Description>ExecutionFailed</common:Description>
                <common:ErrorMsg>steps.extractvariables.ExecutionFailed</common:ErrorMsg>
                <common:ErrorNumber>1</common:ErrorNumber>
            </common:ExceptionData>
        </common:Errors>
    </common:CifException>
</Envelope>');
        $response->registerXPathNamespace('env', 'http://www.w3.org/2003/05/soap-envelope');
        $response->registerXPathNamespace('common', 'http://postnl.nl/cif/services/common/');

        AbstractService::validateSOAPResponse($response);
    }
}
