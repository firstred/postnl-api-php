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
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LabellingServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\LabellingServiceRestRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;
use setasign\Fpdi\PdfReader\PdfReaderException;
use function file_get_contents;
use function json_decode;
use const _RESPONSES_DIR_;

#[TestDox(text: 'The LabellingService (REST)')]
class LabellingServiceRestTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected LabellingServiceInterface $service;
    protected RequestInterface $lastRequest;

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
                GlobalPackCustomerCode: '1234',
                GlobalPackBarcodeType: 'AB'
            ),
            apiKey: 'test',
            sandbox: true,
        );

        global $logger;
        $this->postnl->setLogger(logger: $logger);

        $this->service = $this->postnl->getLabellingService();
        $this->service->setCache(cache: new VoidCachePool());
        $this->service->setTtl(ttl: 1);
    }

    /** @throws */
    #[TestDox(text: 'returns a valid service object')]
    public function testHasValidLabellingService(): void
    {
        $this->assertInstanceOf(expected: LabellingService::class, actual: $this->service);
    }

    /** @throws */
    #[TestDox(text: 'creates a valid label request')]
    public function testCreatesAValidLabelRequest(): void
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGenerateLabelRequest(
            generateLabel: GenerateLabel::create()
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
                ->setCustomer(Customer: $this->postnl->getCustomer()),
            confirm: false
        );

        $this->assertEqualsCanonicalizing(expected: [
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
                'MessageTimeStamp' => (string) $message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s'),
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
        $this->assertStringContainsString(needle: 'v2_2', haystack: $request->getUri()->getPath());
        $this->assertEquals(expected: 'application/json;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid label request')]
    public function testFallsBackOntoOlderApiIfInsuredRequest(): void
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGenerateLabelRequest(
            generateLabel: GenerateLabel::create()
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
                        ->setProductCodeDelivery(ProductCodeDelivery: '3094'),
                ])
                ->setMessage(Message: $message)
                ->setCustomer(Customer: $this->postnl->getCustomer()),
            confirm: false
        );

        $this->assertEqualsCanonicalizing(expected: [
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
                'MessageTimeStamp' => (string) $message->getMessageTimeStamp()->format(format: 'd-m-Y H:i:s'),
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
                'ProductCodeDelivery' => '3094',
            ],
        ],
            actual: json_decode(json: (string) $request->getBody(), associative: true));
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertStringContainsString(needle: 'v2_1', haystack: $request->getUri()->getPath());
        $this->assertEquals(expected: 'application/json;charset=UTF-8', actual: $request->getHeaderLine('Content-Type'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'can generate a single label')]
    #[DataProvider(methodName: 'singleLabelsProvider')]
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

        $this->assertInstanceOf(expected: GenerateLabelResponse::class, actual: $label);
        $this->assertEquals(expected: '3S1234567890123', actual: $label->getResponseShipments()[0]->getBarcode());
        $this->assertIsString(actual: $label->getResponseShipments()[0]->getLabels()[0]->getContent());
        $this->assertInstanceOf(expected: Label::class, actual: $label->getResponseShipments()[0]->getLabels()[0]);
        $this->assertEquals(expected: 'Label', actual: $label->getResponseShipments()[0]->getLabels()[0]->getLabeltype());
        $this->assertNotTrue(condition: static::containsStdClass(value: $label));
    }

    /**
     * @param non-empty-list<ResponseInterface> $responses
     *
     * @throws
     */
    #[TestDox(text: 'can generate multiple A4-merged labels')]
    #[DataProvider(methodName: 'multipleLabelsProvider')]
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
     * @param non-empty-list<ResponseInterface> $responses
     *
     * @throws PdfReaderException
     * @throws Exception
     */
    #[TestDox(text: 'can generate multiple A6-merged labels')]
    #[DataProvider(methodName: 'multipleLabelsProvider')]
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
     * @param non-empty-list<ResponseInterface> $responses
     *
     * @throws PdfReaderException
     * @throws Exception
     */
    #[TestDox(text: 'can generate multiple labels')]
    #[DataProvider(methodName: 'multipleLabelsProvider')]
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
     * @param ResponseInterface          $response
     * @param class-string<ApiException> $exception
     *
     * @throws
     */
    #[TestDox(text: 'throws exception on invalid response')]
    #[DataProvider(methodName: 'invalidResponseProvider')]
    public function testNegativeGenerateLabelInvalidResponseRest(ResponseInterface $response, string $exception): void
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

    /**
     * @return array[]
     */
    public function singleLabelsProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))],
        ];
    }

    /**
     * @return array[]
     */
    public function multipleLabelsProvider(): array
    {
        return [
            [
                [
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel.http')),
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel2.http'))
                ]
            ],
            [
                [
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel2.http')),
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))
                ]
            ],
            [
                [
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel.http')),
                    PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))
                ]
            ],
        ];
    }

    public static function invalidResponseProvider(): array
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

    /** @throws */
    private function getRequestBuilder(): LabellingServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var LabellingServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
