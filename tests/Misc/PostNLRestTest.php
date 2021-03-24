<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2018 Thirty Development, LLC
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
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Tests\Misc;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\CutOffTime;
use ThirtyBees\PostNL\Entity\Location;
use ThirtyBees\PostNL\Entity\Request\GetDeliveryDate;
use ThirtyBees\PostNL\Entity\Request\GetNearestLocations;
use ThirtyBees\PostNL\Entity\Request\GetTimeframes;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\Entity\Timeframe;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;

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
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
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
            true,
            PostNL::MODE_REST
        );
    }

    /**
     * @testdox returns a valid customer code in REST mode
     */
    public function testPostNLRest()
    {
        $this->assertEquals('DEVC', $this->postnl->getCustomer()->getCustomerCode());
    }

    /**
     * @testdox returns a valid customer
     */
    public function testCustomer()
    {
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Customer', $this->postnl->getCustomer());
    }

    /**
     * @testdox accepts a string token
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
     */
    public function testSetTokenString()
    {
        $this->postnl->setToken('test');
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken', $this->postnl->getToken());
    }

    /**
     * @testdox accepts a token object
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
     */
    public function testSetTokenObject()
    {
        $this->postnl->setToken(new UsernameToken(null, 'test'));
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken', $this->postnl->getToken());
    }

    /**
     * @testdox accepts a `null` logger
     */
    public function testSetNullLogger()
    {
        $this->postnl->setLogger();

        $this->assertNull($this->postnl->getLogger());
    }

    /**
     * @testdox returns a combinations of timeframes, locations and the delivery date
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \ThirtyBees\PostNL\Exception\HttpClientException
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
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
                        'Date'       => '07-03-2018',
                        'Timeframes' => [
                            'TimeframeTimeFrame' => [
                                [
                                    'From'    => '16:00:00',
                                    'Options' => [
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
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
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:15:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
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
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:00:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
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
                                        'string' => 'Daytime',
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
                                        'string' => 'Daytime',
                                    ],
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
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
                                    'To' => '18:30:00',
                                ],
                                [
                                    'From'    => '18:00:00',
                                    'Options' => [
                                        'string' => 'Evening',
                                    ],
                                    'To' => '20:00:00',
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
            'Options'      => [
                'string' => 'Daytime',
            ],
        ];

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($timeframesPayload)),
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($locationsPayload)),
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], json_encode($deliveryDatePayload)),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $results = $this->postnl->getTimeframesAndNearestLocations(
            (new GetTimeframes())
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
                        ->setSundaySorting(false),
                ]),
            (new GetNearestLocations())
                ->setCountrycode('NL')
                ->setLocation(Location::create([
                    'AllowSundaySorting' => true,
                    'DeliveryDate'       => '29-06-2016',
                    'DeliveryOptions'    => [
                        'PGE',
                    ],
                    'OpeningTime' => '09:00:00',
                    'Options'     => [
                        'Daytime',
                    ],
                    'City'       => 'Hoofddorp',
                    'HouseNr'    => '42',
                    'HouseNrExt' => 'A',
                    'Postalcode' => '2132WT',
                    'Street'     => 'Siriusdreef',
                ])),
            (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    (new GetDeliveryDate())
                        ->setAllowSundaySorting(false)
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setCutOffTimes([
                            new CutOffTime('00', '14:00:00'),
                        ])
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions([
                            'Daytime',
                        ])
                        ->setPostalCode('2132WT')
                        ->setShippingDate('29-06-2016 14:00:00')
                        ->setShippingDuration('1')
                        ->setStreet('Siriusdreef')
                )
        );

        $this->assertTrue(is_array($results));
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes', $results['timeframes']);
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse', $results['locations']);
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse', $results['delivery_date']);
    }

    /**
     * @testdox does not accept an invalid token object
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
     */
    public function testNegativeInvalidToken()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');
        $this->postnl->setToken(new Address());
    }

    /**
     * @testdox returns `false` when the API key is missing
     *
     * @throws \ReflectionException
     */
    public function testNegativeKeyMissing()
    {
        $reflection = new \ReflectionClass('\\ThirtyBees\\PostNL\\PostNL');
        /** @var PostNL $postnl */
        $postnl = $reflection->newInstanceWithoutConstructor();

        $this->assertFalse($postnl->getRestApiKey());
    }

    /**
     * @testdox throws an exception when setting an invalid mode
     *
     * @throws \ThirtyBees\PostNL\Exception\InvalidArgumentException
     */
    public function testNegativeInvalidMode()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        $this->postnl->setMode('invalid');
    }

    protected function getNearestLocationsMockResponse()
    {
        return $json = '{
  "GetLocationsResult": {
    "ResponseLocation": [
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 22,
          "Remark": "Dit is een Postkantoor. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 16:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Vrijheidslaan",
          "Zipcode": "2625RD"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 244,
        "Latitude": 51.987855746674,
        "LocationCode": 161457,
        "Longitude": 4.34625216973989,
        "Name": "DA Drogisterij Buitenhof",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-19:00"
          },
          "Monday": {
            "string": "09:00-19:00"
          },
          "Saturday": {
            "string": "09:00-18:00"
          },
          "Sunday": {
            "string": "12:00-17:00"
          },
          "Thursday": {
            "string": "09:00-19:00"
          },
          "Tuesday": {
            "string": "09:00-19:00"
          },
          "Wednesday": {
            "string": "09:00-19:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2560615",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "PKT L",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 189,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Bikolaan",
          "Zipcode": "2622GS"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 825,
        "Latitude": 51.982036286304,
        "LocationCode": 203091,
        "Longitude": 4.34583404358571,
        "Name": "Primera",
        "OpeningHours": {
          "Friday": {
            "string": "08:30-19:00"
          },
          "Monday": {
            "string": "08:30-18:00"
          },
          "Saturday": {
            "string": "08:30-17:00"
          },
          "Thursday": {
            "string": "08:30-18:00"
          },
          "Tuesday": {
            "string": "08:30-18:00"
          },
          "Wednesday": {
            "string": "08:30-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2621125",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 67,
          "Remark": "Dit is een Postkantoor. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 15:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Troelstralaan",
          "Zipcode": "2624ET"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 1038,
        "Latitude": 51.9973397152423,
        "LocationCode": 161429,
        "Longitude": 4.35143455385577,
        "Name": "Primera",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-20:00"
          },
          "Monday": {
            "string": "09:00-18:00"
          },
          "Saturday": {
            "string": "09:00-17:00"
          },
          "Thursday": {
            "string": "09:00-18:00"
          },
          "Tuesday": {
            "string": "09:00-18:00"
          },
          "Wednesday": {
            "string": "09:00-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2618017",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "PKT M",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 12,
          "HouseNrExt": -14,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 15:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Dasstraat",
          "Zipcode": "2623CC"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 1242,
        "Latitude": 51.9851578994749,
        "LocationCode": 203064,
        "Longitude": 4.36043621785067,
        "Name": "Primera",
        "OpeningHours": {
          "Friday": {
            "string": "08:30-19:00"
          },
          "Monday": {
            "string": "08:30-18:00"
          },
          "Saturday": {
            "string": "08:30-17:00"
          },
          "Thursday": {
            "string": "08:30-18:00"
          },
          "Tuesday": {
            "string": "08:30-18:00"
          },
          "Wednesday": {
            "string": "08:30-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2614727",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "den Hoorn",
          "Countrycode": "NL",
          "HouseNr": 31,
          "Remark": "Dit is een Postkantoor. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 15:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Dijkshoornseweg",
          "Zipcode": "2635EJ"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 1550,
        "Latitude": 52.0005756289925,
        "LocationCode": 162195,
        "Longitude": 4.33019944648497,
        "Name": "Primera Den Hoorn",
        "OpeningHours": {
          "Friday": {
            "string": "08:30-18:00"
          },
          "Monday": {
            "string": "08:30-18:00"
          },
          "Saturday": {
            "string": "08:30-16:00"
          },
          "Thursday": {
            "string": "08:30-18:00"
          },
          "Tuesday": {
            "string": "08:30-18:00"
          },
          "Wednesday": {
            "string": "08:30-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2614760",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "PKT M",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 35,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Leeuwenstein",
          "Zipcode": "2627AM"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "BW",
            "PG_EX"
          ]
        },
        "Distance": 1645,
        "Latitude": 51.99967798122,
        "LocationCode": 167487,
        "Longitude": 4.3608027269553,
        "Name": "GAMMA Delft",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-21:00"
          },
          "Monday": {
            "string": "09:00-21:00"
          },
          "Saturday": {
            "string": "08:00-18:00"
          },
          "Sunday": {
            "string": "10:00-17:00"
          },
          "Thursday": {
            "string": "09:00-21:00"
          },
          "Tuesday": {
            "string": "09:00-21:00"
          },
          "Wednesday": {
            "string": "09:00-21:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2578899",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 104,
          "Remark": "Dit is een Business Point. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Schieweg",
          "Zipcode": "2627AR"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "PGE",
            "UL",
            "BW",
            "PG_EX",
            "PGE_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 1960,
        "Latitude": 51.9832496204993,
        "LocationCode": 174738,
        "Longitude": 4.3704809280059,
        "Name": "Makro Delft",
        "OpeningHours": {
          "Friday": {
            "string": "08:00-22:00"
          },
          "Monday": {
            "string": "08:00-22:00"
          },
          "Saturday": {
            "string": "08:00-18:00"
          },
          "Sunday": {
            "string": "12:00-17:00"
          },
          "Thursday": {
            "string": "08:00-22:00"
          },
          "Tuesday": {
            "string": "08:00-22:00"
          },
          "Wednesday": {
            "string": "08:00-22:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2700820",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "BUPO RET",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 47,
          "HouseNrExt": -53,
          "Remark": "Dit is een Business Point. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 17:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Westvest",
          "Zipcode": "2611AZ"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "PGE",
            "UL",
            "BW",
            "PG_EX",
            "PGE_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 2197,
        "Latitude": 52.0067524308132,
        "LocationCode": 156881,
        "Longitude": 4.35877639899862,
        "Name": "Copie Sjop",
        "OpeningHours": {
          "Friday": {
            "string": "07:30-23:59"
          },
          "Monday": {
            "string": "07:30-23:59"
          },
          "Saturday": {
            "string": "07:30-23:59"
          },
          "Sunday": {
            "string": "12:00-23:59"
          },
          "Thursday": {
            "string": "07:30-23:59"
          },
          "Tuesday": {
            "string": "07:30-23:59"
          },
          "Wednesday": {
            "string": "07:30-23:59"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "0152-190190",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "BUPO RET",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Schipluiden",
          "Countrycode": "NL",
          "HouseNr": 15,
          "Remark": "Dit is een Postkantoor. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Keenenburgweg",
          "Zipcode": "2636GK"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 2315,
        "Latitude": 51.9762521904687,
        "LocationCode": 171169,
        "Longitude": 4.3173088456154,
        "Name": "Albert Heijn Buckers Schipluiden",
        "OpeningHours": {
          "Friday": {
            "string": "08:00-21:00"
          },
          "Monday": {
            "string": "08:00-20:00"
          },
          "Saturday": {
            "string": "08:00-20:00"
          },
          "Sunday": {
            "string": "12:00-18:00"
          },
          "Thursday": {
            "string": "08:00-20:00"
          },
          "Tuesday": {
            "string": "08:00-20:00"
          },
          "Wednesday": {
            "string": "08:00-20:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-3809563",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "PKT M",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 32,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Vesteplein",
          "Zipcode": "2611WG"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 2527,
        "Latitude": 52.0087737298319,
        "LocationCode": 207647,
        "Longitude": 4.36276475939347,
        "Name": "Biesieklette",
        "OpeningHours": {
          "Friday": {
            "string": "08:30-23:00"
          },
          "Monday": {
            "string": "10:30-18:30"
          },
          "Saturday": {
            "string": "08:30-23:00"
          },
          "Sunday": {
            "string": "11:30-17:30"
          },
          "Thursday": {
            "string": "08:30-23:00"
          },
          "Tuesday": {
            "string": "08:30-18:30"
          },
          "Wednesday": {
            "string": "08:30-18:30"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "085-2229120",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 135,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 17:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Bastiaansplein",
          "Zipcode": "2611DC"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 2631,
        "Latitude": 52.0091143563817,
        "LocationCode": 171790,
        "Longitude": 4.36472337656682,
        "Name": "Jumbo Bastiaansplein",
        "OpeningHours": {
          "Friday": {
            "string": "08:00-22:00"
          },
          "Monday": {
            "string": "08:00-22:00"
          },
          "Saturday": {
            "string": "08:00-22:00"
          },
          "Sunday": {
            "string": "09:00-20:00"
          },
          "Thursday": {
            "string": "08:00-22:00"
          },
          "Tuesday": {
            "string": "08:00-22:00"
          },
          "Wednesday": {
            "string": "08:00-22:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2154090",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 16,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 15:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Van Foreestweg",
          "Zipcode": "2614CJ"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 2684,
        "Latitude": 52.0130523901092,
        "LocationCode": 156819,
        "Longitude": 4.33625653144448,
        "Name": "DA Drogist van Foreest",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-18:00"
          },
          "Monday": {
            "string": "11:00-18:00"
          },
          "Saturday": {
            "string": "09:00-17:00"
          },
          "Thursday": {
            "string": "09:00-18:00"
          },
          "Tuesday": {
            "string": "09:00-18:00"
          },
          "Wednesday": {
            "string": "09:00-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2122793",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 6,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Nassaulaan",
          "Zipcode": "2628GH"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 2903,
        "Latitude": 52.0073457645911,
        "LocationCode": 156596,
        "Longitude": 4.37433315901935,
        "Name": "Sigarenmagazijn Piet de Vries",
        "OpeningHours": {
          "Friday": {
            "string": "07:00-18:00"
          },
          "Monday": {
            "string": "07:00-18:00"
          },
          "Saturday": {
            "string": "08:00-17:00"
          },
          "Thursday": {
            "string": "07:00-18:00"
          },
          "Tuesday": {
            "string": "07:00-18:00"
          },
          "Wednesday": {
            "string": "07:00-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "0152-568775",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delft",
          "Countrycode": "NL",
          "HouseNr": 6,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Elzenlaan",
          "Zipcode": "2612VX"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 3493,
        "Latitude": 52.0180285436483,
        "LocationCode": 204181,
        "Longitude": 4.36441799967166,
        "Name": "Dierenspeciaalzaak Paws and Claws",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-18:00"
          },
          "Monday": {
            "string": "13:00-18:00"
          },
          "Saturday": {
            "string": "09:00-17:00"
          },
          "Thursday": {
            "string": "09:00-18:00"
          },
          "Tuesday": {
            "string": "09:00-18:00"
          },
          "Wednesday": {
            "string": "09:00-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-8871034",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Delfgauw",
          "Countrycode": "NL",
          "HouseNr": 2,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Importweg",
          "Zipcode": "2645EC"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "BW",
            "PG_EX"
          ]
        },
        "Distance": 3664,
        "Latitude": 51.9970822633275,
        "LocationCode": 171898,
        "Longitude": 4.39563621580786,
        "Name": "Karwei",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-21:00"
          },
          "Monday": {
            "string": "09:00-21:00"
          },
          "Saturday": {
            "string": "09:00-18:00"
          },
          "Sunday": {
            "string": "12:00-17:00"
          },
          "Thursday": {
            "string": "09:00-21:00"
          },
          "Tuesday": {
            "string": "09:00-21:00"
          },
          "Wednesday": {
            "string": "09:00-21:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2512121",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "S-Gravenhage",
          "Countrycode": "NL",
          "HouseNr": 223,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Brasserskade",
          "Zipcode": "2497NX"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "BW",
            "PG_EX"
          ]
        },
        "Distance": 4558,
        "Latitude": 52.0290388824125,
        "LocationCode": 171904,
        "Longitude": 4.36018835035983,
        "Name": "KARWEI Den Haag-Ypenburg",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-21:00"
          },
          "Monday": {
            "string": "09:00-21:00"
          },
          "Saturday": {
            "string": "09:00-18:00"
          },
          "Sunday": {
            "string": "10:00-17:00"
          },
          "Thursday": {
            "string": "09:00-21:00"
          },
          "Tuesday": {
            "string": "09:00-21:00"
          },
          "Wednesday": {
            "string": "09:00-21:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "015-2133023",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Wateringen",
          "Countrycode": "NL",
          "HouseNr": 116,
          "Remark": "Dit is een Business Point. Post en pakketten die u op werkdagen vóór de lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag. Pakketten die u op zaterdag voor 15:00 uur afgeeft worden maandag bezorgd.",
          "Street": "Turfschipper",
          "Zipcode": "2292JB"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "PGE",
            "UL",
            "BW",
            "PG_EX",
            "PGE_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 4697,
        "Latitude": 52.0157590615009,
        "LocationCode": 173186,
        "Longitude": 4.29007011744591,
        "Name": "Staples Office Centre",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-18:30"
          },
          "Monday": {
            "string": "09:00-18:30"
          },
          "Saturday": {
            "string": "09:00-17:00"
          },
          "Thursday": {
            "string": "09:00-18:30"
          },
          "Tuesday": {
            "string": "09:00-18:30"
          },
          "Wednesday": {
            "string": "09:00-18:30"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "0174-221042",
        "RetailNetworkID": "PNPNL-01",
        "Saleschannel": "BUPO SOC",
        "TerminalType": "NRS"
      },
      {
        "Address": {
          "City": "Rijswijk",
          "Countrycode": "NL",
          "HouseNr": 86,
          "HouseNrExt": -88,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Henri Dunantlaan",
          "Zipcode": "2286GE"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL",
            "RETA"
          ]
        },
        "Distance": 4779,
        "Latitude": 52.02847182234,
        "LocationCode": 204195,
        "Longitude": 4.31473580396466,
        "Name": "Tabakshop Ylona",
        "OpeningHours": {
          "Friday": {
            "string": "08:30-17:30"
          },
          "Monday": {
            "string": "08:30-17:30"
          },
          "Saturday": {
            "string": "08:30-16:30"
          },
          "Thursday": {
            "string": "08:30-17:30"
          },
          "Tuesday": {
            "string": "08:30-17:30"
          },
          "Wednesday": {
            "string": "08:30-17:30"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "070-3934920",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "Rijswijk",
          "Countrycode": "NL",
          "HouseNr": 9,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Waldhoornplein",
          "Zipcode": "2287EH"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "BW",
            "PG_EX"
          ]
        },
        "Distance": 5129,
        "Latitude": 52.0332351897813,
        "LocationCode": 207473,
        "Longitude": 4.32059704181264,
        "Name": "Supermarkt Buurman",
        "OpeningHours": {
          "Friday": {
            "string": "08:00-21:00"
          },
          "Monday": {
            "string": "08:00-21:00"
          },
          "Saturday": {
            "string": "08:00-21:00"
          },
          "Sunday": {
            "string": "10:00-18:00"
          },
          "Thursday": {
            "string": "08:00-21:00"
          },
          "Tuesday": {
            "string": "08:00-21:00"
          },
          "Wednesday": {
            "string": "08:00-21:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "070-4492193",
        "RetailNetworkID": "PNPNL-01"
      },
      {
        "Address": {
          "City": "S-Gravenhage",
          "Countrycode": "NL",
          "HouseNr": 36,
          "Remark": "Dit is een Pakketpunt. Pakketten die u op werkdagen vóór lichtingstijd afgeeft, bezorgen we binnen Nederland de volgende dag.",
          "Street": "Laan van Haamstede",
          "Zipcode": "2497GE"
        },
        "DeliveryOptions": {
          "string": [
            "DO",
            "PG",
            "UL",
            "BW",
            "PG_EX",
            "BWUL"
          ]
        },
        "Distance": 5486,
        "Latitude": 52.0380977363166,
        "LocationCode": 207869,
        "Longitude": 4.35587035781152,
        "Name": "Amazing Oriental Den Haag-Ypenburg",
        "OpeningHours": {
          "Friday": {
            "string": "09:00-18:00"
          },
          "Monday": {
            "string": "09:00-18:00"
          },
          "Saturday": {
            "string": "09:00-18:00"
          },
          "Thursday": {
            "string": "09:00-18:00"
          },
          "Tuesday": {
            "string": "09:00-18:00"
          },
          "Wednesday": {
            "string": "09:00-18:00"
          }
        },
        "PartnerName": "PostNL",
        "PhoneNumber": "070-7622888",
        "RetailNetworkID": "PNPNL-01"
      }
    ]
  }
}';
    }
}
