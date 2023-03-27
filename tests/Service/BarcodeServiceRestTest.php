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
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\BarcodeServiceRestRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use ReflectionObject;
use function file_get_contents;
use const _RESPONSES_DIR_;

#[TestDox(text: 'The BarcodeService (REST)')]
class BarcodeServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected BarcodeServiceInterface $service;
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
            sandbox: true,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getBarcodeService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'returns a valid service objects')]
    public function testHasValidBarcodeService(): void
    {
        $this->assertInstanceOf(expected: BarcodeServiceInterface::class, actual: $this->service);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid 3S barcode request')]
    public function testCreatesAValid3SBarcodeRequest(): void
    {
        $type = '3S';
        $range = $this->getRange(type: '3S');
        $serie = $this->postnl->findBarcodeSerie(type: '3S', range: $range, eps: false);

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGenerateBarcodeRequest(
            generateBarcode: GenerateBarcode::create()
                ->setBarcode(
                    Barcode: Barcode::create()
                        ->setRange(Range: $range)
                        ->setSerie(Serie: $serie)
                        ->setType(Type: $type)
                )
                ->setMessage(Message: new Message())
                ->setCustomer(Customer: $this->postnl->getCustomer())
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing(
            expected: [
                'CustomerCode'   => 'DEVC',
                'CustomerNumber' => '11223344',
                'Type'           => '3S',
                'Serie'          => '987000000-987600000',
                'Range'          => 'DEVC',
            ],
            actual: $query
        );
        $this->assertEmpty(actual: (string) $request->getBody());
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: '', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid 10S barcode request')]
    public function testCreatesAValid10SBarcodeRequest()
    {
        $type = 'LA';
        $range = $this->getRange(type: $type);
        $serie = $this->postnl->findBarcodeSerie(type: $type, range: $range, eps: false);

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGenerateBarcodeRequest(
            generateBarcode: GenerateBarcode::create()
                ->setBarcode(
                    Barcode: Barcode::create()
                        ->setRange(Range: $range)
                        ->setSerie(Serie: $serie)
                        ->setType(Type: $type)
                )
                ->setMessage(Message: new Message())
                ->setCustomer(Customer: $this->postnl->getCustomer())
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing(
            expected: [
                'CustomerCode'   => 'DEVC',
                'CustomerNumber' => '11223344',
                'Type'           => 'LA',
                'Serie'          => '00000000-99999999',
                'Range'          => '1234'
            ],
            actual: $query
        );
        $this->assertEmpty(actual: (string) $request->getBody());
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: '', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    protected function getRange(string $type): string
    {
        if (in_array(needle: $type, haystack: ['2S', '3S'])) {
            return $this->postnl->getCustomer()->getCustomerCode();
        }

        return $this->postnl->getCustomer()->getGlobalPackCustomerCode();
    }

    /** @throws */
    #[TestDox(text: 'return a valid single barcode')]
    public function testSingleBarcodeRest(): void
    {
        $mock = new MockHandler(queue: [
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/singlebarcode.http')),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->assertEquals(expected: '3SDEVC816223392', actual: $this->postnl->generateBarcode(type: '3S'));
    }

    /** @throws */
    #[TestDox(text: 'return a valid single barcode for a country')]
    public function testSingleBarCodeByCountryRest(): void
    {
        $mock = new MockHandler(queue: [
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/singlebarcode.http')),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->assertEquals(expected: '3SDEVC816223392', actual: $this->postnl->generateBarcodeByCountryCode(iso: 'NL'));
    }

    /** @throws */
    #[TestDox(text: 'returns several barcodes')]
    public function testMultipleNLBarcodesRest(): void
    {
        $mock = new MockHandler(queue: [
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/singlebarcode.http')),
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/singlebarcode2.http')),
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/singlebarcode3.http')),
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/singlebarcode4.http')),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $barcodes = $this->postnl->generateBarcodesByCountryCodes(isos: ['NL' => 4]);

        $this->assertEquals(
            expected: [
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

    /** @throws */
    #[TestDox(text: 'return a valid single barcode')]
    public function testNegativeSingleBarcodeInvalidResponse(): void
    {
        $this->expectException(exception: ResponseException::class);

        $mock = new MockHandler(queue: [
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/barcode/invalid.http')),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->postnl->generateBarcode(type: '3S');
    }

    /**
     * @return BarcodeServiceRestRequestBuilder
     * @throws \ReflectionException
     */
    private function getRequestBuilder(): BarcodeServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var BarcodeServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
