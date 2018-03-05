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

use GuzzleHttp\Psr7\Request;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Barcode;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\BarcodeService;

/**
 * Class BarcodeServiceTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceTest extends \PHPUnit_Framework_TestCase
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
        $logger->debug($this->getName()." Request\n".\GuzzleHttp\Psr7\str($this->lastRequest));
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
     * @throws \ReflectionException
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     */
    public function testCreatesAValid3SBarcodeRequest()
    {
        $this->lastRequest = $request = $this->service->buildGenerateBarcodeRESTRequest(
            GenerateBarcode::create()
                ->setBarcode(
                    Barcode::create()
                        ->setRange($this->getRange('3S'))
                        ->setSerie($this->postnl->findBarcodeSerie('3S', $this->getRange('3S'), false))
                        ->setType('3S')
                )
                ->setMessage(new Message())
                ->setCustomer($this->postnl->getCustomer())
        );

        $this->assertInstanceOf('\\GuzzleHttp\\Psr7\\Request', $request);
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
}
