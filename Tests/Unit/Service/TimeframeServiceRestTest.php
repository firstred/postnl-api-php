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

namespace Firstred\PostNL\Tests\Unit\Service;

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\TimeframeService;

/**
 * Class TimeframeServiceRestTest
 *
 * @testdox The TimeframeService (REST)
 */
class TimeframeServiceRestTest extends TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var TimeframeService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     */
    public function setupPostNL()
    {
        $this->postnl = new PostNL(
            Customer::create()
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress(Address::create([
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]))
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'),
            'test',
            false,
            PostNL::MODE_REST
        );

        $this->service = $this->postnl->getTimeframeService();
        $this->service->cache = new VoidCachePool();
        $this->service->ttl = 1;
    }

    /**
     * @after
     */
    public function logPendingRequest()
    {
        if (!$this->lastRequest instanceof Request) {
            return;
        }

        global $logger;
        if ($logger instanceof LoggerInterface) {
            $logger->debug($this->getName()." Request\n".\GuzzleHttp\Psr7\str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Creates a valid timeframes request
     *
     * @throws \Exception
     */
    public function testGetTimeframesRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetTimeframesRequestREST(
            (new GetTimeframes())
                ->setMessage($message)
                ->setTimeframe([
                    (new Timeframe())
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setEndDate('02-07-2016')
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions([
                            'Evening',
                        ])
                        ->setPostalCode('2132WT')
                        ->setStartDate('30-06-2016')
                        ->setStreet('Siriusdreef')
                        ->setSundaySorting(true),
                ])
        );

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals([
            'AllowSundaySorting' => '1',
            'StartDate'          => '30-06-2016',
            'EndDate'            => '02-07-2016',
            'PostalCode'         => '2132WT',
            'HouseNumber'        => '42',
            'CountryCode'        => 'NL',
            'Options'            => 'Evening',
            'HouseNrExt'         => 'A',
            'Street'             => 'Siriusdreef',
            'City'               => 'Hoofddorp',
        ], $query);
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Can retrieve the available timeframes
     *
     * @throws \Exception
     */
    public function testGetTimeframesRest()
    {
        $payload = [
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
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($payload)),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $responseTimeframes = $this->postnl->getTimeframes(
            (new GetTimeframes())
                ->setTimeframe([(new Timeframe())
                    ->setCity('Hoofddorp')
                    ->setCountryCode('NL')
                    ->setEndDate('02-07-2016')
                    ->setHouseNr('42')
                    ->setHouseNrExt('A')
                    ->setOptions([
                        'Evening',
                    ])
                    ->setPostalCode('2132WT')
                    ->setStartDate('30-06-2016')
                    ->setStreet('Siriusdreef')
                    ->setSundaySorting(false),
                ])
        );

        // Should be a ResponeTimeframes instance
        $this->assertInstanceOf(ResponseTimeframes::class, $responseTimeframes);
        // Check for data loss
        $this->assertEquals(5, count($responseTimeframes->getReasonNoTimeframes()));
        $this->assertEquals(6, count($responseTimeframes->getTimeframes()));
        $this->assertInstanceOf(Timeframe::class, $responseTimeframes->getTimeframes()[0]);
        $this->assertEquals(json_encode($payload), json_encode($responseTimeframes));
    }
}
