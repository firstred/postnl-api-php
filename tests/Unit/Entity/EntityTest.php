<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
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
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Tests\Unit\Entity;

use ArgumentCountError;
use Error;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * @testdox The Entities
 */
class EntityTest extends TestCase
{
    /**
     * @testdox Have a working constructor
     */
    public function testConstructors()
    {
        foreach (scandir(__DIR__.'/../../../src/Entity') as $entityName) {
            if (in_array($entityName, ['.', '..', 'AbstractEntity.php']) || is_dir(__DIR__."/../../../src/Entity/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(AbstractEntity::class, $entity);
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Request') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Request/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Request\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(AbstractEntity::class, $entity);
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Response') as $entityName) {
            if (in_array($entityName, ['.', '..', 'AbstractResponse.php']) || is_dir(__DIR__."/../../src/Entity/Response/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Response\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(AbstractEntity::class, $entity);
        }
    }

    /**
     * @testdox Properties should be readable and writable
     *
     * @throws ReflectionException
     */
    public function testProperties()
    {
        foreach (scandir(__DIR__.'/../../../src/Entity') as $entityName) {
            if (in_array($entityName, ['.', '..', 'AbstractEntity.php']) || is_dir(__DIR__."/../../../src/Entity/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\$entityName";
            $entity = new $entityName();
            $reflection = new ReflectionClass($entityName);
            foreach (array_keys($reflection->getDefaultProperties()) as $var) {
                $property = $reflection->getProperty($var);
                if (!$property->isProtected()) {
                    continue;
                }
                $var = ucfirst($var);
                $this->assertTrue(method_exists($entity, "get$var"), $entityName);
                $this->assertTrue(method_exists($entity, "set$var"), $entityName);
            }
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Request') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Request/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Request\\$entityName";
            $entity = new $entityName();
            $reflection = new ReflectionClass($entityName);
            foreach (array_keys($reflection->getDefaultProperties()) as $var) {
                $property = $reflection->getProperty($var);
                if (!$property->isProtected()) {
                    continue;
                }
                $var = ucfirst($var);
                $this->assertTrue(method_exists($entity, "get$var"), "The method {$entityName}::get{$var} does not exist");
                $this->assertTrue(method_exists($entity, "set$var"), "The method {$entityName}::set{$var} does not exist");
            }
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Response') as $entityName) {
            if (in_array($entityName, ['.', '..', 'AbstractResponse.php']) || is_dir(__DIR__."/../../src/Entity/Response/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Response\\$entityName";
            $entity = new $entityName();
            $reflection = new ReflectionClass($entityName);
            foreach (array_keys($reflection->getDefaultProperties()) as $var) {
                $property = $reflection->getProperty($var);
                if (!$property->isProtected()) {
                    continue;
                }
                $var = ucfirst($var);
                $this->assertTrue(method_exists($entity, "get$var"));
                $this->assertTrue(method_exists($entity, "set$var"));
            }
        }
    }

    /**
     * @testdox Should throw an exception when the value to set is missing
     */
    public function testNegativeMissingValue()
    {
        $this->expectException(ArgumentCountError::class);

        (new Address())->setArea();
    }

    /**
     * @testdox Should be `null` when instantiating the AbstractEntity
     */
    public function testNegativeCannotInstantiateAbstract()
    {
        $this->expectException(InvalidArgumentException::class);

        AbstractEntity::create();
    }

    /**
     * @testdox Should return `null` when the property does not exist
     */
    public function testNegativeReturnNullWhenPropertyDoesNotExist()
    {
        $this->expectException(Error::class);

        $this->assertNull((new Address())->getNothing());
    }

    /**
     * @testdox Should throw an exception when the method does not exist
     */
    public function testNegativeThrowExceptionWhenMethodDoesNotExist()
    {
        $this->expectException(Error::class);

        (new Address())->blab();
    }
}
