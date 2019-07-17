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

namespace Firstred\PostNL\Tests\Integration\Service;

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class BarcodeServiceSoapTest
 *
 * @testdox The BarcodeService (SOAP)
 */
class BarcodeServiceSoapTest extends TestCase
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
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            Customer::create()
                ->setCollectionLocation(getenv('POSTNL_COLLECTION_LOCATION'))
                ->setCustomerCode(getenv('POSTNL_CUSTOMER_CODE'))
                ->setCustomerNumber(getenv('POSTNL_CUSTOMER_NUMBER'))
                ->setContactPerson(getenv('POSTNL_CONTACT_PERSON'))
                ->setAddress(Address::create([
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ])),
            getenv('POSTNL_API_KEY'),
            true,
            PostNL::MODE_SOAP
        );

        $this->service = $this->postnl->getBarcodeService();
        $this->service->cache = new VoidCachePool();
        $this->service->ttl = 1;
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
     * @testdox Returns a valid single barcode
     *
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     */
    public function testSingleBarcodeSoap()
    {
        $this->assertStringContainsString('3SDEVC', $this->postnl->generateBarcode('3S'));
    }

    /**
     * @testdox Returns several barcodes
     *
     * @throws \Firstred\PostNL\Exception\InvalidBarcodeException
     * @throws \Firstred\PostNL\Exception\InvalidConfigurationException
     */
    public function testMultipleNLBarcodesSoap()
    {
        $barcodes = $this->postnl->generateBarcodesByCountryCodes(['NL' => 4]);

        $this->assertIsArray($barcodes);
        $this->assertStringContainsString('3SDEVC', $barcodes['NL'][0]);
    }
}
