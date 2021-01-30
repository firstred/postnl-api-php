<?php

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Tests\Unit\Service;

use Cache\Adapter\Void\VoidCachePool;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\ReasonNoTimeframe;
use ThirtyBees\PostNL\Entity\Request\CalculateTimeframesRequest;
use ThirtyBees\PostNL\Entity\Response\CalculateTimeframesResponse;
use ThirtyBees\PostNL\Entity\Timeframe;
use ThirtyBees\PostNL\Exception\InvalidArgumentException;
use ThirtyBees\PostNL\Util\Message;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class TimeframeServiceTest.
 *
 * @testdox The TimeframeService (REST)
 */
class TimeframeServiceTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;
    /** @var TimeframeService */
    protected $service;
    /** @var */
    protected $lastRequest;

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
            false
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
        if (!$this->lastRequest instanceof RequestInterface) {
            return;
        }

        global $logger;
        if ($logger instanceof LoggerInterface) {
            $logger->debug($this->getName()." Request\n".Message::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Creates a valid timeframes request
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function testCalculateTimeframesRequest()
    {
        $this->lastRequest = $request = $this->service->buildCalculateTimeframesRequest(
            (new CalculateTimeframesRequest())
                ->setAllowSundaySorting(true)
                ->setCity('Hoofddorp')
                ->setCountryCode('NL')
                ->setEndDate('02-07-2016')
                ->setHouseNumber('42')
                ->setHouseNrExt('A')
                ->setOptions(['Evening'])
                ->setPostalCode('2132WT')
                ->setStartDate('30-06-2016')
                ->setStreet('Siriusdreef')
        );

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals([
            'AllowSundaySorting' => 'true',
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
     */
    public function testGetTimeframesRest()
    {
        $payload = file_get_contents(__DIR__.'/../../data/responses/timeframes.json');
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $mockClient->addResponse(
            $responseFactory->createResponse(200, 'OK')
                ->withHeader('Content-Type', 'application/json;charset=UTF-8')
                ->withBody($streamFactory->createStream($payload))
        );
        \ThirtyBees\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $responseTimeframes = $this->postnl->calculateTimeframes(
            '30-06-2016',
            '03-07-2016',
            '2132WT',
            42,
            'A',
            'NL',
            'Siriusdreef',
            'Hoofddorp',
            false,
            ['Daytime', 'Evening']
        );

        // Should be a CalculateTimeframesResponse instance
        $this->assertInstanceOf(CalculateTimeframesResponse::class, $responseTimeframes);

        // There are 5 ReasonNoTimeframes
        $this->assertEquals(5, count($responseTimeframes->getReasonNoTimeframes()));
        // There are 5 Timeframes
        $this->assertEquals(6, count($responseTimeframes->getTimeframes()));

        // The first reason should be an instanceof of ReasonNoTimeframe
        $this->assertInstanceOf(ReasonNoTimeframe::class, $responseTimeframes->getReasonNoTimeframes()[0]);
        // The first timeframe should be an instanceof Timeframe
        $this->assertInstanceOf(Timeframe::class, $responseTimeframes->getTimeframes()[0]);

        // Can be converted back to JSON properly
        $this->assertJsonStringEqualsJsonString(
            json_encode(json_decode($payload), JSON_PRETTY_PRINT),
            json_encode($responseTimeframes, JSON_PRETTY_PRINT)
        );
    }
}
