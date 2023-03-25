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
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

/**
 * @testdox The BarcodeService (SOAP)
 */
class BarcodeServiceSoapTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected BarcodeServiceInterface $service;
    protected RequestInterface $lastRequest;

    /**
     * @before
     *
     * @throws
     */
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
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'), apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: true,
            mode: PostNL::MODE_Soap
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getBarcodeService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /**
     * @testdox creates a valid 3S barcode request
     *
     * @throws
     */
    public function testCreatesAValid3SBarcodeRequest(): void
    {
        $type = '3S';
        $range = $this->getRange(type: '3S');
        $serie = $this->postnl->findBarcodeSerie(type: '3S', range: $range, eps: false);

        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGenerateBarcodeRequestSoap(
            generateBarcode: GenerateBarcode::create()
                ->setBarcode(
                    Barcode: Barcode::create()
                        ->setRange(Range: $range)
                        ->setSerie(Serie: $serie)
                        ->setType(Type: $type)
                )
                ->setMessage(Message: $message)
                ->setCustomer(Customer: $this->postnl->getCustomer())
        );

        $this->assertEmpty(actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'text/xml', actual: $request->getHeaderLine('Accept'));
        $this->assertXmlStringEqualsXmlString(expectedXml: <<<XML
<?xml version="1.0"?>
<soap:Envelope
  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" 
  xmlns:env="http://www.w3.org/2003/05/soap-envelope"
  xmlns:services="http://postnl.nl/cif/services/BarcodeWebService/"
  xmlns:domain="http://postnl.nl/cif/domain/BarcodeWebService/"
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
    <services:GenerateBarcode>
      <domain:Message>
        <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
        <domain:MessageTimeStamp>{$message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s')}</domain:MessageTimeStamp>
      </domain:Message>
      <domain:Customer>
        <domain:CustomerCode>DEVC</domain:CustomerCode>
        <domain:CustomerNumber>11223344</domain:CustomerNumber>
      </domain:Customer>
      <domain:Barcode>
        <domain:Type>3S</domain:Type>
        <domain:Range>DEVC</domain:Range>
        <domain:Serie>987000000-987600000</domain:Serie>
      </domain:Barcode>
    </services:GenerateBarcode>
  </soap:Body>
</soap:Envelope>
XML
            , actualXml: (string) $request->getBody());
    }

    /**
     * @testdox return a valid single barcode
     *
     * @throws
     */
    public function testSingleBarcodeSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: $this->mockValidBarcodeResponse(barcode: '3SDEVC816223392')
            ),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->assertEquals(expected: '3SDEVC816223392', actual: $this->postnl->generateBarcode(type: '3S'));
    }

    /**
     * @testdox returns several barcodes
     *
     * @throws
     */
    public function testMultipleNLBarcodesSoap(): void
    {
        $mock = new MockHandler(queue: [
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: $this->mockValidBarcodeResponse(barcode: '3SDEVC816223392')
            ),
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: $this->mockValidBarcodeResponse(barcode: '3SDEVC816223393')
            ),
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: $this->mockValidBarcodeResponse(barcode: '3SDEVC816223394')
            ),
            new Response(
                status: 200,
                headers: ['Content-Type' => 'text/xml;charset=UTF-8'],
                body: $this->mockValidBarcodeResponse(barcode: '3SDEVC816223395')
            ),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $barcodes = $this->postnl->generateBarcodesByCountryCodes(isos: ['NL' => 4]);

        $this->assertEquals(expected: [
            'NL' => [
                '3SDEVC816223392',
                '3SDEVC816223393',
                '3SDEVC816223394',
                '3SDEVC816223395',
            ],
        ],
            actual: $barcodes
        );
    }

    protected function getRange(string $type): string
    {
        if (in_array(needle: $type, haystack: ['2S', '3S'])) {
            return $this->postnl->getCustomer()->getCustomerCode();
        } else {
            return $this->postnl->getCustomer()->getGlobalPackCustomerCode();
        }
    }

    protected function mockValidBarcodeResponse(string $barcode): string
    {
        return <<<XML
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Body>
    <GenerateBarcodeResponse xmlns="http://postnl.nl/cif/services/BarcodeWebService/"
xmlns:a="http://postnl.nl/cif/domain/BarcodeWebService/"
xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
      <a:Barcode>{$barcode}</a:Barcode>
    </GenerateBarcodeResponse>
  </s:Body>
</s:Envelope>
XML;
    }
}
