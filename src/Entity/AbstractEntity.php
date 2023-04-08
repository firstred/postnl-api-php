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

namespace Firstred\PostNL\Entity;

use DateTimeInterface;
use Exception;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\NotSupportedException;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Util\UUID;
use Firstred\PostNL\Util\XmlSerializable;
use JetBrains\PhpStorm\Deprecated;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;
use Sabre\Xml\Writer;
use stdClass;
use function array_keys;
use function is_array;

/**
 * Class Entity.
 *
 * @method string         getId()
 * @method string         getCurrentService()
 * @method AbstractEntity setId(string $id)
 * @method AbstractEntity setCurrentService(string $service)
 */
abstract class AbstractEntity implements JsonSerializable, XmlSerializable
{
    // @codingStandardsIgnoreStart
    /** @var array */
    public static $defaultProperties = [];
    /** @var string */
    protected $id;
    /** @var string */
    protected $currentService;
    // @codingStandardsIgnoreEnd

    /**
     * AbstractEntity constructor.
     */
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
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @deprecated 1.4.0 Use the constructor instead with named arguments
     */
    #[Deprecated]
    public static function create(array $properties = [])
    {
        PostNL::triggerDeprecation(
            'firstred/postnl-api-php',
            '1.4.0',
            'Using `AbstractEntity::create` is now deprecated. Call the constructor with named arguments instead.'
        );

        if (__CLASS__ === get_called_class()) {
            throw new InvalidArgumentException('Invalid class given');
        }

        try {
            $reflectionClass = new ReflectionClass(get_called_class());
            $instance = $reflectionClass->newInstanceWithoutConstructor();
            /** @var static $instance */
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid class given');
        }

        foreach ($properties as $name => $value) {
            $instance->{'set'.$name}($value);
        }
        $instance->id = UUID::generate();

        return $instance;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return object|null
     *
     * @throws InvalidArgumentException
     */
    public function __call($name, $value)
    {
        $methodName = substr($name, 0, 3);
        $propertyName = substr($name, 3, strlen($name));
        if ('Id' === $propertyName) {
            $propertyName = 'id';
        } elseif ('CurrentService' === $propertyName) {
            $propertyName = 'currentService';
        } elseif ('ReasonNotimeframes' === $propertyName) {
            $propertyName = 'ReasonNoTimeframes';
        }

        if ('get' === $methodName) {
            if (property_exists($this, $propertyName)) {
                return $this->$propertyName;
            } else {
                return null;
            }
        } elseif ('set' === $methodName) {
            if (!is_array($value) || count($value) < 1) {
                throw new InvalidArgumentException('Value is missing');
            }

            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value[0];
            }

            return $this;
        }

        throw new InvalidArgumentException('Not a valid `get` or `set` method');
    }

    /**
     * Return a serializable array for `json_encode`.
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $json = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            throw new InvalidArgumentException('Service not set before serialization');
        }

        foreach (array_keys(static::$defaultProperties[$this->currentService]) as $propertyName) {
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
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function xmlSerialize(Writer $writer)
    {
        $xml = [];
        if (!$this->currentService || !in_array($this->currentService, array_keys(static::$defaultProperties))) {
            throw new InvalidArgumentException('Service not set before serialization');
        }

        foreach (static::$defaultProperties[$this->currentService] as $propertyName => $namespace) {
            if (isset($this->$propertyName)) {
                $xml[$namespace ? "{{$namespace}}{$propertyName}" : $propertyName] = $this->$propertyName;
            }
        }

        $writer->write($xml);
    }

    /**
     * Deserialize JSON.
     *
     * @param stdClass $json JSON object `{"EntityName": object}`
     *
     * @return static
     *
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     */
    public static function jsonDeserialize(stdClass $json)
    {
        // Find the entity name
        $reflection = new ReflectionObject($json);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        if (!count($properties)) {
            return $json;
        }

        $entityName = $properties[0]->getName();
        try {
            $entityFqcn = static::getFullyQualifiedEntityClassName($entityName);
        } catch (InvalidArgumentException $e) {
            $entityFqcn = null;
        }

        // The only key in this stdClass should be the containing object's name
        // The value should be the object itself
        if (!$entityFqcn
            || !class_exists($entityFqcn)
            || (!is_object($json->$entityName) && !is_array($json->$entityName))
        ) {
            if ($entityFqcn instanceof stdClass) {
                throw new NotSupportedException('Unable to deserialize entity', 0, $entityFqcn);
            }

            // Handle {} => `null` values
            if (is_object($json->$entityName) && empty((array) $json->$entityName)) {
                return null;
            }

            // If it's not a known object, just return the property
            return $json->$entityName;
        }

        if ($json->$entityName instanceof DateTimeInterface) {
            return $json->$entityName->format('d-m-Y H:i:s');
        }

        // Instantiate a new entity
        $object = call_user_func([$entityFqcn, 'create']);

        if (is_array($json->$entityName)) {
            return array_map(function ($item) use ($entityName) {
                $fqcn = static::getFullyQualifiedEntityClassName($entityName);
                /** @noinspection PhpUndefinedMethodInspection */
                return $fqcn::jsonDeserialize((object) [$entityName => $item]);
            }, $json->$entityName);
        }

        // Iterate over all the possible properties
        /** @noinspection PhpUndefinedVariableInspection */
        $propertyNames = isset($entityFqcn::$defaultProperties['Barcode'])
            ? array_keys($entityFqcn::$defaultProperties['Barcode'])
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
                $value = $value->format('d-m-Y H:i:s');
            }

