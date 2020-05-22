<?php
declare(strict_types=1);

/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\UUID;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;

/**
 * Class AbstractEntity
 */
abstract class AbstractEntity implements JsonSerializable
{
    /** @var string $id */
    protected $id;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        // Assign a default ID to this object
        $this->id = UUID::generate();
    }

    /**
     * Create an instance of this class without touching the constructor
     *
     * @param array $properties
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     * @since 2.0.0 Always returns an instance, throws Exceptions otherwise
     */
    public static function create(array $properties = []): AbstractEntity
    {
        if (get_called_class() === __CLASS__) {
            throw new InvalidArgumentException('Cannot instantiate an AbstractEntity');
        }

        try {
            $reflectionClass = new ReflectionClass(get_called_class());
            /** @var AbstractEntity $instance */
            $instance = $reflectionClass->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            $instance = new static();
        }

        foreach ($properties as $name => $value) {
            $instance->{'set'.$name}($value);
        }
        $instance->id = UUID::generate();

        return $instance;
    }

    /**
     * Get the full class (incl. namespace) for the given short class name
     *
     * @param string $shortName
     *
     * @return string|null The full name if found, else `null`
     *
     * @since 1.0.0
     * @since 2.0.0 Returns a `null` when not found instead of `false`
     */
    public static function getFullEntityClassName(string $shortName): ?string
    {
        foreach ([
                     '\\Firstred\\PostNL\\Entity',
                     '\\Firstred\\PostNL\\Entity\\Request',
                     '\\Firstred\\PostNL\\Entity\\Response',
                 ] as $namespace) {
            if (class_exists("$namespace\\$shortName")) {
                return "$namespace\\$shortName";
            }
        }

        return null;
    }

    /**
     * Return a serializable array for `json_encode`
     *
     * @return array
     *
     * @since 1.0.0
     * @since 2.0.0 No longer uses the defaultProperties, but the actual class vars
     */
    public function jsonSerialize(): array
    {
        $json = [];
        foreach (array_keys(get_class_vars(static::class)) as $propertyName) {
            if (in_array(ucfirst($propertyName), ['Id'])) {
                continue;
            }
            if (isset($this->{$propertyName})) {
                $json[ucfirst($propertyName)] = $this->{$propertyName};
            }
        }

        return $json;
    }/**  */

    /**
     * Deserialize JSON
     *
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @param array $json JSON as associative array
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public static function jsonDeserialize(array $json)
    {
        reset($json);
        $shortClassName = key($json);
        $fullClassName = static::getFullEntityClassName($shortClassName);
        // The only key in this associate array should be the object's name
        // The value should be the object itself

        if (!$fullClassName
            || !class_exists($fullClassName)
            || !is_array($json[$shortClassName])
            || count(array_filter(array_keys($json[$shortClassName]), 'is_int')) > 0
        ) {
            // If it's not a known object or a non-associative array, just return the direct property
            return $json[$shortClassName];
        }

        $object = call_user_func([$fullClassName, 'create']);
        foreach ($json[$shortClassName] as $key => $value) {
            if (is_null(AbstractEntity::getFullEntityClassName($key))) {
                if (!is_array($value) || !empty($value)) {
                    $object->{"set$key"}($value);
                }
            } else {
                $object->{"set$key"}(call_user_func(
                    [static::getFullEntityClassName($key), 'jsonDeserialize'],
                    [$key => $value]
                ));
            }
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setId(string $id): AbstractEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Determine if the array is associative
     *
     * @param array $array
     *
     * @return bool
     *
     * @since 1.0.0
     */
    protected static function isAssociativeArray(array $array): bool
    {
        if ([] === $array || !is_array($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}
