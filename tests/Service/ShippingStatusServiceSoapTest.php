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
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Dimension;
use ThirtyBees\PostNL\Entity\Message\Message;
use ThirtyBees\PostNL\Entity\Request\CompleteStatus;
use ThirtyBees\PostNL\Entity\Request\CurrentStatus;
use ThirtyBees\PostNL\Entity\Request\GetSignature;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\ShippingStatusService;

/**
 * Class ShippingStatusSoapTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The ShippingStatusService (SOAP)
 */
class ShippingStatusSoapTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var ShippingStatusService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    /**
     * @before
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
                ->setGlobalPackCustomerCode('1234')
            , new UsernameToken(null, 'test'),
            true,
            PostNL::MODE_SOAP
        );

        $this->service = $this->postnl->getShippingStatusService();
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
     * @testdox creates a valid CurrentStatus request
     */
    public function testGetCurrentStatusRequestSoap()
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestSOAP(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode($barcode)
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CurrentStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:Barcode>{$barcode}</domain:Barcode>
   </domain:Shipment>
  </services:CurrentStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox can get the current status
     */
    public function testGetCurrentStatusSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
   <s:Body>
     <CurrentStatusResponse
xmlns="http://postnl.nl/cif/services/ShippingStatusWebService/" xmlns:a="http://postnl.nl/cif/domain/ShippingStatusWebService/" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
       <a:Shipments>
         <a:CurrentStatusResponseShipment>
           <a:Addresses>
             <a:ResponseAddress>
               <a:AddressType>01</a:AddressType>
               <a:City>Hoofddorp</a:City>
               <a:CountryCode>NL</a:CountryCode>
               <a:LastName>de Ruiter</a:LastName>
               <a:RegistrationDate>01-01-0001 00:00:00</a:RegistrationDate>
               <a:Street>Siriusdreef</a:Street>
               <a:Zipcode>2132WT</a:Zipcode>
             </a:ResponseAddress>
             <a:ResponseAddress>
               <a:AddressType>02</a:AddressType>
               <a:City>Vianen</a:City>
               <a:CompanyName>PostNL</a:CompanyName>
               <a:CountryCode>NL</a:CountryCode>
               <a:HouseNumber>1</a:HouseNumber>
               <a:HouseNumberSuffix>A</a:HouseNumberSuffix>
               <a:RegistrationDate>01-01-0001 00:00:00</a:RegistrationDate>
               <a:Street>Lage Biezenweg</a:Street>
               <a:Zipcode>4131LV</a:Zipcode>
             </a:ResponseAddress>
           </a:Addresses>
           <a:Barcode>3SABCD6659149</a:Barcode>
           <a:Groups>
             <a:ResponseGroup>
               <a:GroupType>4</a:GroupType>
               <a:MainBarcode>3SABCD6659149</a:MainBarcode>
               <a:ShipmentAmount>1</a:ShipmentAmount>
               <a:ShipmentCounter>1</a:ShipmentCounter>
             </a:ResponseGroup>
           </a:Groups>
           <a:ProductCode>003052</a:ProductCode>
           <a:Reference>2016014567</a:Reference>
           <a:Status>
             <a:CurrentPhaseCode>4</a:CurrentPhaseCode>
             <a:CurrentPhaseDescription>Afgeleverd</a:CurrentPhaseDescription>
             <a:CurrentStatusCode>11</a:CurrentStatusCode>
             <a:CurrentStatusDescription>Zending afgeleverd</a:CurrentStatusDescription>
             <a:CurrentStatusTimeStamp>06-06-2016 18:00:41</a:CurrentStatusTimeStamp>
           </a:Status>
         </a:CurrentStatusResponseShipment>
       </a:Shipments>
     </CurrentStatusResponse>
   </s:Body>
</s:Envelope>')]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $currentStatusResponse = $this->postnl->getCurrentStatus(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode('3S8392302392342')
                )
        );

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse', $currentStatusResponse);
    }

    /**
     * @testdox creates a valid CurrentStatusByReference request
     */
    public function testGetCurrentStatusByReferenceRequestSoap()
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestSOAP(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setReference($reference)
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CurrentStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:Reference>{$reference}</domain:Reference>
   </domain:Shipment>
  </services:CurrentStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox creates a valid CurrentStatusByStatus request
     */
    public function testGetCurrentStatusByStatusRequestSoap()
    {
        $status = '1';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestSOAP(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setStatusCode($status)
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CurrentStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:StatusCode>{$status}</domain:StatusCode>
   </domain:Shipment>
  </services:CurrentStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox creates a valid CurrentStatusByPhase request
     */
    public function testGetCurrentStatusByPhaseRequestSoap()
    {
        $phase = '1';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCurrentStatusRequestSOAP(
            (new CurrentStatus())
                ->setShipment(
                    (new Shipment())
                        ->setPhaseCode($phase)
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CurrentStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:PhaseCode>{$phase}</domain:PhaseCode>
   </domain:Shipment>
  </services:CurrentStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox creates a valid CompleteStatus request
     */
    public function testGetCompleteStatusRequestSoap()
    {
        $barcode = '3SDEVC201611210';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestSOAP(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode($barcode)
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CompleteStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:Barcode>{$barcode}</domain:Barcode>
   </domain:Shipment>
  </services:CompleteStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox creates a valid CompleteStatusByReference request
     */
    public function testGetCompleteStatusByReferenceRequestSoap()
    {
        $reference = '339820938';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestSOAP(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setReference($reference)
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CompleteStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:Reference>{$reference}</domain:Reference>
   </domain:Shipment>
  </services:CompleteStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox can get the complete status
     */
    public function testGetCompleteStatusSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
   <s:Body>
     <CompleteStatusResponse
xmlns="http://postnl.nl/cif/services/ShippingStatusWebService/" xmlns:a="http://postnl.nl/cif/domain/ShippingStatusWebService/" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
       <a:Shipments>
         <a:CompleteStatusResponseShipment>
           <a:Addresses>
             <a:ResponseAddress>
               <a:AddressType>01</a:AddressType>
               <a:City>Rimini</a:City>
               <a:CountryCode>IT</a:CountryCode>
               <a:HouseNumber>37</a:HouseNumber>
               <a:HouseNumberSuffix>b</a:HouseNumberSuffix>
               <a:LastName>Carlo</a:LastName>
               <a:RegistrationDate>01-01-0001 00:00:00</a:RegistrationDate>
               <a:Street>Via Italia </a:Street>
               <a:Zipcode>46855</a:Zipcode>
             </a:ResponseAddress>
           </a:Addresses>
           <a:Amounts>
             <a:ResponseAmount>
               <a:AmountType>RemboursBedrag</a:AmountType>
               <a:Value>0</a:Value>
             </a:ResponseAmount>
             <a:ResponseAmount>
               <a:AmountType>VerzekerdBedrag</a:AmountType>
               <a:Value>0</a:Value>
             </a:ResponseAmount>
           </a:Amounts>
           <a:Barcode>3SABCD6659149</a:Barcode>
           <a:Customer>
             <a:CustomerCode>ABCD</a:CustomerCode>
             <a:CustomerNumber>11223344</a:CustomerNumber>
           </a:Customer>
           <a:Dimension>
             <a:Height>1400</a:Height>
             <a:Length>2000</a:Length>
             <a:Volume>30000</a:Volume>
             <a:Weight>4300</a:Weight>
             <a:Width>1500</a:Width>
           </a:Dimension>
           <a:Events>
             <a:CompleteStatusResponseEvent>
               <a:Code>01A</a:Code>
               <a:Description>Zending is aangemeld maar nog niet ontvangen door PostNL</a:Description>
               <a:LocationCode>156789</a:LocationCode>
               <a:TimeStamp>03-08-2015 18:27:00</a:TimeStamp>
             </a:CompleteStatusResponseEvent>
             <a:CompleteStatusResponseEvent>
               <a:Code>05Y</a:Code>
               <a:Description>Bezorger is onderweg</a:Description>
               <a:LocationCode>166253</a:LocationCode>
               <a:TimeStamp>21-04-2016 09:50:53</a:TimeStamp>
             </a:CompleteStatusResponseEvent>
             <a:CompleteStatusResponseEvent>
               <a:Code>01B</a:Code>
               <a:Description>Zending is ontvangen door PostNL</a:Description>
               <a:DestinationLocationCode>160662</a:DestinationLocationCode>
               <a:LocationCode>160662</a:LocationCode>
               <a:TimeStamp>20-04-2016 00:39:13</a:TimeStamp>
             </a:CompleteStatusResponseEvent>
             <a:CompleteStatusResponseEvent>
               <a:Code>02M</a:Code>
               <a:Description>Voorgemelde zending niet aangetroffen: manco</a:Description>
               <a:LocationCode>888888</a:LocationCode>
               <a:TimeStamp>20-04-2016 06:06:16</a:TimeStamp>
             </a:CompleteStatusResponseEvent>
             <a:CompleteStatusResponseEvent>
               <a:Code>01A</a:Code>
               <a:Description>Zending is aangemeld maar nog niet ontvangen door PostNL</a:Description>
               <a:LocationCode>888888</a:LocationCode>
               <a:TimeStamp>20-04-2016 06:06:16</a:TimeStamp>
             </a:CompleteStatusResponseEvent>
           </a:Events>
           <a:Groups>
             <a:ResponseGroup>
               <a:GroupType>4</a:GroupType>
               <a:MainBarcode>3SDUGS0101223</a:MainBarcode>
               <a:ShipmentAmount>1</a:ShipmentAmount>
               <a:ShipmentCounter>1</a:ShipmentCounter>
             </a:ResponseGroup>
           </a:Groups>
           <a:OldStatuses>
             <a:CompleteStatusResponseOldStatus>
               <a:Code>99</a:Code>
               <a:Description>niet van toepassing</a:Description>
               <a:PhaseCode>99</a:PhaseCode>
               <a:PhaseDescription>niet van toepassing</a:PhaseDescription>
               <a:TimeStamp>20-04-2016 00:00:00</a:TimeStamp>
             </a:CompleteStatusResponseOldStatus>
             <a:CompleteStatusResponseOldStatus>
               <a:Code>7</a:Code>
               <a:Description>Zending in distributieproces</a:Description>
               <a:PhaseCode>3</a:PhaseCode>
               <a:PhaseDescription>Distributie</a:PhaseDescription>
               <a:TimeStamp>19-04-2016 23:53:58</a:TimeStamp>
             </a:CompleteStatusResponseOldStatus>
             <a:CompleteStatusResponseOldStatus>
               <a:Code>3</a:Code>
               <a:Description>Zending afgehaald</a:Description>
               <a:PhaseCode>1</a:PhaseCode>
               <a:PhaseDescription>Collectie</a:PhaseDescription>
               <a:TimeStamp>19-04-2016 23:50:15</a:TimeStamp>
             </a:CompleteStatusResponseOldStatus>
             <a:CompleteStatusResponseOldStatus>
               <a:Code>13</a:Code>
               <a:Description>Voorgemeld: nog niet aangenomen</a:Description>
               <a:PhaseCode>1</a:PhaseCode>
               <a:PhaseDescription>Collectie</a:PhaseDescription>
               <a:TimeStamp>19-04-2016 06:06:16</a:TimeStamp>
             </a:CompleteStatusResponseOldStatus>
             <a:CompleteStatusResponseOldStatus>
               <a:Code>1</a:Code>
               <a:Description>Zending voorgemeld</a:Description>
               <a:PhaseCode>1</a:PhaseCode>
               <a:PhaseDescription>Collectie</a:PhaseDescription>
               <a:TimeStamp>19-04-2016 06:06:16</a:TimeStamp>
             </a:CompleteStatusResponseOldStatus>
           </a:OldStatuses>
           <a:ProductCode>004944</a:ProductCode>
           <a:ProductDescription>EPS to Consumer</a:ProductDescription>
           <a:Reference>100101101</a:Reference>
           <a:Status>
             <a:CurrentPhaseCode>4</a:CurrentPhaseCode>
             <a:CurrentPhaseDescription>Afgeleverd</a:CurrentPhaseDescription>
             <a:CurrentStatusCode>11</a:CurrentStatusCode>
             <a:CurrentStatusDescription>Zending afgeleverd</a:CurrentStatusDescription>
             <a:CurrentStatusTimeStamp>19-04-2016 18:27:00</a:CurrentStatusTimeStamp>
           </a:Status>
         </a:CompleteStatusResponseShipment>
       </a:Shipments>
     </CompleteStatusResponse>
   </s:Body>
</s:Envelope>')]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $completeStatusResponse = $this->postnl->getCompleteStatus(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setBarcode('3SABCD6659149')
                )
        );

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse', $completeStatusResponse);
        $this->assertEquals(1, count($completeStatusResponse->getShipments()[0]->getAddresses()));
        $this->assertEquals(2, count($completeStatusResponse->getShipments()[0]->getAmounts()));
        $this->assertEquals(5, count($completeStatusResponse->getShipments()[0]->getEvents()));
        $this->assertEquals(1, count($completeStatusResponse->getShipments()[0]->getGroups()));
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Customer', $completeStatusResponse->getShipments()[0]->getCustomer());
        $this->assertEquals('19-04-2016 06:06:16', $completeStatusResponse->getShipments()[0]->getOldStatuses()[4]->getTimeStamp());
    }

    /**
     * @testdox creates a valid CompleteStatusByStatus request
     */
    public function testGetCompleteStatusByStatusRequestSoap()
    {
        $status = '1';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestSOAP(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setStatusCode($status)
                        ->setDateFrom('29-06-2016')
                        ->setDateTo('20-07-2016')
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CompleteStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:DateFrom>29-06-2016</domain:DateFrom>
    <domain:DateTo>20-07-2016</domain:DateTo>
    <domain:StatusCode>{$status}</domain:StatusCode>
   </domain:Shipment>
  </services:CompleteStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox creates a valid CompleteStatusByPhase request
     */
    public function testGetCompleteStatusByPhaseRequestSoap()
    {
        $phase = '1';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildCompleteStatusRequestSOAP(
            (new CompleteStatus())
                ->setShipment(
                    (new Shipment())
                        ->setPhaseCode($phase)
                        ->setDateFrom('29-06-2016')
                        ->setDateTo('20-07-2016')
                )
                ->setMessage($message)
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:CompleteStatus>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:DateFrom>29-06-2016</domain:DateFrom>
    <domain:DateTo>20-07-2016</domain:DateTo>
    <domain:PhaseCode>{$phase}</domain:PhaseCode>
   </domain:Shipment>
  </services:CompleteStatus>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox creates a valid GetSignature request
     */
    public function testGetSignatureRequestSoap()
    {
        $barcode = '3S9283920398234';
        $message = new Message();

        $this->lastRequest = $request = $this->service->buildGetSignatureRequestSOAP(
            (new GetSignature())
                ->setMessage($message)
                ->setShipment((new Shipment())
                    ->setBarcode($barcode)
                )
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/ShippingStatusWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/ShippingStatusWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GetSignature>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
   </domain:Message>
   <domain:Customer>
    <domain:CustomerCode>{$this->postnl->getCustomer()->getCustomerCode()}</domain:CustomerCode>
    <domain:CustomerNumber>{$this->postnl->getCustomer()->getCustomerNumber()}</domain:CustomerNumber>
   </domain:Customer>
   <domain:Shipment>
    <domain:Barcode>{$barcode}</domain:Barcode>
   </domain:Shipment>
  </services:GetSignature>
 </soap:Body>
</soap:Envelope>
", (string) $request->getBody());
    }

    /**
     * @testdox can get the signature
     */
    public function testGetSignatureSoap()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
   <s:Body>
     <SignatureResponse
xmlns="http://postnl.nl/cif/services/ShippingStatusWebService/" xmlns:a="http://postnl.nl/cif/domain/ShippingStatusWebService/" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
          <a:Signature>
             <a:GetSignatureResponseSignature>
                <a:Barcode>3SABCD6659149</a:Barcode>
                <a:SignatureDate>27-06-2015 13:34:19</a:SignatureDate>
                <a:SignatureImage>[Base64 string]</a:SignatureImage>
             </a:GetSignatureResponseSignature>
             <a:Warnings>
                 <a:Warning>
                   <a:Code>00</a:Code>
                   <a:Description>Warning</a:Description>
                </a:Warning>
             </a:Warnings>
          </a:Signature>
       </SignatureResponse>
    </s:Body>
</s:Envelope>')]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $signatureResponse = $this->postnl->getSignature(
            (new GetSignature())
                ->setShipment((new Shipment())
                    ->setBarcode('3SABCD6659149')
                )
        );

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\SignatureResponse', $signatureResponse);
    }
}
