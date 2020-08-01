<?php
/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class BarcodeService.
 *
 * @method string           generateBarcode(GenerateBarcode $generateBarcode)
 * @method RequestInterface buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode)
 * @method string           processGenerateBarcodeResponse(mixed $response)
 * @method string[]         generateBarcodes(GenerateBarcode[] $generateBarcode)
 */
class BarcodeService extends AbstractService
{
    /** @var PostNL */
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
     * Namespaces uses for the SOAP version of this service.
     *
     * @var array
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
     * Generate a single barcode.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string|null Barcode
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function generateBarcodeREST(GenerateBarcode $generateBarcode)
    {
        /** @var Response $response */
        $response = $this->postnl
            ->getHttpClient()
            ->doRequest($this->buildGenerateBarcodeRequestREST($generateBarcode));

        $json = $this->processGenerateBarcodeResponseREST($response);

        return $json['Barcode'];
    }

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[]|ResponseException[]|ApiException[]|CifDownException[]|CifException[] Barcodes
     */
    public function generateBarcodesREST(array $generateBarcodes)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                $generateBarcode->getId(),
                $this->buildGenerateBarcodeRequestREST($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $json = $this->processGenerateBarcodeResponseREST($response);
                $barcode = $json['Barcode'];
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
     * Generate a single barcode.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string Barcode
     *
     * @throws ResponseException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     */
    public function generateBarcodeSOAP(GenerateBarcode $generateBarcode)
    {
        return $this->processGenerateBarcodeResponseSOAP(
            $this->postnl->getHttpClient()->doRequest($this->buildGenerateBarcodeRequestSOAP($generateBarcode))
        );
    }

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[] Barcodes
     */
    public function generateBarcodesSOAP(array $generateBarcodes)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($generateBarcodes as $generateBarcode) {
            $httpClient->addOrUpdateRequest(
                $generateBarcode->getId(),
                $this->buildGenerateBarcodeRequestSOAP($generateBarcode)
            );
        }

        $barcodes = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $barcode = $this->processGenerateBarcodeResponseSOAP($response);
            } catch (\Exception $e) {
                $barcode = new ResponseException($e->getMessage(), $e->getCode(), $e, $response);
            }

            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }

    /**
     * Build the `generateBarcode` HTTP request for the REST API.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     */
    public function buildGenerateBarcodeRequestREST(GenerateBarcode $generateBarcode)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateBarcode);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)
                .'?'.http_build_query([
                    'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                    'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                    'Type'           => $generateBarcode->getBarcode()->getType(),
                    'Serie'          => $generateBarcode->getBarcode()->getSerie(),
                ])
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $apiKey)
        ;
    }

    /**
     * Process GenerateBarcode REST response.
     *
     * @param mixed $response
     *
     * @return array
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function processGenerateBarcodeResponseREST($response)
    {
        static::validateRESTResponse($response);

        $json = json_decode(static::getResponseText($response), true);

        if (!isset($json['Barcode'])) {
            throw new ResponseException('Invalid API Response', null, null, $response);
        }

        return $json;
    }

    /**
     * Build the `generateBarcode` HTTP request for the SOAP API.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     */
    public function buildGenerateBarcodeRequestSOAP(GenerateBarcode $generateBarcode)
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
                '{'.static::ENVELOPE_NAMESPACE.'}Body' => [
                    '{'.static::SERVICES_NAMESPACE.'}GenerateBarcode' => $generateBarcode,
                ],
            ]
        );

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox()
                ? static::SANDBOX_ENDPOINT
                : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($request))
        ;
    }

    /**
     * Process GenerateBarcode SOAP response.
     *
     * @param mixed $response
     *
     * @return string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function processGenerateBarcodeResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        return (string) $xml->xpath('//services:GenerateBarcodeResponse/domain:Barcode')[0][0];
    }
}
