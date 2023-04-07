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
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use libphonenumber\NumberParseException;
use ReflectionException;

/**
 * Class DeliveryDateServiceSoapTest.
 *
 * @testdox The DeliveryDateService (SOAP)
 */
class DeliveryDateServiceSoapTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var DeliveryDateServiceInterface */
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

        $this->service = $this->postnl->getDeliveryDateService();
        $this->service->setCache(new VoidCachePool());
        $this->service->setTtl(1);
    }

    /**
     * @testdox creates a valid delivery date request
     */
    public function testGetDeliveryDateRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetDeliveryDateRequestSOAP(
            (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    (new GetDeliveryDate())
                        ->setAllowSundaySorting('false')
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setCutOffTimes([new CutOffTime('00', '14:00:00'),])
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions(['Daytime',])
                        ->setPostalCode('2132WT')
                        ->setShippingDate('29-06-2016 14:00:00')
                        ->setShippingDuration('1')
                        ->setStreet('Siriusdreef')
                )
                ->setMessage($message)
        );

        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(<<<XML
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
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format('d-m-Y H:i:s')}</domain:MessageTimeStamp>
   </domain:Message>
  </services:GetDeliveryDate>
 </soap:Body>
</soap:Envelope>
XML
            , (string) $request->getBody());
    }

    /**
     * @testdox return a valid delivery date
     */
    public function testGetDeliveryDateSoap()
    {
        $mock = new MockHandler([
            new Response(
                200,
                ['Content-Type' => 'text/xml;charset=UTF-8'],
                <<<XML
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

        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getDeliveryDate((new GetDeliveryDate())
            ->setGetDeliveryDate(
                (new GetDeliveryDate())
                    ->setAllowSundaySorting('false')
                    ->setCity('Hoofddorp')
                    ->setCountryCode('NL')
                    ->setCutOffTimes([
                        new CutOffTime('00', '14:00:00'),
                    ])
                    ->setHouseNr('42')
                    ->setHouseNrExt('A')
                    ->setOptions([
                        'Daytime',
                    ])
                    ->setPostalCode('2132WT')
                    ->setShippingDate('29-06-2016 14:00:00')
                    ->setShippingDuration('1')
                    ->setStreet('Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            GetDeliveryDateResponse::class,
            $response
        );
        $this->assertInstanceOf(DateTimeInterface::class, $response->getDeliveryDate());
        $this->assertEquals('30-06-2016', $response->getDeliveryDate()->format('d-m-Y'));
    }

    /**
     * @testdox creates a valid sent date request
     */
    public function testGetSentDateRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSentDateRequestSOAP((new GetSentDateRequest())
            ->setGetSentDate(
                (new GetSentDate())
                    ->setAllowSundaySorting(true)
                    ->setCity('Hoofddorp')
                    ->setCountryCode('NL')
                    ->setDeliveryDate('30-06-2016')
                    ->setHouseNr('42')
                    ->setHouseNrExt('A')
                    ->setOptions([
                        'Daytime',
                    ])
                    ->setPostalCode('2132WT')
                    ->setShippingDuration('1')
                    ->setStreet('Siriusdreef')
            )
            ->setMessage($message)
        );

        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(<<<XML
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
        <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format('d-m-Y H:i:s')}</domain:MessageTimeStamp>
      </domain:Message>
    </services:GetSentDateRequest>
  </soap:Body>
</soap:Envelope>
XML
            , (string) $request->getBody());
    }

    /**
     * @testdox return a valid sent date
     */
    public function testGetSentDateSoap()
    {
        $mock = new MockHandler([
            new Response(
                200,
                ['Content-Type' => 'text/xml;charset=UTF-8'],
                <<<XML
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

        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getSentDate((new GetSentDateRequest())
            ->setGetSentDate(
                (new GetSentDate())
                    ->setAllowSundaySorting(true)
                    ->setCity('Hoofddorp')
                    ->setCountryCode('NL')
                    ->setDeliveryDate('30-06-2016')
                    ->setHouseNr('42')
                    ->setHouseNrExt('A')
                    ->setOptions([
                        'Daytime',
                    ])
                    ->setPostalCode('2132WT')
                    ->setShippingDuration('1')
                    ->setStreet('Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            GetSentDateResponse::class,
            $response
        );
        $this->assertEquals('29-06-2016', $response->getSentDate()->format('d-m-Y'));
    }
}
