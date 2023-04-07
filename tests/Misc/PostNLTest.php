<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Misc;

use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\PostNL;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

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
     * @throws
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            (new Customer())
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress((new Address())
                    ->setAddressType('02')
                    ->setCity('Hoofddorp')
                    ->setCompanyName('PostNL')
                    ->setCountrycode('NL')
                    ->setHouseNr('42')
                    ->setStreet('Siriusdreef')
                    ->setZipcode('2132WT')
                )
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
            true,
            PostNL::MODE_REST
        );
    }

    /**
     * @testdox cannot generate an international barcode without a GlobalPack range
     *
     * @throws
     */
    public function testGlobalPackWithoutRange()
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->postnl->getCustomer()->setGlobalPackCustomerCode(null);

        $this->postnl->generateBarcodesByCountryCodes(['US' => 3]);
    }

    /**
     * @testdox cannot generate an international barcode without a GlobalPack type
     *
     * @throws
     */
    public function testGlobalPackWithoutType()
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->postnl->getCustomer()->setGlobalPackBarcodeType(null);

        $this->postnl->generateBarcodesByCountryCodes(['US' => 3]);
    }
}
