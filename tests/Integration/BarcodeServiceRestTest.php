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

namespace Firstred\PostNL\Tests\Integration\Service;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidBarcodeException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class BarcodeServiceTest.
 *
 * @testdox The BarcodeService (REST)
 */
class BarcodeServiceRestTest extends TestCase
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
     * @throws InvalidArgumentException
     * @throws ReflectionException
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
            $logger->debug($this->getName()." Request\n".Message::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Returns a valid single barcode
     *
     * @throws InvalidBarcodeException
     */
    public function testSingleBarcodeRest()
    {
        $this->assertStringContainsString('3SDEVC', $this->postnl->generateBarcode('3S'));
    }

    /**
     * @testdox Returns a valid single barcode for a country
     *
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     */
    public function testSingleBarCodeByCountryRest()
    {
        $this->assertStringContainsString('3SDEVC', $this->postnl->generateBarcodeByCountryCode('NL'));
    }

    /**
     * @testdox Returns several barcodes
     *
     * @throws InvalidBarcodeException
     * @throws InvalidConfigurationException
     */
    public function testMultipleNLBarcodesRest()
    {
        $barcodes = $this->postnl->generateBarcodesByCountryCodes(['NL' => 4]);

        $this->assertIsArray($barcodes);
        $this->assertStringContainsString('3SDEVC', $barcodes['NL'][0]);
    }
}
