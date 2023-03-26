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
use DateTimeImmutable;
use DateTimeInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\ProductOption;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CompleteStatusResponseEvent;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponseShipment;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\UpdatedShipmentsResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Entity\StatusAddress;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function file_get_contents;
use function is_array;
use const _RESPONSES_DIR_;

/**
 * @testdox The ShippingStatusService (REST)
 */
class ShippingStatusServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected ShippingStatusServiceInterface $service;
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
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'), apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: true,
            mode: PostNL::MODE_REST,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getShippingStatusService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CurrentStatus request')]
    public function testGetCurrentStatusByBarcodeRequestRest(): void
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestRest(
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

    /** @throws */
    #[TestDox(text: 'can get the current status')]
    #[DataProvider(methodName: 'getCurrentStatusByBarcodeProvider')]
    public function testGetCurrentStatusByBarcodeRest(ResponseInterface $response): void
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
        $this->assertInstanceOf(expected: CurrentStatusResponseShipment::class, actual: $currentStatusResponse->getShipments()[0]);

        $this->assertInstanceOf(expected: Dimension::class, actual: $currentStatusResponse->getShipments()[0]->getDimension());
        $this->assertInstanceOf(expected: StatusAddress::class, actual: $currentStatusResponse->getShipments()[0]->getAddresses()[0]);

        $this->assertIsString(actual: $currentStatusResponse->getShipments()[0]->getMainBarcode());
        $this->assertIsString(actual: $currentStatusResponse->getShipments()[0]->getBarcode());
        $this->assertIsString(actual: $currentStatusResponse->getShipments()[0]->getShipmentAmount());
        $this->assertIsString(actual: $currentStatusResponse->getShipments()[0]->getShipmentCounter());
        $this->assertIsString(actual: $currentStatusResponse->getShipments()[0]->getProductDescription());

        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $currentStatusResponse->getShipments()[0]->getStatus()->getTimeStamp());
        $this->assertNotTrue(condition: static::containsStdClass(value: $currentStatusResponse));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CurrentStatusByReference request')]
    public function testGetCurrentStatusByReferenceRequestRest(): void
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestRest(
            currentStatus: (new CurrentStatus())
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
    public function testGetCompleteStatusRequestRest(): void
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestRest(
            completeStatus: (new CompleteStatus())
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

    /**
     * @param ResponseInterface $response
     *
     * @throws
     */
    #[TestDox(text: 'can retrieve the complete status')]
    #[DataProvider(methodName: 'getCompleteStatusByBarcodeProvider')]
    public function testGetCompleteStatusByBarcodeRest(ResponseInterface $response): void
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
        if (is_array(value: $completeStatusResponse->getShipments()[0]->getProductOptions())) {
            $this->assertInstanceOf(expected: ProductOption::class, actual: $completeStatusResponse->getShipments()[0]->getProductOptions()[0]);
        } else {
            $this->assertNull(actual: $completeStatusResponse->getShipments()[0]->getProductOptions());
        }
        $this->assertInstanceOf(expected: CompleteStatusResponseEvent::class, actual: $completeStatusResponse->getShipments()[0]->getEvents()[0]);
        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $completeStatusResponse->getShipments()[0]->getEvents()[0]->getTimeStamp());
        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $completeStatusResponse->getShipments()[0]->getExpectation()->getETAFrom());
        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $completeStatusResponse->getShipments()[0]->getExpectation()->getETATo());
        $this->assertEquals(expected: '01B', actual: $completeStatusResponse->getShipments()[0]->getEvents()[0]->getCode());

        $this->assertIsString(actual: $completeStatusResponse->getShipments()[0]->getMainBarcode());
        $this->assertIsString(actual: $completeStatusResponse->getShipments()[0]->getBarcode());
        $this->assertIsString(actual: $completeStatusResponse->getShipments()[0]->getShipmentAmount());
        $this->assertIsString(actual: $completeStatusResponse->getShipments()[0]->getShipmentCounter());
        $this->assertIsString(actual: $completeStatusResponse->getShipments()[0]->getProductDescription());

        $this->assertNull(actual: $completeStatusResponse->getShipments()[0]->getGroups());
        $this->assertInstanceOf(expected: Customer::class, actual: $completeStatusResponse->getShipments()[0]->getCustomer());
        $this->assertInstanceOf(expected: DateTimeInterface::class, actual: $completeStatusResponse->getShipments()[0]->getOldStatuses()[0]->getTimeStamp());
        $this->assertNotTrue(condition: static::containsStdClass(value: $completeStatusResponse));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid CompleteStatusByReference request')]
    public function testGetCompleteStatusByReferenceRequestRest(): void
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestRest(
            completeStatus: (new CompleteStatus())
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
    public function testGetSignatureRequestRest(): void
    {
        $barcode = '3S9283920398234';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSignatureRequestRest(
            getSignature: (new GetSignature())
                ->setCustomer(Customer: $this->postnl->getCustomer())
                ->setMessage(Message: $message)
                ->setShipment(Shipment: (new Shipment())
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
    #[TestDox(text: 'creates a valid GetUpdatedShipments request')]
    public function testGetUpdatedShipmentsRequestRest(): void
    {
        $dateTimeFrom = new DateTimeImmutable(datetime: '12-02-2021 14:00');
        $dateTimeTo = new DateTimeImmutable(datetime: '14-02-2021 16:00');

        $this->lastRequest = $request = $this->service->buildGetUpdatedShipmentsRequestRest(
            customer: $this->postnl->getCustomer(),
            dateTimeFrom: $dateTimeFrom,
            dateTimeTo: $dateTimeTo
        );

        $this->assertEquals(expected: "period={$dateTimeFrom->format(format:'Y-m-d\TH:i:s')}&period={$dateTimeTo->format(format:'Y-m-d\TH:i:s')}", actual: $request->getUri()->getQuery());
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/{$this->postnl->getCustomer()->getCustomerNumber()}/updatedshipments", actual: $request->getUri()->getPath());
    }

    /** @throws */
    #[TestDox(text: 'can get the signature')]
    public function testGetSignatureRest(): void
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
                ->setShipment(Shipment: (new Shipment())
                    ->setBarcode(Barcode: '3SABCD6659149')
                )
        );

        $this->assertInstanceOf(expected: GetSignatureResponseSignature::class, actual: $signatureResponse);
        $this->assertEquals(expected: '2018-03-07 13:52:45', actual: $signatureResponse->getSignatureDate()->format(format: 'Y-m-d H:i:s'));
        $this->assertNotNull(actual: $signatureResponse->getSignatureImage());
        $this->assertNotTrue(condition: static::containsStdClass(value: $signatureResponse));
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws
     */
    #[TestDox(text: 'can retrieve updated shipments')]
    #[DataProvider(methodName: 'getUpdatedShipmentsProvider')]
    public function testGetUpdatedShipmentsRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $updatedShipments = $this->postnl->getUpdatedShipments(
            dateTimeFrom: new DateTimeImmutable(datetime: '12-02-2021 14:00'),
            dateTimeTo: new DateTimeImmutable(datetime: '12-02-2021 16:00')
        );

        $this->assertInstanceOf(expected: UpdatedShipmentsResponse::class, actual: $updatedShipments[0]);
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws
     */
    #[TestDox(text: 'can retrieve updated shipments')]
    #[DataProvider(methodName: 'getNoCurrentShipmentsProvider')]
    public function testNoCurrentShipmentsRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $currentStatus = $this->postnl->getCurrentStatus( currentStatus: (new CurrentStatus())
            ->setShipment(
                Shipment: (new Shipment())
                    ->setBarcode(Barcode: '3S8392302392342')
            ));

        $this->assertInstanceOf(expected: CurrentStatusResponse::class, actual: $currentStatus);
        $this->assertNull(actual: $currentStatus->getShipments());
        $this->assertIsArray(actual: $currentStatus->getWarnings());
        $this->assertInstanceOf(expected: Warning::class, actual: $currentStatus->getWarnings()[0]);
        $this->assertEquals(expected: 'No shipment found', actual: $currentStatus->getWarnings()[0]->getDescription());
        $this->assertEquals(expected: '2', actual: $currentStatus->getWarnings()[0]->getCode());
    }

    /**
     * @return array[]
     */
    public function getCurrentStatusByBarcodeProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/currentstatus.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/currentstatus2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/currentstatus3.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function getCompleteStatusByBarcodeProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/completestatus.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/completestatus2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/completestatus3.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function getUpdatedShipmentsProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/updatedshipments.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function getNoCurrentShipmentsProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/shippingstatus/nocurrentshipments.http'))],
        ];
    }
}
