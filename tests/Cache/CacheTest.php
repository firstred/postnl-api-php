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

namespace Firstred\PostNL\Tests\Cache;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\ResponseLocation;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Tests\Service\ServiceTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use OutOfBoundsException;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Clock\MockClock;

use function file_get_contents;

use const _RESPONSES_DIR_;

#[TestDox(text: 'The cache')]
class CacheTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected RequestInterface $lastRequest;
    protected MockClock $mockClock;

    /** @throws */
    #[Before]
    public function setupPostNL(): void
    {
        $this->mockClock = new MockClock(now: '2016-06-29 15:20:00');

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

        $this->postnl->getDeliveryDateService()->setClock(clock: $this->mockClock);
        $this->postnl->getDeliveryDateService()->setCache(cache: new MemoryClockAwareCacheItemPool(clock: $this->mockClock));

        $this->postnl->getTimeframeService()->setClock(clock: $this->mockClock);
        $this->postnl->getTimeframeService()->setCache(cache: new MemoryClockAwareCacheItemPool(clock: $this->mockClock));

        $this->postnl->getLocationService()->setClock(clock: $this->mockClock);
        $this->postnl->getLocationService()->setCache(cache: new MemoryClockAwareCacheItemPool(clock: $this->mockClock));

        $this->postnl->getShippingStatusService()->setClock(clock: $this->mockClock);
        $this->postnl->getShippingStatusService()->setCache(cache: new MemoryClockAwareCacheItemPool(clock: $this->mockClock));
    }

    /** @throws */
    #[TestDox(text: "can cache a 'get delivery date' request")]
    #[DataProvider(methodName: 'singleDeliveryDateResponseProvider')]
    public function testCacheDeliveryDateResponse(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getDeliveryDateService()->setTtl(ttl: DateTimeImmutable::createFromFormat(format: 'Y-m-d H:i:s', datetime: '2016-06-29 16:00:00'));

        foreach (range(start: 0, end: 10) as $ignored) {
            $response = $this->postnl->getDeliveryDate(
                getDeliveryDate: (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        GetDeliveryDate: (new GetDeliveryDate())
                            ->setAllowSundaySorting(AllowSundaySorting: 'false')
                            ->setCity(City: 'Hoofddorp')
                            ->setCountryCode(CountryCode: 'NL')
                            ->setCutOffTimes(CutOffTimes: [
                                new CutOffTime(Day: '00', Time: '16:00:00'),
                            ])
                            ->setHouseNr(HouseNr: '42')
                            ->setHouseNrExt(HouseNrExt: 'A')
                            ->setOptions(Options: [
                                'Daytime',
                            ])
                            ->setPostalCode(PostalCode: '2132WT')
                            ->setShippingDate(shippingDate: $this->mockClock->now())
                            ->setShippingDuration(ShippingDuration: '1')
                            ->setStreet(Street: 'Siriusdreef')
                    )
            );
        }

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceof(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
        $this->assertEquals(expected: 'Daytime', actual: $response->getOptions()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @throws */
    #[TestDox(text: 'checks the cache key for uniqueness')]
    #[DataProvider(methodName: 'singleDeliveryDateResponseProvider')]
    public function testChecksTheCacheKeyForUniqueness(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getDeliveryDateService()->setTtl(ttl: DateTimeImmutable::createFromFormat(format: 'Y-m-d H:i:s', datetime: '2016-06-29 16:00:00'));

        $postalCode = '2132WT';
        foreach (range(start: 0, end: 1) as $ignored) {
            $response = $this->postnl->getDeliveryDate(
                getDeliveryDate: (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        GetDeliveryDate: (new GetDeliveryDate())
                            ->setAllowSundaySorting(AllowSundaySorting: 'false')
                            ->setCity(City: 'Hoofddorp')
                            ->setCountryCode(CountryCode: 'NL')
                            ->setCutOffTimes(CutOffTimes: [
                                new CutOffTime(Day: '00', Time: '16:00:00'),
                            ])
                            ->setHouseNr(HouseNr: '42')
                            ->setHouseNrExt(HouseNrExt: 'A')
                            ->setOptions(Options: [
                                'Daytime',
                            ])
                            ->setPostalCode(PostalCode: $postalCode)
                            ->setShippingDate(shippingDate: $this->mockClock->now())
                            ->setShippingDuration(ShippingDuration: '1')
                            ->setStreet(Street: 'Siriusdreef')
                    )
            );
            $postalCode = '1234AB';
            $this->expectException(exception: OutOfBoundsException::class);
        }

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceof(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
        $this->assertEquals(expected: 'Daytime', actual: $response->getOptions()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @throws */
    #[TestDox(text: "can cache a 'get timeframes' request")]
    #[DataProvider(methodName: 'timeframesProvider')]
    public function testCacheTimeframesResponse(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getTimeframeService()->setTtl(ttl: DateTimeImmutable::createFromFormat(format: 'Y-m-d H:i:s', datetime: '2016-06-29 16:00:00'));

        $responseTimeframes = null;
        foreach (range(start: 0, end: 10) as $ignored) {
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
        }

        // Should be a ResponseTimeframes instance
        $this->assertInstanceOf(expected: ResponseTimeframes::class, actual: $responseTimeframes);
        // Check for data loss
        $this->assertInstanceOf(expected: Timeframe::class, actual: $responseTimeframes->getTimeframes()[0]);
        if (count(value: $responseTimeframes->getReasonNoTimeframes())) {
            $this->assertInstanceOf(expected: ReasonNoTimeframe::class, actual: $responseTimeframes->getReasonNoTimeframes()[0]);
        }
        $this->assertNotTrue(condition: static::containsStdClass(value: $responseTimeframes));
    }

    /** @throws */
    #[TestDox(text: "can cache a 'get nearest locations' request")]
    #[DataProvider(methodName: 'nearestLocationsByPostcodeProvider')]
    public function testCacheLocationResponse(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getLocationService()->setTtl(ttl: DateTimeImmutable::createFromFormat(format: 'Y-m-d H:i:s', datetime: '2016-06-29 16:00:00'));

        foreach (range(start: 0, end: 10) as $ignored) {
            $response = $this->postnl->getNearestLocations(getNearestLocations: (new GetNearestLocations())
                ->setCountrycode(Countrycode: 'NL')
                ->setLocation(Location: new Location(
                    Postalcode: '2132WT',
                    AllowSundaySorting: true,
                    DeliveryDate: '29-06-2016',
                    DeliveryOptions: ['PG', 'PGE'],
                    OpeningTime: '09:00:00',
                    Options: ['Daytime'],
                    City: 'Hoofddorp',
                    Street: 'Siriusdreef',
                    HouseNr: '42',
                    HouseNrExt: 'A',
                )));
        }

        $this->assertInstanceOf(expected: GetNearestLocationsResponse::class, actual: $response);
        $this->assertInstanceOf(expected: ResponseLocation::class, actual: $response->getGetLocationsResult()->getResponseLocation()[0]);

        $this->assertNotTrue(condition: static::containsStdClass(value: $response));

        foreach ($response->getGetLocationsResult()->getResponseLocation() as $responseLocation) {
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                foreach ($responseLocation->getOpeningHours()->{"get$day"}() as $time) {
                    $this->assertIsString(actual: $time);
                    $this->assertMatchesRegularExpression(
                        pattern: '~^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)-(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$~',
                        string: $time
                    );
                }
            }
        }
    }

    /** @throws */
    #[TestDox(text: "can cache a 'get updated shipments' request")]
    #[DataProvider(methodName: 'getUpdatedShipmentsProvider')]
    public function testUpdatedShipmentsResponse(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getShippingStatusService()->setTtl(ttl: DateTimeImmutable::createFromFormat(format: 'Y-m-d H:i:s', datetime: '2016-06-29 16:00:00'));

        foreach (range(start: 0, end: 10) as $ignored) {
            $updatedShipments = $this->postnl->getUpdatedShipments(
                dateTimeFrom: new DateTimeImmutable(datetime: '12-02-2021 14:00'),
                dateTimeTo: new DateTimeImmutable(datetime: '12-02-2021 16:00'),
            );
        }

        $this->assertInstanceOf(expected: UpdatedShipmentsResponse::class, actual: $updatedShipments[0]);
    }

    /** @throws */
    #[TestDox(text: 'can expire a response, ttl configured with `DateTimeInterface`')]
    #[DataProvider(methodName: 'singleDeliveryDateResponseProvider')]
    public function testCanExpireADeliveryDateResponseDateTime(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getDeliveryDateService()->setTtl(ttl: DateTimeImmutable::createFromFormat(format: 'Y-m-d H:i:s', datetime: '2016-06-29 16:00:00'));

        foreach (range(start: 0, end: 1) as $ignored) {
            $response = $this->postnl->getDeliveryDate(
                getDeliveryDate: (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        GetDeliveryDate: (new GetDeliveryDate())
                            ->setAllowSundaySorting(AllowSundaySorting: 'false')
                            ->setCity(City: 'Hoofddorp')
                            ->setCountryCode(CountryCode: 'NL')
                            ->setCutOffTimes(CutOffTimes: [
                                new CutOffTime(Day: '00', Time: '16:00:00'),
                            ])
                            ->setHouseNr(HouseNr: '42')
                            ->setHouseNrExt(HouseNrExt: 'A')
                            ->setOptions(Options: [
                                'Daytime',
                            ])
                            ->setPostalCode(PostalCode: '2132WT')
                            ->setShippingDate(shippingDate: $this->mockClock->now())
                            ->setShippingDuration(ShippingDuration: '1')
                            ->setStreet(Street: 'Siriusdreef')
                    )
            );
            $this->mockClock->modify(modifier: '2016-06-29 16:02:00');
            $this->expectException(exception: OutOfBoundsException::class);
        }

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceof(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
        $this->assertEquals(expected: 'Daytime', actual: $response->getOptions()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @throws */
    #[TestDox(text: 'can expire a response, ttl configured with a date interval')]
    #[DataProvider(methodName: 'singleDeliveryDateResponseProvider')]
    public function testCanExpireADeliveryDateResponseDateInterval(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getDeliveryDateService()->setTtl(ttl: new DateInterval(duration: 'PT600S'));

        foreach (range(start: 0, end: 1) as $ignored) {
            $response = $this->postnl->getDeliveryDate(
                getDeliveryDate: (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        GetDeliveryDate: (new GetDeliveryDate())
                            ->setAllowSundaySorting(AllowSundaySorting: 'false')
                            ->setCity(City: 'Hoofddorp')
                            ->setCountryCode(CountryCode: 'NL')
                            ->setCutOffTimes(CutOffTimes: [
                                new CutOffTime(Day: '00', Time: '16:00:00'),
                            ])
                            ->setHouseNr(HouseNr: '42')
                            ->setHouseNrExt(HouseNrExt: 'A')
                            ->setOptions(Options: [
                                'Daytime',
                            ])
                            ->setPostalCode(PostalCode: '2132WT')
                            ->setShippingDate(shippingDate: $this->mockClock->now())
                            ->setShippingDuration(ShippingDuration: '1')
                            ->setStreet(Street: 'Siriusdreef')
                    )
            );
            $this->mockClock->modify(modifier: '2016-06-29 16:02:00');
            $this->expectException(exception: OutOfBoundsException::class);
        }

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceof(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
        $this->assertEquals(expected: 'Daytime', actual: $response->getOptions()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @throws */
    #[TestDox(text: 'can expire a response, ttl configured with seconds int')]
    #[DataProvider(methodName: 'singleDeliveryDateResponseProvider')]
    public function testCanExpireADeliveryDateResponseSecondsInt(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);
        $this->postnl->getDeliveryDateService()->setTtl(ttl: 500);

        foreach (range(start: 0, end: 1) as $ignored) {
            $response = $this->postnl->getDeliveryDate(
                getDeliveryDate: (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        GetDeliveryDate: (new GetDeliveryDate())
                            ->setAllowSundaySorting(AllowSundaySorting: 'false')
                            ->setCity(City: 'Hoofddorp')
                            ->setCountryCode(CountryCode: 'NL')
                            ->setCutOffTimes(CutOffTimes: [
                                new CutOffTime(Day: '00', Time: '16:00:00'),
                            ])
                            ->setHouseNr(HouseNr: '42')
                            ->setHouseNrExt(HouseNrExt: 'A')
                            ->setOptions(Options: [
                                'Daytime',
                            ])
                            ->setPostalCode(PostalCode: '2132WT')
                            ->setShippingDate(shippingDate: $this->mockClock->now())
                            ->setShippingDuration(ShippingDuration: '1')
                            ->setStreet(Street: 'Siriusdreef')
                    )
            );
            $this->mockClock->modify(modifier: '2016-06-29 16:02:00');
            $this->expectException(exception: OutOfBoundsException::class);
        }

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceof(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
        $this->assertEquals(expected: 'Daytime', actual: $response->getOptions()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @return string[][] */
    public static function singleDeliveryDateResponseProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/deliverydate/deliverydate.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public static function timeframesProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/timeframes/timeframes.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public static function nearestLocationsByPostcodeProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public static function getUpdatedShipmentsProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/updatedshipments.http'))],
        ];
    }
}
