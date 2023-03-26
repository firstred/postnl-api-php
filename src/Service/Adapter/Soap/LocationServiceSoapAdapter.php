<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service\Adapter\Soap;

use DateTimeImmutable;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GetLocation;
use Firstred\PostNL\Entity\Request\GetLocationsInArea;
use Firstred\PostNL\Entity\Request\GetNearestLocations;
use Firstred\PostNL\Entity\Response\GetLocationsInAreaResponse;
use Firstred\PostNL\Entity\Response\GetNearestLocationsResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\LocationServiceAdapterInterface;
use Firstred\PostNL\Util\Util;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;

/**
 * @since 2.0.0
 * @internal
 */
class LocationServiceSoapAdapter extends AbstractSoapAdapter implements LocationServiceAdapterInterface
{
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_1/locations';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_1/locations';

    const SOAP_ACTION = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations';
    const SOAP_ACTION_LOCATIONS_IN_AREA = 'http://postnl.nl/cif/services/LocationWebService/ILocationWebService/GetLocationsInArea';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LocationWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LocationWebService/';

    /**
     * @param HiddenString            $apiKey
     * @param bool                    $sandbox
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface  $streamFactory
     * @param string                  $version
     */
    public function __construct(
        HiddenString            $apiKey,
        bool                    $sandbox,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface  $streamFactory,
        string                  $version,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            version: $version,
        );

        $this->namespaces = array_merge($this->namespaces, [
            SoapNamespace::Services->value => self::SERVICES_NAMESPACE,
            SoapNamespace::Domain->value   => self::DOMAIN_NAMESPACE,
        ]);
    }

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @throws PostNLInvalidArgumentException
     * @since 2.0.0
     */
    public function buildGetNearestLocationsRequest(GetNearestLocations $getNearestLocations): RequestInterface
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespaceReference => $namespace) {
            $xmlService->namespaceMap[$namespace] = $namespaceReference;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [static::class, 'defaultDateFormat'];

        $security = new Security(UserNameToken: new UsernameToken(Password: $this->getApiKey()->getString()));

        $this->setService(object: $security);
        $this->setService(object: $getNearestLocations);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetNearestLocations' => $getNearestLocations,
                ],
            ]
        );

        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            ))
            ->withHeader('SOAPAction', value: "\"$soapAction\"")
            ->withHeader('Accept', value: 'text/xml')
            ->withHeader('Content-Type', value: 'text/xml;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: $request));
    }

    /**
     * Process GetNearestLocations Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetNearestLocationsResponse
     * @throws CifDownException
     * @throws CifException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws LibXMLException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetNearestLocationsResponse(mixed $response): GetNearestLocationsResponse
    {
        $xml = simplexml_load_string(data: static::getResponseText(response: $response));

        static::registerNamespaces(element: $xml);
        $this->validateResponseContent(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        $array = array_values(array: $reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (false !== strpos(haystack: $item['name'], needle: 'DeliveryOptions')) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (false !== strpos(haystack: $item['name'], needle: 'OpeningHours')) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }
        $array = $array[0];

        /** @var GetNearestLocationsResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }

    /**
     * Build the GetLocationsInArea request for the SOAP API.
     *
     * @throws PostNLInvalidArgumentException
     * @since 2.0.0
     */
    public function buildGetLocationsInAreaRequest(GetLocationsInArea $getLocations): RequestInterface
    {
        $soapAction = static::SOAP_ACTION_LOCATIONS_IN_AREA;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespaceReference => $namespace) {
            $xmlService->namespaceMap[$namespace] = $namespaceReference;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [static::class, 'defaultDateFormat'];

        $security = new Security(UserNameToken: new UsernameToken(Password: $this->getApiKey()->getString()));

        $this->setService(object: $security);
        $this->setService(object: $getLocations);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetLocationsInArea' => $getLocations,
                ],
            ]
        );

        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            ))
            ->withHeader('SOAPAction', value: "\"$soapAction\"")
            ->withHeader('Accept', value: 'text/xml')
            ->withHeader('Content-Type', value: 'text/xml;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: $request));
    }

    /**
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     * @throws CifDownException
     * @throws CifException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws LibXMLException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetLocationsInAreaResponse(mixed $response): GetLocationsInAreaResponse
    {
        $xml = simplexml_load_string(data: static::getResponseText(response: $response));

        static::registerNamespaces(element: $xml);
        $this->validateResponseContent(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        $array = array_values(array: $reader->parse()['value'][0]['value']);
        foreach ($array[0]['value'][0]['value'] as &$responseLocation) {
            foreach ($responseLocation['value'] as &$item) {
                if (str_contains(haystack: $item['name'], needle: 'DeliveryOptions')) {
                    $newDeliveryOptions = [];
                    foreach ($item['value'] as $option) {
                        $newDeliveryOptions[] = $option['value'];
                    }

                    $item['value'] = $newDeliveryOptions;
                } elseif (str_contains(haystack: $item['name'], needle: 'OpeningHours')) {
                    foreach ($item['value'] as &$openingHour) {
                        $openingHour['value'] = $openingHour['value'][0]['value'];
                    }
                }
            }
        }
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }

    /**
     * Build the GetLocation request for the SOAP API.
     *
     * @throws PostNLInvalidArgumentException
     * @since 2.0.0
     */
    public function buildGetLocationRequest(GetLocation $getLocations): RequestInterface
    {
        $soapAction = static::SOAP_ACTION_LOCATIONS_IN_AREA;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespaceReference => $namespace) {
            $xmlService->namespaceMap[$namespace] = $namespaceReference;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [static::class, 'defaultDateFormat'];

        $security = new Security(UserNameToken: new UsernameToken(Password: $this->getApiKey()->getString()));

        $this->setService(object: $security);
        $this->setService(object: $getLocations);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetLocation' => $getLocations,
                ],
            ]
        );

        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
            ))
            ->withHeader('SOAPAction', value: "\"$soapAction\"")
            ->withHeader('Accept', value: 'text/xml')
            ->withHeader('Content-Type', value: 'text/xml;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: $request));
    }

    /**
     * Process GetLocation Response SOAP.
     *
     * @param mixed $response
     *
     * @return GetLocationsInAreaResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws LibXMLException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @since 2.0.0
     */
    public function processGetLocationResponse(mixed $response): GetLocationsInAreaResponse
    {
        $xml = simplexml_load_string(data: static::getResponseText(response: $response));

        static::registerNamespaces(element: $xml);
        $this->validateResponseContent(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        $array = array_values(array: $reader->parse()['value'][0]['value']);
        $array = $array[0];

        /** @var GetLocationsInAreaResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }
}
