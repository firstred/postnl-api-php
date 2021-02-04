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

use Exception;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\Request\GetLocationsInAreaRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsGeocodeRequestDTO;
use Firstred\PostNL\DTO\Request\GetNearestLocationsRequestDTO;
use Firstred\PostNL\DTO\Request\LookupLocationRequestDTO;
use Firstred\PostNL\DTO\Response\GetLocationResponseDTO;
use Firstred\PostNL\DTO\Response\GetLocationsResponseDTO;
use Firstred\PostNL\Exception\ApiDownException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
use Firstred\PostNL\Service\LocationServiceInterface;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use Psr\Http\Message\RequestInterface;
use function file_get_contents;

/**
 * Class LocationServiceTest.
 *
 * @testdox The LocationService (REST)
 */
class LocationServiceTest extends ServiceTestBase
{
    /**
     * @testdox Creates a valid NearestLocations request
     *
     * @throws InvalidArgumentException
     */
    public function testFindNearestLocationsRequestRest()
    {
        $this->lastRequest = $request = $this->postnl->getLocationService()->getGateway()->getRequestBuilder()->buildGetNearestLocationsRequest(
            getNearestLocationsRequestDTO: new GetNearestLocationsRequestDTO(
                service: LocationServiceInterface::class,
                propType: RequestProp::class,

                CountryCode: 'NL',
                PostalCode: '2132WT',
                City: 'Hoofddorp',
                Street: 'Siriusdreef',
                HouseNumber: 42,
                DeliveryDate: '30-07-2019',
                OpeningTime: '09:00:00',
                DeliveryOptions: ['PG', 'PGE'],
            ),
        );

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(
            expected: [
                'DeliveryOptions' => 'PG,PGE',
                'City'            => 'Hoofddorp',
                'Street'          => 'Siriusdreef',
                'HouseNumber'     => '42',
                'DeliveryDate'    => '30-07-2019',
                'OpeningTime'     => '09:00:00',
                'PostalCode'      => '2132WT',
                'CountryCode'     => 'NL',
            ],
            actual: $query
        );

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can handle situations where no locations could be found
     *
     * @throws InvalidArgumentException
     */
    public function testNoNearestLocationsFound()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(filename: __DIR__.'/../../data/responses/nonearestlocations.json')))
        ;
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getLocationService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->getNearestLocations(
            PostalCode: '2132WT',
            DeliveryOptions: ['PG', 'PGE'],
            City: 'Hoofddorp',
            Street: 'Siriusdreef',
            HouseNumber: 42,
            DeliveryDate: '30-07-2019',
            OpeningTime: '09:00:00',
        );

        $this->assertInstanceOf(expected: GetLocationsResponseDTO::class, actual: $response);
        $this->assertEquals(expected: 0, actual: count(value: $response));
        $this->assertEquals(expected: 1, actual: count(value: $response->getWarnings()));
    }

    /**
     * @testdox Can request nearest locations
     */
    public function testGetNearestLocations()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(filename: __DIR__.'/../../data/responses/nearestlocations.json')))
        ;
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getLocationService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->getNearestLocations(
            PostalCode: '2132WT',
            DeliveryOptions: ['PG', 'PGE'],
            City: 'Hoofddorp',
            Street: 'Siriusdreef',
            HouseNumber: 42,
            DeliveryDate: '30-07-2019',
            OpeningTime: '09:00:00',
        );

        $this->assertInstanceOf(expected: GetLocationsResponseDTO::class, actual: $response);
        $this->assertEquals(
            expected: '09:00-21:00',
            actual: $response->getGetLocationsResult()[0]->getOpeningHours()->getFriday()[0],
        );
        $this->assertEquals(expected: 20, actual: count(value: $response));
    }

    /**
     * @testdox Can create a  nearest locations by coordinates request
     *
     * @throws InvalidArgumentException
     */
    public function testFindNearestLocationsGeocodeRequest()
    {
        $this->lastRequest = $request = $this->postnl->getLocationService()->getGateway()->getRequestBuilder()->buildGetNearestLocationsGeocodeRequest(getNearestLocationsGeocodeRequestDTO: new GetNearestLocationsGeocodeRequestDTO(
            service: LocationServiceInterface::class,
            propType: RequestProp::class,

            Latitude: 52.156439,
            Longitude: '5.015643',
            CountryCode: 'NL',
            DeliveryDate: '03-07-2019',
            OpeningTime: '09:00',
            DeliveryOptions: ['PG', 'PGE'],
        ));

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(
            expected: [
                'DeliveryOptions' => 'PG,PGE',
                'Latitude'        => '52.156439',
                'Longitude'       => '5.015643',
                'DeliveryDate'    => '03-07-2019',
                'OpeningTime'     => '09:00:00',
                'CountryCode'     => 'NL',
            ],
            actual: $query
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws Exception
     * @throws HttpClientException
     */
    public function testFindNearestLocationsGeocode()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(filename: __DIR__.'/../../data/responses/nearestlocationsgeocode.json')))
        ;
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getLocationService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->getNearestLocationsByGeolocation(
            Latitude: 52.156439,
            Longitude: 5.015643,
            DeliveryOptions: ['PG', 'PGE'],
            DeliveryDate: '03-07-2019',
            OpeningTime: '09:00'
        );

        $this->assertInstanceOf(expected: GetLocationsResponseDTO::class, actual: $response);
        $this->assertEquals(expected: 20, actual: count(value: $response));
    }

    /**
     * @testdox Can create a nearest locations by coordinates request
     *
     * @throws InvalidArgumentException
     */
    public function testGetLocationsInAreaRequest()
    {
        $this->lastRequest = $request = $this->postnl->getLocationService()->getGateway()->getRequestBuilder()->buildGetLocationsInAreaRequest(getLocationsInAreaRequestDTO: new GetLocationsInAreaRequestDTO(
            service: LocationServiceInterface::class,
            propType: RequestProp::class,

            LatitudeNorth: 52.156439,
            LongitudeWest: '5.015643',
            LatitudeSouth: '52.017473',
            LongitudeEast: 5.065254,
            CountryCode: 'NL',
            DeliveryDate: '03-07-2019',
            OpeningTime: '09:00',
            DeliveryOptions: ['PG', 'PGE'],
        ));

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(
            expected: [
                'DeliveryOptions' => 'PG,PGE',
                'DeliveryDate'    => '03-07-2019',
                'OpeningTime'     => '09:00:00',
                'CountryCode'     => 'NL',
                'LatitudeNorth'   => '52.156439',
                'LongitudeWest'   => '5.015643',
                'LatitudeSouth'   => '52.017473',
                'LongitudeEast'   => '5.065254',
            ],
            actual: $query
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws Exception
     * @throws HttpClientException
     */
    public function testGetLocationsInArea()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(filename: __DIR__.'/../../data/responses/nearestlocationsgeocode.json')))
        ;
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getLocationService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->getNearestLocationsByGeolocation(
            Latitude: 52.156439,
            Longitude: 5.015643,
            DeliveryOptions: ['PG', 'PGE'],
            DeliveryDate: '03-07-2019',
            OpeningTime: '09:00'
        );

        $this->assertInstanceOf(expected: GetLocationsResponseDTO::class, actual: $response);
        $this->assertEquals(expected: 20, actual: count(value: $response));
    }

    /**
     * @testdox Creates a valid LookupLocationRequest request
     */
    public function testLookupLocationRequest()
    {
        /** @var RequestInterface $request */
        $this->lastRequest = $request = $this->postnl->getLocationService()->getGateway()->getRequestBuilder()->buildLookupLocationRequest(lookupLocationRequestDTO: new LookupLocationRequestDTO(
            service: LocationServiceInterface::class,
            propType: RequestProp::class,

            LocationCode: 161503,
            RetailNetworkID: 'PNPNL-01',
        ));

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(
            expected: [
                'LocationCode'    => '161503',
                'RetailNetworkID' => 'PNPNL-01',
            ],
            actual: $query
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws InvalidArgumentException
     */
    public function testLookupLocation()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(filename: __DIR__.'/../../data/responses/lookuplocation.json')))
        ;
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getLocationService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->lookupLocation(
            LocationCode: 161503,
            RetailNetworkID: 'PNPNL-01',
        );

        $this->assertInstanceOf(expected: GetLocationResponseDTO::class, actual: $response);
    }
}
