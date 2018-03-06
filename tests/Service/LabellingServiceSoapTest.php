<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
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
 * @copyright 2017 Thirty Development, LLC
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
use ThirtyBees\PostNL\Entity\Message\LabellingMessage;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\HttpClient\MockClient;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Service\LabellingService;

/**
 * Class LabellingServiceSoapTest
 *
 * @package ThirtyBees\PostNL\Tests\Service
 *
 * @testdox The LabellingService (SOAP)
 */
class LabellingServiceSoapTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostNL $postnl */
    protected $postnl;
    /** @var LabellingService $service */
    protected $service;
    /** @var $lastRequest */
    protected $lastRequest;

    private static $base64LabelContent = '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YWN1dGUgMjI5IC9hcmluZyAyNDggL29zbGFzaCAyMjUgL2FhY3V0ZSAyMzcgL2lhY3V0ZSAyNTAgL3VhY3V0ZSAyNTMgL3lhY3V0ZSAyMTAgL09ncmF2ZSAyNDIgL29ncmF2ZSAyMDQgL0lncmF2ZSAyMzYgL2lncmF2ZSAxOTUgL0F0aWxkZSAyMTMgL090aWxkZSAyMjcgL2F0aWxkZSAyNDUgL290aWxkZSAyMjIgL1Rob3JuIDI1NCAvdGhvcm4gMjA5IC9OdGlsZGUgMjQxIC9udGlsZGUgMTM4IC9TY2Fyb24gMTU0IC9zY2Fyb24gMjQzIC9vYWN1dGUgMjExIC9PYWN1dGUgXQ0KPj4NCi9XaWR0aHMgWzI3OCAyNzggMzU1IDU1NiA1NTYgODg5IDY2NyAxOTEgMzMzIDMzMyAzODkgNTg0IDI3OCAzMzMgMjc4IDI3OCA1NTYgNTU2IDU1NiA1NTYgNTU2IDU1NiA1NTYgNTU2IDU1NiA1NTYgMjc4IDI3OCA1ODQgNTg0IDU4NCA1NTYgMTAxNSA2NjcgNjY3IDcyMiA3MjIgNjY3IDYxMSA3NzggNzIyIDI3OCA1MDAgNjY3IDU1NiA4MzMgNzIyIDc3OCA2NjcgNzc4IDcyMiA2NjcgNjExIDcyMiA2NjcgOTQ0IDY2NyA2NjcgNjExIDI3OCAyNzggMjc4IDQ2OSA1NTYgMzMzIDU1NiA1NTYgNTAwIDU1NiA1NTYgMjc4IDU1NiA1NTYgMjIyIDIyMiA1MDAgMjIyIDgzMyA1NTYgNTU2IDU1NiA1NTYgMzMzIDUwMCAyNzggNTU2IDUwMCA3MjIgNTAwIDUwMCA1MDAgMzM0IDI2MCAzMzQgNTg0IDAgNTU2IDAgMjIyIDU1NiAzMzMgMTAwMCA1NTYgNTU2IDMzMyAxMDAwIDY2NyAzMzMgMTAwMCAwIDYxMSAwIDAgMjIyIDIyMiAzMzMgMzMzIDM1MCA1NTYgMTAwMCAzMzMgMTAwMCA1MDAgMzMzIDk0NCAwIDUwMCA2NjcgMCA2NjcgNTU2IDU1NiA1NTYgNTU2IDY2NyA1NTYgMzMzIDczNyAzNzAgNTU2IDYxMSAwIDczNyA2MTEgNDAwIDU1NiAzMzMgMjIyIDMzMyA1NTYgNTAwIDMzMyAzMzMgMjc4IDM2NSA1NTYgNTAwIDgzNCA4MzQgNTAwIDY2NyA2NjcgNjY3IDY2NyA2NjcgNjY3IDEwMDAgNzIyIDY2NyA2NjcgNjY3IDY2NyAyNzggMjc4IDMzMyAzMzMgNzIyIDcyMiA3NzggNzc4IDc3OCA3NzggNzc4IDU4NCA3NzggNzIyIDcyMiA3MjIgNzIyIDY2NyA2NjcgNjExIDU1NiA1NTYgNTU2IDU1NiA1NTYgNTU2IDg4OSA1MDAgNTU2IDU1NiA1NTYgNTU2IDI3OCAyNzggMzMzIDMzMyA1NTYgNTU2IDU1NiA1NTYgNTU2IDU1NiA1NTYgNTg0IDYxMSA1NTYgNTU2IDU1NiA1NTYgNTAwIDU1NiA1MDAgXQ0KL05hbWUgL0YwDQo+Pg0KZW5kb2JqDQo3IDAgb2JqDQo8PA0KL0xlbmd0aCAxNDgNCi9GaWx0ZXIgWy9GbGF0ZURlY29kZSBdDQovVHlwZSAvWE9iamVjdA0KL1N1YnR5cGUgL0ltYWdlDQovQ29sb3JTcGFjZSBbL0luZGV4ZWQgL0RldmljZVJHQiAyMjMgPDAwMDAwMCAwMDAwMzMgMDAwMDY2IDAwMDA5OSAwMDAwY2MgMDAwMGZmIDAwMzMwMCAwMDMzMzMgMDAzMzY2IDAwMzM5OSAwMDMzY2MgMDAzM2ZmIDAwNjYwMCAwMDY2MzMgMDA2NjY2IDAwNjY5OSAwMDY2Y2MgMDA2NmZmIDAwOTkwMCAwMDk5MzMgMDA5OTY2IDAwOTk5OSAwMDk5Y2MgMDA5OWZmIDAwY2MwMCAwMGNjMzMgMDBjYzY2IDAwY2M5OSAwMGNjY2MgMDBjY2ZmIDAwZmYwMCAwMGZmMzMgMDBmZjY2IDAwZmY5OSAwMGZmY2MgMDBmZmZmIDMzMDAwMCAzMzAwMzMgMzMwMDY2IDMzMDA5OSAzMzAwY2MgMzMwMGZmIDMzMzMwMCAzMzMzMzMgMzMzMzY2IDMzMzM5OSAzMzMzY2MgMzMzM2ZmIDMzNjYwMCAzMzY2MzMgMzM2NjY2IDMzNjY5OSAzMzY2Y2MgMzM2NmZmIDMzOTkwMCAzMzk5MzMgMzM5OTY2IDMzOTk5OSAzMzk5Y2MgMzM5OWZmIDMzY2MwMCAzM2NjMzMgMzNjYzY2IDMzY2M5OSAzM2NjY2MgMzNjY2ZmIDMzZmYwMCAzM2ZmMzMgMzNmZjY2IDMzZmY5OSAzM2ZmY2MgMzNmZmZmIDY2MDAwMCA2NjAwMzMgNjYwMDY2IDY2MDA5OSA2NjAwY2MgNjYwMGZmIDY2MzMwMCA2NjMzMzMgNjYzMzY2IDY2MzM5OSA2NjMzY2MgNjYzM2ZmIDY2NjYwMCA2NjY2MzMgNjY2NjY2IDY2NjY5OSA2NjY2Y2MgNjY2NmZmIDY2OTkwMCA2Njk5MzMgNjY5OTY2IDY2OTk5OSA2Njk5Y2MgNjY5OWZmIDY2Y2MwMCA2NmNjMzMgNjZjYzY2IDY2Y2M5OSA2NmNjY2MgNjZjY2ZmIDY2ZmYwMCA2NmZmMzMgNjZmZjY2IDY2ZmY5OSA2NmZmY2MgNjZmZmZmIDk5MDAwMCA5OTAwMzMgOTkwMDY2IDk5MDA5OSA5OTAwY2MgOTkwMGZmIDk5MzMwMCA5OTMzMzMgOTkzMzY2IDk5MzM5OSA5OTMzY2MgOTkzM2ZmIDk5NjYwMCA5OTY2MzMgOTk2NjY2IDk5NjY5OSA5OTY2Y2MgOTk2NmZmIDk5OTkwMCA5OTk5MzMgOTk5OTY2IDk5OTk5OSA5OTk5Y2MgOTk5OWZmIDk5Y2MwMCA5OWNjMzMgOTljYzY2IDk5Y2M5OSA5OWNjY2MgOTljY2ZmIDk5ZmYwMCA5OWZmMzMgOTlmZjY2IDk5ZmY5OSA5OWZmY2MgOTlmZmZmIGNjMDAwMCBjYzAwMzMgY2MwMDY2IGNjMDA5OSBjYzAwY2MgY2MwMGZmIGNjMzMwMCBjYzMzMzMgY2MzMzY2IGNjMzM5OSBjYzMzY2MgY2MzM2ZmIGNjNjYwMCBjYzY2MzMgY2M2NjY2IGNjNjY5OSBjYzY2Y2MgY2M2NmZmIGNjOTkwMCBjYzk5MzMgY2M5OTY2IGNjOTk5OSBjYzk5Y2MgY2M5OWZmIGNjY2MwMCBjY2NjMzMgY2NjYzY2IGNjY2M5OSBjY2NjY2MgY2NjY2ZmIGNjZmYwMCBjY2ZmMzMgY2NmZjY2IGNjZmY5OSBjY2ZmY2MgY2NmZmZmIGZmMDAwMCBmZjAwMzMgZmYwMDY2IGZmMDA5OSBmZjAwY2MgZmYwMGZmIGZmMzMwMCBmZjMzMzMgZmYzMzY2IGZmMzM5OSBmZjMzY2MgZmYzM2ZmIGZmNjYwMCBmZjY2MzMgZmY2NjY2IGZmNjY5OSBmZjY2Y2MgZmY2NmZmIGZmOTkwMCBmZjk5MzMgZmY5OTY2IGZmOTk5OSBmZjk5Y2MgZmY5OWZmIGZmY2MwMCBmZmNjMzMgZmZjYzY2IGZmY2M5OSBmZmNjY2MgZmZjY2ZmIGZmZmYwMCBmZmZmMzMgZmZmZjY2IGZmZmY5OSBmZmZmY2MgZmZmZmZmIGMwYzBjMCA4MDgwODAgODAwMDAwIDAwODAwMCAwMDAwODAgODA4MDAwIDgwMDA4MCAwMDgwODAgPiBdDQovV2lkdGggMjIwOQ0KL0hlaWdodCAxDQovQml0c1BlckNvbXBvbmVudCA4DQovTmFtZSAvMA0KPj4NCnN0cmVhbQ0KeF7FVcENACEMcv8FXed+2kSCEPT0ZWoUSltsY3W0wPEMld28y4/V99p4cANXSYNU1hBloKIypErY1xQwUElxKaCOssxvEoYZQX2DqvoaqAww/bWcYHjUeVIh/CQpqQL7c18lfqUO0qFm5/YYFF3VIIDoto3bRuxDbFrtHoNo4IMqaK6mu2QiOf/KZL+y++oDD7hI3QplbmRzdHJlYW0NCmVuZG9iag0KOCAwIG9iag0KPDwNCi9UeXBlIC9Gb250DQovU3VidHlwZSAvVHlwZTENCi9GaXJzdENoYXIgMzINCi9MYXN0Q2hhciAyNTUNCi9CYXNlRm9udCAvSGVsdmV0aWNhLUJvbGQNCi9FbmNvZGluZyA8PA0KL1R5cGUgL0VuY29kaW5nDQovRGlmZmVyZW5jZXMgWzMyIC9zcGFjZSAxOTYgL0FkaWVyZXNpcyAyMTQgL09kaWVyZXNpcyAyMjAgL1VkaWVyZXNpcyAyMjggL2FkaWVyZXNpcyAyNDYgL29kaWVyZXNpcyAyNTIgL3VkaWVyZXNpcyAyMjMgL2dlcm1hbmRibHMgMTkyIC9BZ3JhdmUgMTk0IC9BY2lyY3VtZmxleCAxOTggL0FFIDE5OSAvQ2NlZGlsbGEgMjAwIC9FZ3JhdmUgMjAxIC9FYWN1dGUgMjAyIC9FY2lyY3VtZmxleCAyMDMgL0VkaWVyZXNpcyAyMDYgL0ljaXJjdW1mbGV4IDIwNyAvSWRpZXJlc2lzIDIxMiAvT2NpcmN1bWZsZXggMTQwIC9PRSAyMTcgL1VncmF2ZSAyMTkgL1VjaXJjdW1mbGV4IDE1OSAvWWRpZXJlc2lzIDIyNCAvYWdyYXZlIDIyNiAvYWNpcmN1bWZsZXggMjMwIC9hZSAyMzEgL2NjZWRpbGxhIDIzMiAvZWdyYXZlIDIzMyAvZWFjdXRlIDIzNCAvZWNpcmN1bWZsZXggMjM1IC9lZGllcmVzaXMgMjM4IC9pY2lyY3VtZmxleCAyMzkgL2lkaWVyZXNpcyAyNDQgL29jaXJjdW1mbGV4IDE1NiAvb2UgMjQ5IC91Z3JhdmUgMjUxIC91Y2lyY3VtZmxleCAyNTUgL3lkaWVyZXNpcyAxOTcgL0FyaW5nIDIxNiAvT3NsYXNoIDE5MyAvQWFjdXRlIDIwNSAvSWFjdXRlIDIxOCAvVWFjdXRlIDIyMSAvWWFjdXRlIDIyOSAvYXJpbmcgMjQ4IC9vc2xhc2ggMjI1IC9hYWN1dGUgMjM3IC9pYWN1dGUgMjUwIC91YWN1dGUgMjUzIC95YWN1dGUgMjEwIC9PZ3JhdmUgMjQyIC9vZ3JhdmUgMjA0IC9JZ3JhdmUgMjM2IC9pZ3JhdmUgMTk1IC9BdGlsZGUgMjEzIC9PdGlsZGUgMjI3IC9hdGlsZGUgMjQ1IC9vdGlsZGUgMjIyIC9UaG9ybiAyNTQgL3Rob3JuIDIwOSAvTnRpbGRlIDI0MSAvbnRpbGRlIDEzOCAvU2Nhcm9uIDE1NCAvc2Nhcm9uIDI0MyAvb2FjdXRlIDIxMSAvT2FjdXRlIF0NCj4+DQovV2lkdGhzIFsyNzggMzMzIDQ3NCA1NTYgNTU2IDg4OSA3MjIgMjM4IDMzMyAzMzMgMzg5IDU4NCAyNzggMzMzIDI3OCAyNzggNTU2IDU1NiA1NTYgNTU2IDU1NiA1NTYgNTU2IDU1NiA1NTYgNTU2IDMzMyAzMzMgNTg0IDU4NCA1ODQgNjExIDk3NSA3MjIgNzIyIDcyMiA3MjIgNjY3IDYxMSA3NzggNzIyIDI3OCA1NTYgNzIyIDYxMSA4MzMgNzIyIDc3OCA2NjcgNzc4IDcyMiA2NjcgNjExIDcyMiA2NjcgOTQ0IDY2NyA2NjcgNjExIDMzMyAyNzggMzMzIDU4NCA1NTYgMzMzIDU1NiA2MTEgNTU2IDYxMSA1NTYgMzMzIDYxMSA2MTEgMjc4IDI3OCA1NTYgMjc4IDg4OSA2MTEgNjExIDYxMSA2MTEgMzg5IDU1NiAzMzMgNjExIDU1NiA3NzggNTU2IDU1NiA1MDAgMzg5IDI4MCAzODkgNTg0IDAgNTU2IDAgMjc4IDU1NiA1MDAgMTAwMCA1NTYgNTU2IDMzMyAxMDAwIDY2NyAzMzMgMTAwMCAwIDYxMSAwIDAgMjc4IDI3OCA1MDAgNTAwIDM1MCA1NTYgMTAwMCAzMzMgMTAwMCA1NTYgMzMzIDk0NCAwIDUwMCA2NjcgMCA3MjIgNTU2IDYxMSA1NTYgNTU2IDY2NyA1NTYgMzMzIDczNyAzNzAgNTU2IDYxMSAwIDczNyA2MTEgNDAwIDU1NiAzMzMgMjc4IDMzMyA2MTEgNTU2IDI3OCAzMzMgMzMzIDM2NSA1NTYgNTAwIDgzNCA4MzQgNTAwIDcyMiA3MjIgNzIyIDcyMiA3MjIgNzIyIDEwMDAgNzIyIDY2NyA2NjcgNjY3IDY2NyAyNzggMjc4IDI3OCAyNzggNzIyIDcyMiA3NzggNzc4IDc3OCA3NzggNzc4IDU4NCA3NzggNzIyIDcyMiA3MjIgNzIyIDY2NyA2NjcgNjExIDU1NiA1NTYgNTU2IDU1NiA1NTYgNTU2IDg4OSA1NTYgNTU2IDU1NiA1NTYgNTU2IDI3OCAyNzggMjc4IDI3OCA2MTEgNjExIDYxMSA2MTEgNjExIDYxMSA2MTEgNTg0IDYxMSA2MTEgNjExIDYxMSA2MTEgNTU2IDYxMSA1NTYgXQ0KL05hbWUgL0YxDQo+Pg0KZW5kb2JqDQp4cmVmDQowIDkNCjAwMDAwMDAwMDAgNjU1MzUgZg0KMDAwMDAwMDAxMSAwMDAwMCBuDQowMDAwMDAwMTExIDAwMDAwIG4NCjAwMDAwMDAyOTggMDAwMDAgbg0KMDAwMDAwMDM2MyAwMDAwMCBuDQowMDAwMDAwNTczIDAwMDAwIG4NCjAwMDAwMDEwNjMgMDAwMDAgbg0KMDAwMDAwMjk5NiAwMDAwMCBuDQowMDAwMDA0OTI2IDAwMDAwIG4NCnRyYWlsZXINCjw8DQovU2l6ZSA5DQovUm9vdCAxIDAgUg0KL0luZm8gMiAwIFINCj4+DQpzdGFydHhyZWYNCjY4NjMNCiUlRU9GDQo=';

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
            true,
            PostNL::MODE_SOAP
        );

        $this->service = $this->postnl->getLabellingService();
        $this->service->cache = new VoidCachePool();
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
     * @testdox returns a valid service object
     */
    public function testHasValidLabellingService()
    {
        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Service\\LabellingService', $this->service);
    }

    /**
     * @testdox creates a valid label request
     *
     * @throws \ReflectionException
     */
    public function testCreatesAValidLabelRequest()
    {
        $message = new LabellingMessage();

        $this->lastRequest = $request = $this->service->buildGenerateLabelSOAPRequest(
            GenerateLabel::create()
                ->setShipments([
                    Shipment::create()
                        ->setAddresses([
                            Address::create([
                                'AddressType' => '01',
                                'City'        => 'Utrecht',
                                'Countrycode' => 'NL',
                                'FirstName'   => 'Peter',
                                'HouseNr'     => '9',
                                'HouseNrExt'  => 'a bis',
                                'Name'        => 'de Ruijter',
                                'Street'      => 'Bilderdijkstraat',
                                'Zipcode'     => '3521VA',
                            ]),
                            Address::create([
                                'AddressType' => '02',
                                'City'        => 'Hoofddorp',
                                'CompanyName' => 'PostNL',
                                'Countrycode' => 'NL',
                                'HouseNr'     => '42',
                                'Street'      => 'Siriusdreef',
                                'Zipcode'     => '2132WT',
                            ]),
                        ])
                        ->setBarcode('3S1234567890123')
                        ->setDeliveryAddress('01')
                        ->setDimension(new Dimension('2000'))
                        ->setProductCodeDelivery('3085')
                ])
                ->setMessage($message)
                ->setCustomer($this->postnl->getCustomer()),
            false
        );

        $this->assertEquals("<?xml version=\"1.0\"?>
<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:env=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:services=\"http://postnl.nl/cif/services/LabellingWebService/\" xmlns:domain=\"http://postnl.nl/cif/domain/LabellingWebService/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\" xmlns:schema=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:common=\"http://postnl.nl/cif/services/common/\">
 <soap:Header>
  <wsse:Security>
   <wsse:UsernameToken>
    <wsse:Password>test</wsse:Password>
   </wsse:UsernameToken>
  </wsse:Security>
 </soap:Header>
 <soap:Body>
  <services:GenerateLabel>
   <domain:Customer>
    <domain:Address>
     <domain:AddressType>02</domain:AddressType>
     <domain:City>Hoofddorp</domain:City>
     <domain:CompanyName>PostNL</domain:CompanyName>
     <domain:Countrycode>NL</domain:Countrycode>
     <domain:HouseNr>42</domain:HouseNr>
     <domain:Street>Siriusdreef</domain:Street>
     <domain:Zipcode>2132WT</domain:Zipcode>
    </domain:Address>
    <domain:CollectionLocation>123456</domain:CollectionLocation>
    <domain:ContactPerson>Test</domain:ContactPerson>
    <domain:CustomerCode>DEVC</domain:CustomerCode>
    <domain:CustomerNumber>11223344</domain:CustomerNumber>
   </domain:Customer>
   <domain:Message>
    <domain:MessageID>{$message->getMessageID()}</domain:MessageID>
    <domain:MessageTimeStamp>{$message->getMessageTimeStamp()}</domain:MessageTimeStamp>
    <domain:Printertype>GraphicFile|PDF</domain:Printertype>
   </domain:Message>
   <domain:Shipments>
    <domain:Shipment>
     <domain:Addresses>
      <domain:Address>
       <domain:AddressType>01</domain:AddressType>
       <domain:City>Utrecht</domain:City>
       <domain:Countrycode>NL</domain:Countrycode>
       <domain:FirstName>Peter</domain:FirstName>
       <domain:HouseNr>9</domain:HouseNr>
       <domain:HouseNrExt>a bis</domain:HouseNrExt>
       <domain:Name>de Ruijter</domain:Name>
       <domain:Street>Bilderdijkstraat</domain:Street>
       <domain:Zipcode>3521VA</domain:Zipcode>
      </domain:Address>
      <domain:Address>
       <domain:AddressType>02</domain:AddressType>
       <domain:City>Hoofddorp</domain:City>
       <domain:CompanyName>PostNL</domain:CompanyName>
       <domain:Countrycode>NL</domain:Countrycode>
       <domain:HouseNr>42</domain:HouseNr>
       <domain:Street>Siriusdreef</domain:Street>
       <domain:Zipcode>2132WT</domain:Zipcode>
      </domain:Address>
     </domain:Addresses>
     <domain:Barcode>3S1234567890123</domain:Barcode>
     <domain:DeliveryAddress>01</domain:DeliveryAddress>
     <domain:Dimension>
      <domain:Weight>2000</domain:Weight>
     </domain:Dimension>
     <domain:ProductCodeDelivery>3085</domain:ProductCodeDelivery>
    </domain:Shipment>
   </domain:Shipments>
  </services:GenerateLabel>
 </soap:Body>
</soap:Envelope>
",
            (string) $request->getBody());
        $this->assertEquals('', $request->getHeaderLine('apikey'));
        $this->assertEquals('text/xml;charset=UTF-8', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('text/xml', $request->getHeaderLine('Accept'));
    }

    /**
     * @testdox can generate a single label
     *
     * @throws \ReflectionException
     */
    public function testGenerateSingleLabelSoap()
    {
        $base64Content = static::$base64LabelContent;
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], "<s:Envelope xmlns:s=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <s:Body>
    <GenerateLabelResponse
xmlns=\"http://postnl.nl/cif/services/LabellingWebService/\"
xmlns:a=\"http://postnl.nl/cif/domain/LabellingWebService/\"
xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\">
      <a:MergedLabels i:nil=\"true\"/>
      <a:ResponseShipments>
        <a:ResponseShipment>
          <a:Barcode>3S1234567890123</a:Barcode>
          <a:DownPartnerBarcode i:nil=\"true\"/>
          <a:DownPartnerID i:nil=\"true\"/>
          <a:DownPartnerLocation i:nil=\"true\"/>
          <a:Labels>
            <a:Label>
              <a:Content>{$base64Content}</a:Content>
              <a:Contenttype i:nil=\"true\"/>
              <a:Labeltype>Label</a:Labeltype>
            </a:Label>
          </a:Labels>
          <a:ProductCodeDelivery>3085</a:ProductCodeDelivery>
          <a:Warnings i:nil=\"true\"/>
        </a:ResponseShipment>
      </a:ResponseShipments>
    </GenerateLabelResponse>
  </s:Body>
</s:Envelope>
"),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $label = $this->postnl->generateLabel(
            (new Shipment())
                ->setAddresses([
                    Address::create([
                        'AddressType' => '01',
                        'City'        => 'Utrecht',
                        'Countrycode' => 'NL',
                        'FirstName'   => 'Peter',
                        'HouseNr'     => '9',
                        'HouseNrExt'  => 'a bis',
                        'Name'        => 'de Ruijter',
                        'Street'      => 'Bilderdijkstraat',
                        'Zipcode'     => '3521VA',
                    ]),
                    Address::create([
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse', $label);
    }

    /**
     * @testdox can generate multiple labels
     *
     * @throws \Exception
     * @throws \ReflectionException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function testGenerateMultipleLabelsSoap()
    {
        $base64Content = static::$base64LabelContent;
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], "<s:Envelope xmlns:s=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <s:Body>
    <GenerateLabelResponse
xmlns=\"http://postnl.nl/cif/services/LabellingWebService/\"
xmlns:a=\"http://postnl.nl/cif/domain/LabellingWebService/\"
xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\">
      <a:MergedLabels i:nil=\"true\"/>
      <a:ResponseShipments>
        <a:ResponseShipment>
          <a:Barcode>3SDEVC201611210</a:Barcode>
          <a:DownPartnerBarcode i:nil=\"true\"/>
          <a:DownPartnerID i:nil=\"true\"/>
          <a:DownPartnerLocation i:nil=\"true\"/>
          <a:Labels>
            <a:Label>
              <a:Content>{$base64Content}</a:Content>
              <a:Contenttype i:nil=\"true\"/>
              <a:Labeltype>Label</a:Labeltype>
            </a:Label>
          </a:Labels>
          <a:ProductCodeDelivery>3085</a:ProductCodeDelivery>
          <a:Warnings i:nil=\"true\"/>
        </a:ResponseShipment>
      </a:ResponseShipments>
    </GenerateLabelResponse>
  </s:Body>
</s:Envelope>
"),new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], "<s:Envelope xmlns:s=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <s:Body>
    <GenerateLabelResponse
xmlns=\"http://postnl.nl/cif/services/LabellingWebService/\"
xmlns:a=\"http://postnl.nl/cif/domain/LabellingWebService/\"
xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\">
      <a:MergedLabels i:nil=\"true\"/>
      <a:ResponseShipments>
        <a:ResponseShipment>
          <a:Barcode>3SDEVC201611211</a:Barcode>
          <a:DownPartnerBarcode i:nil=\"true\"/>
          <a:DownPartnerID i:nil=\"true\"/>
          <a:DownPartnerLocation i:nil=\"true\"/>
          <a:Labels>
            <a:Label>
              <a:Content>{$base64Content}</a:Content>
              <a:Contenttype i:nil=\"true\"/>
              <a:Labeltype>Label</a:Labeltype>
            </a:Label>
          </a:Labels>
          <a:ProductCodeDelivery>3085</a:ProductCodeDelivery>
          <a:Warnings i:nil=\"true\"/>
        </a:ResponseShipment>
      </a:ResponseShipments>
    </GenerateLabelResponse>
  </s:Body>
</s:Envelope>
"),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $label = $this->postnl->generateLabels([
                (new Shipment())
                    ->setAddresses([
                        Address::create([
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'FirstName'   => 'Peter',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                        ]),
                        Address::create([
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode('3SDEVC201611210')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
                (new Shipment())
                    ->setAddresses([
                        Address::create([
                            'AddressType' => '01',
                            'City'        => 'Utrecht',
                            'Countrycode' => 'NL',
                            'FirstName'   => 'Peter',
                            'HouseNr'     => '9',
                            'HouseNrExt'  => 'a bis',
                            'Name'        => 'de Ruijter',
                            'Street'      => 'Bilderdijkstraat',
                            'Zipcode'     => '3521VA',
                        ]),
                        Address::create([
                            'AddressType' => '02',
                            'City'        => 'Hoofddorp',
                            'CompanyName' => 'PostNL',
                            'Countrycode' => 'NL',
                            'HouseNr'     => '42',
                            'Street'      => 'Siriusdreef',
                            'Zipcode'     => '2132WT',
                        ]),
                    ])
                    ->setBarcode('3SDEVC201611211')
                    ->setDeliveryAddress('01')
                    ->setDimension(new Dimension('2000'))
                    ->setProductCodeDelivery('3085'),
            ]
        );

        $this->assertInstanceOf('\\ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse', $label[1]);
    }

    /**
     * @testdox throws exception on invalid response
     * @throws \ReflectionException
     */
    public function testNegativeGenerateLabelInvalidResponseSoap()
    {
        $this->expectException('ThirtyBees\\PostNL\\Exception\\ResponseException');

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json;charset=UTF-8'], 'asdfojasuidfo'),
        ]);
        $handler = HandlerStack::create($mock);
        $mockClient = new MockClient();
        $mockClient->setHandler($handler);
        $this->postnl->setHttpClient($mockClient);

        $this->postnl->generateLabel(
            (new Shipment())
                ->setAddresses([
                    Address::create([
                        'AddressType' => '01',
                        'City'        => 'Utrecht',
                        'Countrycode' => 'NL',
                        'FirstName'   => 'Peter',
                        'HouseNr'     => '9',
                        'HouseNrExt'  => 'a bis',
                        'Name'        => 'de Ruijter',
                        'Street'      => 'Bilderdijkstraat',
                        'Zipcode'     => '3521VA',
                    ]),
                    Address::create([
                        'AddressType' => '02',
                        'City'        => 'Hoofddorp',
                        'CompanyName' => 'PostNL',
                        'Countrycode' => 'NL',
                        'HouseNr'     => '42',
                        'Street'      => 'Siriusdreef',
                        'Zipcode'     => '2132WT',
                    ]),
                ])
                ->setBarcode('3S1234567890123')
                ->setDeliveryAddress('01')
                ->setDimension(new Dimension('2000'))
                ->setProductCodeDelivery('3085')
        );
    }
}
