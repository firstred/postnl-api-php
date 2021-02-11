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

namespace Firstred\PostNL\Tests\Unit\Service;

use Exception;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\DTO\Request\GetDeliveryInformationRequestDTO;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\CutOffTimes;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Service\CheckoutService;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;

/**
 * Class CheckoutServiceTest.
 *
 * @testdox The CheckoutService (REST)
 */
class CheckoutServiceTest extends ServiceTestBase
{
    /**
     * @testdox Returns a valid service object
     */
    public function testHasValidCheckoutService()
    {
        $this->assertInstanceOf(expected: CheckoutService::class, actual: $this->postnl->getCheckoutService());
    }

    /**
     * @testdox Can create a checkout request
     *
     * @throws Exception
     */
    public function testGetDeliveryInformationRequestRest()
    {
        /** @noinspection PhpNamedArgumentsWithChangedOrderInspection */
        $this->lastRequest = $request = $this->postnl->getCheckoutService()->getGateway()->getRequestBuilder()->buildGetDeliveryInformationRequest(
            getDeliveryInformationRequestDTO: new GetDeliveryInformationRequestDTO(
                service: CheckoutServiceInterface::class,
                propType: RequestProp::class,
                OrderDate: '15-02-2020 12:12:12',
                ShippingDuration: 1,
                HolidaySorting: false,
                Options: ['Daytime'],
                Locations: 3,
                Days: 5,
                CutOffTimes: [
                    new CutOffTime(
                        Day: CutOffTime::DAY_DEFAULT,
                        Available: true,
                        Time: '23:00:00',
                        Type: CutOffTime::TYPE_REGULAR,
                    ),
                ],
                Addresses: [
                    new Address(
                        AddressType: '01',
                        Countrycode: 'NL',
                        HouseNr: 42,
                        Street: 'Teststraat',
                        Zipcode: '2132WT',
                    ),
                ],
            ),
        );

        $this->assertJsonStringEqualsJsonString(
            expectedJson: /** @lang JSON */ <<<JSON
            {
              "Addresses": [{
                "AddressType": "01",
                "Countrycode": "NL",
                "HouseNr": 42,
                "Street": "Teststraat",
                "Zipcode": "2132WT"
              }],
              "CutOffTimes": [{
                "Day": "00",
                "Available": true,
                "Time":"23:00:00",
                "Type": "Regular"
              }],
              "Days": 5,
              "HolidaySorting": false,
              "Locations": 3,
              "Options": [
                "Daytime"
              ],
              "OrderDate": "15-02-2020 12:12:12",
              "ShippingDuration": 1
            }
            JSON,
            actualJson: (string) $request->getBody(),
        );
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can generate a single label
     *
     * @throws Exception
     */
    public function testConfirmsALabelRest()
    {
        $this->markTestIncomplete();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient = new Client();
        $mockClient->addResponse(
            response: $responseFactory->createResponse(code: 200, reasonPhrase: 'OK')
                ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
                ->withBody(
                    body: $streamFactory->createStream(
                        content: json_encode(
                            value: [
                                'CheckoutResponseShipments' => [
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
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension(weight: '2000'))
                ->setProductCodeDelivery('3085')
        );

        $this->assertInstanceOf(expected: ConfirmShipmentResponse::class, actual: $confirm);
    }

    /**
     * @testdox Can confirm multiple labels
     *
     * @throws Exception
     */
    public function testConfirmMultipleLabelsRest()
    {
        $this->markTestIncomplete();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient = new Client();
        $mockClient->addResponse(
            response: $responseFactory->createResponse(code: 200, reasonPhrase: 'OK')
                ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
                ->withBody(
                    body: $streamFactory->createStream(
                        content: json_encode(
                            value: [
                                'CheckoutResponseShipments' => [
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
            response: $responseFactory->createResponse(code: 200, reasonPhrase: 'OK')
                ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
                ->withBody(
                    body: $streamFactory->createStream(
                        content: json_encode(
                            value: [
                                'CheckoutResponseShipments' => [
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
                    ->setBarcode('3SDEVC201611210')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension(weight: '2000'))
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
                    ->setBarcode('3SDEVC201611211')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension(weight: '2000'))
                    ->setProductCodeDelivery('3085'),
        ]);

        $this->assertInstanceOf(expected: ConfirmShipmentResponse::class, actual: $confirms[1]);
    }

    /**
     * @testdox Throws exception on invalid response
     *
     * @throws Exception
     */
    public function testNegativeGenerateLabelInvalidResponseRest()
    {
        $this->markTestIncomplete();

        $this->expectException(exception: ApiDownException::class);

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient = new Client();
        $mockClient->addResponse(
            response: $responseFactory->createResponse(code: 200, reasonPhrase: 'OK')
                ->withHeader(name: 'Content-Type', value: 'application/json;charset=UTF-8')
                ->withBody(body: $streamFactory->createStream(content: 'asdfojasuidfo'))
        );
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $this->postnl->confirmShipment(
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
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension(weight: '2000'))
                ->setProductCodeDelivery('3085')
        );
    }
}
