<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Misc;

use Firstred\PostNL\Attribute\PropInterface;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\ServiceInterface;
use JetBrains\PhpStorm\ExpectedValues;
use JsonSerializable;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use function in_array;

/**
 * Class SerializableObject.
 */
abstract class SerializableObject implements JsonSerializable
{
    /**
     * @param string $service
     * @param string $propType
     *
     * @throws InvalidArgumentException
     */
    public function __construct(protected string $service, protected string $propType)
    {
        if ($this->propType
            && !in_array(needle: $this->propType, haystack: [ResponseProp::class, RequestProp::class])
        ) {
            throw new InvalidArgumentException(message: 'Invalid prop type given');
        }
    }

    /**
     * Returns a serializable array to use with `json_encode` or `http_build_query`.
     *
     * @throws InvalidArgumentException
     */
    public function jsonSerialize(): array
    {
        $json = [];

        foreach ($this->getSerializableProps(asStrings: true) as $serializableProp) {
            /** @psalm-var string $serializableProp */
            $val = $this->{"get$serializableProp"}();
            if (null === $val) {
                continue;
            }
            if ($val instanceof SerializableObject) {
                $val = $val->jsonSerialize();
            }
            $json[$serializableProp] = $val;
        }

        return $json;
    }

    /**
     * @param array  $json
     * @param string $service
     * @param string $propType
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function jsonDeserialize(array $json, string $service, string $propType): static
    {
        $json['service'] = $service;
        $json['propType'] = $propType;

        /** @psalm-suppress UnsafeInstantiation */
        return new static(...$json);
    }

    #[ExpectedValues(values: ServiceInterface::SERVICES)]
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setService(
        #[ExpectedValues(values: ServiceInterface::SERVICES)]
        string $service,
    ): static {
        foreach ($this->getSerializableProps(asStrings: true) as $serializableProp) {
            $object = $this->{"get$serializableProp"}();
            if ($object instanceof SerializableObject) {
                $object->setService(service: $service);
            }
        }

        return $this;
    }

    #[ExpectedValues(values: PropInterface::PROP_TYPES)]
    /**
     * @return string
     */
    public function getPropType(): string
    {
        return $this->service;
    }

    /**
     * @param string $propType
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setPropType(
        #[ExpectedValues(values: PropInterface::PROP_TYPES)]
        string $propType,
    ): static {
        foreach ($this->getSerializableProps(asStrings: true) as $serializableProp) {
            $object = $this->{"get$serializableProp"}();
            if ($object instanceof SerializableObject) {
                $object->setPropType(propType: $propType);
            }
        }

        return $this;
    }

    /**
     * @param bool $asStrings
     * @param bool $required
     *
     * @return array
     * @psalm-return list<ReflectionProperty>|list<string>
     *
     * @throws InvalidArgumentException
     */
    public function getSerializableProps(bool $asStrings = false, bool $required = false): array
    {
        if ($this->propType && !in_array(needle: $this->propType, haystack: [RequestProp::class, ResponseProp::class])) {
            throw new InvalidArgumentException(message: 'Invalid prop type given');
        }
        if ($this->service && !is_a(object_or_class: $this->service, class: ServiceInterface::class, allow_string: true)) {
            throw new InvalidArgumentException(message: 'Invalid service given');
        }

        $reflectionClass = new ReflectionClass(objectOrClass: $this);
        $properties = [];
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $requestPropReflectionAttribute = $reflectionProperty->getAttributes(name: RequestProp::class)[0]   ?? null;
            $responsePropReflectionAttribute = $reflectionProperty->getAttributes(name: ResponseProp::class)[0] ?? null;
            if (!$requestPropReflectionAttribute instanceof ReflectionAttribute
                && !$responsePropReflectionAttribute instanceof ReflectionAttribute
            ) {
                continue;
            }
            if ($this->propType) {
                if (RequestProp::class === $this->propType && !$requestPropReflectionAttribute instanceof ReflectionAttribute) {
                    continue;
                } elseif (ResponseProp::class === $this->propType && !$responsePropReflectionAttribute instanceof ReflectionAttribute) {
                    continue;
                }
            }

            if ($this->service) {
                $services = [];
                if (!$this->propType || RequestProp::class === $this->propType) {
                    if ($requestPropReflectionAttribute instanceof ReflectionAttribute) {
                        $services += $requestPropReflectionAttribute->getArguments()['requiredFor'] ?? [];
                        if (!$required) {
                            $services += $requestPropReflectionAttribute->getArguments()['optionalFor'] ?? [];
                        }
                    }
                }
                if (!$this->propType || ResponseProp::class === $this->propType) {
                    if ($responsePropReflectionAttribute instanceof ReflectionAttribute) {
                        $services += $responsePropReflectionAttribute->getArguments()['requiredFor'] ?? [];
                        if (!$required) {
                            $services += $responsePropReflectionAttribute->getArguments()['optionalFor'] ?? [];
                        }
                    }
                }

                foreach ($services as $service) {
                    if (!in_array(needle: $service, haystack: ServiceInterface::SERVICES)) {
                        throw new InvalidArgumentException(message: "Invalid service class: $service");
                    }
                }

                if (!in_array(needle: $this->service, haystack: $services)) {
                    continue;
                }
                $properties[] = $reflectionProperty;
            }
        }

        if (!$asStrings) {
            return $properties;
        }

        return array_map(
            callback: fn (ReflectionProperty $property): string => $property->getName(),
            array: $properties
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isValid(): bool
    {
        if (!$this->service) {
            return false;
        }

        foreach ($this->getSerializableProps(asStrings: true, required: true) as $propName) {
            /** @psalm-var string $propName */
            if (null === $this->{"get$propName"}()) {
                return false;
            }
        }

        return true;
    }
}
