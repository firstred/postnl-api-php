<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Integration\Service;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

abstract class ServiceTestBase extends TestCase
{
    protected PostNL $postnl;

    protected ?RequestInterface $lastRequest = null;

    /**
     * @before
     */
    public function setupPostNL()
    {
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $customer = (new Customer())
            ->setCollectionLocation(CollectionLocation: getenv(name: 'POSTNL_COLLECTION_LOCATION'))
            ->setCustomerCode(CustomerCode: getenv(name: 'POSTNL_CUSTOMER_CODE'))
            ->setCustomerNumber(CustomerNumber: getenv(name: 'POSTNL_CUSTOMER_NUMBER'))
            ->setContactPerson(ContactPerson: getenv(name: 'POSTNL_CONTACT_PERSION'))
            ->setAddress(Address: new Address(
                AddressType: '02',
                City: 'Hoofddorp',
                CompanyName: 'PostNL',
                Countrycode: 'NL',
                HouseNr: '42',
                Street: 'Siriusdreef',
                Zipcode: '2132WT',
            ))
            ->setGlobalPackBarcodeType(getenv(name: 'POSTNL_GLOBAL_PACK_BARCODE_TYPE'))
            ->setGlobalPackCustomerCode(getenv(name: 'POSTNL_GLOBAL_PACK_RANGE'));

        $this->postnl = new PostNL(
            customer: $customer,
            apiKey: getenv(name: 'POSTNL_API_KEY'),
            sandbox: false,
        );
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
            $logger->debug($this->getName()." Request\n".Message::str(message: $this->lastRequest));
        }
        $this->lastRequest = null;
    }
}
