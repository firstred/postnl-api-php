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
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\Message\Message;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Http\MockClient;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\DeliveryDateService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class DeliveryDateRestTest
 *
 * @testdox The DeliveryDateService (REST)
 */
class DeliveryDateRestTest extends TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var DeliveryDateService $service */
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
                ->setAddress(
                    Address::create(
                        [
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]
                    )
                )
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234'),
            'test',
            true,
            PostNL::MODE_REST
        );

        $this->service = $this->postnl->getDeliveryDateService();
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
     * @testdox Creates a valid delivery date request
     *
     * @throws \Exception
     */
    public function testGetDeliveryDateRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetDeliveryDateRequestREST(
            (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    (new GetDeliveryDate())
                        ->setAllowSundaySorting(false)
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setCutOffTimes(
                            [
                                new CutOffTime('00', '14:00:00'),
                            ]
                        )
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions(
                            [
                                'Daytime',
                            ]
                        )
                        ->setPostalCode('2132WT')
                        ->setShippingDate('29-06-2016 14:00:00')
                        ->setShippingDuration(1)
                        ->setStreet('Siriusdreef')
                )
                ->setMessage($message)
        );

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals(
            [
                'ShippingDate'     => '29-06-2016 14:00:00',
                'ShippingDuration' => '1',
                'CountryCode'      => 'NL',
                'Options'          => 'Daytime',
                'CutOffTime'       => '14:00:00',
                'PostalCode'       => '2132WT',
                'City'             => 'Hoofddorp',
                'HouseNr'          => '42',
                'HouseNrExt'       => 'A',
            ],
            $query
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid delivery date
     */
    public function testGetDeliveryDateRest()
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    ['Content-Type' => 'text/xml;charset=UTF-8'],
                    json_encode(
                        [
                            'DeliveryDate' => '30-06-2016',
                            'Options'      => [
                                'string' => 'Daytime',
                            ],
                        ]
                    )
                ),
            ]
        );

        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getDeliveryDate(
            (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    (new GetDeliveryDate())
                        ->setAllowSundaySorting(false)
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setCutOffTimes(
                            [
                                new CutOffTime('00', '14:00:00'),
                            ]
                        )
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions(
                            [
                                'Daytime',
                            ]
                        )
                        ->setPostalCode('2132WT')
                        ->setShippingDate('29-06-2016 14:00:00')
                        ->setShippingDuration(1)
                        ->setStreet('Siriusdreef')
                )
        );

        $this->assertInstanceOf(
            '\\Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse',
            $response
        );
        $this->assertEquals('30-06-2016', $response->getDeliveryDate());
    }

    /**
     * @testdox Creates a valid sent date request
     *
     * @throws \Exception
     */
    public function testGetSentDateRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSentDateRequestREST(
            (new GetSentDateRequest())
                ->setGetSentDate(
                    (new GetSentDate())
                        ->setAllowSundaySorting(true)
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setDeliveryDate('30-06-2016')
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions(
                            [
                                'Daytime',
                            ]
                        )
                        ->setPostalCode('2132WT')
                        ->setShippingDuration('1')
                        ->setStreet('Siriusdreef')
                )
                ->setMessage($message)
        );

        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid sent date
     *
     * @throws \Exception
     */
    public function testGetSentDateRest()
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    ['Content-Type' => 'text/xml;charset=UTF-8'],
                    json_encode(
                        [
                            'SentDate' => '29-06-2016',
                        ]
                    )
                ),
            ]
        );

        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getSentDate(
            (new GetSentDateRequest())
                ->setGetSentDate(
                    (new GetSentDate())
                        ->setAllowSundaySorting(true)
                        ->setCity('Hoofddorp')
                        ->setCountryCode('NL')
                        ->setDeliveryDate('30-06-2016')
                        ->setHouseNr('42')
                        ->setHouseNrExt('A')
                        ->setOptions(
                            [
                                'Daytime',
                            ]
                        )
                        ->setPostalCode('2132WT')
                        ->setShippingDuration('1')
                        ->setStreet('Siriusdreef')
                )
        );

        $this->assertInstanceOf(
            '\\Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse',
            $response
        );
        $this->assertEquals('29-06-2016', $response->getSentDate());
    }
}
