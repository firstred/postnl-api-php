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

namespace Firstred\PostNL\Service\RequestBuilder\Soap;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Soap\Security;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\AbstractService;
use Firstred\PostNL\Service\RequestBuilder\AbstractRequestBuilder;
use ParagonIE\HiddenString\HiddenString;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SimpleXMLElement;

/**
 * @since 2.0.0
 * @internal
 */
abstract class AbstractSoapRequestBuilder extends AbstractRequestBuilder
{
    protected array $namespaces = [];

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
        string                  $version
    ) {
        parent::__construct(
            apiKey: $apiKey,
            sandbox: $sandbox,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            version: $version,
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
     * @since 2.0.0
     */
    protected function registerNamespaces(SimpleXMLElement $element): void
    {
        foreach ($this->namespaces as $prefix => $namespace) {
            $element->registerXPathNamespace(prefix: $prefix, namespace: $namespace);
        }
    }

    /**
     * Set the webservice on the object.
     *
     * This lets the object know for which service it should serialize
     *
     * @throws InvalidArgumentException
     * @since 2.0.0
     */
    public function setService(AbstractEntity $object): void
    {
        $object->setNamespaces(namespaces: $this->namespaces);

        $serializableProperties = $object->getSerializableProperties();
        foreach (array_keys(array: $serializableProperties) as $propertyName) {
            $item = $object->{'get'.$propertyName}();
            if ($item instanceof AbstractEntity) {
                static::setService(object: $item);
            } elseif (is_array(value: $item)) {
                foreach ($item as $child) {
                    if ($child instanceof AbstractEntity) {
                        static::setService(object: $child);
                    }
                }
            }
        }
    }
}