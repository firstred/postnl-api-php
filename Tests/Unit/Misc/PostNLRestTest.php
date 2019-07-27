<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Unit\Misc;

use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDate;
use Firstred\PostNL\Entity\Request\CalculateTimeframes;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
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
        $timeframesPayload = [
            'ReasonNotimeframes' => [
                'ReasonNoTimeframe' => [
                    [
                        'Code'        => '05',
                        'Date'        => '10-03-2018',
                        'Description' => 'Geen avondbelevering mogelijk',
                        'Options'     => [
                            'string' => 'Evening',
                        ],
                    ],
                    [
                        'Code'        => '03',
                        'Date'        => '11-03-2018',
                        'Description' => 'Dag uitgesloten van tijdvak',
                        'Options'     => [
                            'string' => 'Daytime',
                        ],
                    ],
                    [
                        'Code'        => '03',
                        'Date'        => '11-03-2018',
                        'Description' => 'Dag uitgesloten van tijdvak',
                        'Options'     => [
                            'string' => 'Evening',
                        ],
                    ],
                    [
                        'Code'        => '01',
                        'Date'        => '12-03-2018',
                        'Description' => 'Geen routeplan tijdvak',
                        'Options'     => [
                            'string' => 'Daytime',
                        ],
                    ],
                    [
                        'Code'        => '05',
                        'Date'        => '12-03-2018',
                        'Description' => 'Geen avondbelevering mogelijk',
                        'Options'     => [
                            'string' => 'Evening',
                        ],
                    ],
                ],
            ],
            'Timeframes' => [
                'Timeframe' => [
                    [
                        'Date' => '07-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From' => '16:00:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From' => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date' => '08-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From' => '15:45:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:15:00',
                                ],
                                [
                                    'From' => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date' => '09-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From' => '15:30:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:00:00',
                                ],
                                [
                                    'From' => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date' => '10-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From' => '16:15:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:45:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date' => '13-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From' => '16:00:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From' => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date'       => '14-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '16:00:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To'      => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
                                    ],
                                    'To'      => '20:00:00',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $locationsPayload = json_decode($this->getNearestLocationsMockResponse());
        $deliveryDatePayload = [
            'DeliveryDate' => '30-06-2016',
            'Options' => [
                'string' => 'Daytime',
            ],
        ];

        $mockClient = new Client();
        $mockClient->addResponse(new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($timeframesPayload)));
        $mockClient->addResponse(new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($locationsPayload)));
        $mockClient->addResponse(new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($deliveryDatePayload)));
        PostNLHttpClient::getInstance()->setAsyncClient($mockClient);

        $results = $this->postnl->getTimeframesAndNearestLocations(
            (new CalculateTimeframes())
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
            (new GetNearestLocations())
                ->setCountrycode('NL')
                ->setDeliveryDate('29-06-2016')
                ->setDeliveryOptions(['PG', 'PGE'])
                ->setOpeningTime('09:00:00')
                ->setCity('Hoofddorp')
                ->setHouseNumber('42')
                ->setPostalCode('2132WT')
                ->setStreet('Siriusdreef'),
            (new CalculateDeliveryDate())
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
        $this->assertInstanceOf(ResponseTimeframes::class, $results['timeframes']);
        $this->assertInstanceOf(GetNearestLocationsResponse::class, $results['locations']);
        $this->assertInstanceOf(GetDeliveryDateResponse::class, $results['delivery_date']);
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

    /**
     * @return string
     */
    protected function getNearestLocationsMockResponse()
    {
        return $json = file_get_contents(__DIR__.'/../../data/responses/nearestlocations.json');
    }
}
