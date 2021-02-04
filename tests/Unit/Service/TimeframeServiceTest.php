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

namespace Firstred\PostNL\Tests\Unit\Service;

use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\Request\CalculateTimeframesRequestDTO;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use function count;
use function json_encode;

/**
 * Class TimeframeServiceTest.
 *
 * @testdox The TimeframeService (REST)
 */
class TimeframeServiceTest extends ServiceTestBase
{
    /**
     * @testdox Creates a valid timeframes request
     *
     * @throws InvalidArgumentException
     */
    public function testCalculateTimeframesRequest()
    {
        $this->lastRequest = $request = $this->postnl->getTimeframeService()->getGateway()->getRequestBuilder()->buildCalculateTimeframesRequest(calculateTimeframesRequestDTO: new CalculateTimeframesRequestDTO(
            service: TimeframeServiceInterface::class,
            propType: RequestProp::class,

            StartDate: '30-06-2016',
            EndDate: '02-07-2016',
            Options: ['Evening'],
            AllowSundaySorting: true,
            CountryCode: 'NL',
            City: 'Hoofddorp',
            PostalCode: '2132WT',
            Street: 'Siriusdreef',
            HouseNumber: '42',
            HouseNrExt: 'A',
        ));

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(expected: [
            'AllowSundaySorting' => 'true',
            'StartDate'          => '30-06-2016',
            'EndDate'            => '02-07-2016',
            'PostalCode'         => '2132WT',
            'HouseNumber'        => '42',
            'CountryCode'        => 'NL',
            'Options'            => 'Evening',
            'HouseNrExt'         => 'A',
            'Street'             => 'Siriusdreef',
            'City'               => 'Hoofddorp',
        ], actual: $query);
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can retrieve the available timeframes
     *
     * @throws InvalidArgumentException
     */
    public function testGetTimeframesRest()
    {
        $payload = file_get_contents(filename: __DIR__.'/../../data/responses/timeframes.json');

        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream($payload));
        $mockClient->addResponse(response: $response);
        $this->postnl->getTimeframeService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $responseTimeframes = $this->postnl->calculateTimeframes(
            startDate: '30-06-2016',
            endDate: '03-07-2016',
            options: ['Daytime', 'Evening'],
            postalCode: '2132WT',
            houseNumber: 42,
            allowSundaySorting: false,
            city: 'Hoofddorp',
            street: 'Siriusdreef',
            houseNrExt: 'A'
        );

        // There are 5 Timeframes
        $this->assertEquals(expected: 5, actual: count(value: $responseTimeframes->getTimeframes()));
        // There are 5 ReasonNoTimeframes
        $this->assertEquals(expected: 5, actual: count(value: $responseTimeframes->getReasonNoTimeframes()));

        // The first reason should be an instanceof of ReasonNoTimeframe
        $this->assertInstanceOf(expected: ReasonNoTimeframe::class, actual: $responseTimeframes->getReasonNoTimeframes()[0]);
        // The first timeframe should be an instanceof Timeframe
        $this->assertInstanceOf(expected: Timeframe::class, actual: $responseTimeframes->getTimeframes()[0]);

        // Can be converted back to JSON properly
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode(value: json_decode(json: $payload), flags: JSON_PRETTY_PRINT),
            actualJson: json_encode(value: $responseTimeframes, flags: JSON_PRETTY_PRINT)
        );
    }
}
