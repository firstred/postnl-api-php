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
use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequest;
use Firstred\PostNL\Entity\Request\CalculateShippingDateRequest;
use Firstred\PostNL\Entity\Response\CalculateDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\CalculateShippingDateResponse;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\Message;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\DeliveryDateService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

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
            true
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
     * @testdox Creates a valid calculate delivery date request
     *
     * @throws Exception
     */
    public function testCalculateDeliveryDateRequest()
    {
        /** @var RequestInterface $request */
        $this->lastRequest = $request = $this->service->buildCalculateDeliveryDateRequest(
            (new CalculateDeliveryDateRequest())
                ->setCity('Hoofddorp')
                ->setCountryCode('NL')
                ->setCutOffTime('14:00')
                ->setAvailableMonday(true)
                ->setCutOffTimeMonday('14:00')
                ->setHouseNumber('42')
                ->setHouseNrExt('A')
                ->setOptions(['Daytime'])
                ->setPostalCode('2132WT')
                ->setShippingDate('29-06-2016 14:00:00')
                ->setShippingDuration(1)
                ->setStreet('Siriusdreef')
        );

        parse_str($request->getUri()->getQuery(), $query);
        $this->assertEquals(
            [
                'ShippingDate'     => '29-06-2016 14:00:00',
                'ShippingDuration' => '1',
                'CountryCode'      => 'NL',
                'Options'          => 'Daytime',
                'CutOffTime'       => '14:00:00',
                'PostalCode'       => '2132WT',
                'City'             => 'Hoofddorp',
                'HouseNumber'      => '42',
                'HouseNrExt'       => 'A',
                'AvailableMonday'  => 'true',
                'CutOffTimeMonday' => '14:00:00',
            ],
            $query
        );
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid delivery date
     *
     * @throws InvalidArgumentException
     * @throws CifErrorException
     */
    public function testGetDeliveryDate()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(
                [
                    'DeliveryDate' => '30-06-2016',
                    'Options'      => [
                        'string' => 'Daytime',
                    ],
                ]
            )))
        ;
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->calculateDeliveryDate(
            '29-06-2016 14:00:00',
            1,
            '15:00:00',
            '2132WT',
            'NL',
            'NL',
            'Hoofddorp',
            'Siriusdreef',
            ['Daytime']
        );

        $this->assertInstanceOf(CalculateDeliveryDateResponse::class, $response);
        $this->assertEquals('30-06-2016', $response->getDeliveryDate());
    }


    /**
     * @testdox Creates a valid calculate shipping date request
     *
     * @throws Exception
     */
    public function testCalculateShippingDateRequest()
    {
        $this->lastRequest = $request = $this->service->buildCalculateShippingDateRequest(
            (new CalculateShippingDateRequest())
                ->setCity('Hoofddorp')
                ->setCountryCode('NL')
                ->setDeliveryDate('30-06-2016')
                ->setHouseNumber('42')
                ->setHouseNrExt('A')
                ->setPostalCode('2132WT')
                ->setShippingDuration('1')
                ->setStreet('Siriusdreef')
        );

        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Returns a valid shipping date
     *
     * @throws Exception
     */
    public function testCalculateShippingDate()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(json_encode(['SentDate' => '29-06-2016'])));
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        $response = $this->postnl->calculateShippingDate(
            '30-06-2016',
            1,
            '2132WT',
            'NL',
            'NL',
            'Hoofddorp',
            'Siriusdreef',
            42,
            'A'
        );

        $this->assertInstanceOf(CalculateShippingDateResponse::class, $response);
        $this->assertEquals('29-06-2016', $response->getSentDate());
    }
}
