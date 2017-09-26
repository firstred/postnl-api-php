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

namespace ThirtyBees\PostNL\Service;

use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class BarcodeService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method string generateBarcode(GenerateBarcode $generateBarcode)
 * @method array generateBarcodes(GenerateBarcode[] $generateBarcode)
 */
class BarcodeService extends AbstractService
{
    /** @var PostNL $postnl */
    protected $postnl;

    const VERSION = '1.1';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_1/barcode';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/BarcodeWebService/1_1/BarcodeWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/BarcodeWebService/1_1/BarcodeWebService.svc';

    const SOAP_ACTION = 'http://postnl.nl/cif/services/BarcodeWebService/IBarcodeWebService/GenerateBarcode';
    const ENVELOPE_NAMESPACE = 'http://schemas.xmlsoap.org/soap/envelope/';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/BarcodeWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/BarcodeWebService/';

    /**
     * Namespaces uses for the SOAP version of this service
     *
     * @var array $namespaces
     */
    public static $namespaces = [
        self::ENVELOPE_NAMESPACE     => 'soap',
        self::OLD_ENVELOPE_NAMESPACE => 'env',
        self::SERVICES_NAMESPACE     => 'services',
        self::DOMAIN_NAMESPACE       => 'domain',
        Security::SECURITY_NAMESPACE => 'wsse',
        self::XML_SCHEMA_NAMESPACE   => 'schema',
        self::COMMON_NAMESPACE       => 'common',
    ];

    /**
     * Generate a single barcode
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string Barcode
     */
    public function generateBarcodeREST(GenerateBarcode $generateBarcode)
    {
        $result = call_user_func_array(
            [$this->postnl->getHttpClient(), 'request'],
            array_slice($this->buildGenerateBarcodeRESTRequest($generateBarcode), 1)
        );

        $response = json_decode($result[0], true);
        static::validateRESTResponse($response);

        return $response['Barcode'];
    }

    /**
     * Generate multiple barcodes at once
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return array Barcodes
     */
    public function generateBarcodesREST(array $generateBarcodes)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            call_user_func_array(
                [$httpClient, 'addRequest'],
                $this->buildGenerateBarcodeRESTRequest($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $json = json_decode($response['body'], true);
            try {
                static::validateRESTResponse($json);
                $barcode = $json['Barcode'];
            } catch (\Exception $e) {
                $barcode = $e;
            }

            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }

    /**
     * Generate a single barcode
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string Barcode
     */
    public function generateBarcodeSOAP(GenerateBarcode $generateBarcode)
    {
        $result = call_user_func_array(
            [$this->postnl->getHttpClient(), 'request'],
            array_slice($this->buildGenerateBarcodeSOAPRequest($generateBarcode), 1)
        );

        $xml = simplexml_load_string($result[0]);
        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        return (string) $xml->xpath('//services:GenerateBarcodeResponse/domain:Barcode')[0][0];
    }

    /**
     * Generate multiple barcodes at once
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return array Barcodes
     */
    public function generateBarcodesSOAP(array $generateBarcodes)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            call_user_func_array(
                [$httpClient, 'addRequest'],
                $this->buildGenerateBarcodeSOAPRequest($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $xml = simplexml_load_string($response['body']);
            if (!$xml instanceof \SimpleXMLElement) {
                $barcode = new ApiException('Invalid API response');
            } else {
                try {
                    static::registerNamespaces($xml);
                    static::validateSOAPResponse($xml);
                    $barcode = (string) $xml->xpath('//services:GenerateBarcodeResponse/domain:Barcode')[0][0];
                } catch (\Exception $e) {
                    $barcode = $e;
                }
            }

            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }

    /**
     * Build the `generateBarcode` HTTP request for the REST API
     *
     * @param GenerateBarcode $generateBarcode
     * @param int             $id              Override the request ID
     *
     * @return array
     */
    protected function buildGenerateBarcodeRESTRequest(GenerateBarcode $generateBarcode, $id = null)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateBarcode);

        return [
            $id ?: $generateBarcode->getId(),
            'GET',
            $this->postnl->getSandbox()
                ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
                : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT),
            [
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json',
                "apikey: $apiKey",
            ],
            [
                'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                'Type'           => $generateBarcode->getBarcode()->getType(),
                'Serie'          => $generateBarcode->getBarcode()->getSerie(),
            ],
        ];
    }

    /**
     * Build the `generateBarcode` HTTP request for the SOAP API
     *
     * @param GenerateBarcode $generateBarcode
     * @param int             $id              Override ID
     *
     * @return array
     */
    protected function buildGenerateBarcodeSOAPRequest(GenerateBarcode $generateBarcode, $id = null)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }

        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($generateBarcode);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GenerateBarcode' => $generateBarcode,
                ],
            ]
        );

        return [
            $id ?: $generateBarcode->getId(),
            'POST',
            $this->postnl->getSandbox()
                ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
                : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT),
            [
                "SOAPAction: \"$soapAction\"",
                'Content-Type: text/xml',
                'Accept: text/xml',
            ],
            [],
            $request,
        ];
    }
}
