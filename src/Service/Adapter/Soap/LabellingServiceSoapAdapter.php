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
use Firstred\PostNL\Entity\Request\GenerateLabel;
use Firstred\PostNL\Entity\Response\GenerateLabelResponse;
use Firstred\PostNL\Entity\SOAP\Security;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException as PostNLInvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\Adapter\LabellingServiceAdapterInterface;
use Firstred\PostNL\Util\Util;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service as XmlService;
use function in_array;
use function str_replace;

/**
 * @since 2.0.0
 * @internal
 */
class LabellingServiceSoapAdapter extends AbstractSoapAdapter implements LabellingServiceAdapterInterface
{
    const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v2_2/label';
    const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v2_2/label';

    const SOAP_ACTION = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabel';
    const SOAP_ACTION_NO_CONFIRM = 'http://postnl.nl/cif/services/LabellingWebService/ILabellingWebService/GenerateLabelWithoutConfirm';
    const SERVICES_NAMESPACE = 'http://postnl.nl/cif/services/LabellingWebService/';
    const DOMAIN_NAMESPACE = 'http://postnl.nl/cif/domain/LabellingWebService/';

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

    private static array $insuranceProductCodes = [3534, 3544, 3087, 3094];

    /**
     * Build the GenerateLabel request for the SOAP API.
     *
     * @param GenerateLabel $generateLabel
     * @param bool          $confirm
     *
     * @return RequestInterface
     *
     * @throws PostNLInvalidArgumentException
     * @since 2.0.0
     */
    public function buildGenerateLabelRequest(GenerateLabel $generateLabel, bool $confirm = true): RequestInterface
    {
        $soapAction = $confirm ? static::SOAP_ACTION : static::SOAP_ACTION_NO_CONFIRM;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespaceReference => $namespace) {
            $xmlService->namespaceMap[$namespace] = $namespaceReference;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [static::class, 'defaultDateFormat'];

        $security = new Security(UserNameToken: new UsernameToken(Password: $this->getApiKey()->getString()));

        $this->setService(object: $security);
        $this->setService(object: $generateLabel);

        $request = $xmlService->write(
            rootElementName: '{'.static::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.static::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.static::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.static::SERVICES_NAMESPACE.'}GenerateLabel' => $generateLabel,
                ],
            ]
        );

        $endpoint = Util::versionStringToURLString(
            version: $this->getVersion(),
            url: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
        );

        foreach ($generateLabel->getShipments() as $shipment) {
            if (in_array(needle: $shipment->getProductCodeDelivery(), haystack: self::$insuranceProductCodes)) {
                // Insurance behaves a bit strange w/ v2.2, falling back on v2.1
                $endpoint = str_replace(search: 'v2_2', replace: 'v2_1', subject: $endpoint);
            }
        }

        return $this->getRequestFactory()->createRequest(method: 'POST', uri: $endpoint)
            ->withHeader('SOAPAction', value: "\"$soapAction\"")
            ->withHeader('Accept', value: 'text/xml')
            ->withHeader('Content-Type', value: 'text/xml;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: $request));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return GenerateLabelResponse
     *
     * @throws HttpClientException
     * @throws PostNLInvalidArgumentException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @throws CifDownException
     * @throws CifException
     * @since 2.0.0
     */
    public function processGenerateLabelResponse(ResponseInterface $response): GenerateLabelResponse
    {
        $xml = @simplexml_load_string(data: static::getResponseText(response: $response));
        if (false === $xml) {
            if (200 === $response->getStatusCode()) {
                throw new ResponseException(message: 'Invalid API Response', response: $response);
            } else {
                throw new ResponseException(message: 'Invalid API Response');
            }
        }

        static::registerNamespaces(element: $xml);
        $this->validateResponseContent(xml: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        try {
            $array = array_values(array: $reader->parse()['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
        $array = $array[0];

        $object = GenerateLabelResponse::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return $object;
    }
}
