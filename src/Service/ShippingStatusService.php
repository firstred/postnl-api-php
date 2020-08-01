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

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Request\CompleteStatus;
use ThirtyBees\PostNL\Entity\Request\CompleteStatusByPhase;
use ThirtyBees\PostNL\Entity\Request\CompleteStatusByReference;
use ThirtyBees\PostNL\Entity\Request\CompleteStatusByStatus;
use ThirtyBees\PostNL\Entity\Request\CurrentStatus;
use ThirtyBees\PostNL\Entity\Request\CurrentStatusByPhase;
use ThirtyBees\PostNL\Entity\Request\CurrentStatusByReference;
use ThirtyBees\PostNL\Entity\Request\CurrentStatusByStatus;
use ThirtyBees\PostNL\Entity\Request\GetSignature;
use ThirtyBees\PostNL\Entity\Response\CompleteStatusResponse;
use ThirtyBees\PostNL\Entity\Response\CurrentStatusResponse;
use ThirtyBees\PostNL\Entity\Response\GetSignatureResponseSignature;
use ThirtyBees\PostNL\Entity\Response\SignatureResponse;
use ThirtyBees\PostNL\Entity\SOAP\Security;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\InvalidArgumentException;
use ThirtyBees\PostNL\Exception\ResponseException;

