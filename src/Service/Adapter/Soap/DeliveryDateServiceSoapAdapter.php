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
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GetDeliveryDate;
use Firstred\PostNL\Entity\Request\GetSentDateRequest;
use Firstred\PostNL\Entity\Response\GetDeliveryDateResponse;
use Firstred\PostNL\Entity\Response\GetSentDateResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Entity\SOAP\UsernameToken;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\DeliveryDateServiceAdapterInterface;
use Firstred\PostNL\Util\Util;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use SimpleXMLElement;

/**
 * @since 2.0.0
 * @internal
 */
class DeliveryDateServiceSoapAdapter extends AbstractSoapAdapter implements DeliveryDateServiceAdapterInterface
{
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/calculate/date';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/calculate/date';

    const SOAP_ACTION = 'http://postnl.nl/cif/services/DeliveryDateWebService/IDeliveryDateWebService/GetDeliveryDate';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/DeliveryDateWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/DeliveryDateWebService/';

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
     * Build the GetDeliveryDate request for the SOAP API.
     *
     * @param GetDeliveryDate $getDeliveryDate
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     * @since 2.0.0
     */
    public function buildGetDeliveryDateRequest(GetDeliveryDate $getDeliveryDate): RequestInterface
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

        $security = new Security(
            UserNameToken: new UsernameToken(Password: $this->getApiKey()),
        );

        $this->setService(object: $security);
        $this->setService(object: $getDeliveryDate);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetDeliveryDate' => $getDeliveryDate,
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
     * @param ResponseInterface $response
     *
     * @return GetDeliveryDateResponse
     *
     * @throws CifDownException
     * @throws CifException
     * @throws EntityNotFoundException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws ResponseException
     * @since 2.0.0
     */
    public function processGetDeliveryDateResponse(ResponseInterface $response): GetDeliveryDateResponse
    {
        try {
            $xml = new SimpleXMLElement(data: static::getResponseText(response: $response));
        } catch (HttpClientException|ResponseException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }

        $this->registerNamespaces(element: $xml);
        $this->validateResponseContent(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        try {
            $array = array_values(array: $reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
        $array = $array[0];

        /** @var GetDeliveryDateResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }

    /**
     * Build the GetSentDate request for the SOAP API.
     *
     * @throws InvalidArgumentException
     * @since 2.0.0
     */
    public function buildGetSentDateRequest(GetSentDateRequest $getSentDate): RequestInterface
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespace => $prefix) {
            $xmlService->namespaceMap[$namespace] = $prefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [__CLASS__, 'defaultDateFormat'];

        $security = new Security(
            UserNameToken: new UsernameToken(Password: $this->getApiKey()->getString()),
        );

        $this->setService(object: $security);
        $this->setService(object: $getSentDate);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GetSentDateRequest' => $getSentDate,
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
     * Process GetSentDate SOAP Response.
     *
     * @param ResponseInterface $response
     *
     * @return GetSentDateResponse
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws InvalidArgumentException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @since 2.0.0
     */
    public function processGetSentDateResponse(ResponseInterface $response): GetSentDateResponse
    {
        try {
            $xml = new SimpleXMLElement(data: static::getResponseText(response: $response));
        } catch (HttpClientException|ResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }

        $this->registerNamespaces(element: $xml);
        $this->validateResponseContent(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        try {
            $array = array_values(array: $reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
        $array = $array[0];

        /** @var GetSentDateResponse $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }
}
