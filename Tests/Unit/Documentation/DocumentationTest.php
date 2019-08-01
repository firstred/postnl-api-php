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

namespace Firstred\PostNL\Tests\Unit\Entity;

use Firstred\PostNL\Entity\AbstractEntity;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * @testdox The Entities
 */
class DocumentationTest extends TestCase
{
    /**
     * @testdox Has an @see documentation block
     *
     * @throws ReflectionException
     */
    public function testSee()
    {
        foreach ($this->getEntities() as $entityName) {
            $reflector = new ReflectionClass($entityName);
            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                /** @var ReflectionMethod $method */
                if ($method->class !== ltrim($entityName, '\\')) {
                    continue;
                }

                if (!in_array(substr($method->getName(), 0, 3), ['get', 'set'])) {
                    continue;
                }

                $this->assertTrue(strpos($method->getDocComment(), '* @see') !== false, "{$method->class}::{$method->name} does not have an @see comment");
            }
        }
    }

    /**
     * @testdox Has an @pattern documentation block
     *
     * @throws ReflectionException
     */
    public function testPattern()
    {
        foreach ($this->getEntities() as $entityName) {
            $reflector = new ReflectionClass($entityName);
            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                /** @var ReflectionMethod $method */
                if ($method->class !== ltrim($entityName, '\\')) {
                    continue;
                }

                if (!in_array(substr($method->name, 0, 3), ['set'])) {
                    continue;
                }

                $this->assertTrue(strpos($method->getDocComment(), '* @pattern') !== false, "{$method->class}::{$method->name} does not have an @pattern comment");
            }

            foreach ($reflector->getProperties(ReflectionProperty::IS_PROTECTED) as $defaultProperty) {
                /** @var ReflectionProperty $defaultProperty */
                if ($defaultProperty->class !== ltrim($entityName, '\\')) {
                    continue;
                }

                $this->assertTrue(strpos($defaultProperty->getDocComment(), '* @pattern') !== false, "{$defaultProperty->class}::\${$defaultProperty->name} does not have an @pattern comment");
            }
        }
    }

    /**
     * @testdox Has at least one @since documentation block
     *
     * @throws ReflectionException
     */
    public function testSince()
    {
        foreach ($this->getEntities() as $entityName) {
            $reflector = new ReflectionClass($entityName);
            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                /** @var ReflectionMethod $method */
                if ($method->class !== ltrim($entityName, '\\')) {
                    continue;
                }

                if (!in_array(substr($method->name, 0, 3), ['set', 'get'])) {
                    continue;
                }

                $this->assertTrue(strpos($method->getDocComment(), '* @since') !== false, "{$method->class}::{$method->name} does not have an @since comment");
            }

            foreach ($reflector->getProperties(ReflectionProperty::IS_PROTECTED) as $defaultProperty) {
                /** @var ReflectionProperty $defaultProperty */
                if ($defaultProperty->class !== ltrim($entityName, '\\')) {
                    continue;
                }

                $this->assertTrue(strpos($defaultProperty->getDocComment(), '* @since') !== false, "{$defaultProperty->class}::\${$defaultProperty->name} does not have an @since comment");
            }
        }
    }

    /**
     * @testdox Has an @example documentation block
     *
     * @throws ReflectionException
     */
    public function testExample()
    {
        foreach ($this->getEntities() as $entityName) {
            $reflector = new ReflectionClass($entityName);
            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                /** @var ReflectionMethod $method */
                if ($method->class !== ltrim($entityName, '\\')) {
                    continue;
                }

                if (!in_array(substr($method->name, 0, 3), ['set'])) {
                    continue;
                }

                $this->assertTrue(strpos($method->getDocComment(), '* @example') !== false, "{$method->class}::{$method->name} does not have an @example comment");
            }

            foreach ($reflector->getProperties(ReflectionProperty::IS_PROTECTED) as $defaultProperty) {
                /** @var ReflectionProperty $defaultProperty */
                if ($defaultProperty->class !== ltrim($entityName, '\\')) {
                    continue;
                }
                $this->assertTrue(strpos($defaultProperty->getDocComment(), '* @example') !== false, "{$defaultProperty->class}::\${$defaultProperty->name} does not have an @example comment");
            }
        }
    }

    /**
     * @testdox Has an @throws documentation block
     *
     * @throws ReflectionException
     */
    public function testThrows()
    {
        foreach ($this->getEntities() as $entityName) {
            if (in_array(ltrim($entityName, '\\'), [AbstractEntity::class])) {
                continue;
            }
            $reflector = new ReflectionClass($entityName);
            foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                /** @var ReflectionMethod $method */
                if (!in_array(substr($method->getName(), 0, 3), ['set'])
                    || in_array(ltrim($method->class, '\\'), [AbstractEntity::class])
                ) {
                    continue;
                }

                $this->assertTrue(strpos($method->getDocComment(), '* @throws') !== false, "{$method->class}::{$method->name} does not have an @throws comment");
            }
        }
    }

    /**
     * @return array
     */
    private function getEntities()
    {
        $entityNames = [];

        foreach (scandir(__DIR__.'/../../../src/Entity') as $entityName) {
            if (in_array($entityName, ['.', '..', 'AbstractEntity.php']) || is_dir(__DIR__."/../../../src/Entity/$entityName")) {
                continue;
            }
            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\$entityName";

            $entityNames[] = $entityName;
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Request') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Request/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Request\\$entityName";

            $entityNames[] = $entityName;
        }

//        foreach (scandir(__DIR__.'/../../../src/Entity/Response') as $entityName) {
//            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Response/$entityName")) {
//                continue;
//            }
//
//            $entityName = substr($entityName, 0, strlen($entityName) - 4);
//            $entityName = "\\Firstred\\PostNL\\Entity\\Response\\$entityName";
//
//            $entityNames[] = $entityName;
//        }

        return $entityNames;
    }
}
