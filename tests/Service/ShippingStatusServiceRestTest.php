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
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Entity\StatusAddress;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ShippingStatusServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use Psr\Http\Message\ResponseInterface;
use function file_get_contents;
use function is_array;
use const _RESPONSES_DIR_;

/**
 * Class ShippingStatusRestTest.
 *
 * @testdox The ShippingStatusService (REST)
 */
class ShippingStatusServiceRestTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var ShippingStatusServiceInterface */
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
            true,
            PostNL::MODE_REST
        );

        global $logger;
        $this->postnl->setLogger($logger);

        $this->service = $this->postnl->getShippingStatusService();
        $this->service->setCache(new VoidCachePool());
        $this->service->setTtl(1);
    }

    /**
     * @testdox creates a valid CurrentStatus request
     */
    public function testGetCurrentStatusByBarcodeRequestRest()
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestREST(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode($barcode)
                )
                ->setMessage($message)
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEmpty($query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/barcode/$barcode", $request->getUri()->getPath());
    }

    /**
     * @testdox can get the current status
     * @dataProvider getCurrentStatusByBarcodeProvider
     *
     * @param ResponseInterface $response
     *
     * @throws
     */
    public function testGetCurrentStatusByBarcodeRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $currentStatusResponse = $this->postnl->getCurrentStatus(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode('3S8392302392342')
                )
        );

        $this->assertInstanceOf(CurrentStatusResponse::class, $currentStatusResponse);
        $this->assertInstanceOf(CurrentStatusResponseShipment::class, $currentStatusResponse->getShipments()[0]);

        $this->assertInstanceOf(Dimension::class, $currentStatusResponse->getShipments()[0]->getDimension());
        $this->assertInstanceOf(StatusAddress::class, $currentStatusResponse->getShipments()[0]->getAddresses()[0]);

        $this->assertIsString($currentStatusResponse->getShipments()[0]->getMainBarcode());
        $this->assertIsString($currentStatusResponse->getShipments()[0]->getBarcode());
        $this->assertIsString($currentStatusResponse->getShipments()[0]->getShipmentAmount());
        $this->assertIsString($currentStatusResponse->getShipments()[0]->getShipmentCounter());
        $this->assertIsString($currentStatusResponse->getShipments()[0]->getProductDescription());

        $this->assertInstanceOf(DateTimeInterface::class, $currentStatusResponse->getShipments()[0]->getStatus()->getTimeStamp());
        $this->assertNotTrue(static::containsStdClass($currentStatusResponse));
    }

    /**
     * @testdox creates a valid CurrentStatusByReference request
     */
    public function testGetCurrentStatusByReferenceRequestRest()
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestREST(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setReference($reference)
                )
                ->setMessage($message)
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEquals([
            'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
            'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/reference/$reference", $request->getUri()->getPath());
    }

    /**
     * @testdox creates a valid CompleteStatus request
     */
    public function testGetCompleteStatusRequestRest()
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestREST(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode($barcode)
                )
                ->setMessage($message)
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEquals([
            'detail' => 'true',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/barcode/$barcode", $request->getUri()->getPath());
    }

    /**
     * @testdox can retrieve the complete status
     * @dataProvider getCompleteStatusByBarcodeProvider
     *
     * @param ResponseInterface $response
     *
     * @throws
     */
    public function testGetCompleteStatusByBarcodeRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $completeStatusResponse = $this->postnl->getCompleteStatus(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode('3SABCD6659149')
                )
        );

        $this->assertInstanceOf(CompleteStatusResponse::class, $completeStatusResponse);
        $this->assertInstanceOf(StatusAddress::class, $completeStatusResponse->getShipments()[0]->getAddresses()[0]);
        $this->assertNull($completeStatusResponse->getShipments()[0]->getAmounts());
        if (is_array($completeStatusResponse->getShipments()[0]->getProductOptions())) {
            $this->assertInstanceOf(ProductOption::class, $completeStatusResponse->getShipments()[0]->getProductOptions()[0]);
        } else {
            $this->assertNull($completeStatusResponse->getShipments()[0]->getProductOptions());
        }
        $this->assertInstanceOf(CompleteStatusResponseEvent::class, $completeStatusResponse->getShipments()[0]->getEvents()[0]);
        $this->assertInstanceOf(DateTimeInterface::class, $completeStatusResponse->getShipments()[0]->getEvents()[0]->getTimeStamp());
        $this->assertInstanceOf(DateTimeInterface::class, $completeStatusResponse->getShipments()[0]->getExpectation()->getETAFrom());
        $this->assertInstanceOf(DateTimeInterface::class, $completeStatusResponse->getShipments()[0]->getExpectation()->getETATo());
        $this->assertEquals('01B', $completeStatusResponse->getShipments()[0]->getEvents()[0]->getCode());

        $this->assertIsString($completeStatusResponse->getShipments()[0]->getMainBarcode());
        $this->assertIsString($completeStatusResponse->getShipments()[0]->getBarcode());
        $this->assertIsString($completeStatusResponse->getShipments()[0]->getShipmentAmount());
        $this->assertIsString($completeStatusResponse->getShipments()[0]->getShipmentCounter());
        $this->assertIsString($completeStatusResponse->getShipments()[0]->getProductDescription());

        $this->assertNull($completeStatusResponse->getShipments()[0]->getGroups());
        $this->assertInstanceOf(Customer::class, $completeStatusResponse->getShipments()[0]->getCustomer());
        $this->assertInstanceOf(DateTimeInterface::class, $completeStatusResponse->getShipments()[0]->getOldStatuses()[0]->getTimeStamp());
        $this->assertNotTrue(static::containsStdClass($completeStatusResponse));
    }

    /**
     * @testdox creates a valid CompleteStatusByReference request
     */
    public function testGetCompleteStatusByReferenceRequestRest()
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestREST(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setReference($reference)
                )
                ->setMessage($message)
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEquals([
            'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
            'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            'detail'         => 'true',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/reference/$reference", $request->getUri()->getPath());
    }

    /**
     * @testdox creates a valid GetSignature request
     */
    public function testGetSignatureRequestRest()
    {
        $barcode = '3S9283920398234';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSignatureRequestREST(
            (new GetSignature())
                ->setCustomer($this->postnl->getCustomer())
                ->setMessage($message)
                ->setShipment((new Shipment())
                    ->setBarcode($barcode)
                )
        );

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEmpty($query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/signature/$barcode", $request->getUri()->getPath());
    }

    /**
     * @testdox creates a valid GetUpdatedShipments request
     */
    public function testGetUpdatedShipmentsRequestRest()
    {
        $dateTimeFrom = new DateTimeImmutable('12-02-2021 14:00');
        $dateTimeTo = new DateTimeImmutable('14-02-2021 16:00');

        $this->lastRequest = $request = $this->service->buildGetUpdatedShipmentsRequestREST(
            $this->postnl->getCustomer(),
            $dateTimeFrom,
            $dateTimeTo
        );

        $this->assertEquals("period={$dateTimeFrom->format('Y-m-d\TH:i:s')}&period={$dateTimeTo->format('Y-m-d\TH:i:s')}", $request->getUri()->getQuery());
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/{$this->postnl->getCustomer()->getCustomerNumber()}/updatedshipments", $request->getUri()->getPath());
    }

    /**
     * @testdox can get the signature
     */
    public function testGetSignatureRest()
    {
        $mock = new MockHandler([
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/signature.http')),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $signatureResponse = $this->postnl->getSignature(
            (new GetSignature())
                ->setShipment((new Shipment())
                    ->setBarcode('3SABCD6659149')
                )
        );

        $this->assertInstanceOf(GetSignatureResponseSignature::class, $signatureResponse);
        $this->assertEquals('2018-03-07 13:52:45', $signatureResponse->getSignatureDate()->format('Y-m-d H:i:s'));
        $this->assertNotNull($signatureResponse->getSignatureImage());
        $this->assertNotTrue(static::containsStdClass($signatureResponse));
    }

    /**
     * @testdox can retrieve updated shipments
     * @dataProvider getUpdatedShipmentsProvider
     *
     * @param ResponseInterface $response
     */
    public function testGetUpdatedShipmentsRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $updatedShipments = $this->postnl->getUpdatedShipments(
            new DateTimeImmutable('12-02-2021 14:00'),
            new DateTimeImmutable('12-02-2021 16:00')
        );

        $this->assertInstanceOf(UpdatedShipmentsResponse::class, $updatedShipments[0]);
    }

    /**
     * @testdox can retrieve updated shipments
     * @dataProvider getNoCurrentShipmentsProvider
     *
     * @param ResponseInterface $response
     *
     * @throws
     */
    public function testNoCurrentShipmentsRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $currentStatus = $this->postnl->getCurrentStatus( (new CurrentStatus())
            ->setShipment(
                (new Shipment())
                    ->setBarcode('3S8392302392342')
            ));

        $this->assertInstanceOf(CurrentStatusResponse::class, $currentStatus);
        $this->assertNull($currentStatus->getShipments());
        $this->assertIsArray($currentStatus->getWarnings());
        $this->assertInstanceOf(Warning::class, $currentStatus->getWarnings()[0]);
        $this->assertEquals('No shipment found', $currentStatus->getWarnings()[0]->getDescription());
        $this->assertEquals('2', $currentStatus->getWarnings()[0]->getCode());
    }

    /**
     * @return array[]
     */
    public function getCurrentStatusByBarcodeProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/currentstatus.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/currentstatus2.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/currentstatus3.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function getCompleteStatusByBarcodeProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/completestatus.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/completestatus2.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/completestatus3.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function getUpdatedShipmentsProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/updatedshipments.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function getNoCurrentShipmentsProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/shippingstatus/nocurrentshipments.http'))],
        ];
    }
}
