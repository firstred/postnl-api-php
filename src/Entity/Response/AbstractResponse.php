<?php
declare(strict_types=1);

/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Error;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Class AbstractResponse
 */
abstract class AbstractResponse extends AbstractEntity
{
    /**
     * Warnings
     *
     * @var Warning[] $warnings
     *
     * @since 2.0.0
     */
    protected $warnings = [];

    /**
     * Errors
     *
     * @var Error[] $errors
     *
     * @since 2.0.0
     */
    protected $errors = [];

    /**
     * Get warnings
     *
     * @return array
     *
     * @since 2.0.0
     *
     * @see Warning
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * Add warning
     *
     * @param Warning $w
     *
     * @return static
     *
     * @since 2.0.0
     *
     * @see Warning
     */
    public function addWarning(Warning $w): AbstractResponse
    {
        $this->warnings[] = $w;

        return $this;
    }

    /**
     * Set warnings
     *
     * @param array $warnings
     *
     * @return static
     *
     * @since 2.0.0
     *
     * @see Warning
     */
    public function setWarnings(array $warnings): AbstractResponse
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * Get errors
     *
     * @return array
     *
     * @since 2.0.0
     *
     * @see Error
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Add error
     *
     * @param Error $e
     *
     * @return static
     *
     * @since 2.0.0
     *
     * @see Error
     */
    public function addError(Error $e): AbstractResponse
    {
        $this->errors[] = $e;

        return $this;
    }

    /**
     * Set errors
     *
     * @param array $errors
     *
     * @return static
     *
     * @since 2.0.0
     *
     * @see Error
     */
    public function setErrors(array $errors): AbstractResponse
    {
        $this->errors = $errors;

        return $this;
    }

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

        $object = new static();
        foreach ($json[$shortClassName] as $key => $value) {
            if ('Error' === $key) {
                if (isset($value['ErrorsMsg'])) {
                    $value = [$value];
                }
                foreach ($value as $error) {
                    $object->addError(Error::jsonDeserialize(['Error' => $error]));
                }
            } elseif ('Warnings' === $key) {
                $value = $value['Warning'];
                if (isset($value['Code'])) {
                    $value = [$value];
                }
                foreach ($value as $warning) {
                    $object->addWarning(Warning::jsonDeserialize(['Warning' => $warning]));
                }
            } elseif (is_null(AbstractEntity::getFullEntityClassName($key))) {
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
            if (in_array(ucfirst($propertyName), ['Warnings', 'Errors'])) {
                continue;
            }
            if (isset($this->{$propertyName})) {
                $json[ucfirst($propertyName)] = $this->{$propertyName};
            }
        }

        return $json;
    }

    /**
     * Process warnings and errors during deserialization
     *
     * @param AbstractResponse $object
     * @param array            $json
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    protected static function processWarningsAndErrors(AbstractResponse &$object, $json): void
    {
        if (isset($json['Error'])) {
            $value = $json['Error'];
            if (isset($value['ErrorsMsg'])) {
                $value = [$value];
            }
            foreach ($value as $error) {
                $object->addError(Error::jsonDeserialize(['Error' => $error]));
            }
        } elseif (isset($json['Warnings']['Warning'])) {
            $value = $json['Warnings']['Warning'];
            if (isset($value['Code'])) {
                $value = [$value];
            }
            foreach ($value as $warning) {
                $object->addWarning(Warning::jsonDeserialize(['Warning' => $warning]));
            }
        }
    }
}
