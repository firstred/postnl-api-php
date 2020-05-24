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

namespace Firstred\PostNL\Factory;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\AddressInterface;
use Firstred\PostNL\Entity\CustomerInterface;
use Firstred\PostNL\Exception\InvalidArgumentException;
use ReflectionException;
use function getenv;

/**
 * Class CustomerFactory.
 */
final class CustomerFactory implements CustomerFactoryInterface
{
    private $address;
    private $customer;

    public function __construct(AddressInterface $address, CustomerInterface $customer)
    {
        $this->address = $address;
        $this->customer = $customer;
    }

    /**
     * Create a configured Customer instance.
     *
     * @return CustomerInterface
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @since 2.0.0
     */
    public function create(): CustomerInterface
    {
        if (getenv('POSTNL_CONTACT_NAME')) {
            $this->address->setName(getenv('POSTNL_CONTACT_NAME'));
        }
        if (getenv('POSTNL_CONTACT_COMPANY_NAME')) {
            $this->address->setCompanyName(getenv('POSTNL_CONTACT_COMPANY_NAME'));
        }
        $this->address->setAddressType(Address::TYPE_SENDER);
        $this->address->setStreet(getenv('POSTNL_CONTACT_STREET'));
        $this->address->setHouseNr(getenv('POSTNL_CONTACT_HOUSE_NR'));
        $this->address->setHouseNrExt(getenv('POSTNL_CONTACT_HOUSE_NR_EXT'));
        $this->address->setZipcode(getenv('POSTNL_CONTACT_ZIPCODE'));
        $this->address->setCountrycode(getenv('POSTNL_CONTACT_COUNTRY_CODE'));

        $this->customer->setEmail(getenv('POSTNL_CONTACT_EMAIL'));
        $this->customer->setCustomerCode(getenv('POSTNL_CUSTOMER_CODE'));
        $this->customer->setCustomerNumber(getenv('POSTNL_CUSTOMER_NUMBER'));
        $this->customer->setCollectionLocation(getenv('POSTNL_CUSTOMER_NUMBER'));
        $this->customer->setGlobalPackBarcodeType(getenv('POSTNL_GLOBALPACK_BARCODE_TYPE'));
        $this->customer->setGlobalPackCustomerCode(getenv('POSTNL_GLOBALPACK_CUSTOMER_CODE'));

        return $this->customer;
    }
}
