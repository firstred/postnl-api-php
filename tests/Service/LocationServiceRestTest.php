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
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LocationServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use function file_get_contents;
use const _RESPONSES_DIR_;

/**
 * Class LocationServiceRestTest.
 *
 * @testdox The LocationService (REST)
 */
class LocationServiceRestTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var LocationServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \ReflectionException
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            Customer::create()
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress(Address::create([
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]))
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
            false,
            PostNL::MODE_REST
        );

        global $logger;
        $this->postnl->setLogger($logger);

        $this->service = $this->postnl->getLocationService();
        $this->service->setCache(new VoidCachePool());
        $this->service->setTtl(1);
    }

    /**
     * @testdox creates a valid NearestLocations request
     */
    public function testGetNearestLocationsRequestRest()
    {
        $message = new Message();

        /* @var Request $request */
        $this->lastRequest = $request = $this->service->buildGetNearestLocationsRequestREST(
            (new GetNearestLocations())
                ->setMessage($message)
                ->setCountrycode('NL')
                ->setLocation(Location::create([
                    'AllowSundaySorting' => true,
                    'DeliveryDate'       => '29-06-2016',
                    'DeliveryOptions'    => [
                        'PG',
                        'PGE',
                    ],
                    'OpeningTime' => '09:00:00',
                    'Options'     => [
                        'Daytime',
                    ],
                    'City'       => 'Hoofddorp',
                    'HouseNr'    => '42',
                    'HouseNrExt' => 'A',
                    'Postalcode' => '2132WT',
                    'Street'     => 'Siriusdreef',
                ]))
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing([
            'DeliveryOptions' => 'PG',
            'City'            => 'Hoofddorp',
            'Street'          => 'Siriusdreef',
            'HouseNumber'     => '42',
            'DeliveryDate'    => '29-06-2016',
            'OpeningTime'     => '09:00:00',
            'PostalCode'      => '2132WT',
            'CountryCode'     => 'NL',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can request nearest locations
     * @dataProvider nearestLocationsByPostcodeProvider
     *
     * @param ResponseInterface $response
     */
    public function testGetNearestLocationsRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getNearestLocations((new GetNearestLocations())
            ->setCountrycode('NL')
            ->setLocation(Location::create([
                'AllowSundaySorting' => true,
                'DeliveryDate'       => '29-06-2016',
                'DeliveryOptions'    => [
                    'PG',
                    'PGE',
                ],
                'OpeningTime' => '09:00:00',
                'Options'     => [
                    'Daytime',
                ],
                'City'       => 'Hoofddorp',
                'HouseNr'    => '42',
                'HouseNrExt' => 'A',
                'Postalcode' => '2132WT',
                'Street'     => 'Siriusdreef',
            ])));

        $this->assertInstanceOf(GetNearestLocationsResponse::class, $response);
        $this->assertInstanceOf(ResponseLocation::class, $response->getGetLocationsResult()->getResponseLocation()[0]);

        $this->assertNotTrue(static::containsStdClass($response));

        foreach ($response->getGetLocationsResult()->getResponseLocation() as $responseLocation) {
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                foreach ($responseLocation->getOpeningHours()->{"get$day"}() as $time) {
                    $this->assertIsString($time);
                    $this->assertMatchesRegularExpression(
                        '~^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)-(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$~',
                        $time
                    );
                }
            }
        }
    }

    /**
     * @testdox creates a valid GetLocationsInArea request
     */
    public function testGetLocationsInAreaRequestRest()
    {
        $message = new Message();

        /* @var Request $request */
        $this->lastRequest = $request = $this->service->buildGetLocationsInAreaRequest(
            (new GetLocationsInArea())
                ->setMessage($message)
                ->setCountrycode('NL')
                ->setLocation(Location::create([
                    'AllowSundaySorting' => true,
                    'DeliveryDate'       => '29-06-2016',
                    'DeliveryOptions'    => [
                        'PG',
                    ],
                    'OpeningTime' => '09:00:00',
                    'Options'     => [
                        'Daytime',
                    ],
                    'CoordinatesNorthWest' => CoordinatesNorthWest::create([
                        'Latitude'  => '52.156439',
                        'Longitude' => '5.015643',
                    ]),
                    'CoordinatesSouthEast' => CoordinatesSouthEast::create([
                        'Latitude'  => '52.017473',
                        'Longitude' => '5.065254',
                    ]),
                ]))
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing([
            'DeliveryOptions' => 'PG',
            'LatitudeNorth'   => '52.156439',
            'LongitudeWest'   => '5.015643',
            'LatitudeSouth'   => '52.017473',
            'LongitudeEast'   => '5.065254',
            'DeliveryDate'    => '29-06-2016',
            'OpeningTime'     => '09:00:00',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox      can request locations in area
     * @dataProvider locationsInAreaProvider
     *
     * @param ResponseInterface $response
     *
     * @throws ReflectionException
     */
    public function testGetLocationsInAreaRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getLocationsInArea((new GetLocationsInArea())
            ->setCountrycode('NL')
            ->setLocation(Location::create([
                'AllowSundaySorting' => true,
                'DeliveryDate'       => '29-06-2016',
                'DeliveryOptions'    => [
                    'PG',
                ],
                'OpeningTime' => '09:00:00',
                'Options'     => [
                    'Daytime',
                ],
                'CoordinatesNorthWest' => CoordinatesNorthWest::create([
                    'Latitude'  => '52.156439',
                    'Longitude' => '5.015643',
                ]),
                'CoordinatesSouthEast' => CoordinatesSouthEast::create([
                    'Latitude'  => '52.017473',
                    'Longitude' => '5.065254',
                ]),
            ])));

        $this->assertInstanceOf(GetLocationsInAreaResponse::class, $response);
        $this->assertEquals(20, count((array) $response->getGetLocationsResult()->getResponseLocation()));
        $this->assertNotTrue(static::containsStdClass($response));
    }

    /**
     * @testdox creates a valid GetLocation request
     */
    public function testGetLocationRequestRest()
    {
        $message = new Message();

        /* @var Request $request */
        $this->lastRequest = $request = $this->service->buildGetLocationRequest(
            (new GetLocation())
                ->setLocationCode('161503')
                ->setMessage($message)
                ->setRetailNetworkID('PNPNL-01')
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing([
            'LocationCode'    => '161503',
            'RetailNetworkID' => 'PNPNL-01',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can request locations in area
     * @dataProvider singleLocationProvider
     */
    public function testGetLocationRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getLocation(
            (new GetLocation())
                ->setLocationCode('161503')
                ->setRetailNetworkID('PNPNL-01')
        );

        $this->assertInstanceOf(GetLocationsInAreaResponse::class, $response);
        $this->assertCount(1, $response->getGetLocationsResult()->getResponseLocation());
        $this->assertNotTrue(static::containsStdClass($response));

        $result = $response->getGetLocationsResult()->getResponseLocation()[0];
        $this->assertEquals('161503', $result->getLocationCode());
    }

    public function nearestLocationsByPostcodeProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode2.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode3.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/location/nearestlocationsbypostcode4.http'))],
        ];
    }

    public function locationsInAreaProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/location/locationsinarea.http'))],
        ];
    }

    public function singleLocationProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/location/singlelocation.http'))],
        ];
    }
}
