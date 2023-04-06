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

namespace Firstred\PostNL\Entity;

use DateTimeInterface;
use Exception;
use Firstred\PostNL\Attribute\SerializableProperty;
use Firstred\PostNL\Enum\SoapNamespace;
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\EntityNotFoundException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Firstred\PostNL\Util\Util;
use Firstred\PostNL\Util\UUID;
use JetBrains\PhpStorm\Deprecated;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionObject;
use ReflectionProperty;
use ReflectionUnionType;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use stdClass;
use TypeError;

use function array_keys;
use function is_array;

abstract class AbstractEntity implements JsonSerializable, XmlSerializable
{
    /** @var string */
    protected string $id;

    /** @var class-string */
    protected string $currentService;

    /** @var array<string, string> */
    protected array $namespaces = [];

    public function __construct()
    {
        // Assign a default ID to this object
        $this->id = UUID::generate();
    }

    /**
     * Create an instance of this class without touching the constructor.
     *
     * @param array $properties
     *
     * @return AbstractEntity
     *
     * @since 1.0.0
     */
    public static function create(array $properties = []): static
    {
        if (__CLASS__ === get_called_class()) {
            throw new TypeError(message: 'Invalid class given');
        }

        try {
            $reflectionClass = new ReflectionClass(objectOrClass: get_called_class());
            $instance = $reflectionClass->newInstanceWithoutConstructor();
            /* @var static $instance */
        } catch (Exception) {
            throw new TypeError(message: 'Invalid class given');
        }

        foreach ($properties as $name => $value) {
            $instance->{'set'.$name}($value);
        }
        $instance->id = UUID::generate();

        return $instance;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string|int $id
     *
     * @return static
     */
    public function setId(string|int $id): static
    {
        if (is_int(value: $id)) {
            $id = (string) $id;
        }

        $this->id = $id;

        return $this;
    }

    /**
     * @param class-string          $currentService
     * @param array<string, string> $namespaces
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function setCurrentService(string $currentService, array $namespaces = []): static
    {
        foreach ($namespaces as $namespacePrefix => $namespaceValue) {
            if (!is_string(value: $namespacePrefix)) {
                throw new InvalidArgumentException(message: 'Namespace prefix is not supported');
            } elseif (!is_string(value: $namespaceValue)) {
                throw new InvalidArgumentException(message: 'Namespace value should be a string');
            }
            try {
                /* @noinspection PhpExpressionResultUnusedInspection */
                SoapNamespace::from(value: $namespacePrefix);
            } catch (TypeError) {
                throw new InvalidArgumentException(message: 'Namespace prefix is not supported');
            }
        }

        $reflectionCurrentService = new ReflectionClass(objectOrClass: $currentService);
        if (!$reflectionCurrentService->isInterface()) {
            throw new InvalidArgumentException(message: '`$currentService` must be an interface');
        }

        $this->currentService = $currentService;
        $this->namespaces = $namespaces;

        return $this;
    }

    /**
     * @return class-string
     */
    public function getCurrentService(): string
    {
        return $this->currentService;
    }

    /**
     * @return array<string, string>
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * @return array<string, string>
     *
     * @since 2.0.0
     */
    public function getSerializableProperties(): array
    {
        $serializableProperties = [];

        $reflectionClass = new ReflectionClass(objectOrClass: static::class);
        foreach ($reflectionClass->getProperties() as $property) {
            foreach ($property->getAttributes(name: SerializableProperty::class) as $attribute) {
                $supportedServices = $attribute->getArguments()['supportedServices'];
                if (empty($supportedServices)
                    || isset($this->currentService) && in_array(needle: $this->currentService, haystack: $supportedServices)
                ) {
                    $namespacePrefix = $attribute->getArguments()['namespace']->value;
                    $serializableProperties[$property->getName()] = $this->namespaces[$namespacePrefix] ?? '';
                }
            }
        }

        return $serializableProperties;
    }

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     *
     * @throws ServiceNotSetException
     */
    public function jsonSerialize(): array
    {
        $json = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $_) {
            if (isset($this->$propertyName)) {
                if ($this->$propertyName instanceof DateTimeInterface) {
                    $json[$propertyName] = $this->$propertyName->format('d-m-Y H:i:s');
                } else {
                    $json[$propertyName] = $this->$propertyName;
                }
            }
        }

        return $json;
    }

    /**
     * Return a serializable array for the XMLWriter.
     *
     * @param Writer $writer
     *
     * @throws ServiceNotSetException
     *
     * @since 1.0.0
     */
    public function xmlSerialize(Writer $writer): void
    {
        $xml = [];
        if (!isset($this->currentService)) {
            throw new ServiceNotSetException(message: 'Service not set before serialization');
        }

        foreach ($this->getSerializableProperties() as $propertyName => $namespacePrefix) {
            if (isset($this->$propertyName)) {
                $xml["{{$namespacePrefix}}$propertyName"] = $this->$propertyName;
            }
        }

        $writer->write(value: $xml);
    }

    /**
     * @param stdClass $json {"EntityName": object}
     *
     * @return static
     *
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws NotSupportedException
     *
     * @since 1.0.0
     */
    public static function jsonDeserialize(stdClass $json): static
    {
        // Find the entity name
        $reflection = new ReflectionObject(object: $json);
        $properties = $reflection->getProperties(filter: ReflectionProperty::IS_PUBLIC);

        if (!count(value: $properties)) {
            throw new DeserializationException(message: 'No properties found');
        }

        $entityName = $properties[0]->getName();
        // Instantiate a new entity
        $entity = static::create();

        // Iterate over all the possible properties
        $propertyNames = array_keys(array: $entity->getSerializableProperties());
        foreach ($propertyNames as $propertyName) {
            if (!isset($json->$entityName->$propertyName)) {
                continue;
            }

            $value = $json->$entityName->$propertyName;

            try {
                $reflectionProperty = (new ReflectionClass(objectOrClass: $entity))->getProperty(name: $propertyName);
            } catch (ReflectionException $e) {
                throw new DeserializationException(previous: $e);
            }
            $propertyFqcn = $reflectionProperty->getAttributes(name: SerializableProperty::class)[0]->getArguments()['type'] ?? '';
            $isArray = $reflectionProperty->getAttributes(name: SerializableProperty::class)[0]->getArguments()['isArray']   ?? false;

            if (!$isArray) {
                if (($value instanceof stdClass || is_array(value: $value)) && empty((array) $value)) {
                    // Handle cases where the API returns {} instead of a `null` value
                    $value = null;
                } elseif ($value instanceof DateTimeInterface) {
                    // Handle DateTimes
                    $value = $value->format(format: 'd-m-Y H:i:s');
                }
            }

            if (is_a(object_or_class: $propertyFqcn, class: AbstractEntity::class, allow_string: true)) {
                if ($isArray) {
                    try {
                        $reflectionPropertyClass = new ReflectionClass(objectOrClass: $propertyFqcn);
                    } catch (ReflectionException $e) {
                        throw new DeserializationException(previous: $e);
                    }
                    $entity->{"set$propertyName"}(array_map(callback: function ($item) use ($propertyName, $propertyFqcn, $reflectionPropertyClass) {
                        $propertyEntity = $item instanceof stdClass ? $propertyFqcn::jsonDeserialize(json: (object) [$reflectionPropertyClass->getShortName() => $item]) : $item;
                        if (!is_a(object_or_class: $propertyEntity, class: AbstractEntity::class, allow_string: true)) {
                            throw new DeserializationException(message: "Could not deserialize array property `$propertyName`");
                        }

                        return $propertyEntity;
                    }, array: Util::isAssociativeArray(array: (array) $value) ? [$value] : (array) $value));
                } else {
                    $entity->{"set$propertyName"}($propertyFqcn::jsonDeserialize(json: (object) [$propertyName => $value]));
                }
            } else {
                $entity->{"set$propertyName"}($isArray ? (Util::isAssociativeArray(array: (array) $value) ? [$value] : (array) $value) : $value);
            }
        }

        return $entity;
    }

    /**
     * @param array $xml
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function xmlDeserialize(array $xml): static
    {
        if (self::class === static::class) {
            throw new InvalidArgumentException(message: 'Calling `AbstractEntity::xmlDeserialize` is not supported.');
        }

        $object = new static();
        $reflectionObject = new ReflectionObject(object: $object);
        foreach ($reflectionObject->getProperties() as $reflectionProperty) {
            $reflectionAttributes = $reflectionProperty->getAttributes();
            foreach ($reflectionAttributes as $reflectionAttribute) {
                $reflectionNamedTypes = static::getPropertyTypes(reflectionProperty: $reflectionProperty);
                switch ($reflectionAttribute->getName()) {
                    case SerializableProperty::class:
                        break;
                }
            }
        }

        return $object;
    }

    /**
     * @return non-empty-array<ReflectionNamedType>
     *
     * @since 2.0.0
     *
     * @internal
     */
    protected static function getPropertyTypes(
        ReflectionProperty $reflectionProperty,
        bool $serializableEntitiesOnly = false,
    ): array {
        $reflectionNamedTypes = [];
        $rawReflectionType = $reflectionProperty->getType();
        if ($rawReflectionType instanceof ReflectionIntersectionType) {
            $reflectionNamedTypes = $rawReflectionType->getTypes();
        } elseif ($rawReflectionType instanceof ReflectionUnionType) {
            foreach ($rawReflectionType->getTypes() as $reflectionIntersectionOrNamedType) {
                $reflectionNamedTypes[] = $reflectionIntersectionOrNamedType instanceof ReflectionIntersectionType ? $reflectionIntersectionOrNamedType->getTypes() : $reflectionIntersectionOrNamedType;
            }
        } elseif ($rawReflectionType instanceof ReflectionNamedType) {
            $reflectionNamedTypes = [$rawReflectionType];
        }
        if ($serializableEntitiesOnly) {
            foreach ($reflectionNamedTypes as $reflectionNamedType) {
                if (is_a(object_or_class: AbstractEntity::class, class: $reflectionNamedType->getName())) {
                    return [$reflectionNamedType];
                }
            }
        }

        return $reflectionNamedTypes;
    }

    /**
     * Whether the given property should be an array.
     *
     * @param string $fqcn         Fully-qualified class name
     * @param string $propertyName Property name
     *
     * @return string|false If found, singular name of property, else false
     *
     * @since 1.2.0
     * @deprecated 2.0.0
     *
     * @internal
     */
    #[Deprecated]
    public static function shouldBeAnArray(string $fqcn, string $propertyName): string|false
    {
        trigger_deprecation(
            package: 'firstred/postnl-api-php',
            version: '2.0.0',
            message: 'Using `AbstractEntity::shouldBeAnArray` is deprecated. It is an internal function about to be removed.',
        );

        try {
            $reflection = new ReflectionClass(objectOrClass: $fqcn);
            $reflectionProperty = $reflection->getProperty(name: $propertyName);
            foreach ($reflectionProperty->getAttributes() as $attribute) {
                if (SerializableProperty::class === $attribute->getName()) {
                    if ($attribute->getArguments()['isArray'] ?? false) {
                        return $reflectionProperty->getName();
                    }
                }
            }
        } catch (Exception) {
            return false;
        }

        return false;
    }

    /**
     * Get the fully qualified class name for the given entity name.
     *
     * @param string $shortName
     *
     * @return class-string
     *
     * @throws EntityNotFoundException
     *
     * @since 1.2.0
     * @deprecated 2.0.0
     *
     * @internal
     */
    #[Deprecated]
    public static function getFullyQualifiedEntityClassName(string $shortName): string
    {
        trigger_deprecation(
            package: 'firstred/postnl-api-php',
            version: '2.0.0',
            message: 'Using `AbstractEntity::getFullQualifiedEntityClassName` is deprecated. Use the corresponding property attributes instead.',
        );

        foreach ([
                     '\\Firstred\\PostNL\\Entity',
                     '\\Firstred\\PostNL\\Entity\\Message',
                     '\\Firstred\\PostNL\\Entity\\Request',
                     '\\Firstred\\PostNL\\Entity\\Response',
                     '\\Firstred\\PostNL\\Entity\\Soap',
                 ] as $namespace) {
            if (class_exists(class: "$namespace\\$shortName") && AbstractEntity::class !== "$namespace\\$shortName") {
                return "$namespace\\$shortName";
            }
        }

        throw new EntityNotFoundException(message: "Entity not found: $shortName");
    }
}
