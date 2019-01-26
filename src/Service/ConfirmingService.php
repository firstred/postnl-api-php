<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Request;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;

/**
 * Class ConfirmingService
 *
 * @method ConfirmingResponseShipment   confirmShipment(Confirming $shipment)
 * @method Request                      buildConfirmShipmentRequest(Confirming $shipment)
 * @method ConfirmingResponseShipment   processConfirmShipmentResponse(mixed $response)
 * @method ConfirmingResponseShipment[] confirmShipments(Confirming[] $shipments)
 */
class ConfirmingService extends AbstractService
{
    // API Version
    const VERSION = '2.0';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_10/confirm';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_10/confirm';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/ConfirmingWebService/IConfirmingWebService/Confirming';
    const ENVELOPE_NAMESPACE = 'http://schemas.xmlsoap.org/soap/envelope/';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/ConfirmingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/ConfirmingWebService/';

    /**
     * Namespaces uses for the SOAP version of this service
     *
     * @var array $namespaces
     *
     * @since 1.0.0
     */
    public static $namespaces = [
        self::ENVELOPE_NAMESPACE     => 'soap',
        self::OLD_ENVELOPE_NAMESPACE => 'env',
        self::SERVICES_NAMESPACE     => 'services',
        self::DOMAIN_NAMESPACE       => 'domain',
        self::XML_SCHEMA_NAMESPACE   => 'schema',
        self::COMMON_NAMESPACE       => 'common',
    ];

    /**
     * Generate a single barcode via REST
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipmentREST(Confirming $confirming): ConfirmingResponseShipment
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildConfirmRequestREST($confirming));
        $object = $this->processConfirmResponseREST($response);

        if ($object instanceof ConfirmingResponseShipment) {
            return $object;
        }

        if ($response->getStatusCode() === 200) {
            throw new ResponseException('Invalid API Response', 0, null, $response);
        }

        throw new ApiException('Unable to confirm');
    }

    /**
     * @param Confirming $confirming
     *
     * @return Request
     *
     * @since 1.0.0
     */
    public function buildConfirmRequestREST(Confirming $confirming)
    {
        $this->setService($confirming);

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ],
            json_encode($confirming)
        );
    }

    /**
     * Process Confirm REST Response
     *
     * @param mixed $response
     *
     * @return null|ConfirmingResponseShipment
     *
     * @throws ApiException
     * @throws ResponseException
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseREST($response)
    {
        static::validateRESTResponse($response);
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['ConfirmingResponseShipments'])) {
            /** @var ConfirmingResponseShipment $object */
            $object = AbstractEntity::jsonDeserialize($body['ConfirmingResponseShipments']);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Confirm multiple shipments
     *
     * @param Confirming[] $confirms ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @since 1.0.0
     */
    public function confirmShipmentsREST(array $confirms): array
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($confirms as $confirm) {
            $httpClient->addOrUpdateRequest(
                (string) $confirm->getId(),
                $this->buildConfirmRequestREST($confirm)
            );
        }

        $confirmingResponses = [];
        foreach ($httpClient->doRequests() as $uuid => $response) {
            try {
                $confirming = $this->processConfirmResponseREST($response);
                if (!$confirming instanceof ConfirmingResponseShipment) {
                    throw new ResponseException('Invalid API Response', 0, null, $response);
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
     *
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipmentSOAP(Confirming $confirming): ConfirmingResponseShipment
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildConfirmRequestSOAP($confirming));
        $object = $this->processConfirmResponseSOAP($response);

        return $object;
    }

    /**
     * @param Confirming $confirming
     *
     * @return Request
     *
     * @since 1.0.0
     */
    public function buildConfirmRequestSOAP(Confirming $confirming)
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }

        $this->setService($confirming);

        $body = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body' => [
                    '{'.static::SERVICES_NAMESPACE.'}Confirming' => $confirming,
                ],
            ]
        );

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ],
            $body
        );
    }

    /**
     * Process Confirm SOAP response
     *
     * @param mixed $response
     *
     * @return ConfirmingResponseShipment
     *
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\CifDownException
     * @throws \Firstred\PostNL\Exception\CifException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));
        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var ConfirmingResponseShipment $object */
        $object = AbstractEntity::xmlDeserialize(
            (array) array_values($reader->parse()['value'][0]['value'][0]['value'])[0]
        );
        $this->setService($object);

        return $object;
    }

    /**
     * Generate multiple labels at once
     *
     * @param array $confirmings ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @since 1.0.0
     */
    public function confirmShipmentsSOAP(array $confirmings)
    {
        $httpClient = $this->postnl->getHttpClient();

        foreach ($confirmings as $confirming) {
            $httpClient->addOrUpdateRequest(
                (string) $confirming->getId(),
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
}
