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
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\RequestBuilder\Rest\ShippingStatusServiceRestRequestBuilder;
use Firstred\PostNL\Service\RequestBuilder\Soap\TimeframeServiceSoapRequestBuilder;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use ReflectionObject;

#[TestDox(text: 'The TimeframeService (SOAP)')]
class TimeframeServiceSoapTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected TimeframeServiceInterface $service;
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
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'), apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: false,
            mode: PostNL::MODE_SOAP
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getTimeframeService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid timeframes request')]
    public function testGetTimeframesRequestSoap(): void
    {
        $message = new Message();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetTimeframesRequest(
            getTimeframes: (new GetTimeframes())
                ->setMessage(Message: $message)
                ->setTimeframe(timeframes: [
                    (new Timeframe())
                        ->setCity(City: 'Hoofddorp')
                        ->setCountryCode(CountryCode: 'NL')
                        ->setEndDate(EndDate: '02-07-2016')
                        ->setHouseNr(HouseNr: '42')
                        ->setHouseNrExt(HouseNrExt: 'A')
                        ->setOptions(Options: [
                            'Evening',
                        ])
                        ->setPostalCode(PostalCode: '2132WT')
                        ->setStartDate(StartDate: '30-06-2016')
                        ->setStreet(Street: 'Siriusdreef')
                        ->setSundaySorting(SundaySorting: true),
                ])
        );

        $this->assertEmpty(actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'text/xml', actual: $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(expectedXml: <<<XML
<?xml version="1.0"?>
<soap:Envelope
    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:env="http://www.w3.org/2003/05/soap-envelope"
    xmlns:services="http://postnl.nl/cif/services/TimeframeWebService/" 
    xmlns:domain="http://postnl.nl/cif/domain/TimeframeWebService/"
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
  <services:GetTimeframes>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s')}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Timeframe>
    <domain:City>Hoofddorp</domain:City>
    <domain:CountryCode>NL</domain:CountryCode>
    <domain:EndDate>02-07-2016</domain:EndDate>
    <domain:HouseNr>42</domain:HouseNr>
    <domain:HouseNrExt>A</domain:HouseNrExt>
    <domain:Options>
     <arr:string>Evening</arr:string>
    </domain:Options>
    <domain:PostalCode>2132WT</domain:PostalCode>
    <domain:StartDate>30-06-2016</domain:StartDate>
    <domain:Street>Siriusdreef</domain:Street>
    <domain:SundaySorting>true</domain:SundaySorting>
   </domain:Timeframe>
  </services:GetTimeframes>
 </soap:Body>
</soap:Envelope>
XML
            , actualXml: (string) $request->getBody());
    }

    /** @throws */
    #[TestDox(text: 'can retrieve the available timeframes')]
    public function testGetTimeframesSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: '<s:Envelope xmlns:a="http://postnl.nl/cif/domain/TimeframeWebService/"
            xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays"
            xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
    <s:Body>
        <ResponseTimeframes xmlns="http://postnl.nl/cif/services/TimeframeWebService/"
                          xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
            <a:ReasonNoTimeframes>
                <a:ReasonNoTimeframe>
                    <a:Code>05</a:Code>
                    <a:Date>09-03-2018</a:Date>
                    <a:Description>Geen avondbelevering mogelijk</a:Description>
                    <a:Options>
                        <b:string>Evening</b:string>
                    </a:Options>
                </a:ReasonNoTimeframe>
                <a:ReasonNoTimeframe>
                    <a:Code>05</a:Code>
                    <a:Date>10-03-2018</a:Date>
                    <a:Description>Geen avondbelevering mogelijk</a:Description>
                    <a:Options>
                        <b:string>Evening</b:string>
                    </a:Options>
                </a:ReasonNoTimeframe>
            </a:ReasonNoTimeframes>
            <a:Timeframes>
                <a:Timeframe>
                    <a:Date>09-03-2018</a:Date>
                    <a:Timeframes>
                        <a:TimeframeTimeFrame>
                            <a:From>10:15:00</a:From>
                            <a:Options>
                                <b:string>Daytime</b:string>
                            </a:Options>
                            <a:To>12:45:00</a:To>
                        </a:TimeframeTimeFrame>
                    </a:Timeframes>
                </a:Timeframe>
                <a:Timeframe>
                    <a:Date>10-03-2018</a:Date>
                    <a:Timeframes>
                        <a:TimeframeTimeFrame>
                            <a:From>09:30:00</a:From>
                            <a:Options>
                                <b:string>Daytime</b:string>
                            </a:Options>
                            <a:To>12:00:00</a:To>
                        </a:TimeframeTimeFrame>
                    </a:Timeframes>
                </a:Timeframe>
            </a:Timeframes>
        </ResponseTimeframes>
    </s:Body>
</s:Envelope>'),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $responseTimeframes = $this->postnl->getTimeframes(
            getTimeframes: (new GetTimeframes())
                ->setTimeframe(timeframes: [
                    (new Timeframe())
                        ->setCity(City: 'Hoofddorp')
                        ->setCountryCode(CountryCode: 'NL')
                        ->setEndDate(EndDate: '02-07-2016')
                        ->setHouseNr(HouseNr: '42')
                        ->setHouseNrExt(HouseNrExt: 'A')
                        ->setOptions(Options: [
                            'Evening',
                        ])
                        ->setPostalCode(PostalCode: '2132WT')
                        ->setStartDate(StartDate: '30-06-2016')
                        ->setStreet(Street: 'Siriusdreef')
                        ->setSundaySorting(SundaySorting: false),
                ])
        );

        // Should be a ResponeTimefarmes instance
        $this->assertInstanceOf(expected: ResponseTimeframes::class, actual: $responseTimeframes);
        // Check for data loss
        $this->assertEquals(expected: 2, actual: count(value: $responseTimeframes->getReasonNoTimeframes()));
        $this->assertEquals(expected: 2, actual: count(value: $responseTimeframes->getTimeframes()));
    }

    /**
     * @throws
     */
    private function getRequestBuilder(): TimeframeServiceSoapRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var TimeframeServiceSoapRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
