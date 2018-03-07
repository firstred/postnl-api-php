<?php
/**
 * The MIT License (MIT)
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

namespace ThirtyBees\PostNL\Tests\Service;

use Cache\Adapter\Void\VoidCachePool;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\GetTimeframes;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\Entity\Timeframe;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\TimeframeService;

/**
 * Class TimeframeServiceSoapTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The TimeframeService (SOAP)
 */
class TimeframeServiceSoapTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var TimeframeService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
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
                ->setGlobalPackCustomerCode('1234')
            , new UsernameToken(null, 'test'),
            false,
            PostNL::MODE_SOAP
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
     * @testdox creates a valid timeframes request
     */
    public function testGetTimeframesRequestSoap()
    {
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetTimeframesSOAPRequest(
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
                            'Evening'
                        ])
                        ->setPostalCode('2132WT')
                        ->setStartDate('30-06-2016')
                        ->setStreet('Siriusdreef')
                        ->setSundaySorting(true)
                ])
        );

        $this->assertEmpty($request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/TimeframeWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/TimeframeWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\" xmlns:arr=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GetTimeframes>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Timeframe>
    <domain:City>Hoofddorp</domain:City>
    <domain:CountryCode>NL</domain:CountryCode>
    <domain:EndDate>02-07-2016</domain:EndDate>
    <domain:HouseNr>42</domain:HouseNr>
    <domain:HouseNrExt>A</domain:HouseNrExt>
    <domain:Options>
     <arr:string>Evening</arr:string>
    </domain:Options>
    <domain:PostalCode>2132WT</domain:PostalCode>
    <domain:StartDate>30-06-2016</domain:StartDate>
    <domain:Street>Siriusdreef</domain:Street>
    <domain:SundaySorting>true</domain:SundaySorting>
   </domain:Timeframe>
  </services:GetTimeframes>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }
}
