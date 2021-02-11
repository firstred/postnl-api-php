<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Unit\Entity;

use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Service\CheckoutServiceInterface;
use function array_keys;
use Error;
use Firstred\PostNL\Attribute\RequestProp;
use Firstred\PostNL\Attribute\ResponseProp;
use Firstred\PostNL\DTO\Request\GenerateBarcodeRequestDTO;
use Firstred\PostNL\DTO\Response\GenerateBarcodeResponseDTO;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Misc\SerializableObject;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use function is_a;
use LogicException;
use function method_exists;
use PHPUnit\Framework\TestCase;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

/**
 * @testdox The Entities
 */
class EntityTest extends TestCase
{
    /**
     * @testdox Should be able to find serializable properties
     *
     * @throws InvalidArgumentException
     */
    public function testCanFindAllSerializableProperties()
    {
        $generateBarcode = new GenerateBarcodeRequestDTO(
            service: BarcodeServiceInterface::class,
            propType: RequestProp::class,

            Type: 'test',
            Serie: 'test',
            Range: 'test',
        );

        $this->assertEqualsCanonicalizing(
            expected: ['Type', 'Serie', 'Range'],
            actual: $generateBarcode->getSerializableProps(asStrings: true),
        );
    }

    /**
     * @testdox Should be able to find serializable properties
     *
     * @throws InvalidArgumentException
     */
    public function testCanFindRequiredSerializableProperties()
    {
        $generateBarcode = new GenerateBarcodeRequestDTO(
            service: BarcodeServiceInterface::class,
            propType: RequestProp::class,

            Type: 'test',
            Serie: 'test',
            Range: 'test',
        );

        $this->assertEqualsCanonicalizing(
            expected: ['Type'],
            actual: $generateBarcode->getSerializableProps(asStrings: true, required: true),
        );
    }

    /**
     * @testdox Properties should have dedicated getters and setters
     *
     * @throws ReflectionException
     */
    public function testConstructorParametersHaveGettersAndSetters()
    {
        $classmap = array_keys(array: include __DIR__.'/../../../vendor/composer/autoload_classmap.php');
        foreach ($classmap as $class) {
            try {
                if (is_a(object_or_class: $class, class: SerializableObject::class, allow_string: true)
                    && SerializableObject::class !== $class
                ) {
                    $reflectionClass = new ReflectionClass(objectOrClass: $class);
                    foreach ($reflectionClass->getConstructor()->getParameters() as $reflectionParameter) {
                        if (in_array(needle: $reflectionParameter->getName(), haystack: ['service', 'propType', 'cacheKey'])) {
                            continue;
                        }

                        $this->assertTrue(
                            condition: method_exists(object_or_class: $class, method: "get{$reflectionParameter->getName()}"),
                            message: "Class `$class` does not have required the method `get{$reflectionParameter->getName()}`",
                        );
                        $this->assertTrue(
                            condition: method_exists(object_or_class: $class, method: "set{$reflectionParameter->getName()}"),
                            message: "Class `$class` does not have required the method `set{$reflectionParameter->getName()}`",
                        );
                    }
                }
            } catch (Error | LogicException) {
            }
        }
    }