            if ($singularEntityName = static::shouldBeAnArray($entityFqcn, $propertyName)) {
                if (null === $value) {
                    $value = [];
                } elseif (!is_array($value)) {
                    $value = [$value];
                }

                $entities = [];
                foreach ($value as $item) {
                    try {
                        $fqcn = static::getFullyQualifiedEntityClassName($singularEntityName);
                    } catch (InvalidArgumentException $e) {
                        $fqcn = AbstractEntity::class;
                    }
                    /** @noinspection PhpUndefinedMethodInspection */
                    $entities[] = $fqcn::jsonDeserialize((object) [$singularEntityName => $item]);
                }
                $object->{'set'.$propertyName}($entities);
            } else {
                try {
                    $fqcn = static::getFullyQualifiedEntityClassName($propertyName);
                } catch (InvalidArgumentException $e) {
                    $fqcn = AbstractEntity::class;
                }
                /** @noinspection PhpUndefinedMethodInspection */
                $object->{'set'.$propertyName}($fqcn::jsonDeserialize((object) [$propertyName => $value]));
            }
        }

        return $object;
    }

    /**
     * Deserialize XML.
     *
     * @param array $xml Associative array representation of XML response, using Clark notation for namespaces
     *
     * @return AbstractEntity
     */
    public static function xmlDeserialize(array $xml)
    {
        if (!isset($xml['name']) && isset($xml[0]['name'])) {
            $xml = $xml[0];
        }

        $shortClassName = preg_replace('/({.*})([A-Za-z]+)/', '$2', $xml['name']);
        try {
            $fqcn = static::getFullyQualifiedEntityClassName($shortClassName);
        } catch (InvalidArgumentException $e) {
            $fqcn = null;
        }

        // The only key in this associate array should be the object's name
        // The value should be the object itself

        if (!$fqcn || !class_exists($fqcn) || !is_array($xml['value'])) {
            // If it's not a known object, just return the property
            return $xml['value'];
        }

        $object = call_user_func([$fqcn, 'create']);
        foreach ($xml['value'] as $value) {
            $shortClassName = preg_replace('/({.*})([A-Za-z]+)/', '$2', $value['name']);
            try {
                $fqcn = static::getFullyQualifiedEntityClassName($shortClassName);
            } catch (InvalidArgumentException $e) {
                $fqcn = null;
            }

            // If key is plural, try the singular version, because this might be an array
            if (in_array($shortClassName, ['OldStatuses', 'Statuses', 'Addresses'])) {
                try {
                    $fqcn = static::getFullyQualifiedEntityClassName(substr($shortClassName, 0, strlen($shortClassName) - 2));
                } catch (InvalidArgumentException $e) {
                }
            } elseif (!$fqcn && 's' === substr($shortClassName, -1)) {
                try {
                $fqcn = static::getFullyQualifiedEntityClassName(substr($shortClassName, 0, strlen($shortClassName) - 1));
                } catch (InvalidArgumentException $e) {
                }
            }

            if (!$value['value']) {
                $object->{'set'.$shortClassName}($value['value']);
            } elseif (is_array($value['value'])
                && count($value['value']) >= 1
                && !in_array($shortClassName, ['Customer', 'OpeningHours', 'Customs'])
                && is_subclass_of($fqcn, AbstractEntity::class)
            ) {
                $entities = [];
                if (isset($value['value'][0]['value']) && !is_array($value['value'][0]['value'])) {
                    $object->{'set'.$shortClassName}(static::xmlDeserialize([$value]));
                } else {
                    foreach (array_values($value['value']) as $item) {
                        if (!is_array($item['value'])) {
                            $entities[$item['name']] = $item['value'];
                        } else {
                            $entities[] = static::xmlDeserialize([$item]);
                        }
                    }

                    $object->{'set'.$shortClassName}($entities);
                }
            } else {
                $object->{'set'.$shortClassName}(static::xmlDeserialize([$value]));
            }
        }

        return $object;
    }

    /**
     * Whether the given property should bbe an array
     *
     * @param string $fqcn
     * @param string $propertyName
     *
     * @return false|string If found, singular name of property
     *
     * @since 1.2.0
     */
    public static function shouldBeAnArray($fqcn, $propertyName)
    {
        try {
            $reflection = new ReflectionClass($fqcn);
            $property = $reflection->getProperty($propertyName);
            $comment = $property->getDocComment();
        } catch (ReflectionException $e) {
            return false;
        }
        // Quick 'n dirty annotation reader
        //
        // A property comment could look like /** @var string|null */
        // or
        // /**
        //  * @var string|null
        //  */
        $matches = ['types' => ''];
        preg_match('/@var\s(?P<types>[a-zA-Z0-9|\[\]]+)/', $comment, $matches);
        foreach (explode('|', $matches['types']) as $type) {
            if ('array' === $type) {
                return $propertyName;
            } elseif (false !== strpos($type, '[]')) {
                return substr($type, 0, -2);
            }
        }

        return false;
    }

    /**
     * Get the fully qualified class name for the given entity name.
     *
     * @param string $shortName
     *
     * @return string The FQCN
     * @psalm-return class-string
     *
     * @throws InvalidArgumentException
     *
     * @since 1.2.0
     */
    public static function getFullyQualifiedEntityClassName($shortName)
    {
        foreach ([
            '\\Firstred\\PostNL\\Entity',
            '\\Firstred\\PostNL\\Entity\\Message',
            '\\Firstred\\PostNL\\Entity\\Request',
            '\\Firstred\\PostNL\\Entity\\Response',
            '\\Firstred\\PostNL\\Entity\\SOAP',
        ] as $namespace) {
            if (class_exists("$namespace\\$shortName")) {
                return "$namespace\\$shortName";
            }
        }

        throw new InvalidArgumentException("Entity not found: $shortName");
    }
}
