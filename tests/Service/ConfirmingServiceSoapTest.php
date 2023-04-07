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
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Soap\ConfirmingServiceSoapRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use ReflectionObject;

#[TestDox(text: 'The ConfirmingService (SOAP)')]
class ConfirmingServiceSoapTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected ConfirmingServiceInterface $service;
    protected RequestInterface $lastRequest;

    protected function setUp(): void
    {
        $this->markTestIncomplete();
    }

    /** @throws */
    #[Before]
    public function setupPostNL(): void
    {
        $this->postnl = new PostNL(
            customer: (new Customer())
                ->setCollectionLocation(CollectionLocation: '123456')
                ->setCustomerCode(CustomerCode: 'DEVC')
                ->setCustomerNumber(CustomerNumber: '11223344')
                ->setContactPerson(ContactPerson: 'Test')
                ->setAddress(Address: new Address(
                    AddressType: '02',
                    CompanyName: 'PostNL',
                    Street: 'Siriusdreef',
                    HouseNr: '42',
                    Zipcode: '2132WT',
                    City: 'Hoofddorp',
                    Countrycode: 'NL',
                ))
                ->setGlobalPackBarcodeType(GlobalPackBarcodeType: 'AB')
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'),
            apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: true,
            mode: PostNL::MODE_SOAP,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getConfirmingService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'returns a valid service object')]
    public function testHasValidConfirmingService(): void
    {
        $this->assertInstanceOf(expected: ConfirmingService::class, actual: $this->service);
    }

    /** @throws */
    #[TestDox(text: 'creates a confirm request')]
    public function testCreatesAValidLabelRequest(): void
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildConfirmRequest(
            confirming: (new Confirming())
                ->setShipments(Shipments: [
                    (new Shipment())
                        ->setAddresses(Addresses: [
                            new Address(
                                AddressType: '01',
                                FirstName: 'Peter',
                                Name: 'de Ruijter',
                                Street: 'Bilderdijkstraat',
                                HouseNr: '9',
                                HouseNrExt: 'a bis',
                                Zipcode: '3521VA',
                                City: 'Utrecht',
                                Countrycode: 'NL',
                            ),
                            new Address(
                                AddressType: '02',
                                CompanyName: 'PostNL',
                                Street: 'Siriusdreef',
                                HouseNr: '42',
                                Zipcode: '2132WT',
                                City: 'Hoofddorp',
                                Countrycode: 'NL',
                            ),
                        ])
                        ->setBarcode(Barcode: '3S1234567890123')
                        ->setDeliveryAddress(DeliveryAddress: '01')
                        ->setDimension(Dimension: new Dimension(Weight: '2000'))
                        ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
                ])
                ->setMessage(Message: $message)
                ->setCustomer(Customer: $this->postnl->getCustomer())
        );

        $this->assertXmlStringEqualsXmlString(
            expectedXml: <<<XML
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
    <domain:Printertype>GraphicFile|PDF</domain:Printertype>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s')}</domain:MessageTimeStamp>
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
            actualXml: (string) $request->getBody()
        );
        $this->assertEquals(expected: '', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'text/xml;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'text/xml', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'can confirm a single label')]
    public function testGenerateSingleLabelSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
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
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $confirm = $this->postnl->confirmShipment(
            shipment: (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3S1234567890123')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085')
        );

        $this->assertInstanceOf(expected: ConfirmingResponseShipment::class, actual: $confirm);
    }

    /** @throws */
    #[TestDox(text: 'can confirm multiple labels')]
    public function testGenerateMultipleLabelsSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
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
'), new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
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
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $confirmShipments = $this->postnl->confirmShipments(
            shipments: [
            (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3SDEVC201611210')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3SDEVC201611211')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
        ]
        );

        $this->assertInstanceOf(expected: ConfirmingResponseShipment::class, actual: $confirmShipments[1]);
    }

    /** @throws */
    #[TestDox(text: 'throws exception on invalid response')]
    public function testNegativeGenerateLabelInvalidResponseSoap(): void
    {
        $this->expectException(exception: ResponseException::class);

        $mock = new MockHandler(queue: [
            new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: 'asdfojasuidfo'),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->postnl->generateLabel(
            shipment: (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3S1234567890123')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085')
        );
    }

    /**
     * @throws
     */
    private function getRequestBuilder(): ConfirmingServiceSoapRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var ConfirmingServiceSoapRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
