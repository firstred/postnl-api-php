<?php
/**
 * The MIT License (MIT).
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
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Dimension;
use ThirtyBees\PostNL\Entity\Message\LabellingMessage;
use ThirtyBees\PostNL\Entity\Request\Confirming;
use ThirtyBees\PostNL\Entity\Response\ConfirmingResponseShipment;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\ConfirmingService;
use ThirtyBees\PostNL\Service\ConfirmingServiceInterface;

/**
 * Class ConfirmingServiceSoapTest.
 *
 * @testdox The ConfirmingService (SOAP)
 */
class ConfirmingServiceSoapTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;
    /** @var ConfirmingServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
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
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
            true,
            PostNL::MODE_SOAP
        );

        $this->service = $this->postnl->getConfirmingService();
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
     * @testdox returns a valid service object
     */
    public function testHasValidConfirmingService()
    {
        $this->assertInstanceOf(ConfirmingService::class, $this->service);
    }

    /**
     * @testdox creates a confirm request
     */
    public function testCreatesAValidLabelRequest()
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->service->buildConfirmRequestSOAP(
            Confirming::create()
                ->setShipments([
                    Shipment::create()
                        ->setAddresses([
                            Address::create([
                                'AddressType' => '01',
                                'City'        => 'Utrecht',
                                'Countrycode' => 'NL',
                                'FirstName'   => 'Peter',
                                'HouseNr'     => '9',
                                'HouseNrExt'  => 'a bis',
                                'Name'        => 'de Ruijter',
                                'Street'      => 'Bilderdijkstraat',
                                'Zipcode'     => '3521VA',
                            ]),
                            Address::create([
                                'AddressType' => '02',
                                'City'        => 'Hoofddorp',
                                'CompanyName' => 'PostNL',
                                'Countrycode' => 'NL',
                                'HouseNr'     => '42',
                                'Street'      => 'Siriusdreef',
                                'Zipcode'     => '2132WT',
                            ]),
                        ])
                        ->setBarcode('3S1234567890123')
                        ->setDeliveryAddress('01')
                        ->setDimension(new Dimension('2000'))
                        ->setProductCodeDelivery('3085'),
                ])
                ->setMessage($message)
                ->setCustomer($this->postnl->getCustomer())
        );

        $this->assertXmlStringEqualsXmlString(<<<XML
<?xml version="1.0"?>
<soap:Envelope 
  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:env="http://www.w3.org/2003/05/soap-envelope"
  xmlns:services="http://postnl.nl/cif/services/ConfirmingWebService/"
  xmlns:domain="http://postnl.nl/cif/domain/ConfirmingWebService/" 
  xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" 
  xmlns:schema="http://www.w3.org/2001/XMLSchema-instance" 
  xmlns:common="http://postnl.nl/cif/services/common/"
>
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:Confirming>
   <domain:Customer>
    <domain:Address>
     <domain:AddressType>02</domain:AddressType>
     <domain:City>Hoofddorp</domain:City>
     <domain:CompanyName>PostNL</domain:CompanyName>
     <domain:Countrycode>NL</domain:Countrycode>
     <domain:HouseNr>42</domain:HouseNr>
     <domain:Street>Siriusdreef</domain:Street>
     <domain:Zipcode>2132WT</domain:Zipcode>
    </domain:Address>
    <domain:CollectionLocation>123456</domain:CollectionLocation>
    <domain:ContactPerson>Test</domain:ContactPerson>
    <domain:CustomerCode>DEVC</domain:CustomerCode>
    <domain:CustomerNumber>11223344</domain:CustomerNumber>
   </domain:Customer>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
    <domain:Printertype>GraphicFile|PDF</domain:Printertype>
   </domain:Message>
   <domain:Shipments>
    <domain:Shipment>
     <domain:Addresses>
      <domain:Address>
       <domain:AddressType>01</domain:AddressType>
       <domain:City>Utrecht</domain:City>
       <domain:Countrycode>NL</domain:Countrycode>
       <domain:FirstName>Peter</domain:FirstName>
       <domain:HouseNr>9</domain:HouseNr>
       <domain:HouseNrExt>a bis</domain:HouseNrExt>
       <domain:Name>de Ruijter</domain:Name>
       <domain:Street>Bilderdijkstraat</domain:Street>
       <domain:Zipcode>3521VA</domain:Zipcode>
      </domain:Address>
      <domain:Address>
       <domain:AddressType>02</domain:AddressType>
       <domain:City>Hoofddorp</domain:City>
       <domain:CompanyName>PostNL</domain:CompanyName>
       <domain:Countrycode>NL</domain:Countrycode>
       <domain:HouseNr>42</domain:HouseNr>
       <domain:Street>Siriusdreef</domain:Street>
       <domain:Zipcode>2132WT</domain:Zipcode>
      </domain:Address>
     </domain:Addresses>
     <domain:Barcode>3S1234567890123</domain:Barcode>
     <domain:DeliveryAddress>01</domain:DeliveryAddress>
     <domain:Dimension>
      <domain:Weight>2000</domain:Weight>
     </domain:Dimension>
     <domain:ProductCodeDelivery>3085</domain:ProductCodeDelivery>
    </domain:Shipment>
   </domain:Shipments>
  </services:Confirming>
 </soap:Body>
</soap:Envelope>
XML
            ,
            (string) $request->getBody());
        $this->assertEquals('', $request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml;charset=UTF-8', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can confirm a single label
     */
    public function testGenerateSingleLabelSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <ConfirmingResponseShipments
xmlns="http://postnl.nl/cif/services/ConfirmingWebService/"
xmlns:a="http://postnl.nl/cif/domain/ConfirmingWebService/"
xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
      <a:ConfirmingResponseShipment>
        <a:Barcode>3S1234567890123</a:Barcode>
        <a:Warnings i:nil= "true"/>
      </a:ConfirmingResponseShipment>
    </ConfirmingResponseShipments>
  </s:Body>
</s:Envelope>
'),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $confirm = $this->postnl->confirmShipment(
            (new Shipment())
                ->setAddresses([
                    Address::create([
                        'AddressType' => '01',
                        'City'        => 'Utrecht',
                        'Countrycode' => 'NL',
                        'FirstName'   => 'Peter',
                        'HouseNr'     => '9',
                        'HouseNrExt'  => 'a bis',
                        'Name'        => 'de Ruijter',
                        'Street'      => 'Bilderdijkstraat',
                        'Zipcode'     => '3521VA',
                    ]),
                    Address::create([
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );

        $this->assertInstanceOf(ConfirmingResponseShipment::class, $confirm);
    }

    /**
     * @testdox can confirm multiple labels
     *
     * @throws \Exception
     */
    public function testGenerateMultipleLabelsSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <ConfirmingResponseShipments
xmlns="http://postnl.nl/cif/services/ConfirmingWebService/"
xmlns:a="http://postnl.nl/cif/domain/ConfirmingWebService/"
xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
      <a:ConfirmingResponseShipment>
        <a:Barcode>3SDEVC201611210</a:Barcode>
        <a:Warnings i:nil= "true"/>
      </a:ConfirmingResponseShipment>
    </ConfirmingResponseShipments>
  </s:Body>
</s:Envelope>
'), new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <ConfirmingResponseShipments
xmlns="http://postnl.nl/cif/services/ConfirmingWebService/"
xmlns:a="http://postnl.nl/cif/domain/ConfirmingWebService/"
xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
      <a:ConfirmingResponseShipment>
        <a:Barcode>3SDEVC201611211</a:Barcode>
        <a:Warnings i:nil= "true"/>
      </a:ConfirmingResponseShipment>
    </ConfirmingResponseShipments>
  </s:Body>
</s:Envelope>
'),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $confirmShipments = $this->postnl->confirmShipments([
                (new Shipment())
                    ->setAddresses([
                        Address::create([
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'FirstName'   => 'Peter',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                        ]),
                        Address::create([
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode('3SDEVC201611210')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
                (new Shipment())
                    ->setAddresses([
                        Address::create([
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'FirstName'   => 'Peter',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                        ]),
                        Address::create([
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode('3SDEVC201611211')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
            ]
        );

        $this->assertInstanceOf(ConfirmingResponseShipment::class, $confirmShipments[1]);
    }

    /**
     * @testdox throws exception on invalid response
     */
    public function testNegativeGenerateLabelInvalidResponseSoap()
    {
        $this->expectException(ResponseException::class);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], 'asdfojasuidfo'),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->postnl->generateLabel(
            (new Shipment())
                ->setAddresses([
                    Address::create([
                        'AddressType' => '01',
                        'City'        => 'Utrecht',
                        'Countrycode' => 'NL',
                        'FirstName'   => 'Peter',
                        'HouseNr'     => '9',
                        'HouseNrExt'  => 'a bis',
                        'Name'        => 'de Ruijter',
                        'Street'      => 'Bilderdijkstraat',
                        'Zipcode'     => '3521VA',
                    ]),
                    Address::create([
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );
    }
}
