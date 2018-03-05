<?php

namespace ThirtyBees\PostNL\Tests\Entity;

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
}
