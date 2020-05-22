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

namespace Firstred\PostNL\Tests\Unit\Service;

use Exception;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\BasicNationalAddressCheckRequest;
use Firstred\PostNL\Entity\Response\BasicNationalAddressCheckResponse;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifErrorException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\Message as MiscMessage;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BasicNationalAddressCheckService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class NationalAddressCheckServiceTest
 *
 * @testdox The NationalAddressCheck (REST)
 */
class NationalAddressCheckServiceTest extends TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var BasicNationalAddressCheckService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
     *
     * @throws InvalidArgumentException
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
            true
        );

        $this->service = $this->postnl->getBasicNationalAddressCheckService();
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
            $logger->debug($this->getName()." Request\n".MiscMessage::str($this->lastRequest));
        }
        $this->lastRequest = null;
    }

    /**
     * @testdox Creates a valid address check by postcode request
     *
     * @throws Exception
     */
    public function testCreatesAValidCheckRequest()
    {
        $this->lastRequest = $request = $this->service->buildBasicNationalAddressCheckRequest(
            (new BasicNationalAddressCheckRequest())
                ->setPostalCode('1234AB')
                ->setHouseNumber(42)
        );
        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            [
                'postalcode'  => '1234AB',
                'housenumber' => '42',
            ],
            $query,
            '',
            0,
            10,
            true
        );
        $this->assertEmpty((string) $request->getBody());
        $this->assertEquals('/address/national/basic/v1/postalcode', $request->getUri()->getPath());
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox Creates a valid address check by postcode request
     *
     * @throws Exception
     */
    public function testCreatesAValidCheckByCityStreetRequest()
    {
        $this->lastRequest = $request = $this->service->buildBasicNationalAddressCheckRequest((new BasicNationalAddressCheckRequest())->setPostalCode('1234AB'));
        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals(
            ['postalcode'  => '1234AB'],
            $query,
            '',
            0,
            10,
            true
        );
        $this->assertEmpty((string) $request->getBody());
        $this->assertEquals('/address/national/basic/v1/citystreetname', $request->getUri()->getPath());
        $this->assertEquals('test', $request->getHeaderLine('apikey'));
        $this->assertEquals('', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdoc Does a valid request
     *
     * @throws InvalidArgumentException
     * @throws CifDownException
     * @throws CifErrorException
     * @throws \Http\Client\Exception
     */
    public function testDoesAValidCheck()
    {
        $mockClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse(200, 'OK')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($streamFactory->createStream(file_get_contents(__DIR__.'/../../data/responses/basicnationaladdresscheck.json')))
        ;
        $mockClient->addResponse($response);
        $mockClient->addResponse($response);
        \Firstred\PostNL\Http\Client::getInstance()->setAsyncClient($mockClient);

        /** @var BasicNationalAddressCheckResponse $response */
        $response = $this->postnl->basicNationalAddressCheck('2132WT', 42);

        $this->assertInstanceOf(BasicNationalAddressCheckResponse::class, $response);
        $this->assertEquals('Siriusdreef', $response->getStreetName());

        $response = $this->postnl->basicNationalAddressCheck('2132WT');

        $this->assertInstanceOf(BasicNationalAddressCheckResponse::class, $response);
        $this->assertEquals('Siriusdreef', $response->getStreetName());
    }
}
