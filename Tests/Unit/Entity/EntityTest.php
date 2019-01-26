<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * *Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
use Firstred\PostNL\Entity\Address;
use PHPUnit\Framework\TestCase;
use Sabre\Xml\Service as XmlService;

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
            $this->assertInstanceOf("\\Firstred\\PostNL\\Entity\\AbstractEntity", $entity);
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Message') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Message/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Message\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\Firstred\\PostNL\\Entity\\AbstractEntity", $entity);
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Request') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Request/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Request\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\Firstred\\PostNL\\Entity\\AbstractEntity", $entity);
        }

        foreach (scandir(__DIR__.'/../../../src/Entity/Response') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Response/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\Firstred\\PostNL\\Entity\\Response\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\Firstred\\PostNL\\Entity\\AbstractEntity", $entity);
        }
    }

    /**
     * @testdox Should throw an exception when the value to set is missing
     */
    public function testNegativeMissingValue()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\InvalidArgumentException');

        (new Address())
            ->setArea()
        ;
    }

    /**
     * @testdox Should be `null` when instantiating the AbstractEntity
     */
    public function testNegativeCannotInstantiateAbstract()
    {
        $this->assertNull(AbstractEntity::create());
    }

    /**
     * @testdox Should return `null` when the property does not exist
     */
    public function testNegativeReturnNullWhenPropertyDoesNotExist()
    {
        $this->assertNull((new Address())->getNothing());
    }

    /**
     * @testdox Should throw an exception when the method does not exist
     */
    public function testNegativeThrowExceptionWhenMethodDoesNotExist()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\InvalidArgumentException');

        (new Address())->blab();
    }

    /**
     * @testdox Should throw an exception when json serializing without having a service
     */
    public function testNegativeThrowExceptionWhenServiceNotSetJson()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\InvalidArgumentException');

        json_encode(new Address());
    }

    /**
     * @testdox Should throw an exception when xml serializing without having a service
     */
    public function testNegativeThrowExceptionWhenServiceNotSetXml()
    {
        $this->expectException('\\Firstred\\PostNL\\Exception\\InvalidArgumentException');

        $service = new XmlService();

        $service->write(
            '{test}a',
            new Address()
        );
    }
}
