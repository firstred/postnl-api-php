<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Tests\Service;

use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\AbstractService;
use Firstred\PostNL\Service\Adapter\AbstractApiAdapter;
use GuzzleHttp\Psr7\Response;

/**
 * @testdox The AbstractService class
 */
class AbstractServiceTest extends ServiceTestCase
{
    /**
     * @testdox can get the response text from the value property
     *
     * @throws ResponseException
     * @throws HttpClientException
     */
    public function testGetResponseTextFromArray(): void
    {
        $response = new Response(status: 200, headers: [], body: 'test');

        $result = AbstractApiAdapter::getResponseText(response: ['value' => $response]);

        $this->assertEquals(expected: 'test', actual: $result);
    }

    /**
     * @throws HttpClientException
     * @throws ResponseException
     */
    public function testGetResponseTextFromException(): void
    {
        $response = new HttpClientException(message: '', code: 0, previous: null, response: new Response(status: 500, headers: [], body: 'test'));

        $this->assertEquals(expected: 'test', actual: AbstractApiAdapter::getResponseText(response: ['value' => $response]));
    }

    /**
     * @testdox can detect and throw a CifDownException (REST)
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws ApiException
     * @throws InvalidConfigurationException
     */
    public function testCifDownExceptionRest(): void
    {
        $this->expectException(exception: CifDownException::class);

        $response = new Response(status: 500, headers: [], body: json_encode(value: [
            'Envelope' => ['Body' => ['Fault' => ['Reason' => ['Text' => ['' => 'error']]]]],
        ]));

        AbstractService::validateRestResponse(response: $response);
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
    public function testCifExceptionRest(): void
    {
        $this->expectException(exception: CifException::class);

        $response = new Response(status: 500, headers: [], body: json_encode(value: [
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

        AbstractService::validateRestResponse(response: $response);
    }

    /**
     * @testdox can detect and throw a CifDownException (SOAP)
     *
     * @throws CifDownException
     * @throws CifException
     */
    public function testCifDownExceptionSoap(): void
    {
        $this->expectException(exception: CifDownException::class);

        $response = simplexml_load_string(data: <<<XML
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
        $response->registerXPathNamespace(prefix: 'env', namespace: 'http://www.w3.org/2003/05/soap-envelope');
        $response->registerXPathNamespace(prefix: 'common', namespace: 'http://postnl.nl/cif/services/common/');

        AbstractService::validateSoapResponse(xml: $response);
    }

    /**
     * @testdox can detect and throw a CifException (SOAP)
     *
     * @throws CifDownException
     * @throws CifException
     */
    public function testCifExceptionSoap(): void
    {
        $this->expectException(exception: CifException::class);

        $response = simplexml_load_string(data: <<<XML
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
        $response->registerXPathNamespace(prefix: 'env', namespace: 'http://www.w3.org/2003/05/soap-envelope');
        $response->registerXPathNamespace(prefix: 'common', namespace: 'http://postnl.nl/cif/services/common/');

        AbstractService::validateSoapResponse(xml: $response);
    }
}
