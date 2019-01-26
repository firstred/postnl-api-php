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
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\Request\CompleteStatus;
use Firstred\PostNL\Entity\Request\CompleteStatusByPhase;
use Firstred\PostNL\Entity\Request\CompleteStatusByReference;
use Firstred\PostNL\Entity\Request\CompleteStatusByStatus;
use Firstred\PostNL\Entity\Request\CurrentStatus;
use Firstred\PostNL\Entity\Request\CurrentStatusByPhase;
use Firstred\PostNL\Entity\Request\CurrentStatusByReference;
use Firstred\PostNL\Entity\Request\CurrentStatusByStatus;
use Firstred\PostNL\Entity\Request\GetSignature;
use Firstred\PostNL\Entity\Response\CompleteStatusResponse;
use Firstred\PostNL\Entity\Response\CurrentStatusResponse;
use Firstred\PostNL\Entity\Response\GetSignatureResponseSignature;
use Firstred\PostNL\Entity\Response\SignatureResponse;
use Firstred\PostNL\Exception\ApiException;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;

/**
 * Class ShippingStatusService
 *
 * @method CurrentStatusResponse
 *         currentStatus(CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus
 *         $currentStatus)
 * @method Request
 *         buildCurrentStatusRequest(CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus
 *         $currentStatus)
 * @method CurrentStatusResponse         processCurrentStatusResponse(mixed $response)
 * @method CompleteStatusResponse
 *         completeStatus(CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus
 *         $completeStatus)
 * @method Request buildCompleteStatusRequest(CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus)
 * @method CompleteStatusResponse        processCompleteStatusResponse(mixed $response)
 * @method SignatureResponse             getSignature(GetSignature $getSignature)
 * @method Request                       buildGetSignatureRequest(GetSignature $getSignature)
 * @method SignatureResponse             processGetSignatureResponse(mixed $response)
 */
