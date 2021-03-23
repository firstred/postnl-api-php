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

namespace ThirtyBees\PostNL\Tests\Misc;

use PHPUnit\Framework\TestCase;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\PostNL;

/**
 * Class PostNLTest.
 *
 * @testdox The PostNL object
 */
class PostNLTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;

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
    }

    /**
     * @testdox cannot generate an international barcode without a GlobalPack range
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     * @throws \ThirtyBees\PostNL\Exception\InvalidConfigurationException
     */
    public function testGlobalPackWithoutRange()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException');

        $this->postnl->getCustomer()->setGlobalPackCustomerCode(null);

        $this->postnl->generateBarcodesByCountryCodes(['US' => 3]);
    }

    /**
     * @testdox cannot generate an international barcode without a GlobalPack type
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidBarcodeException
     * @throws \ThirtyBees\PostNL\Exception\InvalidConfigurationException
     */
    public function testGlobalPackWithoutType()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException');

        $this->postnl->getCustomer()->setGlobalPackBarcodeType(null);

        $this->postnl->generateBarcodesByCountryCodes(['US' => 3]);
    }
}
