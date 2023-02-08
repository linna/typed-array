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

use ArrayObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Int Array Object Test.
 */
class ArrayOfClassesTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayOfClasses::class, (new ArrayOfClasses(ArrayObject::class)));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $array = [
            (new ArrayObject()),
            (new ArrayObject()),
            (new ArrayObject())
        ];

        $this->assertInstanceOf(ArrayOfClasses::class, (new ArrayOfClasses(ArrayObject::class, $array)));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $object = new ArrayObject();

        $classArray = new ArrayOfClasses(ArrayObject::class);
        $classArray[] = $object;

        $this->assertSame(1, $this->count($classArray));
        $this->assertSame($object, $classArray[0]);
    }

    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $object = new ArrayObject();

        $classArray = new ArrayOfClasses(ArrayObject::class);
        $classArray->append($object);

        $this->assertSame(1, $this->count($classArray));
        $this->assertSame($object, $classArray[0]);
    }

    /**
     * Provide invalid typed arrays.
     *
     * @return array
     */
    public static function invalidArrayProvider(): array
    {
        return [
            [[[1], [2]]], //array
            [[true, false]], //bool
            [[function () {
            }, function () {
            }]], //callable
            [[1.1, 2.2]], //float
            [[1, 2]], //int
            [[(object) ['name' => 'foo'], (object) ['name' => 'bar']]], //object
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

        (new ArrayOfClasses(ArrayObject::class, $array));
    }

    /**
     * Provide invalid values.
     *
     * @return array
     */
    public static function invalidValueProvider(): array
    {
        return [
            [[1]], //array
            [true], //bool
            [function () {
            }], //callable
            [1.1], //float
            [1], //int
            [(object) ['name' => 'foo']], //object
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

        $classArray = new ArrayOfClasses(ArrayObject::class);
        $classArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfClasses(ArrayObject::class))->append($value);
    }
}
