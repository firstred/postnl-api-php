<?php
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

declare(strict_types=1);

namespace Firstred\PostNL\Service\RequestBuilder\Soap;

use DateTimeImmutable;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GenerateBarcode;
use Firstred\PostNL\Entity\Soap\Security;
use Firstred\PostNL\Entity\Soap\UsernameToken;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Service\RequestBuilder\BarcodeServiceRequestBuilderInterface;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\Service as XmlService;

/**
 * @deprecated 2.0.0
 *
 * @internal
 */
class BarcodeServiceSoapRequestBuilder extends AbstractSoapRequestBuilder implements BarcodeServiceRequestBuilderInterface
{
    // Endpoints
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode';
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/v1_1/barcode';

    // SOAP API specific
    private const SOAP_ACTION = 'http://postnl.nl/cif/services/BarcodeWebService/IBarcodeWebService/GenerateBarcode';

    /**
     * @param HiddenString            $apiKey
     * @param bool                    $sandbox
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface  $streamFactory
     */
    public function __construct(
        HiddenString $apiKey,
        bool $sandbox,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
        );

        $this->namespaces = array_merge($this->namespaces, [
            SoapNamespace::Domain->value   => BarcodeService::DOMAIN_NAMESPACE,
            SoapNamespace::Services->value => BarcodeService::SERVICES_NAMESPACE,
        ]);
    }

    /**
     * Build the `generateBarcode` HTTP request for the SOAP API.
     *
     * @param GenerateBarcode $generateBarcode
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     *
     * @deprecated 2.0.0
     */
    public function buildGenerateBarcodeRequest(GenerateBarcode $generateBarcode): RequestInterface
    {
        $soapAction = static::SOAP_ACTION;
        $xmlService = new XmlService();
        foreach ($this->namespaces as $namespacePrefix => $namespace) {
            $xmlService->namespaceMap[$namespace] = $namespacePrefix;
        }
        $xmlService->classMap[DateTimeImmutable::class] = [static::class, 'defaultDateFormat'];

        $security = new Security(
            UserNameToken: new UsernameToken(Username: null, Password: $this->getApiKey()->getString()),
        );

        $this->setService(entity: $security);
        $this->setService(entity: $generateBarcode);

        $request = $xmlService->write(
            rootElementName: '{'.BarcodeService::ENVELOPE_NAMESPACE.'}Envelope',
            value: [
                '{'.BarcodeService::ENVELOPE_NAMESPACE.'}Header' => [
                    ['{'.Security::SECURITY_NAMESPACE.'}Security' => $security],
                ],
                '{'.BarcodeService::ENVELOPE_NAMESPACE.'}Body'   => [
                    '{'.BarcodeService::SERVICES_NAMESPACE.'}GenerateBarcode' => $generateBarcode,
                ],
            ],
        );

        return $this->getRequestFactory()->createRequest(
            method: 'POST',
            uri: $this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT,
        )
            ->withHeader('SOAPAction', value: "\"$soapAction\"")
            ->withHeader('Accept', value: 'text/xml')
            ->withHeader('Content-Type', value: 'text/xml;charset=UTF-8')
            ->withBody(body: $this->getStreamFactory()->createStream(content: $request));
    }

    /**
     * @param AbstractEntity $entity
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *
     * @deprecated 2.0.0
     */
    protected function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(
            currentService: BarcodeServiceInterface::class,
            namespaces: $this->namespaces,
        );

        parent::setService(entity: $entity);
    }
}
