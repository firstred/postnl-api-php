<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Unit\Service;

use Cache\Adapter\Void\VoidCachePool;
use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Request\FindLocationsInAreaRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsGeocodeRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsRequest;
use Firstred\PostNL\Entity\Request\LookupLocationRequest;
use Firstred\PostNL\Entity\Response\FindNearestLocationsGeocodeResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsResponse;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LocationService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class LocationServiceTest
 *
 * @testdox The LocationService (REST)
 */
class LocationServiceTest extends TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var LocationService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            Customer::create()
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress(
                    Address::create(
                        [
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]
                    )
                )
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'),
            'test',
            false
        );

        $this->service = $this->postnl->getLocationService();
        $this->service->cache = new VoidCachePool();
        $this->service->ttl = 1;
    }

    /**
     * @after
     */
    public function logPendingRequest()
    {
        if (!$this->lastRequest instanceof RequestInterface) {
            return;
        }

        global $logger;
        if ($logger instanceof LoggerInterface) {
            $logger->debug($this->getName()." Request\n".Message::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Creates a valid NearestLocations request
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function testFindNearestLocationsRequestRest()
    {
        /** @var RequestInterface $request */
        $this->lastRequest = $request = $this->service->buildFindNearestLocationsRequest(
            (new FindNearestLocationsRequest())
                ->setCountrycode('NL')
                ->setDeliveryDate('30-07-2019')
                ->setDeliveryOptions(['PG', 'PGE'])
                ->setOpeningTime('09:00:00')
                ->setCity('Hoofddorp')
                ->setHouseNumber(42)
                ->setPostalCode('2132WT')
                ->setStreet('Siriusdreef')
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            [
                'DeliveryOptions' => 'PG,PGE',
                'City'            => 'Hoofddorp',
                'Street'          => 'Siriusdreef',
                'HouseNumber'     => '42',
                'DeliveryDate'    => '30-07-2019',
                'OpeningTime'     => '09:00:00',
                'PostalCode'      => '2132WT',
                'CountryCode'     => 'NL',
            ],
            $query
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @testdox Can handle situations where no locations could be found
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function testNoLocationsFound()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/nonearestlocations.json')))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->findNearestLocations('2132WT', 'NL', ['PG', 'PGE'], 'Hoofddorp', 'Siriusdreef', 42, '30-07-2019', '09:00:00');

        $this->assertInstanceOf(FindNearestLocationsResponse::class, $response);
        $this->assertEquals(0, count($response));
        $this->assertEquals(1, count($response->getWarnings()));
    }

    /**
     * @testdox Can request nearest locations
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function testGetNearestLocationsRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/nearestlocations.json')))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->findNearestLocations('2132WT', 'NL', ['PG', 'PGE'], 'Hoofddorp', 'Siriusdreef', 42, '30-07-2019', '09:00:00');

        $this->assertInstanceOf(FindNearestLocationsResponse::class, $response);
        $this->assertEquals(20, count($response));
    }

    /**
     * @testdox Can create a  nearest locations by coordinates request
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testFindNearestLocationsGeocodeRequest()
    {
        /** @var RequestInterface $request */
        $this->lastRequest = $request = $this->service->buildFindNearestLocationsGeocodeRequest(
            (new FindNearestLocationsGeocodeRequest())
                ->setCountrycode('NL')
                ->setLatitude(52.156439)
                ->setLongitude('5.015643')
                ->setDeliveryOptions(['PG', 'PGE'])
                ->setDeliveryDate('03-07-2019')
                ->setOpeningTime('09:00')
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            [
                'DeliveryOptions' => 'PG,PGE',
                'Latitude'        => '52.156439',
                'Longitude'       => '5.015643',
                'DeliveryDate'    => '03-07-2019',
                'OpeningTime'     => '09:00:00',
                'CountryCode'     => 'NL',
            ],
            $query
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws Exception
     */
    public function testFindNearestLocationsGeocode()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/nearestlocationsgeocode.json')))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->findNearestLocationsGeocode(
            52.156439,
            '5.015643',
            'NL',
            ['PG', 'PGE'],
            '03-07-2019',
            '09:00'
        );

        $this->assertInstanceOf(FindNearestLocationsGeocodeResponse::class, $response);
        $this->assertEquals(20, count($response));
    }

    /**
     * @testdox Can create a  nearest locations by coordinates request
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testFindLocationsInAreaRequest()
    {
        /** @var RequestInterface $request */
        $this->lastRequest = $request = $this->service->buildFindLocationsInAreaRequest(
            (new FindLocationsInAreaRequest())
                ->setCountrycode('NL')
                ->setLatitudeNorth(52.156439)
                ->setLongitudeWest('5.015643')
                ->setLatitudeSouth('52.017473')
                ->setLongitudeEast(5.065254)
                ->setDeliveryOptions(['PG', 'PGE'])
                ->setDeliveryDate('03-07-2019')
                ->setOpeningTime('09:00')
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            [
                'DeliveryOptions' => 'PG,PGE',
                'DeliveryDate'    => '03-07-2019',
                'OpeningTime'     => '09:00:00',
                'CountryCode'     => 'NL',
                'LatitudeNorth' => '52.156439',
                'LongitudeWest' => '5.015643',
                'LatitudeSouth' => '52.017473',
                'LongitudeEast' => '5.065254',
            ],
            $query
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws Exception
     */
    public function testFindLocationsInArea()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/nearestlocationsgeocode.json')))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->findNearestLocationsGeocode(
            52.156439,
            '5.015643',
            'NL',
            ['PG', 'PGE'],
            '03-07-2019',
            '09:00'
        );

        $this->assertInstanceOf(FindNearestLocationsGeocodeResponse::class, $response);
        $this->assertEquals(20, count($response));
    }

    /**
     * @testdox Creates a valid LookupLocationRequest request
     *
     * @throws Exception
     */
    public function testGetLocationRequest()
    {
        /** @var RequestInterface $request */
        $this->lastRequest = $request = $this->service->buildLookupLocationRequest(
            (new LookupLocationRequest())
                ->setLocationCode('161503')
                ->setRetailNetworkID('PNPNL-01')
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            [
                'LocationCode'    => '161503',
                'RetailNetworkID' => 'PNPNL-01',
            ],
            $query
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws Exception
     */
    public function testGetLocationRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/lookuplocation.json')))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->getLocation(
            (new LookupLocationRequest())
                ->setLocationCode('161503')
                ->setRetailNetworkID('PNPNL-01')
        );

        $this->assertInstanceOf(Location::class, $response);
    }
}
