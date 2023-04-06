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

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\RequestBuilder\Rest\TimeframeServiceRestRequestBuilder;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;

use function file_get_contents;

use const _RESPONSES_DIR_;

#[TestDox(text: 'The TimeframeService (REST)')]
class TimeframeServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected TimeframeServiceInterface $service;
    protected RequestInterface $lastRequest;

    /** @throws */
    #[Before]
    public function setupPostNL(): void
    {
        $this->postnl = new PostNL(
            customer: new Customer(
                CustomerNumber: '11223344',
                CustomerCode: 'DEVC',
                CollectionLocation: '123456',
                ContactPerson: 'Test',
                Address: new Address(
                    AddressType: '02',
                    CompanyName: 'PostNL',
                    Street: 'Siriusdreef',
                    HouseNr: '42',
                    Zipcode: '2132WT',
                    City: 'Hoofddorp',
                    Countrycode: 'NL',
                ),
                GlobalPackCustomerCode: '1234',
                GlobalPackBarcodeType: 'AB'
            ),
            apiKey: 'test',
            sandbox: true,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getTimeframeService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid timeframes request')]
    public function testGetTimeframesRequestRest(): void
    {
        $message = new Message();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetTimeframesRequest(
            getTimeframes: (new GetTimeframes())
                ->setMessage(Message: $message)
                ->setTimeframe(timeframes: [
                    (new Timeframe())
                        ->setCity(City: 'Hoofddorp')
                        ->setCountryCode(CountryCode: 'NL')
                        ->setEndDate(EndDate: '02-07-2016')
                        ->setHouseNr(HouseNr: '42')
                        ->setHouseNrExt(HouseNrExt: 'A')
                        ->setOptions(Options: [
                            'Evening',
                        ])
                        ->setPostalCode(PostalCode: '2132WT')
                        ->setStartDate(StartDate: '30-06-2016')
                        ->setStreet(Street: 'Siriusdreef')
                        ->setSundaySorting(SundaySorting: true),
                ])
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

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
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'can retrieve the available timeframes')]
    #[DataProvider(methodName: 'timeframesProvider')]
    public function testGetTimeframesRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $responseTimeframes = $this->postnl->getTimeframes(
            getTimeframes: (new GetTimeframes())
                ->setTimeframe(timeframes: [
                    (new Timeframe())
                        ->setCity(City: 'Hoofddorp')
                        ->setCountryCode(CountryCode: 'NL')
                        ->setEndDate(EndDate: '02-07-2016')
                        ->setHouseNr(HouseNr: '42')
                        ->setHouseNrExt(HouseNrExt: 'A')
                        ->setOptions(Options: [
                            'Evening',
                        ])
                        ->setPostalCode(PostalCode: '2132WT')
                        ->setStartDate(StartDate: '30-06-2016')
                        ->setStreet(Street: 'Siriusdreef')
                        ->setSundaySorting(SundaySorting: false),
                ])
        );

        // Should be a ResponseTimeframes instance
        $this->assertInstanceOf(expected: ResponseTimeframes::class, actual: $responseTimeframes);
        // Check for data loss
        $this->assertInstanceOf(expected: Timeframe::class, actual: $responseTimeframes->getTimeframes()[0]);
        if (count(value: $responseTimeframes->getReasonNoTimeframes())) {
            $this->assertInstanceOf(expected: ReasonNoTimeframe::class, actual: $responseTimeframes->getReasonNoTimeframes()[0]);
        }
        $this->assertNotTrue(condition: static::containsStdClass(value: $responseTimeframes));
    }

    /**
     * @return array[]
     */
    public function timeframesProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/timeframes/timeframes.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/timeframes/timeframes2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/timeframes/timeframes3.http'))],
        ];
    }

    /** @throws */
    private function getRequestBuilder(): TimeframeServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var TimeframeServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
