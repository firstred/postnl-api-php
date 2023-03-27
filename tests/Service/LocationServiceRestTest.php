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

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\CoordinatesNorthWest;
use Firstred\PostNL\Entity\CoordinatesSouthEast;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\ResponseLocation;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LocationServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\LocationServiceRestRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;
use function file_get_contents;
use const _RESPONSES_DIR_;

/**
 * @testdox The LocationService (REST)
 */
class LocationServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected LocationServiceInterface $service;
    protected RequestInterface $lastRequest;

    /** @throws */
    #[Before]
    public function setupPostNL(): void
    {
        $this->postnl = new PostNL(
            customer: Customer::create()
                ->setCollectionLocation(CollectionLocation: '123456')
                ->setCustomerCode(CustomerCode: 'DEVC')
                ->setCustomerNumber(CustomerNumber: '11223344')
                ->setContactPerson(ContactPerson: 'Test')
                ->setAddress(Address: Address::create(properties: [
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]))
                ->setGlobalPackBarcodeType(GlobalPackBarcodeType: 'AB')
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'), apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: false,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getLocationService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid NearestLocations request')]
    public function testGetNearestLocationsRequestRest(): void
    {
        $message = new Message();

        /* @var Request $request */
        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetNearestLocationsRequest(
            getNearestLocations: (new GetNearestLocations())
                ->setMessage(Message: $message)
                ->setCountrycode(Countrycode: 'NL')
                ->setLocation(Location: Location::create(properties: [
                    'AllowSundaySorting' => true,
                    'DeliveryDate'       => '29-06-2016',
                    'DeliveryOptions'    => [
                        'PG',
                        'PGE',
                    ],
                    'OpeningTime'        => '09:00:00',
                    'Options'            => [
                        'Daytime',
                    ],
                    'City'               => 'Hoofddorp',
                    'HouseNr'            => '42',
                    'HouseNrExt'         => 'A',
                    'Postalcode'         => '2132WT',
                    'Street'             => 'Siriusdreef',
                ]))
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing(expected: [
            'DeliveryOptions' => 'PG',
            'City'            => 'Hoofddorp',
            'Street'          => 'Siriusdreef',
            'HouseNumber'     => '42',
            'DeliveryDate'    => '29-06-2016',
            'OpeningTime'     => '09:00:00',
            'PostalCode'      => '2132WT',
            'CountryCode'     => 'NL',
        ], actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine(header: 'apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine(header: 'Accept'));
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws
     */
    #[TestDox(text: 'can request nearest locations')]
    #[DataProvider(methodName: 'nearestLocationsByPostcodeProvider')]
    public function testGetNearestLocationsRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getNearestLocations(getNearestLocations: (new GetNearestLocations())
            ->setCountrycode(Countrycode: 'NL')
            ->setLocation(Location: Location::create(properties: [
                'AllowSundaySorting' => true,
                'DeliveryDate'       => '29-06-2016',
                'DeliveryOptions'    => [
                    'PG',
                    'PGE',
                ],
                'OpeningTime'        => '09:00:00',
                'Options'            => [
                    'Daytime',
                ],
                'City'               => 'Hoofddorp',
                'HouseNr'            => '42',
                'HouseNrExt'         => 'A',
                'Postalcode'         => '2132WT',
                'Street'             => 'Siriusdreef',
            ])));

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
    #[TestDox(text: 'creates a valid `GetLocationsInArea` request')]
    public function testGetLocationsInAreaRequestRest(): void
    {
        $message = new Message();

        /* @var Request $request */
        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetLocationsInAreaRequest(
            getLocations: (new GetLocationsInArea())
                ->setMessage(Message: $message)
                ->setCountrycode(Countrycode: 'NL')
                ->setLocation(Location: Location::create(properties: [
                    'AllowSundaySorting'   => true,
                    'DeliveryDate'         => '29-06-2016',
                    'DeliveryOptions'      => [
                        'PG',
                    ],
                    'OpeningTime'          => '09:00:00',
                    'Options'              => [
                        'Daytime',
                    ],
                    'CoordinatesNorthWest' => CoordinatesNorthWest::create(properties: [
                        'Latitude'  => '52.156439',
                        'Longitude' => '5.015643',
                    ]),
                    'CoordinatesSouthEast' => CoordinatesSouthEast::create(properties: [
                        'Latitude'  => '52.017473',
                        'Longitude' => '5.065254',
                    ]),
                ]))
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing(expected: [
            'DeliveryOptions' => 'PG',
            'LatitudeNorth'   => '52.156439',
            'LongitudeWest'   => '5.015643',
            'LatitudeSouth'   => '52.017473',
            'LongitudeEast'   => '5.065254',
            'DeliveryDate'    => '29-06-2016',
            'OpeningTime'     => '09:00:00',
        ], actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine(header: 'apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine(header: 'Accept'));
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws
     */
    #[TestDox(text: 'can request locations in area')]
    #[DataProvider(methodName: 'locationsInAreaProvider')]
    public function testGetLocationsInAreaRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getLocationsInArea(getLocationsInArea: (new GetLocationsInArea())
            ->setCountrycode(Countrycode: 'NL')
            ->setLocation(Location: Location::create(properties: [
                'AllowSundaySorting'   => true,
                'DeliveryDate'         => '29-06-2016',
                'DeliveryOptions'      => [
                    'PG',
                ],
                'OpeningTime'          => '09:00:00',
                'Options'              => [
                    'Daytime',
                ],
                'CoordinatesNorthWest' => CoordinatesNorthWest::create(properties: [
                    'Latitude'  => '52.156439',
                    'Longitude' => '5.015643',
                ]),
                'CoordinatesSouthEast' => CoordinatesSouthEast::create(properties: [
                    'Latitude'  => '52.017473',
                    'Longitude' => '5.065254',
                ]),
            ])));

        $this->assertInstanceOf(expected: GetLocationsInAreaResponse::class, actual: $response);
        $this->assertEquals(expected: 20, actual: count(value: (array) $response->getGetLocationsResult()->getResponseLocation()));
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid `GetLocation` request')]
    public function testGetLocationRequestRest(): void
    {
        $message = new Message();

        /* @var Request $request */
        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetLocationRequest(
            (new GetLocation())
                ->setLocationCode(LocationCode: '161503')
                ->setMessage(Message: $message)
                ->setRetailNetworkID(RetailNetworkID: 'PNPNL-01')
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing(expected: [
            'LocationCode'    => '161503',
            'RetailNetworkID' => 'PNPNL-01',
        ], actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine(header: 'apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine(header: 'Accept'));
    }

    /** @throws */
    #[TestDox(text: 'can request locations in area')]
    #[DataProvider(methodName: 'singleLocationProvider')]
    public function testGetLocationRest($response)
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getLocation(
            getLocation: (new GetLocation())
                ->setLocationCode(LocationCode: '161503')
                ->setRetailNetworkID(RetailNetworkID: 'PNPNL-01')
        );

        $this->assertInstanceOf(expected: GetLocationsInAreaResponse::class, actual: $response);
        $this->assertCount(expectedCount: 1, haystack: $response->getGetLocationsResult()->getResponseLocation());
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));

        $result = $response->getGetLocationsResult()->getResponseLocation()[0];
        $this->assertEquals(expected: '161503', actual: $result->getLocationCode());
    }

    /**
     * @return array[]
     */
    public function nearestLocationsByPostcodeProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode3.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode4.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function locationsInAreaProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/locationsinarea.http'))],
        ];
    }

    /**
     * @return array[]
     */

    public function singleLocationProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/location/singlelocation.http'))],
        ];
    }

    /** @throws */
    private function getRequestBuilder(): LocationServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var LocationServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
