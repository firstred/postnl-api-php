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
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\LabellingService;
use Firstred\PostNL\Service\LabellingServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use Psr\Http\Message\ResponseInterface;
use setasign\Fpdi\PdfReader\PdfReaderException;
use function file_get_contents;
use function json_decode;
use const _RESPONSES_DIR_;

/**
 * Class LabellingServiceRestTest.
 *
 * @testdox The LabellingService (REST)
 */
class LabellingServiceRestTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var LabellingServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /** @var string */
    private static $base64LabelContent = '';

    /**
     * @before
     *
     * @throws
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            (new Customer())
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress((new Address())
                    ->setAddressType('02')
                    ->setCity('Hoofddorp')
                    ->setCompanyName('PostNL')
                    ->setCountrycode('NL')
                    ->setHouseNr('42')
                    ->setStreet('Siriusdreef')
                    ->setZipcode('2132WT')
                )
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
            true,
            PostNL::MODE_REST
        );

        global $logger;
        $this->postnl->setLogger($logger);

        $this->service = $this->postnl->getLabellingService();
        $this->service->setCache(new VoidCachePool());
        $this->service->setTtl(1);
    }

    /**
     * @testdox returns a valid service object
     */
    public function testHasValidLabellingService()
    {
        $this->assertInstanceOf(LabellingService::class, $this->service);
    }

    /**
     * @testdox creates a valid label request
     */
    public function testCreatesAValidLabelRequest()
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->service->buildGenerateLabelRequestREST(
            (new GenerateLabel())
                ->setShipments([
                    (new Shipment())
                        ->setAddresses([
                            (new Address())
                                ->setAddressType('01')
                                ->setCity('Utrecht')
                                ->setCountrycode('NL')
                                ->setFirstName('Peter')
                                ->setHouseNr('9')
                                ->setHouseNrExt('a bis')
                                ->setName('de Ruijter')
                                ->setStreet('Bilderdijkstraat')
                                ->setZipcode('3521VA'),
                            (new Address())
                                ->setAddressType('02')
                                ->setCity('Hoofddorp')
                                ->setCompanyName('PostNL')
                                ->setCountrycode('NL')
                                ->setHouseNr('42')
                                ->setStreet('Siriusdreef')
                                ->setZipcode('2132WT'),
                        ])
                        ->setBarcode('3S1234567890123')
                        ->setDeliveryAddress('01')
                        ->setDimension(new Dimension('2000'))
                        ->setProductCodeDelivery('3085'),
                ])
                ->setMessage($message)
                ->setCustomer($this->postnl->getCustomer()),
            false
        );

        $this->assertEqualsCanonicalizing([
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
                'MessageTimeStamp' => (string) $message->getMessageTimeStamp()->format('d-m-Y H:i:s'),
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
            json_decode((string) $request->getBody(), true));
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertStringContainsString('v2_2', $request->getUri()->getPath());
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox creates a valid label request
     */
    public function testFallsBackOntoOlderApiIfInsuredRequest()
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->service->buildGenerateLabelRequestREST(
            (new GenerateLabel())
                ->setShipments([
                    (new Shipment())
                        ->setAddresses([
                            (new Address())
                                ->setAddressType('01')
                                ->setCity('Utrecht')
                                ->setCountrycode('NL')
                                ->setFirstName('Peter')
                                ->setHouseNr('9')
                                ->setHouseNrExt('a bis')
                                ->setName('de Ruijter')
                                ->setStreet('Bilderdijkstraat')
                                ->setZipcode('3521VA'),
                            (new Address())
                                ->setAddressType('02')
                                ->setCity('Hoofddorp')
                                ->setCompanyName('PostNL')
                                ->setCountrycode('NL')
                                ->setHouseNr('42')
                                ->setStreet('Siriusdreef')
                                ->setZipcode('2132WT'),
                        ])
                        ->setBarcode('3S1234567890123')
                        ->setDeliveryAddress('01')
                        ->setDimension(new Dimension('2000'))
                        ->setProductCodeDelivery('3094'),
                ])
                ->setMessage($message)
                ->setCustomer($this->postnl->getCustomer()),
            false
        );

        $this->assertEqualsCanonicalizing([
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
                'MessageTimeStamp' => (string) $message->getMessageTimeStamp()->format('d-m-Y H:i:s'),
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
            json_decode((string) $request->getBody(), true));
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertStringContainsString('v2_1', $request->getUri()->getPath());
        $this->assertEquals('application/json;charset=UTF-8', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can generate a single label
     * @dataProvider singleLabelsProvider
     */
    public function testGenerateSingleLabelRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $label = $this->postnl->generateLabel(
            (new Shipment())
                ->setAddresses([
                    (new Address())
                        ->setAddressType('01')
                        ->setCity('Utrecht')
                        ->setCountrycode('NL')
                        ->setFirstName('Peter')
                        ->setHouseNr('9')
                        ->setHouseNrExt('a bis')
                        ->setName('de Ruijter')
                        ->setStreet('Bilderdijkstraat')
                        ->setZipcode('3521VA'),
                    (new Address())
                        ->setAddressType('02')
                        ->setCity('Hoofddorp')
                        ->setCompanyName('PostNL')
                        ->setCountrycode('NL')
                        ->setHouseNr('42')
                        ->setStreet('Siriusdreef')
                        ->setZipcode('2132WT'),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );

        $this->assertInstanceOf(GenerateLabelResponse::class, $label);
        $this->assertEquals('3S1234567890123', $label->getResponseShipments()[0]->getBarcode());
        $this->assertIsString($label->getResponseShipments()[0]->getLabels()[0]->getContent());
        $this->assertInstanceOf(Label::class, $label->getResponseShipments()[0]->getLabels()[0]);
        $this->assertEquals('Label', $label->getResponseShipments()[0]->getLabels()[0]->getLabeltype());
        $this->assertNotTrue(static::containsStdClass($label));
    }

    /**
     * @testdox can generate multiple A4-merged labels
     * @dataProvider multipleLabelsProvider
     *
     * @param array $responses
     * @psalm-param non-empty-list<ResponseInterface> $responses
     *
     * @throws
     */
    public function testMergeMultipleA4LabelsRest($responses)
    {
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $label = $this->postnl->generateLabels([
                (new Shipment())
                    ->setAddresses([
                        (new Address())
                            ->setAddressType('01')
                            ->setCity('Utrecht')
                            ->setCountrycode('NL')
                            ->setFirstName('Peter')
                            ->setHouseNr('9')
                            ->setHouseNrExt('a bis')
                            ->setName('de Ruijter')
                            ->setStreet('Bilderdijkstraat')
                            ->setZipcode('3521VA'),
                        (new Address())
                            ->setAddressType('02')
                            ->setCity('Hoofddorp')
                            ->setCompanyName('PostNL')
                            ->setCountrycode('NL')
                            ->setHouseNr('42')
                            ->setStreet('Siriusdreef')
                            ->setZipcode('2132WT'),
                    ])
                    ->setBarcode('3SDEVC201611210')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
                (new Shipment())
                    ->setAddresses([
                        (new Address())
                            ->setAddressType('01')
                            ->setCity('Utrecht')
                            ->setCountrycode('NL')
                            ->setFirstName('Peter')
                            ->setHouseNr('9')
                            ->setHouseNrExt('a bis')
                            ->setName('de Ruijter')
                            ->setStreet('Bilderdijkstraat')
                            ->setZipcode('3521VA'),
                        (new Address())
                            ->setAddressType('02')
                            ->setCity('Hoofddorp')
                            ->setCompanyName('PostNL')
                            ->setCountrycode('NL')
                            ->setHouseNr('42')
                            ->setStreet('Siriusdreef')
                            ->setZipcode('2132WT'),
                    ])
                    ->setBarcode('3SDEVC201611211')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
            ],
            'GraphicFile|PDF',
            true,
            true,
            Label::FORMAT_A4,
            [
                1 => true,
                2 => true,
                3 => true,
                4 => true,
            ]
        );

        $this->assertIsString($label);
    }

    /**
     * @testdox can generate multiple A6-merged labels
     * @dataProvider multipleLabelsProvider
     *
     * @param array $responses
     * @psalm-param non-empty-list<ResponseInterface> $responses
     *
     * @throws
     */
    public function testMergeMultipleA6LabelsRest($responses)
    {
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $label = $this->postnl->generateLabels([
            (new Shipment())
                ->setAddresses([
                    (new Address())
                        ->setAddressType('01')
                        ->setCity('Utrecht')
                        ->setCountrycode('NL')
                        ->setFirstName('Peter')
                        ->setHouseNr('9')
                        ->setHouseNrExt('a bis')
                        ->setName('de Ruijter')
                        ->setStreet('Bilderdijkstraat')
                        ->setZipcode('3521VA'),
                    (new Address())
                        ->setAddressType('02')
                        ->setCity('Hoofddorp')
                        ->setCompanyName('PostNL')
                        ->setCountrycode('NL')
                        ->setHouseNr('42')
                        ->setStreet('Siriusdreef')
                        ->setZipcode('2132WT'),
                ])
                ->setBarcode('3SDEVC201611210')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085'),
            (new Shipment())
                ->setAddresses([
                    (new Address())
                        ->setAddressType('01')
                        ->setCity('Utrecht')
                        ->setCountrycode('NL')
                        ->setFirstName('Peter')
                        ->setHouseNr('9')
                        ->setHouseNrExt('a bis')
                        ->setName('de Ruijter')
                        ->setStreet('Bilderdijkstraat')
                        ->setZipcode('3521VA'),
                    (new Address())
                        ->setAddressType('02')
                        ->setCity('Hoofddorp')
                        ->setCompanyName('PostNL')
                        ->setCountrycode('NL')
                        ->setHouseNr('42')
                        ->setStreet('Siriusdreef')
                        ->setZipcode('2132WT'),
                ])
                ->setBarcode('3SDEVC201611211')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085'),
        ],
            'GraphicFile|PDF',
            true,
            true,
            Label::FORMAT_A6,
            [
                1 => true,
                2 => true,
                3 => true,
                4 => true,
            ]
        );

        $this->assertTrue(is_string($label));
    }

    /**
     * @testdox can generate multiple labels
     * @dataProvider multipleLabelsProvider
     *
     * @param array $responses
     * @psalm-param non-empty-list<ResponseInterface>
     *
     * @throws
     */
    public function testGenerateMultipleLabelsRest($responses)
    {
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $label = $this->postnl->generateLabels([
                (new Shipment())
                    ->setAddresses([
                        (new Address())
                            ->setAddressType('01')
                            ->setCity('Utrecht')
                            ->setCountrycode('NL')
                            ->setFirstName('Peter')
                            ->setHouseNr('9')
                            ->setHouseNrExt('a bis')
                            ->setName('de Ruijter')
                            ->setStreet('Bilderdijkstraat')
                            ->setZipcode('3521VA'),
                        (new Address())
                            ->setAddressType('02')
                            ->setCity('Hoofddorp')
                            ->setCompanyName('PostNL')
                            ->setCountrycode('NL')
                            ->setHouseNr('42')
                            ->setStreet('Siriusdreef')
                            ->setZipcode('2132WT'),
                    ])
                    ->setBarcode('3SDEVC201611210')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
                (new Shipment())
                    ->setAddresses([
                        (new Address())
                            ->setAddressType('01')
                            ->setCity('Utrecht')
                            ->setCountrycode('NL')
                            ->setFirstName('Peter')
                            ->setHouseNr('9')
                            ->setHouseNrExt('a bis')
                            ->setName('de Ruijter')
                            ->setStreet('Bilderdijkstraat')
                            ->setZipcode('3521VA'),
                        (new Address())
                            ->setAddressType('02')
                            ->setCity('Hoofddorp')
                            ->setCompanyName('PostNL')
                            ->setCountrycode('NL')
                            ->setHouseNr('42')
                            ->setStreet('Siriusdreef')
                            ->setZipcode('2132WT'),
                    ])
                    ->setBarcode('3SDEVC201611211')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
            ]
        );

        $this->assertInstanceOf(GenerateLabelResponse::class, $label[1]);
        $this->assertNotTrue(static::containsStdClass($label[1]));
    }

    /**
     * @testdox throws exception on invalid response
     * @dataProvider invalidResponseProvider
     *
     * @psalm-param class-string<ApiException> $exception
     */
    public function testNegativeGenerateLabelInvalidResponseRest(ResponseInterface $response, $exception)
    {
        $this->expectException($exception);

        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->postnl->generateLabel(
            (new Shipment())
                ->setAddresses([
                    (new Address())
                        ->setAddressType('01')
                        ->setCity('Utrecht')
                        ->setCountrycode('NL')
                        ->setFirstName('Peter')
                        ->setHouseNr('9')
                        ->setHouseNrExt('a bis')
                        ->setName('de Ruijter')
                        ->setStreet('Bilderdijkstraat')
                        ->setZipcode('3521VA'),
                    (new Address())
                        ->setAddressType('02')
                        ->setCity('Hoofddorp')
                        ->setCompanyName('PostNL')
                        ->setCountrycode('NL')
                        ->setHouseNr('42')
                        ->setStreet('Siriusdreef')
                        ->setZipcode('2132WT'),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );
    }

    public function singleLabelsProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel2.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))],
        ];
    }

    public function multipleLabelsProvider()
    {
        return [
            [[
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel.http')),
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel2.http'))
            ]],
            [[
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel2.http')),
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))
            ]],
            [[
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel.http')),
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/singlelabel3.http'))
            ]],
        ];
    }

    public function invalidResponseProvider()
    {
        return [
            [
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/invalid.http')),
                ResponseException::class
            ],
            [
                PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/labelling/error.http')),
                CifException::class
            ],
        ];
    }
}
