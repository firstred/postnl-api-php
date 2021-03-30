<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker
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

namespace Firstred\PostNL\Tests\Service;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Barcode;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use function file_get_contents;
use const _RESPONSES_DIR_;

/**
 * Class BarcodeServiceRestTest.
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceRestTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var BarcodeServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws \ReflectionException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \libphonenumber\NumberParseException
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
            $logger->debug($this->getName()." Request\n".PsrMessage::toString($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox returns a valid service object
     */
    public function testHasValidBarcodeService()
    {
        $this->assertInstanceOf(BarcodeService::class, $this->service);
    }

    /**
     * @testdox creates a valid 3S barcode request
     *
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     * @throws \ReflectionException
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

        $query = Query::parse($request->getUri()->getQuery());

        $this->assertEqualsCanonicalizing([
            'CustomerCode'   => 'DEVC',
            'CustomerNumber' => '11223344',
            'Type'           => '3S',
            'Serie'          => '987000000-987600000',
        ],
            $query
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
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     */
    public function testSingleBarcodeRest()
    {
        $mock = new MockHandler([
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/singlebarcode.http')),
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
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     * @throws \Firstred\PostNL\Exception\InvalidConfigurationException
     */
    public function testSingleBarCodeByCountryRest()
    {
        $mock = new MockHandler([
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/singlebarcode.http')),
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
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     * @throws \Firstred\PostNL\Exception\InvalidConfigurationException
     */
    public function testMultipleNLBarcodesRest()
    {
        $mock = new MockHandler([
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/singlebarcode.http')),
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/singlebarcode2.http')),
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/singlebarcode3.http')),
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/singlebarcode4.http')),
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
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     */
    public function testNegativeSingleBarcodeInvalidResponse()
    {
        $this->expectException(ResponseException::class);

        $mock = new MockHandler([
            PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/barcode/invalid.http')),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->postnl->generateBarcode('3S');
    }
}