class ShippingStatusService extends AbstractService
{
    // API Version
    const VERSION = '1.6';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_6/status';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_6/status';

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
     * Namespaces uses for the SOAP version of this service
     *
     * @var array $namespaces
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
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return CurrentStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function currentStatusREST($currentStatus): CurrentStatusResponse
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusRequestREST($currentStatus));
            static::validateRESTResponse($response);
        }

        $object = $this->processCurrentStatusResponseREST($response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }


        throw new ApiException('Unable to retrieve current status');
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
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return Request
     *
     * @since 1.0.0
     */
    public function buildCurrentStatusRequestREST($currentStatus): Request
    {
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
            $endpoint = "/search";
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

        return new Request(
            'GET',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process CurrentStatus Response REST
     *
     * @param mixed $response
     *
     * @return CurrentStatusResponse
     *
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processCurrentStatusResponseREST($response): CurrentStatusResponse
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
     *   - Fill the Shipment->StatusCode property. Leave the rest empty.
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
     * @throws \Sabre\Xml\LibXMLException
     *
     * @since 1.0.0
     */
    public function currentStatusSOAP($currentStatus): CurrentStatusResponse
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildCurrentStatusRequestSOAP($currentStatus));
        }

        $object = $this->processCurrentStatusResponseSOAP($response);
        if ($object instanceof CurrentStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve current status');
    }

    /**
     * Build the CurrentStatus request for the SOAP API
     *
     * @param CurrentStatus|CurrentStatusByReference|CurrentStatusByPhase|CurrentStatusByStatus $currentStatus
     *
     * @return Request
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function buildCurrentStatusRequestSOAP($currentStatus): Request
    {
        if (!$currentStatus->getCustomer() || !$currentStatus->getCustomer() instanceof Customer) {
            $currentStatus->setCustomer(
                (new Customer())
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

        $this->setService($currentStatus);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}'.$item => $currentStatus,
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
            $request
        );
    }

    /**
     * Process CurrentStatus Response SOAP
     *
     * @param mixed $response
     *
     * @return CurrentStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws \Sabre\Xml\LibXMLException
     * @throws \Firstred\PostNL\Exception\ResponseException
     *
     * @since 1.0.0
     */
    public function processCurrentStatusResponseSOAP($response): CurrentStatusResponse
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var CurrentStatusResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);

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
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function completeStatusREST(CompleteStatus $completeStatus): CompleteStatusResponse
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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildCompleteStatusRequestREST($completeStatus)
            );
            static::validateRESTResponse($response);
        }

        $object = $this->processCompleteStatusResponseREST($response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve complete status');
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
     *
     * @since 1.0.0
     */
    public function buildCompleteStatusRequestREST(CompleteStatus $completeStatus): Request
    {
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
            $endpoint = "/search";
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

        return new Request(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint,
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process CompleteStatus Response REST
     *
     * @param mixed $response
     *
     * @return null|CompleteStatusResponse
     *
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processCompleteStatusResponseREST($response): ?CompleteStatusResponse
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
     * @param CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus
     *
     * @return CompleteStatusResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function completeStatusSOAP($completeStatus): CompleteStatusResponse
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
            $response = $this->postnl->getHttpClient()->doRequest(
                $this->buildCompleteStatusRequestSOAP($completeStatus)
            );
        }

        $object = $this->processCompleteStatusResponseSOAP($response);
        if ($object instanceof CompleteStatusResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve complete status');
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
     * @param CompleteStatus|CompleteStatusByReference|CompleteStatusByPhase|CompleteStatusByStatus $completeStatus
     *
     * @return Request
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function buildCompleteStatusRequestSOAP($completeStatus): Request
    {
        if (!$completeStatus->getCustomer() || !$completeStatus->getCustomer() instanceof Customer) {
            $completeStatus->setCustomer(
                (new Customer())
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

        $this->setService($completeStatus);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}'.$item => $completeStatus,
                ],
            ]
        );

        return new Request(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : self::LIVE_ENDPOINT,
            [
                'SOAPAction'   => "\"$soapAction\"",
                'Accept'       => 'text/xml',
                'Content-Type' => 'text/xml;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ],
            $request
        );
    }

    /**
     * Process CompleteStatus Response SOAP
     *
     * @param mixed $response
     *
     * @return CompleteStatusResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     *
     * @since 1.0.0
     */
    public function processCompleteStatusResponseSOAP($response): CompleteStatusResponse
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var CompleteStatusResponse $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);
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
     * @return SignatureResponse
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function getSignatureREST(GetSignature $getSignature): SignatureResponse
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureRequestREST($getSignature));
            static::validateRESTResponse($response);
        }

        $object = $this->processGetSignatureResponseREST($response);
        if ($object instanceof SignatureResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to get signature');
    }

    /**
     * Build the GetSignature request for the REST API
     *
     * @param GetSignature $getSignature
     *
     * @return Request
     *
     * @since 1.0.0
     */
    public function buildGetSignatureRequestREST(GetSignature $getSignature): Request
    {
        $this->setService($getSignature);

        return new Request(
            'POST',
            ($this->postnl->getSandbox(
            ) ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)."/signature/{$getSignature->getShipment()->getBarcode()}",
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'apikey'       => $this->postnl->getApiKey(),
            ]
        );
    }

    /**
     * Process GetSignature Response REST
     *
     * @param mixed $response
     *
     * @return null|SignatureResponse
     *
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function processGetSignatureResponseREST($response): ?SignatureResponse
    {
        $body = json_decode(static::getResponseText($response), true);
        if (!empty($body['Signature'])) {
            /** @var SignatureResponse $object */
            $object = AbstractEntity::jsonDeserialize(['SignatureResponse' => $body]);
            $this->setService($object);

            return $object;
        }

        return null;
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
     * @param GetSignature $getSignature
     *
     * @return SignatureResponse
     *
     * @throws ApiException
     *
     * @since 1.0.0
     */
    public function getSignatureSOAP(GetSignature $getSignature): SignatureResponse
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
            $response = $this->postnl->getHttpClient()->doRequest($this->buildGetSignatureRequestSOAP($getSignature));
        }

        $object = $this->processGetSignatureResponse($response);
        if ($object instanceof SignatureResponse) {
            if ($item instanceof CacheItemInterface
                && $response instanceof Response
                && $response->getStatusCode() === 200
            ) {
                $item->set(\GuzzleHttp\Psr7\str($response));
                $this->cacheItem($item);
            }

            return $object;
        }

        throw new ApiException('Unable to retrieve signature');
    }

    /**
     * Build the GetSignature request for the SOAP API
     *
     * @param GetSignature $getSignature
     *
     * @return Request
     *
     * @since 1.0.0
     */
    public function buildGetSignatureRequestSOAP(GetSignature $getSignature): Request
    {
        if (!$getSignature->getCustomer() || !$getSignature->getCustomer() instanceof Customer) {
            $getSignature->setCustomer(
                (new Customer())
                    ->setCustomerCode($this->postnl->getCustomer()->getCustomerCode())
                    ->setCustomerNumber($this->postnl->getCustomer()->getCustomerNumber())
            );
        }

        $soapAction = static::SOAP_ACTION_SIGNATURE;
        $xmlService = new XmlService();
        foreach (static::$namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }

        $this->setService($getSignature);

        $request = $xmlService->write(
            '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            [
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetSignature' => $getSignature,
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
            $request
        );
    }

    /**
     * Process GetSignature Response SOAP
     *
     * @param mixed $response
     *
     * @return SignatureResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws \Sabre\Xml\LibXMLException
     *
     * @since 1.0.0
     */
    public function processGetSignatureResponseSOAP($response): SignatureResponse
    {
        $xml = simplexml_load_string(static::getResponseText($response));

        static::registerNamespaces($xml);
        static::validateSOAPResponse($xml);

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));

        /** @var GetSignatureResponseSignature $object */
        $object = AbstractEntity::xmlDeserialize((array) array_values($reader->parse()['value'][0]['value'])[0]);
        $this->setService($object);

        return $object;
    }
}
