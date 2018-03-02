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

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Request\Confirming;
use ThirtyBees\PostNL\Entity\Response\ConfirmingResponseShipment;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class ConfirmingService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method ConfirmingResponseShipment[] confirmShipments(Shipment[] $shipments)
 */
class ConfirmingService extends AbstractService
{
    // API Version
    const VERSION = '2.1';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_10/confirm';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_10/confirm';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/ConfirmingWebService/1_10/ConfirmingWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/ConfirmingWebService/1_9/ConfirmingWebService.svc';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/ConfirmingWebService/IConfirmingWebService/Confirming';
    const ENVELOPE_NAMESPACE = 'http://schemas.xmlsoap.org/soap/envelope/';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/ConfirmingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/ConfirmingWebService/';

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
     * Generate a single barcode via REST
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     * @throws ApiException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function confirmShipmentREST(Confirming $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequests($this->buildConfirmRESTRequest($confirming));
        static::validateRESTResponse($response);
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ConfirmingResponseShipments'])) {
            return AbstractEntity::jsonDeserialize($confirming['ConfirmingResponseShipments']);
        }

        throw new ApiException('Unable to confirm');
    }

    /**
     * Confirm multiple shipments
     *
     * @param Confirming[] $confirms ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     */
    public function confirmShipmentsREST(array $confirms)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($confirms as $confirm) {

            $httpClient->addOrUpdateRequest(
                $confirm->getId(),
                $this->buildConfirmRESTRequest($confirm)
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $confirmingResponse = json_decode($response['body'], true);
            try {
                static::validateRESTResponse($confirmingResponse);
                if (isset($confirmingResponse['ConfirmingResponseShipments'])) {
                    $confirming = AbstractEntity::jsonDeserialize($confirmingResponse['ConfirmingResponseShipments']);
                } else {
                    throw new ApiException('Unable to generate label');
                }
            } catch (\Exception $e) {
                $confirming = $e;
            }

            $confirmingResponses[$uuid] = $confirming;
        }

        return $confirmingResponses;
    }

    /**
     * Generate a single label via SOAP
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     * @throws \Exception
     */
    public function confirmShipmentSOAP(Confirming $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequests($this->buildConfirmSOAPRequest($confirming));
        $xml = simplexml_load_string(static::getResponseText($response));
        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value'][0]['value']);
        $array = $array[0];

        return AbstractEntity::xmlDeserialize($array);
    }

    /**
     * Generate multiple labels at once
     *
     * @param array $confirmings ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     */
    public function confirmShipmentsSOAP(array $confirmings)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($confirmings as $confirming) {
            $httpClient->addOrUpdateRequest(
                $confirming->getId(),
                $this->buildConfirmSOAPRequest($confirming)
            );
        }

        $responses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            $xml = simplexml_load_string($response['body']);
            if (!$xml instanceof \SimpleXMLElement) {
                $confirmingResponse = new ApiException('Invalid API response');
            } else {
                try {
                    static::registerNamespaces($xml);
                    static::validateSOAPResponse($xml);

                    $reader = new Reader();
                    $reader->xml($response['body']);
                    $array = array_values($reader->parse()['value'][0]['value'][0]['value']);
                    $array = $array[0];

                    $confirmingResponse = AbstractEntity::xmlDeserialize($array);
                } catch (\Exception $e) {
                    $confirmingResponse = $e;
                }
            }

            $responses[$uuid] = $confirmingResponse;
        }

        return $responses;
    }

    /**
     * @param Confirming $confirming
     *
     * @return Request
     */
    public function buildConfirmRESTRequest(Confirming $confirming)
    {
        $apiKey = $this->postnl->getRestApiKey();

        $this->setService($confirming);

        return new Request(
            'POST',
            $this->postnl->getSandbox()
                ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
                : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT),
            [
                "apikey: $apiKey",
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            json_encode($confirming)
        );
    }

    /**
     * @param Confirming $confirming
     *
     * @return Request
     */
    protected function buildConfirmSOAPRequest(Confirming $confirming)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($confirming);

        $body = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}Confirming' => $confirming,
                ],
            ]
        );

        $endpoint = $this->postnl->getSandbox()
            ? ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_SANDBOX_ENDPOINT : static::SANDBOX_ENDPOINT)
            : ($this->postnl->getMode() === PostNL::MODE_LEGACY ? static::LEGACY_LIVE_ENDPOINT : static::LIVE_ENDPOINT);

        return new Request(
            'POST',
            $endpoint,
            [
                ['SOAPAction' => "\"$soapAction\""],
                ['Content-Type'=> 'text/xml'],
                ['Accept' => 'text/xml'],
            ],
            $body
        );
    }
}
