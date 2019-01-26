<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\CoordinatesNorthWest;
use Firstred\PostNL\Entity\CoordinatesSouthEast;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LocationService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class LocationServiceSoapTest
 *
 * @testdox The LocationService (SOAP)
 */
class LocationServiceSoapTest extends TestCase
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
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
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
     * @testdox Creates a valid NearestLocations request
     *
     * @throws \Exception
     */
    public function testGetNearestLocationsRequestSoap()
    {
        $message = new Message();

        /** @var Request $request */
        $this->lastRequest = $request = $this->service->buildGetNearestLocationsRequest(
            (new GetNearestLocations())
                ->setMessage($message)
                ->setCountrycode('NL')
                ->setLocation(
                    Location::create(
                        [
                            'AllowSundaySorting' => true,
                            'DeliveryDate'       => '29-06-2016',
                            'DeliveryOptions'    => [
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
                        ]
                    )
                )
        );

        $this->assertEquals(
            "<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LocationWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LocationWebService/\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
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
",
            (string) $request->getBody()
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can request nearest locations
     *
     * @throws \Exception
     */
    public function testGetNearestLocationsSoap()
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    ['Content-Type' => 'application/json;charset=UTF-8'],
                    static::getNearestLocationsMockResponse()
                ),
            ]
        );
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getNearestLocations(
            (new GetNearestLocations())
                ->setCountrycode('NL')
                ->setLocation(
                    Location::create(
                        [
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
                        ]
                    )
                )
        );

        $this->assertInstanceOf('\\Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse', $response);
        $this->assertEquals(1, count($response->getGetLocationsResult()));
    }

    /**
     * @testdox Creates a valid GetLocationsInArea request
     *
     * @throws \Exception
     */
    public function testGetLocationsInAreaRequestSoap()
    {
        $message = new Message();

        /** @var Request $request */
        $this->lastRequest = $request = $this->service->buildGetLocationsInAreaRequest(
            (new GetLocationsInArea())
                ->setMessage($message)
                ->setCountrycode('NL')
                ->setLocation(
                    Location::create(
                        [
                            'AllowSundaySorting'   => true,
                            'DeliveryDate'         => '29-06-2016',
                            'DeliveryOptions'      => [
                                'PG',
                            ],
                            'OpeningTime'          => '09:00:00',
                            'Options'              => [
                                'Daytime',
                            ],
                            'CoordinatesNorthWest' => CoordinatesNorthWest::create(
                                [
                                    'Latitude'  => '52.156439',
                                    'Longitude' => '5.015643',
                                ]
                            ),
                            'CoordinatesSouthEast' => CoordinatesSouthEast::create(
                                [
                                    'Latitude'  => '52.017473',
                                    'Longitude' => '5.065254',
                                ]
                            ),
                        ]
                    )
                )
        );


        $this->assertEquals(
            "<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LocationWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LocationWebService/\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
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
",
            (string) $request->getBody()
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws \Exception
     */
    public function testGetLocationsInAreaSoap()
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    ['Content-Type' => 'application/json;charset=UTF-8'],
                    static::getLocationsInAreaMockResponse()
                ),
            ]
        );
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getLocationsInArea(
            (new GetLocationsInArea())
                ->setCountrycode('NL')
                ->setLocation(
                    Location::create(
                        [
                            'AllowSundaySorting'   => true,
                            'DeliveryDate'         => '29-06-2016',
                            'DeliveryOptions'      => [
                                'PG',
                            ],
                            'OpeningTime'          => '09:00:00',
                            'Options'              => [
                                'Daytime',
                            ],
                            'CoordinatesNorthWest' => CoordinatesNorthWest::create(
                                [
                                    'Latitude'  => '52.156439',
                                    'Longitude' => '5.015643',
                                ]
                            ),
                            'CoordinatesSouthEast' => CoordinatesSouthEast::create(
                                [
                                    'Latitude'  => '52.017473',
                                    'Longitude' => '5.065254',
                                ]
                            ),
                        ]
                    )
                )
        );

        $this->assertInstanceOf('\\Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse', $response);
        $this->assertEquals(1, count($response->getGetLocationsResult()));
    }

    /**
     * @testdox Creates a valid GetLocation request
     *
     * @throws \Exception
     */
    public function testGetLocationRequestSoap()
    {
        $message = new Message();

        /** @var Request $request */
        $this->lastRequest = $request = $this->service->buildGetLocationRequest(
            (new GetLocation())
                ->setLocationCode('161503')
                ->setMessage($message)
                ->setRetailNetworkID('PNPNL-01')
        );


        $this->assertEquals(
            "<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LocationWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LocationWebService/\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
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
",
            (string) $request->getBody()
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can request locations in area
     *
     * @throws \Exception
     */
    public function testGetLocationSoap()
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    ['Content-Type' => 'application/json;charset=UTF-8'],
                    static::getLocationMockResponse()
                ),
            ]
        );
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getLocation(
            (new GetLocation())
                ->setLocationCode('161503')
                ->setRetailNetworkID('PNPNL-01')
        );

        $this->assertInstanceOf('\\Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse', $response);
        $this->assertEquals(1, count($response->getGetLocationsResult()));
    }

    /**
     * @return string
     */
    protected function getNearestLocationsMockResponse(): string
    {
        return '<?xml version="1.0"?>
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <GetNearestLocationsResponse xmlns="http://postnl.nl/cif/services/LocationWebService/"
xmlns:a="http://postnl.nl/cif/domain/LocationWebService/">
      <a:GetLocationsResult>
        <a:ResponseLocation>
          <a:Address>
            <a:City>Hoofddorp</a:City>
            <a:Countrycode>NL</a:Countrycode>
            <a:HouseNr>10</a:HouseNr>
            <a:Remark>Dit is een Business Point. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.</a:Remark>
            <a:Street>Jacobus Spijkerdreef</a:Street>
            <a:Zipcode>2132PZ</a:Zipcode>
          </a:Address>
          <a:DeliveryOptions xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
            <b:string>DO</b:string>
            <b:string>PG</b:string>
            <b:string>PGE</b:string>
            <b:string>UL</b:string>
          </a:DeliveryOptions>
          <a:Distance>355</a:Distance>
          <a:Latitude>52.2864669620795</a:Latitude>
          <a:LocationCode>173187</a:LocationCode>
          <a:Longitude>4.68239055845954</a:Longitude>
          <a:Name>Gamma</a:Name>
          <a:OpeningHours>
            <a:Friday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
              <b:string>08:00-18:30</b:string>
            </a:Friday>
            <a:Monday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
              <b:string>08:00-18:30</b:string>
            </a:Monday>
            <a:Saturday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
              <b:string>08:00-17:00</b:string>
            </a:Saturday>
            <a:Thursday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
              <b:string>08:00-18:30</b:string>
            </a:Thursday>
            <a:Tuesday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
              <b:string>08:00-18:30</b:string>
            </a:Tuesday>
            <a:Wednesday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
              <b:string>08:00-18:30</b:string>
            </a:Wednesday>
          </a:OpeningHours>
          <a:PartnerName>PostNL</a:PartnerName>
          <a:PhoneNumber>023-5576310</a:PhoneNumber>
          <a:RetailNetworkID>PNPNL-01</a:RetailNetworkID>
          <a:Saleschannel>PKT XL</a:Saleschannel>
          <a:TerminalType>NRS</a:TerminalType>
        </a:ResponseLocation>
      </a:GetLocationsResult>
    </GetNearestLocationsResponse>
  </s:Body>
</s:Envelope>';
    }

    /**
     * @return string
     */
    protected function getLocationsInAreaMockResponse()
    {
        return '<?xml version="1.0"?>
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
   <s:Body>
      <GetLocationsInAreaResponse xmlns="http://postnl.nl/cif/services/LocationWebService/"
xmlns:a="http://postnl.nl/cif/domain/LocationWebService/">
         <a:GetLocationsResult>
            <a:ResponseLocation>
               <a:Address>
                  <a:City>de Meern</a:City>
                  <a:Countrycode>NL</a:Countrycode>
                  <a:HouseNr>22</a:HouseNr>
                  <a:Remark>&lt;b>Brieven en pakketten die je ma t/m vr afgeeft, worden uiterlijk om 18.00 uur dezelfde dag opgehaald voor bezorging &lt;/b></a:Remark>
                  <a:Street>Mereveldplein</a:Street>
                  <a:Zipcode>3454CK</a:Zipcode>
               </a:Address>
               <a:DeliveryOptions xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                  <b:string>DO</b:string>
                  <b:string>PG</b:string>
                  <b:string>UL</b:string>
               </a:DeliveryOptions>
               <a:Distance>355</a:Distance>
               <a:Latitude>52.0794943427349</a:Latitude>
               <a:LocationCode>175812</a:LocationCode>
               <a:Longitude>5.03762153082277</a:Longitude>
               <a:Name>Kantoorboekhandel Kees Visscher</a:Name>
               <a:OpeningHours>
                  <a:Friday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:30-18:00</b:string>
                  </a:Friday>
                  <a:Monday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:30-18:00</b:string>
                  </a:Monday>
                  <a:Saturday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:30-17:00</b:string>
                  </a:Saturday>
                  <a:Thursday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:30-18:00</b:string>
                  </a:Thursday>
                  <a:Tuesday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:30-18:00</b:string>
                  </a:Tuesday>
                  <a:Wednesday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:30-18:00</b:string>
                  </a:Wednesday>
               </a:OpeningHours>
               <a:PhoneNumber>030-6662230</a:PhoneNumber>
               <a:RetailNetworkID>PNPNL-01</a:RetailNetworkID>
               <a:Saleschannel>PKT M</a:Saleschannel>
               <a:TerminalType>NRS</a:TerminalType>
            </a:ResponseLocation>
            </a:GetLocationsResult>
      </GetLocationsInAreaResponse>
   </s:Body>
</s:Envelope>';
    }

    /**
     * @return string
     */
    protected function getLocationMockResponse()
    {
        return '<?xml version="1.0"?>
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
   <s:Body>
      <GetLocationsInAreaResponse xmlns="http://postnl.nl/cif/services/LocationWebService/"
xmlns:a="http://postnl.nl/cif/domain/LocationWebService/">
         <a:GetLocationsResult>
            <a:ResponseLocation>
               <a:Address>
                  <a:City>Hoofddorp</a:City>
                  <a:Countrycode>NL</a:Countrycode>
                  <a:HouseNr>10</a:HouseNr>
                  <a:Remark>&lt;b>Brieven en pakketten die je ma t/m vr afgeeft, worden uiterlijk om 18.00 uur dezelfde dag opgehaald voor bezorging &lt;/b></a:Remark>
                  <a:Street>Jacobus Spijkerdreef</a:Street>
                  <a:Zipcode>2132PZ</a:Zipcode>
               </a:Address>
               <a:DeliveryOptions xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                  <b:string>DO</b:string>
               </a:DeliveryOptions>
               <a:Latitude>52.2864669620795</a:Latitude>
               <a:LocationCode>161503</a:LocationCode>
               <a:Longitude>4.68239055845954</a:Longitude>
               <a:Name>Gamma</a:Name>
               <a:OpeningHours>
                  <a:Friday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:00-18:30</b:string>
                  </a:Friday>
                  <a:Monday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:00-18:30</b:string>
                  </a:Monday>
                  <a:Saturday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:00-17:00</b:string>
                  </a:Saturday>
                  <a:Thursday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:00-18:30</b:string>
                  </a:Thursday>
                  <a:Tuesday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:00-18:30</b:string>
                  </a:Tuesday>
                  <a:Wednesday xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                     <b:string>08:00-18:30</b:string>
                  </a:Wednesday>
               </a:OpeningHours>
               <a:PhoneNumber>023-5576310</a:PhoneNumber>
               <a:RetailNetworkID>PNPNL-01</a:RetailNetworkID>
               <a:Saleschannel>PKT XL</a:Saleschannel>
               <a:TerminalType>NRS</a:TerminalType>
            </a:ResponseLocation>
         </a:GetLocationsResult>
      </GetLocationsInAreaResponse>
   </s:Body>
</s:Envelope>';
    }
}
