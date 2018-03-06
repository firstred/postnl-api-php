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
use Psr\Cache\CacheItemInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Request\CompleteStatus;
use ThirtyBees\PostNL\Entity\Request\CurrentStatus;
use ThirtyBees\PostNL\Entity\Request\GetSignature;
use ThirtyBees\PostNL\Entity\Response\CompleteStatusResponse;
use ThirtyBees\PostNL\Entity\Response\CurrentStatusResponse;
use ThirtyBees\PostNL\Entity\Response\GetSignatureResponseSignature;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class ShippingStatusService
 *
 * @package ThirtyBees\PostNL\Service
 *
 * @method CurrentStatusResponse currentStatus(CurrentStatus $currentStatus)
 * @method CompleteStatusResponse completeStatus(CompleteStatus $completeStatus)
 * @method GetSignature getSignature(GetSignature $getSignature)
 */
class ShippingStatusService extends AbstractService
{
    // API Version
    const VERSION = '1.6';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_6/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_6/status';
    const LEGACY_SANDBOX_ENDPOINT = 'https://testservice.postnl.com/CIF_SB/ShippingStatusWebService/1_6/ShippingStatusWebService.svc';
    const LEGACY_LIVE_ENDPOINT = 'https://service.postnl.com/CIF/ShippingStatusWebService/1_6/ShippingStatusWebService.svc';

