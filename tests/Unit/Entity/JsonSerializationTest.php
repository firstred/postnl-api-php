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

use Firstred\PostNL\DTO\Response\GetLocationResponseDTO;
use Firstred\PostNL\DTO\Response\GetLocationsResponseDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function file_get_contents;
use function json_decode;
use function json_encode;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

/**
 * @testdox The Entities
 *
 * @covers \Firstred\PostNL\Misc\SerializableObject
 */
class JsonSerializationTest extends TestCase
{
    /**
     * @testdox Should be able to JSON serialize and deserialize responses
     *
     * @throws InvalidArgumentException
     */
    public function testCanJsonSerializeAndDeserializeLookupLocationResponse()
    {
        $json = file_get_contents(filename: __DIR__.'/../../data/responses/location/lookuplocation.json');

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = new GetLocationResponseDTO(...@json_decode(json: $json, associative: true));

        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode(value: json_decode(json: $json, associative: true), flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            actualJson: json_encode(value: $response->jsonSerialize(), flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        );
    }

    /**
     * @testdox Should be able to JSON serialize and deserialize responses
     *
     * @throws InvalidArgumentException
     */
    public function testCanJsonSerializeAndDeserializeGetLocationsResponse()
    {
        $json = file_get_contents(filename: __DIR__.'/../../data/responses/location/nearestlocations.json');

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = new GetLocationsResponseDTO(...@json_decode(json: $json, associative: true));

        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode(value: json_decode(json: $json, associative: true), flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            actualJson: json_encode(value: $response->jsonSerialize(), flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        );
    }
}
