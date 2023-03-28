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
use Firstred\PostNL\Entity\Soap\Security;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\Service\AbstractService;
use Firstred\PostNL\Service\ResponseProcessor\AbstractResponseProcessor;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SimpleXMLElement;

/**
 * @deprecated 2.0.0
 * @internal
 */
abstract class AbstractSoapResponseProcessor extends AbstractResponseProcessor
{
    protected array $namespaces = [];

    /**
     * @param HiddenString            $apiKey
     * @param bool                    $sandbox
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface  $streamFactory
     */
    public function __construct(
        HiddenString            $apiKey,
        bool                    $sandbox,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface  $streamFactory,
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
        );

        $this->namespaces = array_merge($this->namespaces, [
            SoapNamespace::Security->value           => Security::SECURITY_NAMESPACE,
            SoapNamespace::Common->value             => AbstractService::COMMON_NAMESPACE,
            SoapNamespace::Envelope->value           => AbstractService::ENVELOPE_NAMESPACE,
            SoapNamespace::OldEnvelope->value        => AbstractService::OLD_ENVELOPE_NAMESPACE,
            SoapNamespace::XmlSchema->value          => AbstractService::XML_SCHEMA_NAMESPACE,
            SoapNamespace::ArraySerialization->value => AbstractService::ARRAY_SERIALIZATION_NAMESPACE,
        ]);
    }


    /**
     * Register namespaces.
     *
     * @param SimpleXMLElement $element
     *
     * @deprecated 2.0.0
     */
    protected function registerNamespaces(SimpleXMLElement $element): void
    {
        foreach ($this->namespaces as $namespacePrefix => $namespace) {
            $element->registerXPathNamespace(prefix: $namespacePrefix, namespace: $namespace);
        }
    }

    /**
     * Set the webservice on the object.
     *
     * This lets the object know for which service it should serialize
     *
     * @throws InvalidArgumentException
     * @deprecated 2.0.0
     */
    public function setService(AbstractEntity $object): void
    {
        $serializableProperties = $object->getSerializableProperties();
        foreach (array_keys(array: $serializableProperties) as $propertyName) {
            $item = $object->{'get'.$propertyName}();
            if ($item instanceof AbstractEntity) {
                $this->setService(object: $item);
            } elseif (is_array(value: $item)) {
                foreach ($item as $child) {
                    if ($child instanceof AbstractEntity) {
                        $this->setService(object: $child);
                    }
                }
            }
        }
    }

    /**
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @deprecated 2.0.0
     */
    protected function validateResponse(ResponseInterface $response): bool
    {
        try {
            $xml = new SimpleXMLElement(data: (string) $response->getBody());
            $this->registerNamespaces(element: $xml);
        } catch (\Throwable $e) {
            throw new ResponseException(
                message: "Invalid response from server",
                previous: $e,
                response: $response,
            );
        }

        $errorText = $xml->xpath(expression: '//env:Fault/env:Reason/env:Text');
        if (is_countable(value: $errorText) && count(value: $errorText) >= 1) {
            throw new CifDownException(message: (string) $xml->xpath(expression: '//env:Fault/env:Reason/env:Text')[0]);
        }

        // Detect errors
        $cifErrors = $xml->xpath(expression: '//common:CifException/common:Errors/common:ExceptionData');
        if (count(value: $cifErrors)) {
            $exceptionData = [];
            foreach ($cifErrors as $error) {
                static::registerNamespaces(element: $error);
                $exceptionData[] = [
                    'description' => (string) $error->xpath(expression: '//common:Description')[0],
                    'message'     => (string) $error->xpath(expression: '//common:ErrorMsg')[0],
                    'code'        => (int) $error->xpath(expression: '//common:ErrorNumber')[0],
                ];
            }
            throw new CifException(message: $exceptionData);
        }

        return true;
    }
}