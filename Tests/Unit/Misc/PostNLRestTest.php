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

namespace Firstred\PostNL\Tests\Unit\Misc;

use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequest;
use Firstred\PostNL\Entity\Request\CalculateTimeframesRequest;
use Firstred\PostNL\Entity\Request\FindNearestLocationsRequest;
use Firstred\PostNL\Entity\Response\CalculateDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\CalculateTimeframesResponse;
use Firstred\PostNL\Entity\Response\FindNearestLocationsResponse;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Http\Client as PostNLHttpClient;
use Firstred\PostNL\PostNL;
use Http\Mock\Client;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Class PostNLRestTest
 *
 * @testdox The PostNL object
 */
class PostNLRestTest extends TestCase
{
    /** @var PostNL $postnl */
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
    }

    /**
     * @testdox Returns a valid customer code in REST mode
     */
    public function testPostNLRest()
    {
        $this->assertEquals('DEVC', $this->postnl->getCustomer()->getCustomerCode());
    }

    /**
     * @testdox Returns a valid customer
     */
    public function testCustomer()
    {
        $this->assertInstanceOf(Customer::class, $this->postnl->getCustomer());
    }

    /**
     * @testdox Accepts a `null` logger
     */
    public function testSetNullLogger()
    {
        $this->postnl->setLogger();

        $this->assertNull($this->postnl->getLogger());
    }

    /**
     * @testdox Returns a combinations of timeframes, locations and the delivery date
     *
     * @throws Exception
     */
    public function testGetTimeframesAndLocations()
    {
        $timeframesPayload = file_get_contents(__DIR__.'/../../data/responses/timeframes.json');
        $locationsPayload = file_get_contents(__DIR__.'/../../data/responses/nearestlocations.json');
        $deliveryDatePayload = json_encode([
            'DeliveryDate' => '03-07-2019',
            'Options' => [
                'string' => 'Daytime',
            ],
        ]);

        $mockClient = new Client();
        $mockClient->addResponse(new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], $timeframesPayload));
        $mockClient->addResponse(new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], $locationsPayload));
        $mockClient->addResponse(new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], $deliveryDatePayload));
        PostNLHttpClient::getInstance()->setAsyncClient($mockClient);

        $results = $this->postnl->getTimeframesAndNearestLocations(
            (new CalculateTimeframesRequest())
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
            (new FindNearestLocationsRequest())
                ->setCountrycode('NL')
                ->setDeliveryDate('29-06-2016')
                ->setDeliveryOptions(['PG', 'PGE'])
                ->setOpeningTime('09:00:00')
                ->setCity('Hoofddorp')
                ->setHouseNumber('42')
                ->setPostalCode('2132WT')
                ->setStreet('Siriusdreef'),
            (new CalculateDeliveryDateRequest())
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

        $this->assertTrue(is_array($results));
        $this->assertInstanceOf(CalculateTimeframesResponse::class, $results['timeframes']);
        $this->assertInstanceOf(FindNearestLocationsResponse::class, $results['locations']);
        $this->assertInstanceOf(CalculateDeliveryDateResponse::class, $results['delivery_date']);
    }

    /**
     * @testdox Returns `false` when the API key is missing
     *
     * @throws ReflectionException
     */
    public function testNegativeKeyMissing()
    {
        $reflection = new ReflectionClass(PostNL::class);
        /** @var PostNL $postnl */
        $postnl = $reflection->newInstanceWithoutConstructor();

        $this->assertNull($postnl->getApiKey());
    }
}