    /**
     * @testdox Properties should have dedicated getters and setters
     *
     * @throws ReflectionException
     */
    public function testPropsHaveGettersAndSetters()
    {
        $classmap = array_keys(array: include __DIR__.'/../../../vendor/composer/autoload_classmap.php');
        foreach ($classmap as $class) {
            try {
                if (is_a(object_or_class: $class, class: SerializableObject::class, allow_string: true)
                    && SerializableObject::class !== $class
                ) {
                    $reflectionClass = new ReflectionClass(objectOrClass: $class);
                    foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                        $requestPropReflectionAttribute = $reflectionProperty->getAttributes(name: RequestProp::class)[0]   ?? null;
                        $responsePropReflectionAttribute = $reflectionProperty->getAttributes(name: ResponseProp::class)[0] ?? null;
                        if (!$requestPropReflectionAttribute instanceof ReflectionAttribute
                            && !$responsePropReflectionAttribute instanceof ReflectionAttribute
                        ) {
                            continue;
                        }
                        $this->assertTrue(
                            condition: method_exists(object_or_class: $class, method: "get{$reflectionProperty->getName()}"),
                            message: "Class `$class` does not have required the method `get{$reflectionProperty->getName()}`",
                        );
                        $this->assertTrue(
                            condition: method_exists(object_or_class: $class, method: "set{$reflectionProperty->getName()}"),
                            message: "Class `$class` does not have required the method `set{$reflectionProperty->getName()}`",
                        );
                    }
                }
            } catch (Error | LogicException) {
            }
        }
    }

    /**
     * @testdox Setters should accept the property as first parameter
     *
     * @throws ReflectionException
     */
    public function testFirstSetterParameterIsProp()
    {
        $classmap = array_keys(array: include __DIR__.'/../../../vendor/composer/autoload_classmap.php');
        foreach ($classmap as $class) {
            try {
                if (is_a(object_or_class: $class, class: SerializableObject::class, allow_string: true)
                    && SerializableObject::class !== $class
                ) {
                    $reflectionClass = new ReflectionClass(objectOrClass: $class);
                    foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                        $requestPropReflectionAttribute = $reflectionProperty->getAttributes(name: RequestProp::class)[0]   ?? null;
                        $responsePropReflectionAttribute = $reflectionProperty->getAttributes(name: ResponseProp::class)[0] ?? null;
                        if (!$requestPropReflectionAttribute instanceof ReflectionAttribute
                            && !$responsePropReflectionAttribute instanceof ReflectionAttribute
                        ) {
                            continue;
                        }

                        $reflectionSetterMethod = $reflectionClass->getMethod(name: "set{$reflectionProperty->getName()}");
                        $this->assertTrue(
                            condition: $reflectionSetterMethod->getParameters()[0]->getName() === $reflectionProperty->getName(),
                            message: "Method `$class::{$reflectionSetterMethod->getName()}()` does not accept the property as a first named argument, the parameter is called `{$reflectionSetterMethod->getParameters()[0]->getName()}`",
                        );
                    }
                }
            } catch (Error | LogicException) {
            }
        }
    }

    /**
     * @testdox Should be able to create a valid serializable object
     *
     * @throws InvalidArgumentException
     */
    public function testCanCreateValidSerializableObject()
    {
        $generateBarcodeResponseDTO = new GenerateBarcodeResponseDTO(
            service: BarcodeServiceInterface::class,
            propType: ResponseProp::class,

            Barcode: 'test',
        );

        $this->assertTrue(condition: $generateBarcodeResponseDTO->isValid());
    }

    /**
     * @testdox Should be able to find both required and optional serializable props
     *
     * @throws InvalidArgumentException
     */
    public function testCanFindBothRequiredAndOptionalSerializableProps()
    {
        $address = new Address(
            service: CheckoutServiceInterface::class,
            propType: RequestProp::class,

            AddressType: '01',
            Countrycode: 'NL',
            HouseNr: 42,
            Street: 'Teststraat',
            Zipcode: '2132WT',
        );

        $this->assertEquals(
            expected: [
                'AddressType',
                'City',
                'Countrycode',
                'HouseNr',
                'HouseNrExt',
                'Street',
                'Zipcode',
            ],
            actual: $address->getSerializableProps(asStrings: true),
        );
    }

    /**
     * @testdox Should be able to serialize an object
     *
     * @throws InvalidArgumentException
     */
    public function testCanJsonSerializeObject()
    {
        $generateBarcode = new GenerateBarcodeRequestDTO(
            service: BarcodeServiceInterface::class,
            propType: RequestProp::class,

            Type: 'test',
            Serie: 'test',
        );

        $this->assertEquals(
            expected: [
                'Type'  => 'test',
                'Serie' => 'test',
            ],
            actual: $generateBarcode->jsonSerialize(),
        );
    }
}
