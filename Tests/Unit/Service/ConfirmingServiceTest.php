<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
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
 *
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Unit\Service;

use Cache\Adapter\Void\VoidCachePool;
use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Request\ConfirmShipmentRequest;
use Firstred\PostNL\Entity\Response\ConfirmShipmentResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ConfirmingService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class ConfirmingServiceTest
 *
 * @testdox The ConfirmingService (REST)
 */
class ConfirmingServiceTest extends TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var ConfirmingService $service */
    protected $service;
    /** @var $lastRequest */
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
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress(
                    (new Address())
                        ->setAddressType('02')
                        ->setCity('Hoofddorp')
                        ->setCompanyName('PostNL')
                        ->setCountrycode('NL')
                        ->setHouseNr('42')
                        ->setStreet('Siriusdreef')
                        ->setZipcode('2132WT')
                )
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'),
            'test',
            true
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
            $logger->debug($this->getName()." Request\n".Message::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Returns a valid service object
     */
    public function testHasValidConfirmingService()
    {
        $this->assertInstanceOf(ConfirmingService::class, $this->service);
    }

    /**
     * @testdox Confirms a label properly
     *
     * @throws Exception
     */
    public function testConfirmsALabelRequestRest()
    {
        $this->lastRequest = $request = $this->service->buildConfirmRequest(
            ConfirmShipmentRequest::create()
                ->setShipments(
                    [
                        Shipment::create()
                            ->setAddresses(
                                [
                                    Address::create(
                                        [
                                            'AddressType' => '01',
                                            'City'        => 'Utrecht',
                                            'Countrycode' => 'NL',
                                            'FirstName'   => 'Peter',
                                            'HouseNr'     => '9',
                                            'HouseNrExt'  => 'a bis',
                                            'Name'        => 'de Ruijter',
                                            'Street'      => 'Bilderdijkstraat',
                                            'Zipcode'     => '3521VA',
                                        ]
                                    ),
                                    Address::create(
                                        [
                                            'AddressType' => '02',
                                            'City'        => 'Hoofddorp',
                                            'CompanyName' => 'PostNL',
                                            'Countrycode' => 'NL',
                                            'HouseNr'     => '42',
                                            'Street'      => 'Siriusdreef',
                                            'Zipcode'     => '2132WT',
                                        ]
                                    ),
                                ]
                            )
                            ->setBarcode('3S1234567890123')
                            ->setDeliveryAddress('01')
                            ->setDimension(new Dimension('2000'))
                            ->setProductCodeDelivery('3085'),
                    ]
                )
        );

        $this->assertEquals(
            [
                'Customer'  => [
                    'Address'                => [
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ],
                    'CollectionLocation'     => '123456',
                    'ContactPerson'          => 'Test',
                    'CustomerCode'           => 'DEVC',
                    'CustomerNumber'         => '11223344',
                    'GlobalPackCustomerCode' => '1234',
                    'GlobalPackBarcodeType'  => 'AB',
                ],
                'Message'   => [
                    'MessageID'        => '1',
                    'MessageTimeStamp' => date('d-m-Y 00:00:00'),
                    'Printertype'      => 'GraphicFile|PDF',
                ],
                'Shipments' => [
                    'Addresses'           => [
                        [
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                            'Firstname'   => 'Peter',
                        ],
                        [
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ],
                    ],
                    'Barcode'             => '3S1234567890123',
                    'DeliveryAddress'     => '01',
                    'Dimension'           => [
                        'Weight' => '2000',
                    ],
                    'ProductCodeDelivery' => '3085',
                ],
            ],
            json_decode((string) $request->getBody(), true)
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can generate a single label
     *
     * @throws Exception
     */
    public function testConfirmsALabelRest()
    {
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient = new Client();
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody(
                    $streamFactory->createStream(
                        json_encode(
                            [
                                'ConfirmingResponseShipments' => [
                                    'ConfirmShipmentResponse' => [
                                        'Barcode'  => '3SDEVC987119100',
                                        'Warnings' => [],
                                        'Errors'   => [],
                                    ],
                                ],
                            ]
                        )
                    )
                )
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $confirm = $this->postnl->confirmShipment(
            (new Shipment())
                ->setAddresses([
                    Address::create([
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
                    Address::create([
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );

        $this->assertInstanceOf(ConfirmShipmentResponse::class, $confirm);
    }

    /**
     * @testdox Can confirm multiple labels
     *
     * @throws Exception
     */
    public function testConfirmMultipleLabelsRest()
    {
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient = new Client();
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody(
                    $streamFactory->createStream(
                        json_encode(
                            [
                                'ConfirmingResponseShipments' => [
                                    'ConfirmShipmentResponse' => [
                                        'Barcode'  => '3SDEVC201611210',
                                        'Warnings' => [],
                                        'Errors'   => [],
                                    ],
                                ],
                            ]
                        )
                    )
                )
        );
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody(
                    $streamFactory->createStream(
                        json_encode(
                            [
                                'ConfirmingResponseShipments' => [
                                    'ConfirmShipmentResponse' => [
                                        'Barcode'  => '3SDEVC201611211',
                                        'Warnings' => [],
                                        'Errors'   => [],
                                    ],
                                ],
                            ]
                        )
                    )
                )
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $confirms = $this->postnl->confirmShipments([
                (new Shipment())
                    ->setAddresses([
                        Address::create([
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
                        Address::create([
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode('3SDEVC201611210')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
                (new Shipment())
                    ->setAddresses([
                        Address::create([
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
                        Address::create([
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode('3SDEVC201611211')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
        ]);

        $this->assertInstanceOf(ConfirmShipmentResponse::class, $confirms[1]);
    }

    /**
     * @testdox Throws exception on invalid response
     *
     * @throws Exception
     */
    public function testNegativeGenerateLabelInvalidResponseRest()
    {
        $this->expectException(CifDownException::class);

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient = new Client();
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream('asdfojasuidfo'))
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $this->postnl->confirmShipment(
            (new Shipment())
                ->setAddresses([
                    Address::create([
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
                    Address::create([
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );
    }
}
