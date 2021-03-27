<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker
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

namespace ThirtyBees\PostNL\Tests\Service;

use Cache\Adapter\Void\VoidCachePool;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\GetTimeframes;
use ThirtyBees\PostNL\Entity\Response\ResponseTimeframes;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\Entity\Timeframe;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\TimeframeServiceInterface;

/**
 * Class TimeframeServiceRestTest.
 *
 * @testdox The TimeframeService (REST)
 */
class TimeframeServiceRestTest extends ServiceTest
{
    /** @var PostNL */
    protected $postnl;
    /** @var TimeframeServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
     * @throws \ReflectionException
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
                ->setGlobalPackCustomerCode('1234'), new UsernameToken(null, 'test'),
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
            $logger->debug($this->getName()." Request\n".PsrMessage::toString($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox creates a valid timeframes request
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

        $query = Query::parse($request->getUri()->getQuery());

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
     * @testdox can retrieve the available timeframes
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
                            'Evening',
                        ],
                    ],
                    [
                        'Code'        => '03',
                        'Date'        => '11-03-2018',
                        'Description' => 'Dag uitgesloten van tijdvak',
                        'Options'     => [
                            'Daytime',
                        ],
                    ],
                    [
                        'Code'        => '03',
                        'Date'        => '11-03-2018',
                        'Description' => 'Dag uitgesloten van tijdvak',
                        'Options'     => [
                            'Evening',
                        ],
                    ],
                    [
                        'Code'        => '01',
                        'Date'        => '12-03-2018',
                        'Description' => 'Geen routeplan tijdvak',
                        'Options'     => [
                            'Daytime',
                        ],
                    ],
                    [
                        'Code'        => '05',
                        'Date'        => '12-03-2018',
                        'Description' => 'Geen avondbelevering mogelijk',
                        'Options'     => [
                            'Evening',
                        ],
                    ],
                ],
            ],
            'Timeframes' => [
                'Timeframe' => [
                    [
                        'Date'       => '07-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '16:00:00',
                                    'Options' => [
                                        'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date'       => '08-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '15:45:00',
                                    'Options' => [
                                        'Daytime',
                                    ],
                                    'To' => '18:15:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date'       => '09-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '15:30:00',
                                    'Options' => [
                                        'Daytime',
                                    ],
                                    'To' => '18:00:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'Evening',
                                    ],
                                    'To' => '22:00:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date'       => '10-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '16:15:00',
                                    'Options' => [
                                        'Daytime',
                                    ],
                                    'To' => '18:45:00',
                                ],
                            ],
                        ],
                    ],
                    [
                        'Date'       => '13-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '16:00:00',
                                    'Options' => [
                                        'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'Evening',
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
                                        'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'Evening',
                                    ],
                                    'To' => '20:00:00',
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

        // Should be a ResponseTimeframes instance
        $this->assertInstanceOf(ResponseTimeframes::class, $responseTimeframes);
        // Check for data loss
        $this->assertCount(5, $responseTimeframes->getReasonNoTimeframes());
        $this->assertCount(6, $responseTimeframes->getTimeframes());
        $this->assertInstanceOf(Timeframe::class, $responseTimeframes->getTimeframes()[0]);
        $this->assertJsonStringEqualsJsonString(json_encode($payload), json_encode($responseTimeframes));
        $this->assertNotTrue($this->containsStdClass($responseTimeframes));
    }
}
