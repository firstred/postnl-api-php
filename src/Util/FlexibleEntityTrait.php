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

namespace Firstred\PostNL\Util;

use Firstred\PostNL\Exception\InvalidArgumentException;

/**
 * Trait FlexibleEntityTrait.
 */
trait FlexibleEntityTrait
{
    /**
     * Add additional properties.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return object|null
     *
     * @throws InvalidArgumentException
     */
    public function __call(string $name, mixed $value)
    {
        $methodName = substr(string: $name, offset: 0, length: 3);
        $propertyName = lcfirst(string: substr(string: $name, offset: 3, length: strlen(string: $name)));
        if ('get' === $methodName) {
            if (property_exists(object_or_class: $this, property: $propertyName)) {
                return $this->$propertyName;
            }

            return null;
        } elseif ('set' === $methodName) {
            if (!is_array(value: $value) || count(value: $value) < 1) {
                throw new InvalidArgumentException(message: 'Value is missing');
            }
            if (property_exists(object_or_class: $this, property: $propertyName)) {
                $this->$propertyName = $value[0];
            }

            return $this;
        }
        throw new InvalidArgumentException(message: 'Not a valid `get` or `set` method');
    }
}
