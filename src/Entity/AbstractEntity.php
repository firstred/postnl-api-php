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
use Firstred\PostNL\Util\UUID;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use stdClass;
use TypeError;
use function array_keys;
use function is_array;

/**
 *
 */
abstract class AbstractEntity implements JsonSerializable, XmlSerializable
{
    /** @var string $id */
    protected string $id;

    /** @var class-string $currentService */
    protected string $currentService;

    /** @var array<string, string> $namespaces */
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
            /** @var static $instance */
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
     * @return $this
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
                /** @noinspection PhpExpressionResultUnusedInspection */
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
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function __call(string $name, mixed $value): mixed
    {
        $methodName = substr(string: $name, offset: 0, length: 3);
        $propertyName = substr(string: $name, offset: 3, length: strlen(string: $name));
        if ('ReasonNotimeframes' === $propertyName) {
            $propertyName = 'ReasonNoTimeframes';
        }

        if ('get' === $methodName) {
            if (property_exists(object_or_class: $this, property: $propertyName)) {
                return $this->$propertyName;
            } else {
                return null;
            }
        } elseif ('set' === $methodName) {
            if (!is_array(value: $value) || count(value: $value) < 1) {
                throw new TypeError(message: 'Value is missing');
            }

            if (property_exists(object_or_class: $this, property: $propertyName)) {
                $this->$propertyName = $value[0];
            }

            return $this;
        }

        throw new TypeError(message: 'Not a valid `get` or `set` method');
    }

    /**
     * @return array
     * @phpstan-return array<string, string>
     * @psalm-return array<string, string>
     */
    public function getSerializableProperties(): array
    {
        $serializableProperties = [];

        $reflectionClass = new ReflectionClass(objectOrClass: static::class);
        foreach ($reflectionClass->getProperties() as $property) {
            foreach ($property->getAttributes(name: SerializableProperty::class) as $attribute) {
                $supportedServices = $attribute->getArguments()['supportedServices'];
                if (empty($supportedServices) || in_array(needle: $this->currentService, haystack: $supportedServices)) {
                    $serializableProperties[$property->getName()] = $this->namespaces[$attribute->getArguments()['namespace']->value];
                }
            }
        }

        return $serializableProperties;
    }

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
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
     * @param stdClass $json
     *
     * @return AbstractEntity|array|bool|int|string|float|null
     * @throws DeserializationException
     * @throws EntityNotFoundException
     * @throws NotSupportedException
     * @since 1.0.0
     */
    public static function jsonDeserialize(stdClass $json /* `{"EntityName": object}` */): static|array|bool|int|string|float|null
    {
        // Find the entity name
        $reflection = new ReflectionObject(object: $json);
        $properties = $reflection->getProperties(filter: ReflectionProperty::IS_PUBLIC);

        if (!count(value: $properties)) {
            throw new DeserializationException(message: 'No properties found');
        }

        $entityName = $properties[0]->getName();
        try {
            $entityFqcn = static::getFullyQualifiedEntityClassName(shortName: $entityName);
        } catch (EntityNotFoundException) {
            $entityFqcn = null;
        }

        // The only key in this stdClass should be the containing object's name
        // The value should be the object itself
        if (!$entityFqcn
            || !class_exists(class: $entityFqcn)
            || (!is_object(value: $json->$entityName) && !is_array(value: $json->$entityName))
        ) {
            if ($entityFqcn instanceof stdClass) {
                throw new NotSupportedException(message: 'Unable to deserialize entity', code: 0, previous: $entityFqcn);
            }

            // Handle {} => `null` values
            if (is_object(value: $json->$entityName) && empty((array) $json->$entityName)) {
                return null;
            }

            // If it's not a known object, just return the property
            return $json->$entityName;
        }

        if ($json->$entityName instanceof DateTimeInterface) {
            return $json->$entityName->format('d-m-Y H:i:s');
        }

        // Instantiate a new entity
        $object = call_user_func(callback: [$entityFqcn, 'create']);

        if (is_array(value: $json->$entityName)) {
            return array_map(callback: function ($item) use ($entityName) {
                $fqcn = static::getFullyQualifiedEntityClassName(shortName: $entityName);

                /** @noinspection PhpUndefinedMethodInspection */
                return $fqcn::jsonDeserialize((object) [$entityName => $item]);
            }, array: $json->$entityName);
        }

        // Iterate over all the possible properties
        $propertyNames = isset($entityFqcn::$defaultProperties['Barcode'])
            ? array_keys(array: $entityFqcn::$defaultProperties['Barcode'])
            : [];
        foreach ($propertyNames as $propertyName) {
            if (!isset($json->$entityName->$propertyName)) {
                continue;
            }

            $value = $json->$entityName->$propertyName;

            // Handle cases where the API returns {} instead of a `null` value
            if ($value instanceof stdClass && empty((array) $value)) {
                $value = null;
            } elseif ($value instanceof DateTimeInterface) {
                $value = $value->format(format: 'd-m-Y H:i:s');
            }

            if ($singularEntityName = static::shouldBeAnArray(fqcn: $entityFqcn, propertyName: $propertyName)) {
                if (null === $value) {
                    $value = [];
                } elseif (!is_array(value: $value)) {
                    $value = [$value];
                }

                $entities = [];
                foreach ($value as $item) {
                    try {
                        $fqcn = static::getFullyQualifiedEntityClassName(shortName: $singularEntityName);
                    } catch (EntityNotFoundException) {
                        $fqcn = AbstractEntity::class;
                    }
                    $entities[] = $fqcn::jsonDeserialize(json: (object) [$singularEntityName => $item]);
                }
                $object->{'set'.$propertyName}($entities);
            } else {
                try {
                    $fqcn = static::getFullyQualifiedEntityClassName(shortName: $propertyName);
                } catch (EntityNotFoundException) {
                    $fqcn = AbstractEntity::class;
                }
                $object->{'set'.$propertyName}($fqcn::jsonDeserialize(json: (object) [$propertyName => $value]));
            }
        }

        return $object;
    }

