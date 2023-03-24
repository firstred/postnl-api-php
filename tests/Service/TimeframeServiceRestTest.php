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

namespace Firstred\PostNL\Tests\Service;

use Cache\Adapter\Void\VoidCachePool;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Entity\Response\ResponseTimeframes;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\HttpClient\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Query;
use stdClass;
use function file_get_contents;
use const _RESPONSES_DIR_;

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
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
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

        global $logger;
        $this->postnl->setLogger($logger);

        $this->service = $this->postnl->getTimeframeService();
        $this->service->setCache(new VoidCachePool());
        $this->service->setTtl(1);
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
     * @testdox can retrieve the available timeframes
     * @dataProvider timeframesProvider
     */
    public function testGetTimeframesRest($response)
    {
        $mock = new MockHandler([$response]);
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
        $this->assertInstanceOf(Timeframe::class, $responseTimeframes->getTimeframes()[0]);
        if (count($responseTimeframes->getReasonNoTimeframes())) {
            $this->assertInstanceOf(ReasonNoTimeframe::class, $responseTimeframes->getReasonNoTimeframes()[0]);
        }
        $this->assertNotTrue(static::containsStdClass($responseTimeframes));
    }

    public function timeframesProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/timeframes/timeframes.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/timeframes/timeframes2.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/timeframes/timeframes3.http'))],
        ];
    }
}
