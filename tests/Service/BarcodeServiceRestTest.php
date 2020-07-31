<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Tests\Service;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Barcode;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\BarcodeService;

/**
 * Class BarcodeServiceRestTest.
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceRestTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostNL */
    protected $postnl;
    /** @var BarcodeService */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
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
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
            true,
            PostNL::MODE_REST
        );

        $this->service = $this->postnl->getBarcodeService();
    }

    /**
     * @after
     */
    public function logPendingRequest()
    {
        if (!$this->lastRequest instanceof Request) {
            return;
        }

        global $logger;
        if ($logger instanceof LoggerInterface) {
            $logger->debug($this->getName()." Request\n".\GuzzleHttp\Psr7\str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox returns a valid service object
     */
    public function testHasValidBarcodeService()
    {
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Service\\BarcodeService', $this->service);
    }

    /**
     * @testdox creates a valid 3S barcode request
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     */
    public function testCreatesAValid3SBarcodeRequest()
    {
        $type = '3S';
        $range = $this->getRange('3S');
        $serie = $this->postnl->findBarcodeSerie('3S', $range, false);

        $this->lastRequest = $request = $this->service->buildGenerateBarcodeRequestREST(
            GenerateBarcode::create()
                ->setBarcode(
                    Barcode::create()
                        ->setRange($range)
                        ->setSerie($serie)
                        ->setType($type)
                )
                ->setMessage(new Message())
                ->setCustomer($this->postnl->getCustomer())
        );

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals([
            'CustomerCode'   => 'DEVC',
            'CustomerNumber' => '11223344',
            'Type'           => '3S',
            'Serie'          => '987000000-987600000',
        ],
            $query,
            null,
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
     * @param string $type
     *
     * @return string
     */
    protected function getRange($type)
    {
        if (in_array($type, ['2S', '3S'])) {
            return $this->postnl->getCustomer()->getCustomerCode();
        } else {
            return $this->postnl->getCustomer()->getGlobalPackCustomerCode();
        }
    }

    /**
     * @testdox return a valid single barcode
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     */
    public function testSingleBarcodeRest()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode([
                'Barcode' => '3SDEVC816223392',
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->assertEquals('3SDEVC816223392', $this->postnl->generateBarcode('3S'));
    }

    /**
     * @testdox return a valid single barcode for a country
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     * @throws \ThirtyBees\PostNL\Exception\InvalidConfigurationException
     */
    public function testSingleBarCodeByCountryRest()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode([
                'Barcode' => '3SDEVC816223392',
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->assertEquals('3SDEVC816223392', $this->postnl->generateBarcodeByCountryCode('NL'));
    }

    /**
     * @testdox returns several barcodes
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     * @throws \ThirtyBees\PostNL\Exception\InvalidConfigurationException
     */
    public function testMultipleNLBarcodesRest()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode([
                'Barcode' => '3SDEVC816223392',
            ])),
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode([
                'Barcode' => '3SDEVC816223393',
            ])),
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode([
                'Barcode' => '3SDEVC816223394',
            ])),
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode([
                'Barcode' => '3SDEVC816223395',
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $barcodes = $this->postnl->generateBarcodesByCountryCodes(['NL' => 4]);

        $this->assertEquals([
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

    /**
     * @testdox return a valid single barcode
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     */
    public function testNegativeSingleBarcodeInvalidResponse()
    {
        $this->expectException('ThirtyBees\\PostNL\\Exception\\ResponseException');

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], 'asdfojasuidfo'),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->postnl->generateBarcode('3S');
    }
}
