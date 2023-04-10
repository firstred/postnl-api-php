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
use Firstred\PostNL\Exception\DeserializationException;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\Exception\ServiceNotSetException;
use Firstred\PostNL\Util\Util;
use Firstred\PostNL\Util\UUID;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;
use stdClass;
use TypeError;
use function array_keys;
use function is_array;

abstract class AbstractEntity implements JsonSerializable
{
    /** @var string */
    protected string $id;

    /** @var class-string */
    protected string $currentService;

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
     * @deprecated 2.0.0 Use the constructor instead with named arguments
     */
    public static function create(array $properties = []): static
    {
        trigger_deprecation(
            package: 'firstred/postnl-api-php',
            version: '2.0.0',
            message: 'Using `AbstractEntity::create` is now deprecated. Call the constructor with named arguments instead.',
        );

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
     * @param class-string $currentService
     *
     * @return static
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     */
    public function setCurrentService(string $currentService): static
    {
        try {
            $reflectionCurrentService = new ReflectionClass(objectOrClass: $currentService);
            if (!$reflectionCurrentService->isInterface()) {
                throw new InvalidArgumentException(message: '`$currentService` must be an interface');
            }

            $this->currentService = $currentService;

            return $this;
        } catch (ReflectionException $e) {
            throw new InvalidConfigurationException(message: 'Reflection is not working', previous: $e);
        }
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
     *
     * @since 2.0.0
     */
    public function getSerializableProperties(bool $withAliases = false): array
    {
        $serializableProperties = [];

        $reflectionClass = new ReflectionClass(objectOrClass: static::class);
        foreach ($reflectionClass->getProperties() as $property) {
            foreach ($property->getAttributes(name: SerializableProperty::class) as $attribute) {
                $supportedServices = $attribute->getArguments()['supportedServices'] ?? [];
                if (empty($supportedServices)
                    || !isset($this->currentService)
                    || in_array(needle: $this->currentService, haystack: $supportedServices)
                ) {
                    $serializableProperties[$property->getName()] = $property->getName();
                    if ($withAliases) {
                        foreach ($attribute->getArguments()['aliases'] ?? [] as $alias) {
                            $serializableProperties[$alias] = $property->getName();
                        }
                    }
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
     * @param stdClass $json {"EntityName": object}
     *
     * @return static
     *
     * @throws DeserializationException
     * @throws NotSupportedException
     * @throws InvalidConfigurationException
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
        if ($json->$entityName instanceof self) {
            return $json->$entityName;
        }

        // Instantiate a new entity
        $entity = new static();

        // Iterate over all the possible properties
        $propertyNames = $entity->getSerializableProperties(withAliases: true);
        $deserializablePropertyNames = array_keys(array: (array) $json->$entityName);
        $diffPropertyNames = array_diff($deserializablePropertyNames, array_keys(array: $propertyNames), ['Errors']);
        if (count(value: $diffPropertyNames)) {
            trigger_error(
                message: "Deserializable entity `$entityName` contains unknown properties: `['".implode(separator: "','", array: $diffPropertyNames)."']`",
                error_level: E_USER_WARNING,
            );
        }

        foreach ($propertyNames as $propertyAlias => $propertyName) {
            if (!isset($json->$entityName->$propertyAlias)) {
                continue;
            }

            $value = $json->$entityName->$propertyAlias;

            try {
                $reflectionProperty = (new ReflectionClass(objectOrClass: $entity))->getProperty(name: $propertyName);
            } catch (ReflectionException $e) {
                throw new InvalidConfigurationException(message: 'Reflection is not working', previous: $e);
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
}
