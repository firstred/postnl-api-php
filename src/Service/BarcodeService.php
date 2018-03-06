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
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;
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
     * @return string|null Barcode
     *
     * @throws ResponseException
     * @throws ApiException
     * @throws GuzzleException
     * @throws CifDownException
     * @throws CifException
     */
    public function generateBarcodeREST(GenerateBarcode $generateBarcode)
    {
        /** @var Response $response */
        $response = $this->postnl
            ->getHttpClient()
            ->doRequest($this->buildGenerateBarcodeRESTRequest($generateBarcode));

        static::validateRESTResponse($response);

        $json = json_decode((string) $response->getBody(), true);

        return $json['Barcode'];
    }

    /**
     * Generate multiple barcodes at once
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[]|ClientException[]|ResponseException[]|ApiException[]|CifDownException[]|CifException[] Barcodes
     */
    public function generateBarcodesREST(array $generateBarcodes)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                $generateBarcode->getId(),
                $this->buildGenerateBarcodeRESTRequest($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                static::validateRESTResponse($response);
                $json = json_decode(static::getResponseText($response), true);
                if (!isset($json['Barcode'])) {
                    throw new ResponseException('Unknown response', null, null, $response);
                }
                $barcode = $json['Barcode'];
            } catch (ClientException $e) {
                $barcode = $e;
            } catch (ResponseException $e) {
                $barcode = $e;
            } catch (ApiException $e) {
                $barcode = $e;
            } catch (CifDownException $e) {
                $barcode = $e;
            } catch (CifException $e) {
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
     * @throws ResponseException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     */
    public function generateBarcodeSOAP(GenerateBarcode $generateBarcode)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildGenerateBarcodeSOAPRequest($generateBarcode));
        $xml = simplexml_load_string(static::getResponseText($response));

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
     * @throws ResponseException
     */
    public function generateBarcodesSOAP(array $generateBarcodes)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                $generateBarcode->getId(),
                $this->buildGenerateBarcodeSOAPRequest($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $xml = simplexml_load_string(static::getResponseText($response));
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
     *
     * @return Request
     */
    public function buildGenerateBarcodeRESTRequest(GenerateBarcode $generateBarcode)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateBarcode);

        return new Request(
            'GET',
            ($this->postnl->getSandbox()
                ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
                : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT))
                .'?'.http_build_query([
                     'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                     'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                     'Type'           => $generateBarcode->getBarcode()->getType(),
                     'Serie'          => $generateBarcode->getBarcode()->getSerie(),
            ]),
            [
                'Accept'       => 'application/json',
                'apikey'       => $apiKey,
            ]
        );
    }

    /**
     * Build the `generateBarcode` HTTP request for the SOAP API
     *
     * @param GenerateBarcode $generateBarcode
     * @param int             $id              Override ID
     *
     * @return Request
     */
    public function buildGenerateBarcodeSOAPRequest(GenerateBarcode $generateBarcode, $id = null)
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

        return new Request(
            'POST',
            $this->postnl->getSandbox()
                ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
                : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT),
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }
}