    // SOAP API
    const SOAP_ACTION = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CurrentStatus';
    const SOAP_ACTION_COMPLETE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CompleteStatus';
    const SOAP_ACTION_SIGNATURE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/GetSignature';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/ShippingStatusWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/ShippingStatusWebService/';

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
     * Gets the current status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param CurrentStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function currentStatusREST(CurrentStatus $currentStatus)
    {
        $item = $this->retrieveCachedItem($currentStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusRESTRequest($currentStatus));
            static::validateRESTResponse($response);
        }
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['Shipments'])) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            /** @var CurrentStatusResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CurrentStatusResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Gets the current status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param CurrentStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function currentStatusSOAP(CurrentStatus $currentStatus)
    {
        $item = $this->retrieveCachedItem($currentStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusSOAPRequest($currentStatus));
        }
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        if ($item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var CurrentStatusResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param CompleteStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function completeStatusREST(CompleteStatus $completeStatus)
    {
        $item = $this->retrieveCachedItem($completeStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCompleteStatusRESTRequest($completeStatus));
            static::validateRESTResponse($response);
        }
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['Shipments'])) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            /** @var CompleteStatusResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CompleteStatusResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
     *
     * @param CompleteStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function completeStatusSOAP(CompleteStatus $completeStatus)
    {
        $item = $this->retrieveCachedItem($completeStatus->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCompleteStatusSOAPRequest($completeStatus));
        }
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        if ($item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var CompleteStatusResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);;
        $this->setService($object);

        return $object;
    }

    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param GetSignature $getSignature
     *
     * @return GetSignatureResponseSignature
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getSignatureREST(GetSignature $getSignature)
    {
        $item = $this->retrieveCachedItem($getSignature->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureRESTRequest($getSignature));
            static::validateRESTResponse($response);
        }
        $body = json_decode(static::getResponseText($response), true);
        if (!empty($body['Barcode'])) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            /** @var GetSignatureResponseSignature $object */
            $object = AbstractEntity::jsonDeserialize(['GetSignatureResponseSignature' => $body]);
            $this->setService($object);

            return $object;
        }

        throw new ApiException('Unable to generate label');
    }

    /**
     * Gets the complete status
     *
     * This is a combi-function, supporting the following:
     * - CurrentStatus (by barcode):
     *   - Fill the Shipment->Barcode property. Leave the rest empty.
     * - CurrentStatusByReference:
     *   - Fill the Shipment->Reference property. Leave the rest empty.
     * - CurrentStatusByPhase:
     *   - Fill the Shipment->PhaseCode property, do not pass Barcode or Reference.
     *     Optionally add DateFrom and/or DateTo.
     * - CurrentStatusByStatus:
     *   - Fill the Shipment->StatuCode property. Leave the rest empty.
     *
     * @param GetSignature $getSignature
     *
     * @return GetSignatureResponseSignature
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \ThirtyBees\PostNL\Exception\ResponseException
     */
    public function getSignatureSOAP(GetSignature $getSignature)
    {
        $item = $this->retrieveCachedItem($getSignature->getId());
        $response = null;
        if ($item instanceof CacheItemInterface) {
            $response = $item->get();
            try {
                $response = \GuzzleHttp\Psr7\parse_response($response);
            } catch (\InvalidArgumentException $e) {
            }
        }
        if (!$response instanceof Response) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureSOAPRequest($getSignature));
        }
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        if ($item instanceof CacheItemInterface
            && $response instanceof Response
            && $response->getStatusCode() === 200
        ) {
            $item->set(\GuzzleHttp\Psr7\str($response));
            $this->cacheItem($item);
        }

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetSignatureResponseSignature $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the CurrentStatus request for the REST API
     *
     * This function auto-detects and adjusts the following requests:
     * - CurrentStatus
     * - CurrentStatusByReference
     * - CurrentStatusByPhase
     * - CurrentStatusByStatus
     *
     * @param CurrentStatus $currentStatus
     *
     * @return Request
     */
    public function buildCurrentStatusRESTRequest(CurrentStatus $currentStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($currentStatus);

        if ($currentStatus->getShipment()->getReference()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = "/reference/{$currentStatus->getShipment()->getReference()}";
        } elseif ($currentStatus->getShipment()->getStatusCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = "/search";
            $query['status'] = $currentStatus->getShipment()->getStatusCode();
            $query['startDate'] = $currentStatus->getShipment()->getDateFrom();
            $query['endDate'] = $currentStatus->getShipment()->getDateTo();
        } elseif ($currentStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = "/search";
            $query['phase'] = $currentStatus->getShipment()->getPhaseCode();
            $query['startDate'] = $currentStatus->getShipment()->getDateFrom();
            $query['endDate'] = $currentStatus->getShipment()->getDateTo();
          } else {
            $query = [];
            $endpoint = "/barcode/{$currentStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query($query);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Build the CurrentStatus request for the SOAP API
     *
     * @param CurrentStatus $currentStatus
     *
     * @return Request
     */
    public function buildCurrentStatusSOAPRequest(CurrentStatus $currentStatus)
    {
        if (!$currentStatus->getCustomer() || !$currentStatus->getCustomer() instanceof Customer) {
            $currentStatus->setCustomer((new Customer())
                ->setCustomerCode($this->postnl->getCustomer()->getCustomerCode())
                ->setCustomerNumber($this->postnl->getCustomer()->getCustomerNumber())
            );
        }

        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($currentStatus);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}CurrentStatus' => $currentStatus,
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
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * Build the CompleteStatus request for the REST API
     *
     * This function auto-detects and adjusts the following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     * - CompleteStatusByPhase
     * - CompleteStatusByStatus
     *
     * @param CompleteStatus $completeStatus
     *
     * @return Request
     */
    public function buildCompleteStatusRESTRequest(CompleteStatus $completeStatus)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($completeStatus);

        if ($completeStatus->getShipment()->getReference()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = "/reference/{$completeStatus->getShipment()->getReference()}";
        } elseif ($completeStatus->getShipment()->getStatusCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = "/search";
            $query['status'] = $completeStatus->getShipment()->getStatusCode();
            $query['startDate'] = $completeStatus->getShipment()->getDateFrom();
            $query['endDate'] = $completeStatus->getShipment()->getDateTo();
        } elseif ($completeStatus->getShipment()->getPhaseCode()) {
            $query['startDate'] = $completeStatus->getShipment()->getDateFrom();
            $query['endDate'] = $completeStatus->getShipment()->getDateTo();
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = "/search";
            $query['phase'] = $completeStatus->getShipment()->getPhaseCode();
            $query['startDate'] = $completeStatus->getShipment()->getDateFrom();
            $query['endDate'] = $completeStatus->getShipment()->getDateTo();
        } else {
            $query = [
                'detail' => 'true',
            ];
            $endpoint = "/barcode/{$completeStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.\GuzzleHttp\Psr7\build_query($query);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Build the CompleteStatus request for the SOAP API
     *
     * This function handles following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     * - CompleteStatusByPhase
     * - CompleteStatusByStatus
     *
     * @param CompleteStatus $completeStatus
     *
     * @return Request
     */
    public function buildCompleteStatusSOAPRequest(CompleteStatus $completeStatus)
    {
        if (!$completeStatus->getCustomer() || !$completeStatus->getCustomer() instanceof Customer) {
            $completeStatus->setCustomer((new Customer())
                ->setCustomerCode($this->postnl->getCustomer()->getCustomerCode())
                ->setCustomerNumber($this->postnl->getCustomer()->getCustomerNumber())
            );
        }

        $soapAction = static::SOAP_ACTION_COMPLETE;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($completeStatus);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}CompleteStatus' => $completeStatus,
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
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }

    /**
     * Build the GetSignature request for the REST API
     *
     * @param GetSignature $getSignature
     *
     * @return Request
     */
    public function buildGetSignatureRESTRequest(GetSignature $getSignature)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getSignature);

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}",
            [
                'apikey'       => $apiKey,
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        );
    }

    /**
     * Build the GetSignature request for the SOAP API
     *
     * @param GetSignature $getSignature
     *
     * @return Request
     */
    public function buildGetSignatureSOAPRequest(GetSignature $getSignature)
    {
        if (!$getSignature->getCustomer() || !$getSignature->getCustomer() instanceof Customer) {
            $getSignature->setCustomer((new Customer())
                ->setCustomerCode($this->postnl->getCustomer()->getCustomerCode())
                ->setCustomerNumber($this->postnl->getCustomer()->getCustomerNumber())
            );
        }

        $soapAction = static::SOAP_ACTION_SIGNATURE;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $security = new Security($this->postnl->getToken());

        $this->setService($security);
        $this->setService($getSignature);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetSignature' => $getSignature,
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
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
            ],
            $request
        );
    }
}
