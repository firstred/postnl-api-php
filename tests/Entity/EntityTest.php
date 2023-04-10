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

namespace Firstred\PostNL\Tests\Entity;

use Error;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Exception\ServiceNotSetException;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sabre\Xml\Service as XmlService;
use TypeError;

#[TestDox(text: 'The Entities')]
class EntityTest extends TestCase
{
    /** @throws */
    #[TestDox(text: 'have a working constructor')]
    public function testConstructors(): void
    {
        foreach (scandir(directory: __DIR__.'/../../src/Entity') as $entityName) {
            if (in_array(needle: $entityName, haystack: ['.', '..', 'AbstractEntity.php']) || is_dir(filename: __DIR__."/../../src/Entity/$entityName")) {
                continue;
            }

            $entityName = substr(string: $entityName, offset: 0, length: strlen(string: $entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(expected: AbstractEntity::class, actual: $entity);
        }

        foreach (scandir(directory: __DIR__.'/../../src/Entity/Message') as $entityName) {
            if (in_array(needle: $entityName, haystack: ['.', '..']) || is_dir(filename: __DIR__."/../../src/Entity/Message/$entityName")) {
                continue;
            }

            $entityName = substr(string: $entityName, offset: 0, length: strlen(string: $entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Message\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(expected: AbstractEntity::class, actual: $entity);
        }

        foreach (scandir(directory: __DIR__.'/../../src/Entity/Request') as $entityName) {
            if (in_array(needle: $entityName, haystack: ['.', '..']) || is_dir(filename: __DIR__."/../../src/Entity/Request/$entityName")) {
                continue;
            }

            $entityName = substr(string: $entityName, offset: 0, length: strlen(string: $entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Request\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(expected: AbstractEntity::class, actual: $entity);
        }

        foreach (scandir(directory: __DIR__.'/../../src/Entity/Response') as $entityName) {
            if (in_array(needle: $entityName, haystack: ['.', '..']) || is_dir(filename: __DIR__."/../../src/Entity/Response/$entityName")) {
                continue;
            }

            $entityName = substr(string: $entityName, offset: 0, length: strlen(string: $entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Response\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf(expected: AbstractEntity::class, actual: $entity);
        }
    }

    /** @throws */
    #[TestDox(text: 'should throw a `TypeError` when the value to set is missing')]
    public function testNegativeMissingValue(): void
    {
        $this->expectException(exception: TypeError::class);

        /* @noinspection PhpParamsInspection */
        (new Address())->setArea();
    }

    /** @throws */
    #[TestDox(text: 'should be `null` when instantiating the AbstractEntity')]
    public function testNegativeCannotInstantiateAbstract(): void
    {
        $this->expectException(exception: TypeError::class);

        AbstractEntity::create();
    }

    /** @throws */
    #[TestDox(text: 'should return `null` when the property does not exist')]
    public function testNegativeReturnNullWhenPropertyDoesNotExist(): void
    {
        $this->expectException(exception: Error::class);

        /* @noinspection PhpUndefinedMethodInspection */
        $this->assertNull(actual: (new Address())->getNothing());
    }

    /** @throws  */
    #[TestDox(text: 'should throw a `TypeError` when the method does not exist')]
    public function testNegativeThrowExceptionWhenMethodDoesNotExist(): void
    {
        $this->expectException(exception: Error::class);

        (new Address())->blab();
    }

    /** @throws */
    #[TestDox(text: 'should throw a `ServiceNotSetException` when json serializing without having a service')]
    public function testNegativeThrowExceptionWhenServiceNotSetJson(): void
    {
        $this->expectException(exception: ServiceNotSetException::class);

        json_encode(value: new Address());
    }
}
