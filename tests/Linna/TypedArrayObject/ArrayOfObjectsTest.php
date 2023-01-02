<?php

declare(strict_types=1);

/**
 * This file is part of the Linna Typed ArrayObject.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace Linna\TypedArrayObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Int Array Object Test.
 */
class ArrayOfObjectsTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayOfObjects::class, (new ArrayOfObjects()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(ArrayOfObjects::class, (new ArrayOfObjects([(object)["name" => "test"]])));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $object = (object) ["foo" => 1, "bar" => 2,"baz" => 3];

        $objectArray = new ArrayOfObjects();
        $objectArray[] = $object;

        $this->assertSame(1, $this->count($objectArray));
        $this->assertSame($object, $objectArray[0]);
    }

    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $object = (object) ["foo" => 1, "bar" => 2,"baz" => 3];

        $objectArray = new ArrayOfObjects();
        $objectArray->append($object);

        $this->assertSame(1, $this->count($objectArray));
        $this->assertSame($object, $objectArray[0]);
    }

    /**
     * Provide invalid typed arrays.
     *
     * @return array
     */
    public function invalidArrayProvider(): array
    {
        return [
            [[[1], [2]]], //array
            [[true, false]], //bool
            [[1.1, 2.2]], //float
            [[1, 2]], //int
            [['a', 'b']], //string
        ];
    }

    /**
     * Test new instance with invalid argument.
     *
     * @dataProvider invalidArrayProvider
     */
    public function testNewInstanceWithInvalidArgument(array $array): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfObjects($array));
    }

    /**
     * Provide invalid values.
     *
     * @return array
     */
    public function invalidValueProvider(): array
    {
        return [
            [[1]], //array
            [true], //bool
            [1.1], //float
            [1], //int
            ['a'], //string
        ];
    }

    /**
     * Test set value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testSetValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        $objectArray = new ArrayOfObjects();
        $objectArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfObjects())->append($value);
    }
}
