<?php

declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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

namespace Firstred\PostNL\Tests\Unit\Exception;

use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Service\AbstractService;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

/**
 * Class CifDownExceptionTest.
 */
class CifDownExceptionTest extends TestCase
{
    /**
     * @testdox Can detect and throw a CifDownException (REST)
     *
     * @throws CifDownException
     */
    public function testCifDownExceptionRest()
    {
        $this->markTestSkipped();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $response = $responseFactory->createResponse(code: 500, reasonPhrase: 'Internal Server Error')
            ->withBody(
                body: $streamFactory->createStream(
                    content: json_encode(
                        value: [
                            'Envelope' => ['Body' => ['Fault' => ['Reason' => ['Text' => ['' => 'error']]]]],
                        ]
                    )
                )
            );

        AbstractService::validateResponse($response);
    }

    /**
     * @testdox Can detect and throw a CifDownException (REST)
     *
     * @throws CifDownException
     */
    public function testCifExceptionRest()
    {
        $this->markTestSkipped();

        $this->expectException(exception: CifDownException::class);

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $response = $responseFactory->createResponse(code: 500, reasonPhrase: 'Internal Server Error')
            ->withBody(
                body: $streamFactory->createStream(
                    content: json_encode(
                        value: [
                            'Errors' => [
                                'Error' => [
                                    [
                                        'Description' => 'desc',
                                        'ErrorMsg'    => 'Description',
                                        'ErrorNumber' => 200,
                                    ],
                                ],
                            ],
                        ]
                    )
                )
            );

        AbstractService::validateResponse($response);
    }
}
