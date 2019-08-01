<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Unit\Service;

use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\GenerateBarcodeRequest;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Misc\Message as MiscMessage;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class BarcodeServiceTest
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceTest extends TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var BarcodeService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
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

        $this->service = $this->postnl->getBarcodeService();
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
            $logger->debug($this->getName()." Request\n".MiscMessage::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Returns a valid service object
     */
    public function testHasValidBarcodeService()
    {
        $this->assertInstanceOf(BarcodeService::class, $this->service);
    }

    /**
     * @testdox Creates a valid 3S barcode request
     *
     * @throws InvalidBarcodeException
     * @throws Exception
     */
    public function testCreatesAValid3SBarcodeRequest()
    {
        $type = '3S';
        $range = $this->getRange('3S');
        $serie = $this->postnl->findBarcodeSerie('3S', $range, false);

        $this->lastRequest = $request = $this->service->buildGenerateBarcodeRequest(
            (new GenerateBarcodeRequest())
                ->setRange($range)
                ->setSerie($serie)
                ->setType($type)
        );
        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            [
                'CustomerCode'   => 'DEVC',
                'CustomerNumber' => '11223344',
                'Type'           => '3S',
                'Serie'          => '987000000-987600000',
            ],
            $query,
            '',
            0,
            10,
            true
        );
        $this->assertEmpty((string) $request->getBody());
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid single barcode
     *
     * @throws InvalidBarcodeException
     */
    public function testSingleBarcodeRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(['Barcode' => '3SDEVC816223392'])))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $this->assertEquals('3SDEVC816223392', $this->postnl->generateBarcode('3S'));
    }

    /**
     * @testdox Returns a valid single barcode for a country
     *
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     */
    public function testSingleBarCodeByCountryRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(['Barcode' => '3SDEVC816223392'])))
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $this->assertEquals('3SDEVC816223392', $this->postnl->generateBarcodeByCountryCode('NL'));
    }

    /**
     * @testdox Returns several barcodes
     *
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     */
    public function testMultipleNLBarcodesRest()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(['Barcode' => '3SDEVC816223392'])))
        );
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(['Barcode' => '3SDEVC816223393'])))
        );
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(['Barcode' => '3SDEVC816223394'])))
        );
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream(json_encode(['Barcode' => '3SDEVC816223395'])))
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $barcodes = $this->postnl->generateBarcodesByCountryCodes(['NL' => 4]);

        $this->assertEquals(
            [
                'NL' => [
                    '3SDEVC816223392',
                    '3SDEVC816223393',
                    '3SDEVC816223394',
                    '3SDEVC816223395',
                ],
            ],
            $barcodes
        );
    }

//    /**
//     * @testdox Returns a valid single barcode
//     *
//     * @throws InvalidBarcodeException
//     */
//    public function testNegativeSingleBarcodeInvalidResponse()
//    {
//        $this->expectException(HttpClientException::class);
//
//        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
//        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
//        $mockClient = new Client();
//        $mockClient->addResponse(
//            $responseFactory->createResponse(200, 'OK')
//                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
//                ->withBody($streamFactory->createStream('asdfojasuidfo'))
//        );
//        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);
//
//        $this->postnl->generateBarcode('3S');
//    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function getRange($type)
    {
        if (in_array($type, ['2S', '3S'])) {
            return $this->postnl->getCustomer()->getCustomerCode();
        }

        return $this->postnl->getCustomer()->getGlobalPackCustomerCode();
    }
}
