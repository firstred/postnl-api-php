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
use DateTimeInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Message as PsrMessage;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use libphonenumber\NumberParseException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\CutOffTime;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\GetDeliveryDate;
use ThirtyBees\PostNL\Entity\Request\GetSentDate;
use ThirtyBees\PostNL\Entity\Request\GetSentDateRequest;
use ThirtyBees\PostNL\Entity\Response\GetDeliveryDateResponse;
use ThirtyBees\PostNL\Entity\Response\GetSentDateResponse;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\Exception\InvalidArgumentException;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\DeliveryDateService;
use ThirtyBees\PostNL\Service\DeliveryDateServiceInterface;
use function file_get_contents;
use const _RESPONSES_DIR_;

/**
 * Class DeliveryDateRestTest.
 *
 * @testdox The DeliveryDateService (REST)
 */
class DeliveryDateServiceRestTest extends TestCase
{
    /** @var PostNL */
    protected $postnl;
    /** @var DeliveryDateServiceInterface */
    protected $service;
    /** @var */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     * @throws NumberParseException
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
     * @testdox creates a valid delivery date request
     */
    public function testGetDeliveryDateRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetDeliveryDateRequestREST(
            (new GetDeliveryDate())
                ->setGetDeliveryDate(
                    (new GetDeliveryDate())
                        ->setAllowSundaySorting('false')
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
                ->setMessage($message)
        );

        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $this->assertEquals([
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
     * @testdox return a valid delivery date
     * @dataProvider singleDeliveryDateResponseProvider
     */
    public function testGetDeliveryDateRest($response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getDeliveryDate((new GetDeliveryDate())
            ->setGetDeliveryDate(
                (new GetDeliveryDate())
                    ->setAllowSundaySorting('false')
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

        $this->assertInstanceOf(
            GetDeliveryDateResponse::class,
            $response
        );
        $this->assertInstanceof(DateTimeInterface::class, $response->getDeliveryDate());
        $this->assertEquals('30-06-2016', $response->getDeliveryDate()->format('d-m-Y'));
        $this->assertEquals('Daytime', $response->getOptions()[0]);
    }

    /**
     * @testdox creates a valid sent date request
     */
    public function testGetSentDateRequestRest()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSentDateRequestREST((new GetSentDateRequest())
            ->setGetSentDate(
                (new GetSentDate())
                    ->setAllowSundaySorting(true)
                    ->setCity('Hoofddorp')
                    ->setCountryCode('NL')
                    ->setDeliveryDate('30-06-2016')
                    ->setHouseNr('42')
                    ->setHouseNrExt('A')
                    ->setOptions([
                        'Daytime',
                    ])
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
     * @testdox return a valid sent date
     */
    public function testGetSentDateRest()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'text/xml;charset=UTF-8'], json_encode([
                'SentDate' => '29-06-2016',
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $response = $this->postnl->getSentDate((new GetSentDateRequest())
            ->setGetSentDate(
                (new GetSentDate())
                    ->setAllowSundaySorting(true)
                    ->setCity('Hoofddorp')
                    ->setCountryCode('NL')
                    ->setDeliveryDate('30-06-2016')
                    ->setHouseNr('42')
                    ->setHouseNrExt('A')
                    ->setOptions([
                        'Daytime',
                    ])
                    ->setPostalCode('2132WT')
                    ->setShippingDuration('1')
                    ->setStreet('Siriusdreef')
            )
        );

        $this->assertInstanceOf(
            GetSentDateResponse::class,
            $response
        );
        $this->assertEquals('29-06-2016', $response->getSentDate());
    }

    public function singleDeliveryDateResponseProvider()
    {
        return [
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/deliverydate/deliverydate.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/deliverydate/deliverydate2.http'))],
            [PsrMessage::parseResponse(file_get_contents(_RESPONSES_DIR_.'/rest/deliverydate/deliverydate3.http'))],
        ];
    }
}