/**
 * Class ShippingStatusService.
 *
 * @method CurrentStatusResponse  currentStatus(CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus)
 * @method RequestInterface                buildCurrentStatusRequest(CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus)
 * @method CurrentStatusResponse  processCurrentStatusResponse(mixed $response)
 * @method CompleteStatusResponse completeStatus(CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus)
 * @method RequestInterface                buildCompleteStatusRequest(CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus)
 * @method CompleteStatusResponse processCompleteStatusResponse(mixed $response)
 * @method GetSignature           getSignature(GetSignature $getSignature)
 * @method RequestInterface                buildGetSignatureRequest(GetSignature $getSignature)
 * @method GetSignature           processGetSignatureResponse(mixed $response)
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
    const SOAP_ACTION_REFERENCE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CurrentStatusByReference';
    const SOAP_ACTION_PHASE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CurrentStatusByPhase';
    const SOAP_ACTION_STATUS = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CurrentStatusByStatus';
    const SOAP_ACTION_COMPLETE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CompleteStatus';
    const SOAP_ACTION_COMPLETE_REFERENCE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CompleteStatusByReference';
    const SOAP_ACTION_COMPLETE_PHASE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CompleteStatusByPhase';
    const SOAP_ACTION_COMPLETE_STATUS = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CompleteStatusByStatus';
    const SOAP_ACTION_SIGNATURE = 'http://postnl.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/GetSignature';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/ShippingStatusWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/ShippingStatusWebService/';

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
     * Gets the current status.
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
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     */
    public function currentStatusREST($currentStatus)
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
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusRequestREST($currentStatus));
            static::validateRESTResponse($response);
        }

        $object = $this->processCurrentStatusResponseREST($response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve current status');
    }

    /**
     * Gets the current status.
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
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws InvalidArgumentException
     * @throws ResponseException
     * @throws LibXMLException
     */
    public function currentStatusSOAP($currentStatus)
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
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusRequestSOAP($currentStatus));
        }

        $object = $this->processCurrentStatusResponseSOAP($response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve current status');
    }

    /**
     * Gets the complete status.
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
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
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
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCompleteStatusRequestREST($completeStatus));
            static::validateRESTResponse($response);
        }

        $object = $this->processCompleteStatusResponseREST($response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve complete status');
    }

    /**
     * Gets the complete status.
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
     * @param CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws LibXMLException
     * @throws InvalidArgumentException
     */
    public function completeStatusSOAP($completeStatus)
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
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCompleteStatusRequestSOAP($completeStatus));
        }

        $object = $this->processCompleteStatusResponseSOAP($response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve complete status');
    }

    /**
     * Gets the complete status.
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
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
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
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureRequestREST($getSignature));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetSignatureResponseREST($response);
        if ($object instanceof GetSignatureResponseSignature) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to get signature');
    }

    /**
     * Gets the complete status.
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
     * @return GetSignature
     *
     * @throws ApiException
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
        if (!$response instanceof ResponseInterface) {
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureRequestSOAP($getSignature));
        }

        $object = $this->processGetSignatureResponse($response);
        if ($object instanceof SignatureResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof ResponseInterface
                && 200 === $response->getStatusCode()
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve signature');
    }

    /**
     * Build the CurrentStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CurrentStatus
     * - CurrentStatusByReference
     * - CurrentStatusByPhase
     * - CurrentStatusByStatus
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return RequestInterface
     */
    public function buildCurrentStatusRequestREST($currentStatus)
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
            $endpoint = '/search';
            $query['status'] = $currentStatus->getShipment()->getStatusCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } elseif ($currentStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
            ];
            $endpoint = '/search';
            $query['phase'] = $currentStatus->getShipment()->getPhaseCode();
            if ($startDate = $currentStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $currentStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } else {
            $query = [];
            $endpoint = "/barcode/{$currentStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query($query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process CurrentStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CurrentStatusResponse
     *
     * @throws ResponseException
     */
    public function processCurrentStatusResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['CurrentStatus'])) {
            /** @var CurrentStatusResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CurrentStatusResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the CurrentStatus request for the SOAP API.
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public function buildCurrentStatusRequestSOAP($currentStatus)
    {
        if (!$currentStatus->getCustomer() || !$currentStatus->getCustomer() instanceof Customer) {
            $currentStatus->setCustomer((new Customer())
                ->setCustomerCode($this->postnl->getCustomer()->getCustomerCode())
                ->setCustomerNumber($this->postnl->getCustomer()->getCustomerNumber())
            );
        }

        if ($currentStatus instanceof CurrentStatus) {
            $soapAction = static::SOAP_ACTION;
            $item = 'CurrentStatus';
        } elseif ($currentStatus instanceof CurrentStatusByReference) {
            $soapAction = static::SOAP_ACTION_REFERENCE;
            $item = 'CurrentStatusByReference';
        } elseif ($currentStatus instanceof CurrentStatusByPhase) {
            $soapAction = static::SOAP_ACTION_PHASE;
            $item = 'CurrentStatusByPhase';
        } elseif ($currentStatus instanceof CurrentStatusByStatus) {
            $soapAction = static::SOAP_ACTION_STATUS;
            $item = 'CurrentStatusByStatus';
        } else {
            throw new InvalidArgumentException('Invalid CurrentStatus service');
        }

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
                    '{'.static::SERVICES_NAMESPACE.'}'.$item => $currentStatus,
                ],
            ]
        );

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($request));
    }

    /**
     * Process CurrentStatus Response SOAP.
     *
     * @param mixed $response
     *
     * @return CurrentStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws LibXMLException
     * @throws ResponseException
     */
    public function processCurrentStatusResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

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
     * Build the CompleteStatus request for the REST API.
     *
     * This function auto-detects and adjusts the following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     * - CompleteStatusByPhase
     * - CompleteStatusByStatus
     *
     * @param CompleteStatus $completeStatus
     *
     * @return RequestInterface
     */
    public function buildCompleteStatusRequestREST(CompleteStatus $completeStatus)
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
            $endpoint = '/search';
            $query['status'] = $completeStatus->getShipment()->getStatusCode();
            if ($startDate = $completeStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } elseif ($completeStatus->getShipment()->getPhaseCode()) {
            $query = [
                'customerCode'   => $this->postnl->getCustomer()->getCustomerCode(),
                'customerNumber' => $this->postnl->getCustomer()->getCustomerNumber(),
                'detail'         => 'true',
            ];
            $endpoint = '/search';
            $query['phase'] = $completeStatus->getShipment()->getPhaseCode();
            if ($startDate = $completeStatus->getShipment()->getDateFrom()) {
                $query['startDate'] = date('d-m-Y', strtotime($startDate));
            }
            if ($endDate = $completeStatus->getShipment()->getDateTo()) {
                $query['endDate'] = date('d-m-Y', strtotime($endDate));
            }
        } else {
            $query = [
                'detail' => 'true',
            ];
            $endpoint = "/barcode/{$completeStatus->getShipment()->getBarcode()}";
        }
        $endpoint .= '?'.http_build_query($query);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8');
    }

    /**
     * Process CompleteStatus Response REST.
     *
     * @param mixed $response
     *
     * @return CompleteStatusResponse|null
     *
     * @throws ResponseException
     */
    public function processCompleteStatusResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response), true);
        if (isset($body['CompleteStatus'])) {
            if (isset($body['CompleteStatus']['Shipment']['MainBarcode'])) {
                $body['CompleteStatus']['Shipments'] = [$body['CompleteStatus']['Shipment']];
            } else {
                $body['CompleteStatus']['Shipments'] = $body['CompleteStatus']['Shipment'];
            }

            unset($body['CompleteStatus']['Shipment']);

            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Customer'] = AbstractEntity::jsonDeserialize(['Customer' => $shipment['Customer']]);
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Addresses'] = $shipment['Address'];
                unset($shipment['Address']);
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['Events'] = $shipment['Event'];
                unset($shipment['Event']);
                foreach ($shipment['Events'] as &$event) {
                    $event = AbstractEntity::jsonDeserialize(['CompleteStatusResponseEvent' => $event]);
                    //$event = ['CompleteStatusResponseEvent' => $event];
                }
            }
            foreach ($body['CompleteStatus']['Shipments'] as &$shipment) {
                $shipment['OldStatuses'] = $shipment['OldStatus'];
                unset($shipment['OldStatus']);
                foreach ($shipment['OldStatuses'] as &$oldStatus) {
                    $oldStatus = AbstractEntity::jsonDeserialize(['CompleteStatusResponseOldStatus' => $oldStatus]);
                }
            }

            /** @var CompleteStatusResponse $object */
            $object = AbstractEntity::jsonDeserialize(['CompleteStatusResponse' => $body['CompleteStatus']]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the CompleteStatus request for the SOAP API.
     *
     * This function handles following requests:
     * - CompleteStatus
     * - CompleteStatusByReference
     * - CompleteStatusByPhase
     * - CompleteStatusByStatus
     *
     * @param CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public function buildCompleteStatusRequestSOAP($completeStatus)
    {
        if (!$completeStatus->getCustomer() || !$completeStatus->getCustomer() instanceof Customer) {
            $completeStatus->setCustomer((new Customer())
                ->setCustomerCode($this->postnl->getCustomer()->getCustomerCode())
                ->setCustomerNumber($this->postnl->getCustomer()->getCustomerNumber())
            );
        }

        if ($completeStatus instanceof CompleteStatus) {
            $soapAction = static::SOAP_ACTION_COMPLETE;
            $item = 'CompleteStatus';
        } elseif ($completeStatus instanceof CompleteStatusByReference) {
            $soapAction = static::SOAP_ACTION_COMPLETE_REFERENCE;
            $item = 'CompleteStatusByReference';
        } elseif ($completeStatus instanceof CompleteStatusByPhase) {
            $soapAction = static::SOAP_ACTION_COMPLETE_PHASE;
            $item = 'CompleteStatusByPhase';
        } elseif ($completeStatus instanceof CompleteStatusByStatus) {
            $soapAction = static::SOAP_ACTION_COMPLETE_STATUS;
            $item = 'CompleteStatusByStatus';
        } else {
            throw new InvalidArgumentException('Invalid CompleteStatus service');
        }

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
                    '{'.static::SERVICES_NAMESPACE.'}'.$item => $completeStatus,
                ],
            ]
        );

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($request));
    }

    /**
     * Process CompleteStatus Response SOAP.
     *
     * @param mixed $response
     *
     * @return CompleteStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws LibXMLException
     */
    public function processCompleteStatusResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var CompleteStatusResponse $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }

    /**
     * Build the GetSignature request for the REST API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     */
    public function buildGetSignatureRequestREST(GetSignature $getSignature)
    {
        $apiKey = $this->postnl->getRestApiKey();
        $this->setService($getSignature);

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}"
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json');
    }

    /**
     * Process GetSignature Response REST.
     *
     * @param mixed $response
     *
     * @return GetSignatureResponseSignature|null
     *
     * @throws ResponseException
     */
    public function processGetSignatureResponseREST($response)
    {
        $body = json_decode(static::getResponseText($response), true);
        if (!empty($body['Signature'])) {
            /** @var GetSignatureResponseSignature $object */
            $object = AbstractEntity::jsonDeserialize(['GetSignatureResponseSignature' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
    }

    /**
     * Build the GetSignature request for the SOAP API.
     *
     * @param GetSignature $getSignature
     *
     * @return RequestInterface
     */
    public function buildGetSignatureRequestSOAP(GetSignature $getSignature)
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

        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox()
                ? static::SANDBOX_ENDPOINT
                : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($request));
    }

    /**
     * Process GetSignature Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetSignatureResponseSignature
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws LibXMLException
     */
    public function processGetSignatureResponseSOAP($response)
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        $array = array_values($reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetSignatureResponseSignature $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
