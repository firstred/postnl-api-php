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

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Misc;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\PostNL;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox(text: 'The PostNL object')]
class PostNLTest extends TestCase
{
    protected PostNL $postnl;

    /** @throws */
    #[Before]
    public function setupPostNL(): void
    {
        $this->postnl = new PostNL(
            customer: new Customer(
                CustomerNumber: '11223344',
                CustomerCode: 'DEVC',
                CollectionLocation: '123456',
                ContactPerson: 'Test',
                Address: new Address(
                    AddressType: '02',
                    CompanyName: 'PostNL',
                    Street: 'Siriusdreef',
                    HouseNr: '42',
                    Zipcode: '2132WT',
                    City: 'Hoofddorp',
                    Countrycode: 'NL',
                ),
                GlobalPackCustomerCode: 'AB',
                GlobalPackBarcodeType: '1234',
            ),
            apiKey: 'test',
            sandbox: true,
        );
    }

    /** @throws */
    #[TestDox(text: 'cannot generate an international barcode without a GlobalPack range')]
    public function testGlobalPackWithoutRange(): void
    {
        $this->expectException(exception: InvalidConfigurationException::class);

        $this->postnl->getCustomer()->setGlobalPackCustomerCode(GlobalPackCustomerCode: null);

        $this->postnl->generateBarcodesByCountryCodes(isos: ['US' => 3]);
    }

    /** @throws */
    #[TestDox(text: 'cannot generate an international barcode without a GlobalPack type')]
    public function testGlobalPackWithoutType(): void
    {
        $this->expectException(exception: InvalidConfigurationException::class);

        $this->postnl->getCustomer()->setGlobalPackBarcodeType(GlobalPackBarcodeType: null);

        $this->postnl->generateBarcodesByCountryCodes(isos: ['US' => 3]);
    }
}
