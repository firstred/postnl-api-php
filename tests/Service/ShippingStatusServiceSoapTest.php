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
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Entity\StatusAddress;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\RequestBuilder\Rest\ShippingStatusServiceRestRequestBuilder;
use Firstred\PostNL\Service\RequestBuilder\ShippingStatusServiceRequestBuilderInterface;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;

use function file_get_contents;

use const _RESPONSES_DIR_;

#[TestDox(text: 'The ShippingStatusService (SOAP)')]
class ShippingStatusServiceSoapTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected ShippingStatusServiceInterface $service;
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

        $this->service = $this->postnl->getShippingStatusService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CurrentStatus request')]
    public function testGetCurrentStatusRequestSoap(): void
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $reflectionService = new \ReflectionObject(object: $this->service);
        $requestBuilderReflection = $reflectionService->getProperty(name: 'requestBuilder');
        /** @var ShippingStatusServiceRequestBuilderInterface $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);
        $this->lastRequest = $request = $requestBuilder->buildCurrentStatusRequest(
            currentStatus: (new CurrentStatus())
                ->setShipment(
                    Shipment: (new Shipment())
                        ->setBarcode(Barcode: $barcode)
                )
                ->setMessage(Message: $message)
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEmpty(actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/barcode/$barcode", actual: $request->getUri()->getPath());
    }

    /**
     * @throws
     */
    #[TestDox(text: 'can get the current status')]
    #[DataProviderExternal(
        className: ShippingStatusServiceRestTest::class,
        methodName: 'getCurrentStatusByBarcodeProvider',
    )]
    public function testGetCurrentStatusSoap(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $currentStatusResponse = $this->postnl->getCurrentStatus(
            currentStatus: (new CurrentStatus())
                ->setShipment(
                    Shipment: (new Shipment())
                        ->setBarcode(Barcode: '3S8392302392342')
                )
        );

        $this->assertInstanceOf(expected: CurrentStatusResponse::class, actual: $currentStatusResponse);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CurrentStatusByReference request')]
    public function testGetCurrentStatusByReferenceRequestSoap(): void
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequest(
            (new CurrentStatus())
                ->setShipment(
                    Shipment: (new Shipment())
                        ->setReference(Reference: $reference)
                )
                ->setMessage(Message: $message)
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEquals(expected: [
            'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
            'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
        ], actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/reference/$reference", actual: $request->getUri()->getPath());
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CompleteStatus request')]
    public function testGetCompleteStatusRequestSoap(): void
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequest(
            (new CompleteStatus())
                ->setShipment(
                    Shipment: (new Shipment())
                        ->setBarcode(Barcode: $barcode)
                )
                ->setMessage(Message: $message)
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEquals(expected: [
            'detail' => 'true',
        ], actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/barcode/$barcode", actual: $request->getUri()->getPath());
    }

    /** @throws */
    #[TestDox(text: 'can retrieve the complete status')]
    #[DataProviderExternal(
        className: ShippingStatusServiceRestTest::class,
        methodName: 'getCompleteStatusByBarcodeProvider',
    )]
    public function testGetCompleteStatusSoap(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $completeStatusResponse = $this->postnl->getCompleteStatus(
            completeStatus: (new CompleteStatus())
                ->setShipment(
                    Shipment: (new Shipment())
                        ->setBarcode(Barcode: '3SABCD6659149')
                )
        );

        $this->assertInstanceOf(expected: CompleteStatusResponse::class, actual: $completeStatusResponse);
        $this->assertInstanceOf(expected: StatusAddress::class, actual: $completeStatusResponse->getShipments()[0]->getAddresses()[0]);
        $this->assertNull(actual: $completeStatusResponse->getShipments()[0]->getAmounts());
        $this->assertEquals(expected: '01B', actual: $completeStatusResponse->getShipments()[0]->getEvents()[0]->getCode());
        $this->assertNull(actual: $completeStatusResponse->getShipments()[0]->getGroups());
        $this->assertInstanceOf(expected: Customer::class, actual: $completeStatusResponse->getShipments()[0]->getCustomer());
        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $completeStatusResponse->getShipments()[0]->getOldStatuses()[0]->getTimeStamp());
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CompleteStatusByReference request')]
    public function testGetCompleteStatusByReferenceRequestSoap(): void
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequest(
            (new CompleteStatus())
                ->setShipment(
                    Shipment: (new Shipment())
                        ->setReference(Reference: $reference)
                )
                ->setMessage(Message: $message)
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEquals(expected: [
            'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
            'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            'detail'         => 'true',
        ], actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/reference/$reference", actual: $request->getUri()->getPath());
    }

    /** @throws */
    #[TestDox(text: 'creates a valid GetSignature request')]
    public function testGetSignatureRequestSoap(): void
    {
        $barcode = '3S9283920398234';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSignatureRequest(
            (new GetSignature())
                ->setCustomer(Customer: $this->postnl->getCustomer())
                ->setMessage(Message: $message)
                ->setShipment(
                    Shipment: (new Shipment())
                    ->setBarcode(Barcode: $barcode)
                )
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEmpty(actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/signature/$barcode", actual: $request->getUri()->getPath());
    }

    /** @throws */
    #[TestDox(text: 'can get the signature')]
    public function testGetSignatureSoap(): void
    {
        $mock = new MockHandler(queue: [
            PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/signature.http')),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $signatureResponse = $this->postnl->getSignature(
            signature: (new GetSignature())
                ->setShipment(
                    Shipment: (new Shipment())
                    ->setBarcode(Barcode: '3SABCD6659149')
                )
        );

        $this->assertInstanceOf(expected: GetSignatureResponseSignature::class, actual: $signatureResponse);
    }

    /**
     * @throws
     */
    private function getRequestBuilder(): ShippingStatusServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var ShippingStatusServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
