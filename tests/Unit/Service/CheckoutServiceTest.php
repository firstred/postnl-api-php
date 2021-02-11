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
use Firstred\PostNL\Entity\PickupOptions;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\HttpClient\HTTPlugHttpClient;
use Firstred\PostNL\Service\CheckoutService;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use function file_get_contents;
use function json_encode;

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
     * @testdox Can get delivery information
     *
     * @throws Exception
     */
    public function testCanGetDeliveryInformation()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/checkout/checkout.json')));
        /** @noinspection PhpArgumentWithoutNamedIdentifierInspection */
        $mockClient->addResponse($response);
        $this->postnl->getCheckoutService()->getGateway()->setHttpClient(
            httpClient: new HTTPlugHttpClient(client: $mockClient),
        );

        $response = $this->postnl->getDeliveryInformation(
            orderDate: 	'11-07-2019 12:34:54',
            addresses: [new Address(AddressType: '01', Countrycode: 'NL', HouseNr: 42, Street: 'Siriusdreef', Zipcode: '2132WT')],cutOffTimes: [new CutOffTime(Day: '00', Available: true, Time: '14:00')],
        );

        $pickupOptions = $response->getPickupOptions();
        $this->assertInstanceOf(expected: PickupOptions::class, actual: $pickupOptions);
        $this->assertCount(
            expectedCount: 3,
            haystack: $response->getDeliveryOptions(),
        );
        $this->assertCount(
            expectedCount: 1,
            haystack: $response->getPickupOptions(),
        );
        $this->assertCount(
            expectedCount: 4,
            haystack: $response->getWarnings(),
        );
    }
}
