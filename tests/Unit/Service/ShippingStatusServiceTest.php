<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Unit\Service;

use Cache\Adapter\Void\VoidCachePool;
use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByBarcodeRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByKgidRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByReferenceRequest;
use Firstred\PostNL\Entity\Request\RetrieveSignatureByBarcodeRequest;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ShippingStatusService;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ShippingStatusRestTest.
 *
 * @testdox The ShippingStatusService (REST)
 */
class ShippingStatusRestTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;
    /** @var ShippingStatusService */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws InvalidArgumentException
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            Customer::create()
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress(Address::create([
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]))
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'),
            'test',
            true
        );

        $this->service = $this->postnl->getShippingStatusService();
        $this->service->cache = new VoidCachePool();
        $this->service->ttl = 1;
    }

    /**
     * @after
     */
    public function logPendingRequest()
    {
        if (!$this->lastRequest instanceof RequestInterface) {
            return;
        }

        global $logger;
        if ($logger instanceof LoggerInterface) {
            $logger->debug($this->getName()." Request\n".Message::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Creates a valid LookupShipmentByBarcodeRequest request
     *
     * @throws Exception
     */
    public function testRetrieveShipmentByBarcodeRequest()
    {
        $barcode = '3SDEVC987021270';
        $this->lastRequest = $request = $this->service->buildRetrieveShipmentRequest(
            (new RetrieveShipmentByBarcodeRequest())
                ->setBarcode($barcode)
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEmpty($query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/barcode/$barcode", $request->getUri()->getPath());
    }

    /**
     * @testdox Creates a valid LookupShipmentByBarcodeRequest request
     *
     * @throws Exception
     */
    public function testRetrieveShipmentByReferenceRequest()
    {
        $reference = '112233';
        $this->lastRequest = $request = $this->service->buildRetrieveShipmentRequest(
            (new RetrieveShipmentByReferenceRequest())
                ->setReference($reference)
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals($query, [
            'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
            'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
        ]);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/reference/$reference", $request->getUri()->getPath());
    }

    /**
     * @testdox Creates a valid LookupShipmentByBarcodeRequest request
     *
     * @throws Exception
     */
    public function testRetrieveShipmentByKgidRequest()
    {
        $kgid = 'KG112233';
        $this->lastRequest = $request = $this->service->buildRetrieveShipmentRequest(
            (new RetrieveShipmentByKgidRequest())
                ->setKgid($kgid)
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEmpty($query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/lookup/$kgid", $request->getUri()->getPath());
    }

    /**
     * @testdox Can get the current status
     *
     * @throws Exception
     * @throws HttpClientException
     */
    public function testRetrieveShipmentByBarcode()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/shipment.json')))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $shipment = $this->postnl->retrieveShipmentByBarcode('3SDEVC987021270');

        $this->assertInstanceOf(Shipment::class, $shipment);
    }

    /**
     * @testdox creates a valid GetSignature request
     */
    public function testGetSignatureRequestRest()
    {
        $barcode = '3S9283920398234';
        $message = new Message();
        $this->lastRequest = $request = $this->service->buildRetrieveSignatureRequest((new RetrieveSignatureByBarcodeRequest())->setBarcode($barcode));
        parse_str($request->getUri()->getQuery(), $query);
        $this->assertEmpty($query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals("/shipment/v2/status/signature/$barcode", $request->getUri()->getPath());
    }

    /**
     * @testdox can get the signature
     */
    public function testGetSignatures()
    {
        $payload = file_get_contents(__DIR__.'/../../data/responses/signature.json');
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream($payload))
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $signatureResponse = $this->postnl->retrieveSignatureByBarcode('3SABCD6659149');
        $this->assertInstanceOf(Signature::class, $signatureResponse);
    }
}
