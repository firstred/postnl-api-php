<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Tests\Service;

use Cache\Adapter\Void\VoidCachePool;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\CoordinatesNorthWest;
use ThirtyBees\PostNL\Entity\CoordinatesSouthEast;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Location;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\GetLocation;
use ThirtyBees\PostNL\Entity\Request\GetLocationsInArea;
use ThirtyBees\PostNL\Entity\Request\GetNearestLocations;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\LocationService;

/**
 * Class LocationServiceRestTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The LocationService (SOAP)
 */
class LocationServiceRestTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var LocationService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
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
                ->setGlobalPackCustomerCode('1234')
            , new UsernameToken(null, 'test'),
            false,
            PostNL::MODE_SOAP
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
        if (!$this->lastRequest instanceof Request) {
            return;
        }

        global $logger;
        if ($logger instanceof LoggerInterface) {
            $logger->debug($this->getName()." Request\n".\GuzzleHttp\Psr7\str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox creates a valid NearestLocations request
     */
    public function testGetNearestLocationsRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetNearestLocationsRESTRequest(
            (new GetNearestLocations())
                ->setMessage($message)
                ->setCountrycode('NL')
                ->setLocation(Location::create([
                    'AllowSundaySorting' => true,
                    'DeliveryDate'       => '29-06-2016',
                    'DeliveryOptions'    => [
                        'PGE',
                    ],
                    'OpeningTime'        => '09:00:00',
                    'Options'    => [
                        'Daytime'
                    ],
                    'City'               => 'Hoofddorp',
                    'HouseNr'            => '42',
                    'HouseNrExt'         => 'A',
                    'Postalcode'         => '2132WT',
                    'Street'             => 'Siriusdreef',
                ]))
        );

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals([
            'DeliveryOptions' => 'PG,PGE',
            'City'            => 'Hoofddorp',
            'Street'          => 'Siriusdreef',
            'HouseNumber'     => '42',
            'DeliveryDate'    => '29-06-2016',
            'OpeningTime'     => '09:00:00',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @testdox creates a valid GetLocationsInArea request
     */
    public function testGetLocationsInAreaRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetLocationsInAreaRESTRequest(
            (new GetLocationsInArea())
                ->setMessage($message)
                ->setCountrycode('NL')
                ->setLocation(Location::create([
                    'AllowSundaySorting'   => true,
                    'DeliveryDate'         => '29-06-2016',
                    'DeliveryOptions'      => [
                        'PG',
                    ],
                    'OpeningTime'          => '09:00:00',
                    'Options'              => [
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

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals([
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
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @testdox creates a valid GetLocation request
     */
    public function testGetLocationRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetLocationRESTRequest(
            (new GetLocation())
                ->setLocationCode('161503')
                ->setMessage($message)
                ->setRetailNetworkID('PNPNL-01')
        );

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals([
            'LocationCode'    => '161503',
            'RetailNetworkID' => 'PNPNL-01',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
    }
}
