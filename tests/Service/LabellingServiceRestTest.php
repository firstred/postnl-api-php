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
use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\Message\LabellingMessage;
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LabellingServiceRestAdapter;
use Firstred\PostNL\Service\LabellingServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use setasign\Fpdi\PdfReader\PdfReaderException;
use function file_get_contents;
use function json_decode;
use const _RESPONSES_DIR_;

/**
 * @testdox The LabellingService (REST)
 */
class LabellingServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected LabellingServiceInterface $service;
    protected RequestInterface $lastRequest;

    private static string $base64LabelContent = '';

    /**
     * @before
     *
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     * @throws \ReflectionException
     */
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
            mode: PostNL::MODE_Rest
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getLabellingService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /**
     * @testdox returns a valid service object
     */
    public function testHasValidLabellingService(): void
    {
        $this->assertInstanceOf(expected: LabellingServiceRestAdapter::class, actual: $this->service);
    }

    /**
     * @testdox creates a valid label request
     */
    public function testCreatesAValidLabelRequest(): void
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->service->buildGenerateLabelRequestRest(
            generateLabel: GenerateLabel::create()
                ->setShipments(Shipments: [
                    Shipment::create()
                        ->setAddresses(Addresses: [
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
                        ->setBarcode(Barcode: '3S1234567890123')
                        ->setDeliveryAddress(DeliveryAddress: '01')
                        ->setDimension(Dimension: new Dimension(Weight: '2000'))
                        ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
                ])
                ->setMessage(Message: $message)
                ->setCustomer(Customer: $this->postnl->getCustomer()),
            confirm: false
        );

        $this->assertEqualsCanonicalizing(expected: [
            'Customer' => [
                'Address' => [
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
            'Message' => [
                'MessageID'        => (string) $message->getMessageID(),
                'MessageTimeStamp' => (string) $message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s'),
                'Printertype'      => 'GraphicFile|PDF',
            ],
            'Shipments' => [
                'Addresses' => [
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
                'Barcode'         => '3S1234567890123',
                'DeliveryAddress' => '01',
                'Dimension'       => [
                    'Weight' => '2000',
                ],
                'ProductCodeDelivery' => '3085',
            ],
        ],
            actual: json_decode(json: (string) $request->getBody(), associative: true));
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertStringContainsString(needle: 'v2_2', haystack: $request->getUri()->getPath());
        $this->assertEquals(expected: 'application/json;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox creates a valid label request
     */
    public function testFallsBackOntoOlderApiIfInsuredRequest(): void
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->service->buildGenerateLabelRequestRest(
            generateLabel: GenerateLabel::create()
                ->setShipments(Shipments: [
                    Shipment::create()
                        ->setAddresses(Addresses: [
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
                        ->setBarcode(Barcode: '3S1234567890123')
                        ->setDeliveryAddress(DeliveryAddress: '01')
                        ->setDimension(Dimension: new Dimension(Weight: '2000'))
                        ->setProductCodeDelivery(ProductCodeDelivery: '3094'),
                ])
                ->setMessage(Message: $message)
                ->setCustomer(Customer: $this->postnl->getCustomer()),
            confirm: false
        );

        $this->assertEqualsCanonicalizing(expected: [
            'Customer' => [
                'Address' => [
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
            'Message' => [
                'MessageID'        => (string) $message->getMessageID(),
                'MessageTimeStamp' => (string) $message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s'),
                'Printertype'      => 'GraphicFile|PDF',
            ],
            'Shipments' => [
                'Addresses' => [
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
                'Barcode'         => '3S1234567890123',
                'DeliveryAddress' => '01',
                'Dimension'       => [
                    'Weight' => '2000',
                ],
                'ProductCodeDelivery' => '3094',
            ],
        ],
            actual: json_decode(json: (string) $request->getBody(), associative: true));
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertStringContainsString(needle: 'v2_1', haystack: $request->getUri()->getPath());
        $this->assertEquals(expected: 'application/json;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can generate a single label
     * @dataProvider singleLabelsProvider
     */
    public function testGenerateSingleLabelRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $label = $this->postnl->generateLabel(
            shipment: (new Shipment())
                ->setAddresses(Addresses: [
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
                ->setBarcode(Barcode: '3S1234567890123')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085')
        );

        $this->assertInstanceOf(expected: GenerateLabelResponse::class, actual: $label);
        $this->assertEquals(expected: '3S1234567890123', actual: $label->getResponseShipments()[0]->getBarcode());
        $this->assertIsString(actual: $label->getResponseShipments()[0]->getLabels()[0]->getContent());
        $this->assertInstanceOf(expected: Label::class, actual: $label->getResponseShipments()[0]->getLabels()[0]);
        $this->assertEquals(expected: 'Label', actual: $label->getResponseShipments()[0]->getLabels()[0]->getLabeltype());
        $this->assertNotTrue(condition: static::containsStdClass(value: $label));
    }

    /**
     * @testdox can generate multiple A4-merged labels
     * @dataProvider multipleLabelsProvider
     *
     * @param array $responses
     * @psalm-param non-empty-list<ResponseInterface> $responses
     *
     * @throws PdfReaderException
     * @throws Exception
     */
    public function testMergeMultipleA4LabelsRest(array $responses): void
    {
        $mock = new MockHandler(queue: $responses);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $label = $this->postnl->generateLabels(shipments: [
            (new Shipment())
                    ->setAddresses(Addresses: [
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
                    ->setBarcode(Barcode: '3SDEVC201611210')
                    ->setDeliveryAddress(DeliveryAddress: '01')
                    ->setDimension(Dimension: new Dimension(Weight: '2000'))
                    ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            (new Shipment())
                    ->setAddresses(Addresses: [
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
                    ->setBarcode(Barcode: '3SDEVC201611211')
                    ->setDeliveryAddress(DeliveryAddress: '01')
                    ->setDimension(Dimension: new Dimension(Weight: '2000'))
                    ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            ],
            printertype: 'GraphicFile|PDF',
            confirm: true,
            merge: true,
            format: Label::FORMAT_A4,
            positions: [
                1 => true,
                2 => true,
                3 => true,
                4 => true,
            ]
        );

        $this->assertIsString(actual: $label);
    }

    /**
     * @testdox can generate multiple A6-merged labels
     * @dataProvider multipleLabelsProvider
     *
     * @param array $responses
     * @psalm-param non-empty-list<ResponseInterface> $responses
     *
     * @throws PdfReaderException
     * @throws Exception
     */
    public function testMergeMultipleA6LabelsRest(array $responses): void
    {
        $mock = new MockHandler(queue: $responses);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $label = $this->postnl->generateLabels(shipments: [
            (new Shipment())
                ->setAddresses(Addresses: [
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
                ->setBarcode(Barcode: '3SDEVC201611210')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            (new Shipment())
                ->setAddresses(Addresses: [
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
                ->setBarcode(Barcode: '3SDEVC201611211')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
        ],
            printertype: 'GraphicFile|PDF',
            confirm: true,
            merge: true,
            format: Label::FORMAT_A6,
            positions: [
                1 => true,
                2 => true,
                3 => true,
                4 => true,
            ]
        );

        $this->assertTrue(condition: is_string(value: $label));
    }

    /**
     * @testdox can generate multiple labels
     * @dataProvider multipleLabelsProvider
     *
     * @param array $responses
     * @psalm-param non-empty-list<ResponseInterface>
     *
     * @throws PdfReaderException
     * @throws Exception
     */
    public function testGenerateMultipleLabelsRest(array $responses): void
    {
        $mock = new MockHandler(queue: $responses);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $label = $this->postnl->generateLabels(shipments: [
            (new Shipment())
                    ->setAddresses(Addresses: [
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
                    ->setBarcode(Barcode: '3SDEVC201611210')
                    ->setDeliveryAddress(DeliveryAddress: '01')
                    ->setDimension(Dimension: new Dimension(Weight: '2000'))
                    ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            (new Shipment())
                    ->setAddresses(Addresses: [
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
                    ->setBarcode(Barcode: '3SDEVC201611211')
                    ->setDeliveryAddress(DeliveryAddress: '01')
                    ->setDimension(Dimension: new Dimension(Weight: '2000'))
                    ->setProductCodeDelivery(ProductCodeDelivery: '3085'),
            ]
        );

        $this->assertInstanceOf(expected: GenerateLabelResponse::class, actual: $label[1]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $label[1]));
    }

    /**
     * @testdox throws exception on invalid response
     * @dataProvider invalidResponseProvider
     *
     * @psalm-param class-string<ApiException> $exception
     */
    public function testNegativeGenerateLabelInvalidResponseRest(ResponseInterface $response, $exception): void
    {
        $this->expectException(exception: $exception);

        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $this->postnl->generateLabel(
            shipment: (new Shipment())
                ->setAddresses(Addresses: [
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
                ->setBarcode(Barcode: '3S1234567890123')
                ->setDeliveryAddress(DeliveryAddress: '01')
                ->setDimension(Dimension: new Dimension(Weight: '2000'))
                ->setProductCodeDelivery(ProductCodeDelivery: '3085')
        );
    }

    public function singleLabelsProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))],
        ];
    }

    public function multipleLabelsProvider(): array
    {
        return [
            [[
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel.http')),
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel2.http'))
            ]],
            [[
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel2.http')),
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))
            ]],
            [[
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel.http')),
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))
            ]],
        ];
    }

    public function invalidResponseProvider(): array
    {
        return [
            [
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/invalid.http')),
                ResponseException::class
            ],
            [
                PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/error.http')),
                CifException::class
            ],
        ];
    }
}
