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

namespace Firstred\PostNL\Tests\Unit\Misc;

use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\HttpClient\HTTPlugHTTPClient as PostNLHttpClient;
use Firstred\PostNL\PostNL;
use Http\Mock\Client;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class PostNLRestTest.
 *
 * @testdox The PostNL object
 */
class PostNLRestTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;

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
                ->setCollectionLocation(collectionLocation: '123456')
                ->setCustomerCode(customerCode: 'DEVC')
                ->setCustomerNumber(customerNumber: '11223344')
                ->setContactPerson(contactPerson: 'Test')
                ->setAddress(
                    address: (new Address())
                        ->setAddressType(AddressType: '02')
                        ->setCity(City: 'Hoofddorp')
                        ->setCompanyName(CompanyName: 'PostNL')
                        ->setCountrycode(Countrycode: 'NL')
                        ->setHouseNr(HouseNr: '42')
                        ->setStreet(Street: 'Siriusdreef')
                        ->setZipcode(Zipcode: '2132WT')
                )
                ->setGlobalPackBarcodeType(GlobalPackBarcodeType: 'AB')
                ->setGlobalPackCustomerCode(GlobalPackCustomerCode: '1234'),
            apiKey: 'test',
            sandbox: true
        );
    }

    /**
     * @testdox Returns a valid customer code in REST mode
     */
    public function testPostNLRest()
    {
        $this->assertEquals(expected: 'DEVC', actual: $this->postnl->getCustomer()->getCustomerCode());
    }

    /**
     * @testdox Returns a valid customer
     */
    public function testCustomer()
    {
        $this->assertInstanceOf(expected: Customer::class, actual: $this->postnl->getCustomer());
    }

    /**
     * @testdox Accepts a `null` logger
     */
    public function testSetNullLogger()
    {
        $this->postnl->setLogger();

        $this->assertNull(actual: $this->postnl->getLogger());
    }

    /**
     * @testdox Returns a combinations of timeframes, locations and the delivery date
     *
     * @throws Exception
     */
    public function testGetTimeframesAndLocations()
    {
        $timeframesPayload = file_get_contents(filename: __DIR__.'/../../data/responses/timeframes.json');
        $locationsPayload = file_get_contents(filename: __DIR__.'/../../data/responses/nearestlocations.json');
        $deliveryDatePayload = json_encode(value: [
            'DeliveryDate' => '03-07-2019',
            'Options'      => [
                'string' => 'Daytime',
            ],
        ]);

        $mockClient = new Client();
        $mockClient->addResponse(response: new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: $timeframesPayload));
        $mockClient->addResponse(response: new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: $locationsPayload));
        $mockClient->addResponse(response: new Response(status: 200, headers: ['Content-Type' => 'application/json;charset=UTF-8'], body: $deliveryDatePayload));
        PostNLHttpClient::getInstance()->setAsyncClient($mockClient);

        $results = $this->postnl->getTimeframesAndNearestLocations(
            getTimeframes: (new CalculateTimeframesRequest())
                ->setCity('Hoofddorp')
                ->setCountryCode('NL')
                ->setEndDate('02-07-2016')
                ->setHouseNumber('42')
                ->setHouseNrExt('A')
                ->setOptions([
                    'Evening',
                ])
                ->setPostalCode('2132WT')
                ->setStartDate('30-06-2016')
                ->setStreet('Siriusdreef'),
            getNearestLocations: (new FindNearestLocationsRequest())
                ->setCountrycode('NL')
                ->setDeliveryDate('29-06-2016')
                ->setDeliveryOptions(['PG', 'PGE'])
                ->setOpeningTime('09:00:00')
                ->setCity('Hoofddorp')
                ->setHouseNumber('42')
                ->setPostalCode('2132WT')
                ->setStreet('Siriusdreef'),
            calculateDeliveryDate: (new CalculateDeliveryDateRequest())
                ->setCity('Hoofddorp')
                ->setCountryCode('NL')
                ->setAvailableMonday(true)
                ->setCutOffTimeMonday('14:00:00')
                ->setHouseNumber('42')
                ->setHouseNrExt('A')
                ->setOptions([
                    'Daytime',
                ])
                ->setPostalCode('2132WT')
                ->setShippingDate('29-06-2016 14:00:00')
                ->setShippingDuration(1)
                ->setStreet('Siriusdreef')
        );

        $this->assertTrue(condition: is_array(value: $results));
        $this->assertInstanceOf(expected: CalculateTimeframesResponse::class, actual: $results['timeframes']);
        $this->assertInstanceOf(expected: FindNearestLocationsResponse::class, actual: $results['locations']);
        $this->assertInstanceOf(expected: CalculateDeliveryDateResponse::class, actual: $results['delivery_date']);
    }
}
