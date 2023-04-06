<?php
declare(strict_types=1);
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

namespace Firstred\PostNL\Tests\Service;

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\ConfirmingServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\ConfirmingServiceRestRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;
use function file_get_contents;
use const _RESPONSES_DIR_;

#[TestDox(text: 'The ConfirmingService (REST)')]
class ConfirmingServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected ConfirmingServiceInterface $service;
    protected RequestInterface $lastRequest;

    /** @throws */
    #[Before]
    public function setupPostNL(): void
    {
        $this->postnl = new PostNL(
            customer: Customer::create()
                ->setCollectionLocation(CollectionLocation: '123456')
                ->setCustomerCode(CustomerCode: 'DEVC')
                ->setCustomerNumber(CustomerNumber: '11223344')
                ->setContactPerson(ContactPerson: 'Test')
                ->setAddress(Address: Address::create(properties: [
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]))
                ->setGlobalPackBarcodeType(GlobalPackBarcodeType: 'AB')
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'), apiKey: new UsernameToken(Username: null, Password: 'test'),
            sandbox: true,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getConfirmingService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'returns a valid service object')]
    public function testHasValidConfirmingService(): void
    {
        $this->assertInstanceOf(expected: ConfirmingService::class, actual: $this->service);
    }

    /** @throws */
    #[TestDox(text: 'confirms a label properly')]
    public function testConfirmsALabelRequestRest(): void
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildConfirmRequest(
            confirming: Confirming::create()
                ->setShipments(Shipments: [
                    Shipment::create()
                        ->setAddresses(Addresses: [
                            new Address(
                                AddressType: '01',
                                FirstName: 'Peter',
                                Name: 'de Ruijter',
                                Street: 'Bilderdijkstraat',
                                HouseNr: '9',
                                HouseNrExt: 'a bis',
                                Zipcode: '3521VA',
                                City: 'Utrecht',
                                Countrycode: 'NL',
                            ),
                            new Address(
                                AddressType: '02',
                                CompanyName: 'PostNL',
                                Street: 'Siriusdreef',
                                HouseNr: '42',
                                Zipcode: '2132WT',
                                City: 'Hoofddorp',
                                Countrycode: 'NL',
                            ),
                        ])
                        ->setBarcode(Barcode: '3S1234567890123')
                        ->setDeliveryAddress(DeliveryAddress: '01')
                        ->setDimension(Dimension: new Dimension(Weight: '2000'))
                        ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
                ])
                ->setMessage(Message: $message)
                ->setCustomer(Customer: $this->postnl->getCustomer())
        );

        $this->assertEquals(expected: [
            'Customer'  => [
                'Address'            => [
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ],
                'CollectionLocation' => '123456',
                'ContactPerson'      => 'Test',
                'CustomerCode'       => 'DEVC',
                'CustomerNumber'     => '11223344',
            ],
            'Message'   => [
                'MessageID'        => (string) $message->getMessageID(),
                'MessageTimeStamp' => $message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s'),
                'Printertype'      => 'GraphicFile|PDF',
            ],
            'Shipments' => [
                'Addresses'           => [
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
            actual: json_decode(json: (string) $request->getBody(), associative: true));
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'can generate a single label')]
    #[DataProvider(methodName: 'singleLabelConfirmationsProvider')]
    public function testConfirmsALabelRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $confirm = $this->postnl->confirmShipment(
            shipment: (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3SDEVC201611210')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085')
        );

        $this->assertInstanceOf(expected: ConfirmingResponseShipment::class, actual: $confirm);
        $this->assertEquals(expected: '3SDEVC201611210', actual: $confirm->getBarcode());
        $this->assertInstanceOf(expected: Warning::class, actual: $confirm->getWarnings()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $confirm));
    }

    /**
     * @param ResponseInterface[] $responses
     *
     * @throws
     */
    #[TestDox(text: 'can confirm multiple labels')]
    #[DataProvider(methodName: 'multipleLabelsConfirmationsProvider')]
    public function testConfirmMultipleLabelsRest(array $responses): void
    {
        $mock = new MockHandler(queue: $responses);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $confirms = $this->postnl->confirmShipments(shipments: [
            (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3SDEVC201611210')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3SDEVC201611210')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
        ]);

        $this->assertInstanceOf(expected: ConfirmingResponseShipment::class, actual: $confirms[1]);
        $this->assertEquals(expected: '3SDEVC201611210', actual: $confirms[1]->getBarcode());
        $this->assertInstanceOf(expected: Warning::class, actual: $confirms[1]->getWarnings()[0]);
    }

    /** @throws */
    #[TestDox(text: 'throws exception on invalid response')]
    public function testNegativeGenerateLabelInvalidResponseRest(): void
    {
        $this->expectException(exception: ResponseException::class);

        $mock = new MockHandler(queue: [
            new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: 'asdfojasuidfo'),
        ]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->postnl->confirmShipment(
            shipment: (new Shipment())
                ->setAddresses(Addresses: [
                    new Address(
                        AddressType: '01',
                        FirstName: 'Peter',
                        Name: 'de Ruijter',
                        Street: 'Bilderdijkstraat',
                        HouseNr: '9',
                        HouseNrExt: 'a bis',
                        Zipcode: '3521VA',
                        City: 'Utrecht',
                        Countrycode: 'NL',
                    ),
                    new Address(
                        AddressType: '02',
                        CompanyName: 'PostNL',
                        Street: 'Siriusdreef',
                        HouseNr: '42',
                        Zipcode: '2132WT',
                        City: 'Hoofddorp',
                        Countrycode: 'NL',
                    ),
                ])
                ->setBarcode(Barcode: '3S1234567890123')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085')
        );
    }

    /**
     * @return non-empty-list<non-empty-list<ResponseInterface>>
     */
    public static function singleLabelConfirmationsProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel3.http'))],
        ];
    }

    /**
     * @return non-empty-list<non-empty-list<non-empty-list<ResponseInterface>>>
     */
    public static function multipleLabelsConfirmationsProvider(): array
    {
        return [
            [
                [
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel.http')),
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel.http')),
                ]
            ],
            [
                [
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel2.http')),
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel2.http')),
                ]
            ],
            [
                [
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel3.http')),
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/confirming/confirmsinglelabel3.http')),
                ]
            ],
        ];
    }

    /** @throws */
    private function getRequestBuilder(): ConfirmingServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var ConfirmingServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
