<?php

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Unit\Service;

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
        $apiKey = 'test';
        $sandbox = true;
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $customer = (new Customer())
            ->setCollectionLocation(CollectionLocation: '123456')
            ->setCustomerCode(CustomerCode: 'DEVC')
            ->setCustomerNumber(CustomerNumber: '11223344')
            ->setContactPerson(ContactPerson: 'Test')
            ->setAddress(Address: new Address(
                AddressType: '02',
                City: 'Hoofddorp',
                CompanyName: 'PostNL',
                Countrycode: 'NL',
                HouseNr: '42',
                Street: 'Siriusdreef',
                Zipcode: '2132WT',
            ))
            ->setGlobalPackBarcodeType('AB')
            ->setGlobalPackCustomerCode('1234');

        $this->postnl = new PostNL(
            customer: $customer,
            apiKey: $apiKey,
            sandbox: $sandbox,
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
