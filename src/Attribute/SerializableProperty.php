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

namespace Firstred\PostNL\Attribute;

use Attribute;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use ReflectionClass;
use ReflectionException;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class SerializableProperty
{
    /**
     * This indicates that the given property is serializable. All serialization details should
     * be passed to the attribute, making it completely serializable without relying on reflection
     * of the property itself.
     *
     * @param class-string|'bool'|'int'|'float'|'string' $type              Property type
     * @param bool                                       $isArray           Should the property be an array
     * @param string[]                                   $aliases           Property shortname aliases such as `Address`
     * @param class-string[]                             $supportedServices Supported services, empty array = all
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     *
     * @since 2.0.0
     */
    public function __construct(
        public string $type,
        public bool   $isArray = false,
        public array  $aliases = [],
        public array  $supportedServices = [],
    ) {
        try {
            foreach ($this->supportedServices as $supportedService) {
                $reflectionSupportedService = new ReflectionClass(objectOrClass: $supportedService);
                if (!$reflectionSupportedService->isInterface()) {
                    throw new InvalidArgumentException(message: 'Only interfaces of services can be passed');
                }
            }
        } catch (ReflectionException $e) {
            throw new InvalidConfigurationException(message: 'Reflection is not working', previous: $e);
        }
    }
}
