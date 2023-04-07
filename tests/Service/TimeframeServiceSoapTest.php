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

namespace Firstred\PostNL\Tests\Service;

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Class TimeframeServiceSoapTest.
 *
 * @testdox The TimeframeService (SOAP)
 */
class TimeframeServiceSoapTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var TimeframeServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            (new Customer())
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress((new Address())
                    ->setAddressType('02')
                    ->setCity('Hoofddorp')
                    ->setCompanyName('PostNL')
                    ->setCountrycode('NL')
                    ->setHouseNr('42')
                    ->setStreet('Siriusdreef')
                    ->setZipcode('2132WT')
                )
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
            false,
            PostNL::MODE_SOAP
        );

        global $logger;
        $this->postnl->setLogger($logger);

        $this->service = $this->postnl->getTimeframeService();
        $this->service->setCache(new VoidCachePool());
        $this->service->setTtl(1);
    }

    /**
     * @testdox creates a valid timeframes request
     */
    public function testGetTimeframesRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetTimeframesRequestSOAP(
            (new GetTimeframes())
                ->setMessage($message)
                ->setTimeframe([
                    (new Timeframe())
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setEndDate('02-07-2016')
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions(['Evening'])
                        ->setPostalCode('2132WT')
                        ->setStartDate('30-06-2016')
                        ->setStreet('Siriusdreef')
                        ->setSundaySorting(true),
                ])
        );

        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(<<<XML
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
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format('d-m-Y H:i:s')}</domain:MessageTimeStamp>
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
            , (string) $request->getBody());
    }

    /**
     * @testdox can retrieve the available timeframes
     */
    public function testGetTimeframesSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:a="http://postnl.nl/cif/domain/TimeframeWebService/"
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
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $responseTimeframes = $this->postnl->getTimeframes(
            (new GetTimeframes())
                ->setTimeframe([(new Timeframe())
                                    ->setCity('Hoofddorp')
                                    ->setCountryCode('NL')
                                    ->setEndDate('02-07-2016')
                                    ->setHouseNr('42')
                                    ->setHouseNrExt('A')
                                    ->setOptions([
                                        'Evening',
                                    ])
                                    ->setPostalCode('2132WT')
                                    ->setStartDate('30-06-2016')
                                    ->setStreet('Siriusdreef')
                                    ->setSundaySorting(false),
                ])
        );

        // Should be a ResponeTimefarmes instance
        $this->assertInstanceOf(ResponseTimeframes::class, $responseTimeframes);
        // Check for data loss
        $this->assertEquals(2, count($responseTimeframes->getReasonNoTimeframes()));
        $this->assertEquals(2, count($responseTimeframes->getTimeframes()));
    }
}
