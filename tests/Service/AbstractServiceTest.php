<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker
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

namespace ThirtyBees\PostNL\Tests\Service;

use GuzzleHttp\Psr7\Response;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\HttpClientException;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\Service\AbstractService;

/**
 * Class AbstractServiceTest.
 *
 * @testdox The AbstractService class
 */
class AbstractServiceTest extends ServiceTest
{
    /**
     * @testdox can get the response text from the value property
     *
     * @throws ResponseException
     * @throws HttpClientException
     */
    public function testGetResponseTextFromArray()
    {
        $response = new Response(200, [], 'test');

        $result = AbstractService::getResponseText(['value' => $response]);

        $this->assertEquals('test', $result);
    }

    /**
     * @throws HttpClientException
     * @throws ResponseException
     */
    public function testGetResponseTextFromException()
    {
        $response = new HttpClientException('', 0, null, new Response(500, [], 'test'));

        $this->assertEquals('test', AbstractService::getResponseText(['value' => $response]));
    }

    /**
     * @testdox can detect and throw a CifDownException (REST)
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws ApiException
     */
    public function testCifDownExceptionRest()
    {
        $this->expectException(CifDownException::class);

        $response = new Response(500, [], json_encode([
            'Envelope' => ['Body' => ['Fault' => ['Reason' => ['Text' => ['' => 'error']]]]],
        ]));

        AbstractService::validateRESTResponse($response);
    }

    /**
     * @testdox can detect and throw a CifException (REST)
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     */
    public function testCifExceptionRest()
    {
        $this->expectException(CifException::class);

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
     * @throws CifDownException
     * @throws CifException
     */
    public function testCifDownExceptionSoap()
    {
        $this->expectException(CifDownException::class);

        $response = simplexml_load_string(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
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
</Envelope>
XML
        );
        $response->registerXPathNamespace('env', 'http://www.w3.org/2003/05/soap-envelope');
        $response->registerXPathNamespace('common', 'http://postnl.nl/cif/services/common/');

        AbstractService::validateSOAPResponse($response);
    }

    /**
     * @testdox can detect and throw a CifException (SOAP)
     *
     * @throws CifDownException
     * @throws CifException
     */
    public function testCifExceptionSoap()
    {
        $this->expectException(CifException::class);

        $response = simplexml_load_string(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
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
</Envelope>
XML
        );
        $response->registerXPathNamespace('env', 'http://www.w3.org/2003/05/soap-envelope');
        $response->registerXPathNamespace('common', 'http://postnl.nl/cif/services/common/');

        AbstractService::validateSOAPResponse($response);
    }
}
