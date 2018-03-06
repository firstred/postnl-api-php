<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @copyright 2017 Thirty Development, LLC
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
 * Class LocationServiceSoapTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The LocationService (SOAP)
 */
class LocationServiceSoapTest extends \PHPUnit_Framework_TestCase
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
     * @throws \ReflectionException
     */
    public function testGetNearestLocationsRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetNearestLocationsSOAPRequest(
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


        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LocationWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LocationWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GetNearestLocations>
   <domain:Countrycode>NL</domain:Countrycode>
   <domain:Location>
    <domain:AllowSundaySorting>true</domain:AllowSundaySorting>
    <domain:DeliveryDate>29-06-2016</domain:DeliveryDate>
    <domain:DeliveryOptions>
     <arr:string>PGE</arr:string>
    </domain:DeliveryOptions>
    <domain:OpeningTime>09:00:00</domain:OpeningTime>
    <domain:Options>
     <arr:string>Daytime</arr:string>
    </domain:Options>
    <domain:City>Hoofddorp</domain:City>
    <domain:HouseNr>42</domain:HouseNr>
    <domain:HouseNrExt>A</domain:HouseNrExt>
    <domain:Postalcode>2132WT</domain:Postalcode>
    <domain:Street>Siriusdreef</domain:Street>
   </domain:Location>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
  </services:GetNearestLocations>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox creates a valid GetLocationsInArea request
     * @throws \ReflectionException
     */
    public function testGetLocationsInAreaRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetLocationsInAreaSOAPRequest(
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


        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LocationWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LocationWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GetLocationsInArea>
   <domain:Countrycode>NL</domain:Countrycode>
   <domain:Location>
    <domain:AllowSundaySorting>true</domain:AllowSundaySorting>
    <domain:DeliveryDate>29-06-2016</domain:DeliveryDate>
    <domain:DeliveryOptions>
     <arr:string>PG</arr:string>
    </domain:DeliveryOptions>
    <domain:OpeningTime>09:00:00</domain:OpeningTime>
    <domain:Options>
     <arr:string>Daytime</arr:string>
    </domain:Options>
    <domain:CoordinatesNorthWest>
     <domain:Latitude>52.156439</domain:Latitude>
     <domain:Longitude>5.015643</domain:Longitude>
    </domain:CoordinatesNorthWest>
    <domain:CoordinatesSouthEast>
     <domain:Latitude>52.017473</domain:Latitude>
     <domain:Longitude>5.065254</domain:Longitude>
    </domain:CoordinatesSouthEast>
   </domain:Location>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
  </services:GetLocationsInArea>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox creates a valid GetLocation request
     */
    public function testGetLocationRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetLocationSOAPRequest(
            (new GetLocation())
                ->setLocationCode('161503')
                ->setMessage($message)
                ->setRetailNetworkID('PNPNL-01')
        );


        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LocationWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LocationWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GetLocation>
   <domain:LocationCode>161503</domain:LocationCode>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:RetailNetworkID>PNPNL-01</domain:RetailNetworkID>
  </services:GetLocation>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }
}
