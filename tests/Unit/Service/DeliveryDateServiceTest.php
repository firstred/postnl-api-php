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
use Firstred\PostNL\DTO\Request\CalculateDeliveryDateRequestDTO;
use Firstred\PostNL\DTO\Request\CalculateShippingDateRequestDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
use Firstred\PostNL\Service\DeliveryDateServiceInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use function json_encode;

/**
 * Class DeliveryDateRestTest.
 *
 * @testdox The DeliveryDateService (REST)
 */
class DeliveryDateServiceTest extends ServiceTestBase
{
    /**
     * @testdox Creates a valid calculate delivery date request
     *
     * @throws Exception
     */
    public function testCalculateDeliveryDateRequest()
    {
        $this->lastRequest = $request = $this->postnl->getDeliveryDateService()->getGateway()->getRequestBuilder()->buildCalculateDeliveryDateRequest(
            calculateDeliveryDateRequestDTO: new CalculateDeliveryDateRequestDTO(
                service: DeliveryDateServiceInterface::class,
                propType: RequestProp::class,

                ShippingDate: '29-06-2016 14:00:00',
                ShippingDuration: 1,
                CutOffTime: '14:00',
                PostalCode: '2132WT',
                CountryCode: 'NL',
                City: 'Hoofddorp',
                Street: 'Siriusdreef',
                HouseNumber: 42,
                HouseNrExt: 'A',
                Options: ['Daytime'],
                CutOffTimeMonday: '14:00',
                AvailableMonday: true,
            )
        );

        $query = [];
        parse_str(string: $request->getUri()->getQuery(), result: $query);

        $this->assertEquals(
            expected: [
            'ShippingDate'     => '29-06-2016 14:00:00',
            'ShippingDuration' => '1',
            'CountryCode'      => 'NL',
            'Options'          => 'Daytime',
            'CutOffTime'       => '14:00:00',
            'PostalCode'       => '2132WT',
            'City'             => 'Hoofddorp',
            'HouseNumber'      => '42',
            'HouseNrExt'       => 'A',
            'AvailableMonday'  => 'true',
            'CutOffTimeMonday' => '14:00:00',
            'Street'           => 'Siriusdreef',
        ],
            actual: $query
        );

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid delivery date
     */
    public function testCalculateDeliveryDate()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(
                value: [
                    'DeliveryDate' => '30-06-2016',
                    'Options'      => [
                        'Daytime',
                    ],
                ]
            )));
        $mockClient->addResponse(response: $response);
        $this->postnl->getDeliveryDateService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->calculateDeliveryDate(
            shippingDate: '29-06-2016 14:00:00',
            shippingDuration: 1,
            cutOffTime: '15:00:00',
            postalCode: '2132WT',
            countryCode: 'NL',
            originCountryCode: 'NL',
            city: 'Hoofddorp',
            street: 'Siriusdreef',
            options: ['Daytime'],
        );

        $this->assertEquals(expected: '30-06-2016', actual: $response->getDeliveryDate());
        $this->assertEquals(expected: '30-06-2016', actual: (string) $response);
        $this->assertEquals(expected: ['Daytime'], actual: $response->getOptions());
    }

    /**
     * @testdox Creates a valid calculate shipping date request
     *
     * @throws InvalidArgumentException
     */
    public function testCalculateShippingDateRequest()
    {
        $this->lastRequest = $request = $this->postnl->getDeliveryDateService()->getGateway()->getRequestBuilder()->buildCalculateShippingDateRequest(
            calculateShippingDateRequestDTO: new CalculateShippingDateRequestDTO(
                service: DeliveryDateServiceInterface::class,
                propType: RequestProp::class,

                DeliveryDate: '30-06-2016',
                ShippingDuration: 1,
                PostalCode: '2132WT',
                CountryCode: 'NL',
                City: 'Hoofddorp',
                Street: 'Siriusdreef',
                HouseNumber: 42,
                HouseNrExt: 'A',
            ),
        );

        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'test', actual: $request->getHeaderLine('apikey'));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $this->assertEquals(expected: 'application/json', actual: $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid shipping date
     *
     * @throws Exception
     */
    public function testCalculateShippingDate()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(
                value: ['SentDate' => '29-06-2016'],
            )));
        $mockClient->addResponse(response: $response);
        $this->postnl->getDeliveryDateService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(asyncClient: $mockClient),
        );

        $response = $this->postnl->calculateShippingDate(
            deliveryDate: '30-06-2016',
            shippingDuration: 1,
            postalCode: '2132WT',
            countryCode: 'NL',
            originCountryCode: 'NL',
            city: 'Hoofddorp',
            street: 'Siriusdreef',
            houseNumber: 42,
            houseNrExt: 'A'
        );

        $this->assertEquals(expected: '29-06-2016', actual: $response->getSentDate());
        $this->assertEquals(expected: '29-06-2016', actual: (string) $response);
    }
}
