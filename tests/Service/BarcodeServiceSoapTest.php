<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @copyright 2017 Thirty Development, LLC
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
 * Class BarcodeServiceSoapTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The BarcodeService (SOAP)
 */
class BarcodeServiceSoapTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var BarcodeService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
     * @throws \ReflectionException
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
                ->setGlobalPackCustomerCode('1234')
            , new UsernameToken(null, 'test'),
            true,
            PostNL::MODE_SOAP
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
     * @testdox creates a valid 3S barcode request
     *
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     */
    public function testCreatesAValid3SBarcodeRequest()
    {
        $type = '3S';
        $range = $this->getRange('3S');
        $serie = $this->postnl->findBarcodeSerie('3S', $range, false);

        $this->lastRequest = $request = $this->service->buildGenerateBarcodeSOAPRequest(
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

        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox return a valid single barcode
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     */
    public function testSingleBarcodeSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'text/xml;charset=UTF-8'], $this->mockValidBarcodeResponse('3SDEVC816223392')),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->assertEquals('3SDEVC816223392', $this->postnl->generateBarcode('3S'));
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
     * @param string $barcode
     *
     * @return string
     */
    protected function mockValidBarcodeResponse($barcode)
    {
        return "<code><s:Envelope xmlns:s=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <s:Body>
    <GenerateBarcodeResponse xmlns=\"http://postnl.nl/cif/services/BarcodeWebService/\"
xmlns:a=\"http://postnl.nl/cif/domain/BarcodeWebService/\"
xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\">
      <a:Barcode>{$barcode}</a:Barcode>
    </GenerateBarcodeResponse>
  </s:Body>
</s:Envelope>
</code>";
    }
}
