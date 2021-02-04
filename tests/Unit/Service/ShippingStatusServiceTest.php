<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Unit\Service;

use Exception;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByBarcodeRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByKgidRequest;
use Firstred\PostNL\Entity\Request\RetrieveShipmentByReferenceRequest;
use Firstred\PostNL\Entity\Request\RetrieveSignatureByBarcodeRequest;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Misc\Message;
use Http\Client\Exception as HttpClientException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;

/**
 * Class ShippingStatusRestTest.
 *
 * @testdox The ShippingStatusService (REST)
 */
class ShippingStatusServiceTest extends ServiceTestBase
{
    /**
     * @testdox Creates a valid LookupShipmentByBarcodeRequest request
     *
     * @throws Exception
     */
    public function testRetrieveShipmentByBarcodeRequest()
    {
        $this->markTestIncomplete();

        $barcode = '3SDEVC987021270';
        $this->lastRequest = $request = $this->service->buildRetrieveShipmentRequest(
            (new RetrieveShipmentByBarcodeRequest())
                ->setBarcode($barcode)
        );

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEmpty(actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/barcode/$barcode", actual: $request->getUri()->getPath());
    }

    /**
     * @testdox Creates a valid LookupShipmentByBarcodeRequest request
     *
     * @throws Exception
     */
    public function testRetrieveShipmentByReferenceRequest()
    {
        $this->markTestIncomplete();

        $reference = '112233';
        $this->lastRequest = $request = $this->service->buildRetrieveShipmentRequest(
            (new RetrieveShipmentByReferenceRequest())
                ->setReference($reference)
        );

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(expected: $query, actual: [
            'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
            'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
        ]);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/reference/$reference", actual: $request->getUri()->getPath());
    }

    /**
     * @testdox Creates a valid LookupShipmentByBarcodeRequest request
     *
     * @throws Exception
     */
    public function testRetrieveShipmentByKgidRequest()
    {
        $this->markTestIncomplete();

        $kgid = 'KG112233';
        $this->lastRequest = $request = $this->service->buildRetrieveShipmentRequest(
            (new RetrieveShipmentByKgidRequest())
                ->setKgid($kgid)
        );

        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEmpty(actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/lookup/$kgid", actual: $request->getUri()->getPath());
    }

    /**
     * @testdox Can get the current status
     *
     * @throws Exception
     * @throws HttpClientException
     */
    public function testRetrieveShipmentByBarcode()
    {
        $this->markTestIncomplete();

        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(code: 200, reasonPhrase: 'OK')
            ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
            ->withBody(body: $streamFactory->createStream(content: file_get_contents(filename: __DIR__.'/../../data/responses/shipment.json')))
        ;
        $mockClient->addResponse(response: $response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $shipment = $this->postnl->retrieveShipmentByBarcode('3SDEVC987021270');

        $this->assertInstanceOf(expected: Shipment::class, actual: $shipment);
    }

    /**
     * @testdox creates a valid GetSignature request
     */
    public function testGetSignatureRequestRest()
    {
        $this->markTestIncomplete();

        $barcode = '3S9283920398234';
        $message = new Message();
        $this->lastRequest = $request = $this->service->buildRetrieveSignatureRequest((new RetrieveSignatureByBarcodeRequest())->setBarcode($barcode));
        parse_str(string: $request->getUri()->getQuery(), result: $query);
        $this->assertEmpty(actual: $query);
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
        $this->assertEquals(expected: "/shipment/v2/status/signature/$barcode", actual: $request->getUri()->getPath());
    }

    /**
     * @testdox can get the signature
     */
    public function testGetSignatures()
    {
        $this->markTestIncomplete();

        $payload = file_get_contents(filename: __DIR__.'/../../data/responses/signature.json');
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient->addResponse(
            response: $responseFactory->createResponse(code: 200, reasonPhrase: 'OK')
                ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
                ->withBody(body: $streamFactory->createStream(content: $payload))
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $signatureResponse = $this->postnl->retrieveSignatureByBarcode('3SABCD6659149');
        $this->assertInstanceOf(expected: Signature::class, actual: $signatureResponse);
    }
}
