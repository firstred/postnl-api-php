<?php

namespace ThirtyBees\PostNL\Tests\Entity;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Entity\Address;
use Sabre\Xml\Service as XmlService;

/**
 * @testdox The Entities
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testdox have a working constructor
     */
    public function testConstructors()
    {
        foreach (scandir(__DIR__.'/../../src/Entity') as $entityName) {
            if (in_array($entityName, ['.', '..', 'AbstractEntity.php']) || is_dir(__DIR__."/../../src/Entity/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\ThirtyBees\\PostNL\\Entity\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\ThirtyBees\\PostNL\\Entity\\AbstractEntity", $entity);
        }

        foreach (scandir(__DIR__.'/../../src/Entity/Message') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Message/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\ThirtyBees\\PostNL\\Entity\\Message\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\ThirtyBees\\PostNL\\Entity\\AbstractEntity", $entity);
        }

        foreach (scandir(__DIR__.'/../../src/Entity/Request') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Request/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\ThirtyBees\\PostNL\\Entity\\Request\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\ThirtyBees\\PostNL\\Entity\\AbstractEntity", $entity);
        }

        foreach (scandir(__DIR__.'/../../src/Entity/Response') as $entityName) {
            if (in_array($entityName, ['.', '..']) || is_dir(__DIR__."/../../src/Entity/Response/$entityName")) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\ThirtyBees\\PostNL\\Entity\\Response\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\ThirtyBees\\PostNL\\Entity\\AbstractEntity", $entity);
        }
    }

    /**
     * @testdox should throw an exception when the value to set is missing
     */
    public function testNegativeMissingValue()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        (new Address())
            ->setArea()
        ;
    }

    /**
     * @testdox should be `null` when instantiating the AbstractEntity
     *
     * @throws \ReflectionException
     */
    public function testNegativeCannotInstantiateAbstract()
    {
        $this->assertNull(AbstractEntity::create());
    }

    /**
     * @testdox should return `null` when the property does not exist
     */
    public function testNegativeReturnNullWhenPropertyDoesNotExist()
    {
        $this->assertNull((new Address())->getNothing());
    }

    /**
     * @testdox should throw an exception when the method does not exist
     */
    public function testNegativeThrowExceptionWhenMethodDoesNotExist()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        (new Address())->blab();
    }

    /**
     * @testdox should throw an exception when json serializing without having a service
     */
    public function testNegativeThrowExceptionWhenServiceNotSetJson()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        json_encode(new Address());
    }

    /**
     * @testdox should throw an exception when xml serializing without having a service
     */
    public function testNegativeThrowExceptionWhenServiceNotSetXml()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        $service = new XmlService();

        $service->write('{test}a',
            new Address()
        );
    }
}
