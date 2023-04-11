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

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Service;

use DateTimeInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\HttpClient\MockHttpClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\Rest\DeliveryDateServiceRestRequestBuilder;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;
use function file_get_contents;
use const _RESPONSES_DIR_;

#[TestDox(text: 'The DeliveryDateService (REST)')]
class DeliveryDateServiceTest extends ServiceTestCase
{
    protected PostNL $postnl;
    protected DeliveryDateServiceInterface $service;
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

        $this->service = $this->postnl->getDeliveryDateService();
    }

    /** @throws */
    #[TestDox(text: 'creates a valid delivery date request')]
    public function testGetDeliveryDateRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetDeliveryDateRequest(
            getDeliveryDate: (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    GetDeliveryDate: (new GetDeliveryDate())
                        ->setAllowSundaySorting(AllowSundaySorting: 'false')
                        ->setCity(City: 'Hoofddorp')
                        ->setCountryCode(CountryCode: 'NL')
                        ->setCutOffTimes(CutOffTimes: [
                            new CutOffTime(Day: '00', Time: '14:00:00'),
                        ])
                        ->setHouseNr(HouseNr: '42')
                        ->setHouseNrExt(HouseNrExt: 'A')
                        ->setOptions(Options: [
                            'Daytime',
                        ])
                        ->setPostalCode(PostalCode: '2132WT')
                        ->setShippingDate(shippingDate: '29-06-2016 14:00:00')
                        ->setShippingDuration(ShippingDuration: '1')
                        ->setStreet(Street: 'Siriusdreef')
                )
                ->setMessage(Message: $message)
        );

        $query = Query::parse(str: $request->getUri()->getQuery());

        $this->assertEquals(
            expected: [
                'ShippingDate'     => '29-06-2016 14:00:00',
                'ShippingDuration' => '1',
                'CountryCode'      => 'NL',
                'Options'          => 'Daytime',
                'CutOffTime'       => '14:00:00',
                'PostalCode'       => '2132WT',
                'City'             => 'Hoofddorp',
                'HouseNr'          => '42',
                'HouseNrExt'       => 'A',
            ],
            actual: $query
        );
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'return a valid delivery date')]
    #[DataProvider(methodName: 'singleDeliveryDateResponseProvider')]
    public function testGetDeliveryDateRest(ResponseInterface $response): void
    {
        $mock = new MockHandler(queue: [$response]);
        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getDeliveryDate(
            getDeliveryDate: (new GetDeliveryDate())
            ->setGetDeliveryDate(
                GetDeliveryDate: (new GetDeliveryDate())
                    ->setAllowSundaySorting(AllowSundaySorting: 'false')
                    ->setCity(City: 'Hoofddorp')
                    ->setCountryCode(CountryCode: 'NL')
                    ->setCutOffTimes(CutOffTimes: [
                        new CutOffTime(Day: '00', Time: '14:00:00'),
                    ])
                    ->setHouseNr(HouseNr: '42')
                    ->setHouseNrExt(HouseNrExt: 'A')
                    ->setOptions(Options: [
                        'Daytime',
                    ])
                    ->setPostalCode(PostalCode: '2132WT')
                    ->setShippingDate(shippingDate: '29-06-2016 14:00:00')
                    ->setShippingDuration(ShippingDuration: '1')
                    ->setStreet(Street: 'Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            expected: GetDeliveryDateResponse::class,
            actual: $response
        );
        $this->assertInstanceof(expected: DateTimeInterface::class, actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate()->format(format: 'd-m-Y'));
        $this->assertEquals(expected: 'Daytime', actual: $response->getOptions()[0]);
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @throws */
    #[TestDox(text: 'creates a valid sent date request')]
    public function testGetSentDateRequestRest(): void
    {
        $message = new Message();

        $this->lastRequest = $request = $this->getRequestBuilder()->buildGetSentDateRequest(
            getSentDate: (new GetSentDateRequest())
            ->setGetSentDate(
                GetSentDate: (new GetSentDate())
                    ->setAllowSundaySorting(AllowSundaySorting: true)
                    ->setCity(City: 'Hoofddorp')
                    ->setCountryCode(CountryCode: 'NL')
                    ->setDeliveryDate(deliveryDate: '30-06-2016')
                    ->setHouseNr(HouseNr: '42')
                    ->setHouseNrExt(HouseNrExt: 'A')
                    ->setOptions(Options: [
                        'Daytime',
                    ])
                    ->setPostalCode(postcode: '2132WT')
                    ->setShippingDuration(ShippingDuration: '1')
                    ->setStreet(Street: 'Siriusdreef')
            )
            ->setMessage(Message: $message)
        );

        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /** @throws */
    #[TestDox(text: 'return a valid sent date')]
    public function testGetSentDateRest(): void
    {
        $mock = new MockHandler(queue: [
            new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: json_encode(value: [
                'SentDate' => '29-06-2016',
            ])),
        ]);

        $handler = HandlerStack::create(handler: $mock);
        $mockClient = new MockHttpClient();
        $mockClient->setHandler(handler: $handler);
        $this->postnl->setHttpClient(httpClient: $mockClient);

        $response = $this->postnl->getSentDate(
            getSentDate: (new GetSentDateRequest())
            ->setGetSentDate(
                GetSentDate: (new GetSentDate())
                    ->setAllowSundaySorting(AllowSundaySorting: true)
                    ->setCity(City: 'Hoofddorp')
                    ->setCountryCode(CountryCode: 'NL')
                    ->setDeliveryDate(deliveryDate: '30-06-2016')
                    ->setHouseNr(HouseNr: '42')
                    ->setHouseNrExt(HouseNrExt: 'A')
                    ->setOptions(Options: [
                        'Daytime',
                    ])
                    ->setPostalCode(postcode: '2132WT')
                    ->setShippingDuration(ShippingDuration: '1')
                    ->setStreet(Street: 'Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            expected: GetSentDateResponse::class,
            actual: $response,
        );
        $this->assertEquals(expected: '29-06-2016', actual: $response->getSentDate()->format(format: 'd-m-Y'));
        $this->assertNotTrue(condition: static::containsStdClass(value: $response));
    }

    /** @return string[][] */
    public static function singleDeliveryDateResponseProvider(): array
    {
        return [
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/deliverydate/deliverydate.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/deliverydate/deliverydate2.http'))],
            [PsrMessage::parseResponse(message: file_get_contents(filename: _RESPONSES_DIR_.'/rest/deliverydate/deliverydate3.http'))],
        ];
    }

    /** @throws */
    private function getRequestBuilder(): DeliveryDateServiceRestRequestBuilder
    {
        $serviceReflection = new ReflectionObject(object: $this->service);
        $requestBuilderReflection = $serviceReflection->getProperty(name: 'requestBuilder');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $requestBuilderReflection->setAccessible(accessible: true);
        /** @var DeliveryDateServiceRestRequestBuilder $requestBuilder */
        $requestBuilder = $requestBuilderReflection->getValue(object: $this->service);

        return $requestBuilder;
    }
}
