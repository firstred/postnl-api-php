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
use DateTimeInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Soap\DeliveryDateServiceSoapRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use ReflectionObject;

#[TestDox(text: 'The DeliveryDateService (SOAP)')]
class DeliveryDateServiceSoapTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected DeliveryDateServiceInterface $service;
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
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'),
            apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: false,
            mode: PostNL::MODE_SOAP
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getDeliveryDateService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid delivery date request')]
    public function testGetDeliveryDateRequestSoap(): void
    {
        $message = new Message();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetDeliveryDateRequest(
            getDeliveryDate: (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    GetDeliveryDate: (new GetDeliveryDate())
                        ->setAllowSundaySorting(AllowSundaySorting: 'false')
                        ->setCity(City: 'Hoofddorp')
                        ->setCountryCode(CountryCode: 'NL')
                        ->setCutOffTimes(CutOffTimes: [
                            new CutOffTime(Day: '00', Time: '14:00:00'),
                        ])
                        ->setHouseNr(HouseNr: '42')
                        ->setHouseNrExt(HouseNrExt: 'A')
                        ->setOptions(Options: [
                            'Daytime',
                        ])
                        ->setPostalCode(PostalCode: '2132WT')
                        ->setShippingDate(shippingDate: '29-06-2016 14:00:00')
                        ->setShippingDuration(ShippingDuration: '1')
                        ->setStreet(Street: 'Siriusdreef')
                )
                ->setMessage(Message: $message)
        );

        $this->assertEmpty(actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'text/xml', actual: $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(expectedXml: <<<XML
<?xml version="1.0"?>
<soap:Envelope 
  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" 
  xmlns:env="http://www.w3.org/2003/05/soap-envelope"
  xmlns:services="http://postnl.nl/cif/services/DeliveryDateWebService/" 
  xmlns:domain="http://postnl.nl/cif/domain/DeliveryDateWebService/"
  xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
  xmlns:schema="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:common="http://postnl.nl/cif/services/common/" 
  xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays"
>
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GetDeliveryDate>
   <domain:GetDeliveryDate>
    <domain:AllowSundaySorting>false</domain:AllowSundaySorting>
    <domain:City>Hoofddorp</domain:City>
    <domain:CountryCode>NL</domain:CountryCode>
    <domain:CutOffTimes>
     <domain:CutOffTime>
      <domain:Day>00</domain:Day>
      <domain:Time>14:00:00</domain:Time>
     </domain:CutOffTime>
    </domain:CutOffTimes>
    <domain:HouseNr>42</domain:HouseNr>
    <domain:HouseNrExt>A</domain:HouseNrExt>
    <domain:Options>
     <arr:string>Daytime</arr:string>
    </domain:Options>
    <domain:PostalCode>2132WT</domain:PostalCode>
    <domain:ShippingDate>29-06-2016 14:00:00</domain:ShippingDate>
    <domain:ShippingDuration>1</domain:ShippingDuration>
    <domain:Street>Siriusdreef</domain:Street>
   </domain:GetDeliveryDate>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s')}</domain:MessageTimeStamp>
   </domain:Message>
  </services:GetDeliveryDate>
 </soap:Body>
</soap:Envelope>
XML
            , actualXml: (string) $request->getBody());
    }

    /** @throws */
    #[TestDox(text: 'return a valid delivery date')]
    public function testGetDeliveryDateSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: <<<XML
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <GetDeliveryDateResponse
xmlns="http://postnl.nl/cif/services/DeliveryDateWebService/"
xmlns:a="http://postnl.nl/cif/domain/DeliveryDateWebService/"
xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
      <a:DeliveryDate>30-06-2016</a:DeliveryDate>
      <a:Options xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
        <b:string>Daytime</b:string>
      </a:Options>
    </GetDeliveryDateResponse>
  </s:Body>
</s:Envelope>
XML
            ),
        ]);

        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getDeliveryDate(
            getDeliveryDate: (new GetDeliveryDate())
            ->setGetDeliveryDate(
                GetDeliveryDate: (new GetDeliveryDate())
                    ->setAllowSundaySorting(AllowSundaySorting: 'false')
                    ->setCity(City: 'Hoofddorp')
                    ->setCountryCode(CountryCode: 'NL')
                    ->setCutOffTimes(CutOffTimes: [
                        new CutOffTime(Day: '00', Time: '14:00:00'),
                    ])
                    ->setHouseNr(HouseNr: '42')
                    ->setHouseNrExt(HouseNrExt: 'A')
                    ->setOptions(Options: [
                        'Daytime',
                    ])
                    ->setPostalCode(PostalCode: '2132WT')
                    ->setShippingDate(shippingDate: '29-06-2016 14:00:00')
                    ->setShippingDuration(ShippingDuration: '1')
                    ->setStreet(Street: 'Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid sent date request')]
    public function testGetSentDateRequestSoap(): void
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSentDateRequestSoap(
            getSentDate: (new GetSentDateRequest())
            ->setGetSentDate(
                GetSentDate: (new GetSentDate())
                    ->setAllowSundaySorting(AllowSundaySorting: true)
                    ->setCity(City: 'Hoofddorp')
                    ->setCountryCode(CountryCode: 'NL')
                    ->setDeliveryDate(deliveryDate: '30-06-2016')
                    ->setHouseNr(HouseNr: '42')
                    ->setHouseNrExt(HouseNrExt: 'A')
                    ->setOptions(Options: [
                        'Daytime',
                    ])
                    ->setPostalCode(postcode: '2132WT')
                    ->setShippingDuration(ShippingDuration: '1')
                    ->setStreet(Street: 'Siriusdreef')
            )
            ->setMessage(Message: $message)
        );

        $this->assertEmpty(actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'text/xml', actual: $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(expectedXml: <<<XML
<?xml version="1.0"?>
<soap:Envelope 
    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:env="http://www.w3.org/2003/05/soap-envelope" 
    xmlns:services="http://postnl.nl/cif/services/DeliveryDateWebService/" 
    xmlns:domain="http://postnl.nl/cif/domain/DeliveryDateWebService/"
    xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:schema="http://www.w3.org/2001/XMLSchema-instance" xmlns:common="http://postnl.nl/cif/services/common/" 
    xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays"
>
  <soap:Header>
    <wsse:Security>
      <wsse:UsernameToken>
        <wsse:Password>test</wsse:Password>
      </wsse:UsernameToken>
    </wsse:Security>
  </soap:Header>
  <soap:Body>
    <services:GetSentDateRequest>
      <domain:GetSentDate>
        <domain:AllowSundaySorting>true</domain:AllowSundaySorting>
        <domain:City>Hoofddorp</domain:City>
        <domain:CountryCode>NL</domain:CountryCode>
        <domain:DeliveryDate>30-06-2016</domain:DeliveryDate>
        <domain:HouseNr>42</domain:HouseNr>
        <domain:HouseNrExt>A</domain:HouseNrExt>
        <domain:Options>
          <arr:string>Daytime</arr:string>
        </domain:Options>
        <domain:PostalCode>2132WT</domain:PostalCode>
        <domain:ShippingDuration>1</domain:ShippingDuration>
        <domain:Street>Siriusdreef</domain:Street>
      </domain:GetSentDate>
      <domain:Message>
        <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
        <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s')}</domain:MessageTimeStamp>
      </domain:Message>
    </services:GetSentDateRequest>
  </soap:Body>
</soap:Envelope>
XML
            , actualXml: (string) $request->getBody());
    }

    /** @throws */
    #[TestDox(text: 'return a valid sent date')]
    public function testGetSentDateSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: <<<XML
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <GetSentDateResponse
        xmlns="http://postnl.nl/cif/services/DeliveryDateWebService/"
        xmlns:a="http://postnl.nl/cif/domain/DeliveryDateWebService/"
        xmlns:i="http://www.w3.org/2001/XMLSchema-instance"
    >
      <a:SentDate>29-06-2016</a:SentDate>
      <a:Options xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays" />
    </GetSentDateResponse>
  </s:Body>
</s:Envelope>
XML
            ),
        ]);

        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getSentDate(
            getSentDate: (new GetSentDateRequest())
            ->setGetSentDate(
                GetSentDate: (new GetSentDate())
                    ->setAllowSundaySorting(AllowSundaySorting: true)
                    ->setCity(City: 'Hoofddorp')
                    ->setCountryCode(CountryCode: 'NL')
                    ->setDeliveryDate(deliveryDate: '30-06-2016')
                    ->setHouseNr(HouseNr: '42')
                    ->setHouseNrExt(HouseNrExt: 'A')
                    ->setOptions(Options: [
                        'Daytime',
                    ])
                    ->setPostalCode(postcode: '2132WT')
                    ->setShippingDuration(ShippingDuration: '1')
                    ->setStreet(Street: 'Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            expected: GetSentDateResponse::class,
            actual: $response
        );
        $this->assertEquals(expected: '29-06-2016', actual: $response->getSentDate()->format(format: 'd-m-Y'));
    }

    /**
     * @throws
     */
    private function getRequestBuilder(): DeliveryDateServiceSoapRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var DeliveryDateServiceSoapRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
