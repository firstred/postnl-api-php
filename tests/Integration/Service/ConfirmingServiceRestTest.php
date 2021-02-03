<?php

declare(strict_types=1);
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

namespace Firstred\PostNL\Tests\Integration\Service;

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Response\ConfirmShipmentResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ConfirmingService;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class ConfirmingServiceTest.
 *
 * @testdox The ConfirmingService (REST)
 */
class ConfirmingServiceRestTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;
    /** @var ConfirmingService */
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
            customer: Customer::create()
                ->setCollectionLocation(getenv(name: 'POSTNL_COLLECTION_LOCATION'))
                ->setCustomerCode(getenv(name: 'POSTNL_CUSTOMER_CODE'))
                ->setCustomerNumber(getenv(name: 'POSTNL_CUSTOMER_NUMBER'))
                ->setContactPerson(getenv(name: 'POSTNL_CONTACT_PERSON'))
                ->setAddress(Address::create(properties: [
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ])),
            token: getenv(name: 'POSTNL_API_KEY'),
            sandbox: true
        );

        $this->service = $this->postnl->getConfirmingService();
        $this->service->cache = new VoidCachePool();
        $this->service->ttl = 1;
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

    /**
     * @testdox Can generate a single label
     *
     * @throws \Exception
     */
    public function testConfirmsALabelRest()
    {
        $confirm = $this->postnl->confirmShipment(
            shipment: (new Shipment())
                ->setAddresses([
                    Address::create(properties: [
                        'AddressType' => '01',
                        'City'        => 'Utrecht',
                        'Countrycode' => 'NL',
                        'FirstName'   => 'Peter',
                        'HouseNr'     => '9',
                        'HouseNrExt'  => 'a bis',
                        'Name'        => 'de Ruijter',
                        'Street'      => 'Bilderdijkstraat',
                        'Zipcode'     => '3521VA',
                    ]),
                    Address::create(properties: [
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode($this->postnl->generateBarcode(type: '3S'))
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension(weight: 2000))
                ->setProductCodeDelivery('3085')
        );

        $this->assertInstanceOf(expected: ConfirmShipmentResponse::class, actual: $confirm);
    }

    /**
     * @testdox Can confirm multiple labels
     *
     * @throws \Exception
     */
    public function testConfirmMultipleLabelsRest()
    {
        $confirms = $this->postnl->confirmShipments(shipments: [
                (new Shipment())
                    ->setAddresses([
                        Address::create(properties: [
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'FirstName'   => 'Peter',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                        ]),
                        Address::create(properties: [
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode($this->postnl->generateBarcode(type: '3S'))
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension(weight: 2000))
                    ->setProductCodeDelivery('3085'),
                (new Shipment())
                    ->setAddresses([
                        Address::create(properties: [
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'FirstName'   => 'Peter',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                        ]),
                        Address::create(properties: [
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode($this->postnl->generateBarcode(type: '3S'))
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension(weight: 2000))
                    ->setProductCodeDelivery('3085'),
        ]);

        $this->assertInstanceOf(expected: ConfirmShipmentResponse::class, actual: $confirms[1]);
    }
}
