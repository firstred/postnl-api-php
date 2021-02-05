<?php
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

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Unit\Entity;

use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\Response\GetLocationsResponseDTO;
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use PHPUnit\Framework\TestCase;
use function file_get_contents;
use function json_decode;
use function unserialize;

/**
 * @testdox The Entities
 *
 * @covers \Firstred\PostNL\Misc\SerializableObject
 */
class SerializationTest extends TestCase
{
    protected string $serialized = 'O:30:"Firstred\PostNL\Entity\Barcode":5:{s:4:"Type";s:4:"test";s:5:"Range";s:4:"test";s:5:"Serie";s:19:"000000000-999999999";s:7:"service";s:47:"Firstred\PostNL\Service\BarcodeServiceInterface";s:8:"propType";s:38:"Firstred\PostNL\Attribute\ResponseProp";}';

    /**
     * @testdox Should be able to serialize an object
     */
    public function testCanSerializeObject()
    {
        $serialized = serialize(value: new Barcode(
            service: BarcodeServiceInterface::class,
            propType: ResponseProp::class,

            Type: 'test',
            Range: 'test',
        ));

        $this->assertEqualsCanonicalizing(
            expected: $this->serialized,
            actual: $serialized,
        );
    }

    /**
     * @testdox Should be able to deserialize an object
     */
    public function testCanDeserializeObject()
    {
        $deserialized = unserialize(data: $this->serialized);
        $this->assertInstanceOf(expected: Barcode::class, actual: $deserialized);
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode(value: new Barcode(
                service: BarcodeServiceInterface::class,
                propType: ResponseProp::class,

                Type: 'test',
                Range: 'test',
            )),
            actualJson: json_encode(value: $deserialized),
        );
    }

    /**
     * @testdox Should be able to serialize and deserialize responses
     *
     * @throws InvalidArgumentException
     */
    public function testCanSerializeAndDeserializeResponses()
    {
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = new GetLocationsResponseDTO(...@json_decode(json: file_get_contents(filename: __DIR__.'/../../data/responses/location/nearestlocations.json'), associative: true));

        $serialized = serialize(value: $response);

        $copyResponse = unserialize(data: $serialized);

        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode(value: $response),
            actualJson: json_encode(value: $copyResponse),
        );
    }
}
