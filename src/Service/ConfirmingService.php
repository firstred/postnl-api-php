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
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\Confirming;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotFoundException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ResponseException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use SimpleXMLElement;

/**
 * Class ConfirmingService.
 *
 * @method ConfirmingResponseShipment   confirmShipment(Confirming $shipment)
 * @method ConfirmingResponseShipment[] confirmShipments(Confirming[] $shipments)
 * @method RequestInterface             buildConfirmShipmentRequest(Confirming $shipment)
 * @method ConfirmingResponseShipment   processConfirmShipmentResponse(mixed $response)
 *
 * @since 1.0.0
 */
class ConfirmingService extends AbstractService implements ConfirmingServiceInterface
{
    // API Version
    const VERSION = '2.0';

    // Endpoints
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2/confirm';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2/confirm';

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
     * Confirm a single shipment via REST.
     *
     * @param Confirming $confirming
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws NotFoundException
     *
     * @since 1.0.0
     */
    public function confirmShipmentREST(Confirming $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildConfirmRequestREST($confirming));
        $objects = $this->processConfirmResponseREST($response);

        if (!empty($objects) && $objects[0] instanceof ConfirmingResponseShipment) {
            return $objects[0];
        }

        if (200 === $response->getStatusCode()) {
            throw new ResponseException('Invalid API Response', null, null, $response);
        }

        throw new NotFoundException('Unable to confirm');
    }

    /**
     * Confirm multiple shipments.
     *
     * @param Confirming[] $confirms ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws NotSupportedException
     * @throws ResponseException
     *
     * @since 1.0.0
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
            $confirmingResponse = null;
            $objects = $this->processConfirmResponseREST($response);
            foreach ($objects as $object) {
                if (!$object instanceof ConfirmingResponseShipment) {
                    throw new ResponseException('Invalid API Response', null, null, $response);
                }

                $confirmingResponse = $object;
            }

            $confirmingResponses[$uuid] = $confirmingResponse;
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
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public function confirmShipmentSOAP(Confirming $confirming)
    {
        $response = $this->postnl->getHttpClient()->doRequest($this->buildConfirmRequestSOAP($confirming));
        return $this->processConfirmResponseSOAP($response);
    }

    /**
     * Generate multiple labels at once.
     *
     * @param array $confirmings ['uuid' => Confirming, ...]
     *
     * @return ConfirmingResponseShipment[]
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
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
            $confirmingResponse = $this->processConfirmResponseSOAP($response);
            $responses[$uuid] = $confirmingResponse;
        }

        return $responses;
    }

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
     *
     * @since 1.0.0
     */
    public function buildConfirmRequestREST(Confirming $confirming)
    {
        $apiKey = $this->postnl->getRestApiKey();

        $this->setService($confirming);

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            ($this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT)
        )
            ->withHeader('apikey', $apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream(json_encode($confirming)))
        ;
    }

    /**
     * Proces Confirm REST Response.
     *
     * @param mixed $response
     *
     * @return ConfirmingResponseShipment[]|null
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseREST($response)
    {
        static::validateRESTResponse($response);
        $body = json_decode(static::getResponseText($response));
        if (isset($body->ResponseShipments)) {
            if (!is_array($body->ResponseShipments)) {
                $body->ResponseShipments = [$body->ResponseShipments];
            }

            $objects = [];
            foreach ($body->ResponseShipments as $responseShipment) {
                $object = ConfirmingResponseShipment::jsonDeserialize((object) ['ConfirmingResponseShipment' => $responseShipment]);
                $this->setService($object);
                $objects[] = $object;
            }


            return $objects;
        }

        return null;
    }

    /**
     * @param Confirming $confirming
     *
     * @return RequestInterface
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
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

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

        return $this->postnl->getRequestFactory()->createRequest(
            'POST',
            $this->postnl->getSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT
        )
            ->withHeader('SOAPAction', "\"$soapAction\"")
            ->withHeader('Accept', 'text/xml')
            ->withHeader('Content-Type', 'text/xml;charset=UTF-8')
            ->withBody($this->postnl->getStreamFactory()->createStream($body))
        ;
    }

    /**
     * Process Confirm SOAP response.
     *
     * @param ResponseInterface $response
     *
     * @return ConfirmingResponseShipment
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
     */
    public function processConfirmResponseSOAP(ResponseInterface $response)
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

        $reader = new Reader();
        $reader->xml(static::getResponseText($response));
        try {
            $array = array_values($reader->parse()['value'][0]['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException($e->getMessage(), $e->getCode(), $e);
        }
        $array = $array[0];

        /** @var ConfirmingResponseShipment $object */
        $object = AbstractEntity::xmlDeserialize($array);
        $this->setService($object);

        return $object;
    }
}
