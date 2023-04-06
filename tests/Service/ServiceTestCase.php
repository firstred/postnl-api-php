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

namespace Firstred\PostNL\Tests\Service;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use stdClass;

use function is_array;
use function is_object;

#[TestDox(text: 'The AbstractService class')]
abstract class ServiceTestCase extends TestCase
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function containsStdClass(mixed $value): bool
    {
        if ($value instanceof stdClass) {
            return true;
        }

        if (is_array(value: $value)) {
            foreach ($value as $item) {
                if (static::containsStdClass(value: $item)) {
                    return true;
                }
            }
        } elseif (is_object(value: $value)) {
            $reflectionObject = new ReflectionObject(object: $value);
            foreach ($reflectionObject->getProperties() as $property) {
                if (!$property->isInitialized(object: $value)) {
                    continue;
                }

                /** @noinspection PhpExpressionResultUnusedInspection */
                $property->setAccessible(accessible: true);
                if (static::containsStdClass(value: $property->getValue(object: $value))) {
                    return true;
                }
            }
        }

        return false;
    }
}
