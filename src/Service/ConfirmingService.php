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
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Request\Confirming;
use ThirtyBees\PostNL\Entity\Response\ConfirmingResponseShipment;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class ConfirmingService.
 *
 * @method ConfirmingResponseShipment   confirmShipment(Confirming $shipment)
 * @method Request                      buildConfirmShipmentRequest(Confirming $shipment)
 * @method ConfirmingResponseShipment   processConfirmShipmentResponse(mixed $response)
 * @method ConfirmingResponseShipment[] confirmShipments(Confirming[] $shipments)
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
     * Generate a single barcode via REST.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function confirmShipmentREST(Confirming $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildConfirmRequestREST($confirming));
        $object = $this->processConfirmResponseREST($response);

        if ($object instanceof ConfirmingResponseShipment) {
            return $object;
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException('Invalid API Response', null, null, $response);
        }

        throw new ApiException('Unable to confirm');
    }

    /**
     * Confirm multiple shipments.
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
                $this->buildConfirmRequestREST($confirm)
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $confirming = $this->processConfirmResponseREST($response);
                if (!$confirming instanceof ConfirmingResponseShipment) {
                    throw new ResponseException('Invalid API Response', null, null, $response);
                }
            } catch (\Exception $e) {
                $confirming = $e;
            }

            $confirmingResponses[$uuid] = $confirming;
        }

        return $confirmingResponses;
    }

    /**
     * Generate a single label via SOAP.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     * @throws ResponseException
     */
    public function confirmShipmentSOAP(Confirming $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildConfirmRequestSOAP($confirming));
        $object = $this->processConfirmResponseSOAP($response);

        return $object;
    }

    /**
     * Generate multiple labels at once.
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
                $this->buildConfirmRequestSOAP($confirming)
            );
        }

        $responses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $confirmingResponse = $this->processConfirmResponseSOAP($response);
            } catch (\Exception $e) {
                $confirmingResponse = $e;
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
    public function buildConfirmRequestREST(Confirming $confirming)
    {
        $apiKey = $this->postnl->getRestApiKey();

        $this->setService($confirming);

        return new Request(
            'POST',
            $this->postnl->getSandbox()
                ? static::SANDBOX_ENDPOINT
                : static::LIVE_ENDPOINT,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ],
            json_encode($confirming)
        );
    }

    /**
     * Proces Confirm REST Response.
     *
     * @param mixed $response
     *
     * @return ConfirmingResponseShipment|null
     *
     * @throws ApiException
     * @throws ResponseException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     */
    public function processConfirmResponseREST($response)
    {
        static::validateRESTResponse($response);
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ConfirmingResponseShipments'])) {
            /** @var ConfirmingResponseShipment $object */
            $object = AbstractEntity::jsonDeserialize(['ConfirmingResponseShipment' => $body['ConfirmingResponseShipments']['ConfirmingResponseShipment']]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * @param Confirming $confirming
     *
     * @return Request
     */
    public function buildConfirmRequestSOAP(Confirming $confirming)
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
                '{'.static::ENVELOPE_NAMESPACE.'}Body' => [
                    '{'.static::SERVICES_NAMESPACE.'}Confirming' => $confirming,
                ],
            ]
        );

        $endpoint = $this->postnl->getSandbox()
            ? static::SANDBOX_ENDPOINT
            : static::LIVE_ENDPOINT;

        return new Request(
            'POST',
            $endpoint,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $body
        );
    }

    /**
     * Process Confirm SOAP response.
     *
     * @param mixed $response
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\CifDownException
     * @throws \ThirtyBees\PostNL\Exception\CifException
     */
    public function processConfirmResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));
        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value'][0]['value']);
        $array = $array[0];

        /** @var ConfirmingResponseShipment $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
