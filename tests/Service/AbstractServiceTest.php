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

namespace Firstred\PostNL\Tests\Service;

use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\ResponseProcessor\AbstractResponseProcessor;
use Firstred\PostNL\Service\ResponseProcessor\Rest\BarcodeServiceRestResponseProcessor;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox(text: 'The `AbstractService` class')]
class AbstractServiceTest extends ServiceTestCase
{
    /** @throws */
    #[TestDox(text: 'can get the response text from the value property')]
    public function testGetResponseTextFromArray(): void
    {
        $response = new Response(status: 200, headers: [], body: 'test');

        $reflectionResponseProcessor = new \ReflectionClass(objectOrClass: AbstractResponseProcessor::class);

        $result = $reflectionResponseProcessor->getMethod(name: 'getResponseText')->invokeArgs(object: null, args: [['value' => $response]]);

        $this->assertEquals(expected: 'test', actual: $result);
    }

    /** @throws */
    #[TestDox(text: 'can get a response text from an exception')]
    public function testGetResponseTextFromException(): void
    {
        $response = new HttpClientException(message: '', code: 0, previous: null, response: new Response(status: 500, headers: [], body: 'test'));

        $reflectionResponseProcessor = new \ReflectionClass(objectOrClass: AbstractResponseProcessor::class);

        $this->assertEquals(expected: 'test', actual: $reflectionResponseProcessor->getMethod(name: 'getResponseText')->invokeArgs(object: null, args: [['value' => $response]]));
    }

    /** @throws */
    #[TestDox(text: 'can detect and throw a CifDownException (REST)')]
    public function testCifDownExceptionRest(): void
    {
        $this->expectException(exception: CifDownException::class);

        $response = new Response(status: 500, headers: [], body: json_encode(value: [
            'Envelope' => ['Body' => ['Fault' => ['Reason' => ['Text' => ['' => 'error']]]]],
        ]));

        $barcodeService = $this->createMock(originalClassName: BarcodeService::class);
        $barcodeServiceReflection = new \ReflectionObject(object: $barcodeService);
        $adapter = $this->createMock(originalClassName: BarcodeServiceRestResponseProcessor::class);
        $responseProcessorReflection = $barcodeServiceReflection->getProperty(name: 'responseProcessor');
        $responseProcessorReflection->setValue(objectOrValue: $barcodeService, value: $adapter);
        $responseProcessorReflection = new \ReflectionObject(object: $adapter);
        $validateResponseMethod = $responseProcessorReflection->getMethod(name: 'validateResponse');
        $validateResponseMethod->invokeArgs(object: $adapter, args: [$response]);
    }

    /** @throws */
    #[TestDox(text: 'can detect and throw a CifException (REST)')]
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

        $barcodeService = $this->createMock(originalClassName: BarcodeService::class);
        $barcodeServiceReflection = new \ReflectionObject(object: $barcodeService);
        $responseProcessor = $this->createMock(originalClassName: BarcodeServiceRestResponseProcessor::class);
        $responseProcessorReflection = $barcodeServiceReflection->getProperty(name: 'responseProcessor');
        $responseProcessorReflection->setValue(objectOrValue: $barcodeService, value: $responseProcessor);
        $responseProcessorReflection = new \ReflectionObject(object: $responseProcessor);
        $validateResponseMethod = $responseProcessorReflection->getMethod(name: 'validateResponse');
        $validateResponseMethod->invokeArgs(object: $responseProcessor, args: [$response]);
    }
}
