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

namespace Firstred\PostNL\Service\ResponseProcessor\Soap;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Response\ConfirmingResponseShipment;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\ConfirmingService;
use Firstred\PostNL\Service\ResponseProcessor\ConfirmingServiceResponseProcessorInterface;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sabre\Xml\LibXMLException;
use Sabre\Xml\Reader;
use SimpleXMLElement;

/**
 * @since 2.0.0
 * @internal
 */
class ConfirmingServiceSoapResponseProcessor extends AbstractSoapResponseProcessor implements ConfirmingServiceResponseProcessorInterface
{
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
            SoapNamespace::Domain->value   => ConfirmingService::DOMAIN_NAMESPACE,
            SoapNamespace::Services->value => ConfirmingService::SERVICES_NAMESPACE,
        ]);
    }

    /**
     * Process Confirm SOAP response.
     *
     * @param ResponseInterface $response
     *
     * @return ConfirmingResponseShipment[]
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws EntityNotFoundException
     * @throws InvalidArgumentException
     * @since 2.0.0
     */
    public function processConfirmResponse(ResponseInterface $response): array
    {
        $this->validateResponse(response: $response);
        $responseContent = static::getResponseText(response: $response);
        /** @noinspection PhpUnhandledExceptionInspection */
        $xml = new SimpleXMLElement(data: $responseContent);
        $this->registerNamespaces(element: $xml);

        $reader = new Reader();
        $reader->xml(source: static::getResponseText(response: $response));
        try {
            $array = array_values(array: $reader->parse()['value'][0]['value'][0]['value']);
        } catch (LibXMLException $e) {
            throw new ResponseException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
        $array = $array[0];

        /** @var ConfirmingResponseShipment $object */
        $object = AbstractEntity::xmlDeserialize(xml: $array);
        $this->setService(object: $object);

        return [$object];
    }
}