    /**
     * @param array $xml
     *
     * @return static
     * @throws EntityNotFoundException
     * @throws DeserializationException
     */
    public static function xmlDeserialize(array $xml): static
    {
        if (!isset($xml['name']) && isset($xml[0]['name'])) {
            $xml = $xml[0];
        }

        $shortClassName = preg_replace(pattern: '/({.*})([A-Za-z]+)/', replacement: '$2', subject: $xml['name']);
        $fqcn = static::getFullyQualifiedEntityClassName(shortName: $shortClassName);

        // The only key in this associate array should be the object's name
        // The value should be the object itself

        if (!$fqcn || !class_exists(class: $fqcn) || !is_array(value: $xml['value'])) {
            // If it's not a known object, just return the property
            return $xml['value'];
        }

        $object = call_user_func(callback: [$fqcn, 'create']);
        foreach ($xml['value'] as $value) {
            $shortClassName = preg_replace(pattern: '/({.*})([A-Za-z]+)/', replacement: '$2', subject: $value['name']);
            try {
                $fqcn = static::getFullyQualifiedEntityClassName(shortName: $shortClassName);
            } catch (EntityNotFoundException) {
                $fqcn = null;
            }

            // If key is plural, try the singular version, because this might be an array
            if (in_array(needle: $shortClassName, haystack: ['OldStatuses', 'Statuses', 'Addresses'])) {
                try {
                    $fqcn = static::getFullyQualifiedEntityClassName(shortName: substr(string: $shortClassName, offset: 0, length: strlen(string: $shortClassName) - 2));
                } catch (EntityNotFoundException) {
                }
            } elseif (!$fqcn && str_ends_with(haystack: $shortClassName, needle: 's')) {
                try {
                    $fqcn = static::getFullyQualifiedEntityClassName(shortName: substr(string: $shortClassName, offset: 0, length: strlen(string: $shortClassName) - 1));
                } catch (EntityNotFoundException) {
                }
            }

            if (!$value['value']) {
                $object->{'set'.$shortClassName}($value['value']);
            } elseif (is_array(value: $value['value'])
                && count(value: $value['value']) >= 1
                && !in_array(needle: $shortClassName, haystack: ['Customer', 'OpeningHours', 'Customs'])
                && is_subclass_of(object_or_class: $fqcn, class: AbstractEntity::class)
            ) {
                $entities = [];
                if (isset($value['value'][0]['value']) && !is_array(value: $value['value'][0]['value'])) {
                    $object->{'set'.$shortClassName}(static::xmlDeserialize(xml: [$value]));
                } else {
                    foreach ($value['value'] as $item) {
                        if (!is_array(value: $item['value'])) {
                            $entities[$item['name']] = $item['value'];
                        } else {
                            $entities[] = static::xmlDeserialize(xml: [$item]);
                        }
                    }

                    $object->{'set'.$shortClassName}($entities);
                }
            } else {
                try {
                    $object->{'set'.$shortClassName}(static::xmlDeserialize(xml: [$value]));
                } catch (\Throwable) {
                    try {
                        $object->{'set'.$shortClassName}($value);
                    } catch (\Throwable $e) {
                        throw new DeserializationException(message: 'Could not deserialize object', previous: $e);
                    }
                }
            }
        }

        return $object;
    }

    /**
     * Whether the given property should be an array
     *
     * @param string $fqcn
     * @param string $propertyName
     *
     * @return string|false
     * @since 1.2.0
     */
    public static function shouldBeAnArray(string $fqcn, string $propertyName): string|false
    {
        try {
            $reflection = new ReflectionClass(objectOrClass: $fqcn);
            $property = $reflection->getProperty(name: $propertyName);
            $comment = $property->getDocComment();
        } catch (ReflectionException) {
            return false;
        }

        // TODO: convert to PHP 8.1+

        // Quick 'n dirty annotation reader
        //
        // A property comment could look like /** @var string|null */
        // or
        // /**
        //  * @var string|null
        //  */
        $matches = ['types' => ''];
        if (preg_match(pattern: '/@var\s(?P<types>[a-zA-Z0-9|\[\]]+)/', subject: (string) $comment, matches: $matches)) {
            foreach (explode(separator: '|', string: $matches['types']) as $type) {
                if ('array' === $type) {
                    return $propertyName;
                } elseif (str_contains(haystack: $type, needle: '[]')) {
                    return substr(string: $type, offset: 0, length: -2);
                }
            }
        }

        return false;
    }

    /**
     * Get the fully qualified class name for the given entity name.
     *
     * @throws EntityNotFoundException
     * @since 1.2.0
     */
    public static function getFullyQualifiedEntityClassName(string $shortName): string
    {
        foreach ([
                     '\\Firstred\\PostNL\\Entity',
                     '\\Firstred\\PostNL\\Entity\\Message',
                     '\\Firstred\\PostNL\\Entity\\Request',
                     '\\Firstred\\PostNL\\Entity\\Response',
                     '\\Firstred\\PostNL\\Entity\\Soap',
                 ] as $namespace) {
            if (class_exists(class: "$namespace\\$shortName")) {
                return "$namespace\\$shortName";
            }
        }

        throw new EntityNotFoundException(message: "Entity not found: $shortName");
    }
}
