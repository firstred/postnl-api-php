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
            if (in_array($entityName, ['.', '..', 'AbstractEntity.php']) || is_dir(__DIR__.'/../../src/Entity/'.$entityName)) {
                continue;
            }

            $entityName = substr($entityName, 0, strlen($entityName) - 4);
            $entityName = "\\ThirtyBees\\PostNL\\Entity\\$entityName";
            $entity = new $entityName();
            $this->assertInstanceOf("\\ThirtyBees\\PostNL\\Entity\\AbstractEntity", $entity);
        }
    }

    /**
     * @testdox should throw an exception when the value to set is missing
     *
     * @throws \ReflectionException
     */
    public function testNegativeMissingValue()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        $address = Address::create();
        $address->setArea();
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
     *
     * @throws \ReflectionException
     */
    public function testNegativeReturnNullWhenPropertyDoesNotExist()
    {
        $this->assertNull((Address::create())->getNothing());
    }

    /**
     * @testdox should throw an exception when the method does not exist
     *
     * @throws \ReflectionException
     */
    public function testNegativeThrowExceptionWhenMethodDoesNotExist()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        (Address::create())->blab();
    }

    /**
     * @testdox should throw an exception when json serializing without having a service
     *
     * @throws \ReflectionException
     */
    public function testNegativeThrowExceptionWhenServiceNotSetJson()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        json_encode(Address::create());
    }

    /**
     * @testdox should throw an exception when xml serializing without having a service
     *
     * @throws \ReflectionException
     */
    public function testNegativeThrowExceptionWhenServiceNotSetXml()
    {
        $this->expectException('\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException');

        $service = new XmlService();

        $service->write('{test}a',
            Address::create()
        );
    }
}
