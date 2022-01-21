<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2022 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2022 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use DateTimeImmutable;
use Exception;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\PostNL;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\Service as XmlService;
use SimpleXMLElement;
use stdClass;
use const PHP_QUERY_RFC3986;

/**
 * Class BarcodeService.
 *
 * @method string           generateBarcode(GenerateBarcode $generateBarcode)
 * @method RequestInterface buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode)
 * @method string           processGenerateBarcodeResponse(mixed $response)
 * @method string[]         generateBarcodes(GenerateBarcode[] $generateBarcode)
 *
 * @since 1.0.0
 */
class BarcodeService extends AbstractService implements BarcodeServiceInterface
{
    /** @var PostNL */
    protected $postnl;

    const VERSION = '1.1';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode';
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_1/barcode';

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
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     */
    public function generateBarcodeREST(GenerateBarcode $generateBarcode)
    {
        $response = $this->postnl
            ->getHttpClient()
            ->doRequest($this->buildGenerateBarcodeRequestREST($generateBarcode));

        $json = $this->processGenerateBarcodeResponseREST($response);

        return $json->Barcode;
    }

    /**
     * Generate a single barcode.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return string Barcode
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
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
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     *
     * @since 1.0.0
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
            $json = $this->processGenerateBarcodeResponseREST($response);
            $barcode = $json->Barcode;
            $barcodes[$uuid] = $barcode;
        }

        return $barcodes;
    }

    /**
     * Generate multiple barcodes at once.
     *
     * @param GenerateBarcode[] $generateBarcodes
     *
     * @return string[] Barcodes
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws \Firstred\PostNL\Exception\InvalidArgumentException
     *
     * @since 1.0.0
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
            $barcode = $this->processGenerateBarcodeResponseSOAP($response);
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
     *
     * @since 1.0.0
     */
    public function buildGenerateBarcodeRequestREST(GenerateBarcode $generateBarcode)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($generateBarcode);

        return $this->postnl->getRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)
                .'?'.http_build_query([
                    'CustomerCode'   => $generateBarcode->getCustomer()->getCustomerCode(),
                    'CustomerNumber' => $generateBarcode->getCustomer()->getCustomerNumber(),
                    'Type'           => $generateBarcode->getBarcode()->getType(),
                    'Serie'          => $generateBarcode->getBarcode()->getSerie(),
                ], '', '&', PHP_QUERY_RFC3986)
        )
            ->withHeader('Accept', 'application/json')
            ->withHeader('apikey', $apiKey)
        ;
    }

    /**
     * Build the `generateBarcode` HTTP request for the SOAP API.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildGenerateBarcodeRequestSOAP(GenerateBarcode $generateBarcode)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

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

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox()
                ? static::SANDBOX_ENDPOINT
                : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream($request))
            ;
    }

    /**
     * Process GenerateBarcode REST response.
     *
     * @param ResponseInterface $response
     *
     * @return stdClass
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     */
    public function processGenerateBarcodeResponseREST(ResponseInterface $response)
    {
        static::validateRESTResponse($response);

        $json = json_decode(static::getResponseText($response));

        if (!isset($json->Barcode)) {
            throw new ResponseException('Invalid API Response', null, null, $response);
        }

        return $json;
    }

    /**
     * Process GenerateBarcode SOAP response.
     *
     * @param ResponseInterface $response
     *
     * @return string
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGenerateBarcodeResponseSOAP(ResponseInterface $response)
    {
        try {
            $xml = new SimpleXMLElement(static::getResponseText($response));
        } catch (HttpClientException $e) {
            throw $e;
        } catch (ResponseException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ResponseException($e->getMessage(), $e->getCode(), $e);
        }

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        return (string) $xml->xpath('//services:GenerateBarcodeResponse/domain:Barcode')[0][0];
    }
}
