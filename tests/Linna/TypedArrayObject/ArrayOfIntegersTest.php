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
class ArrayOfIntegersTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayOfIntegers::class, (new ArrayOfIntegers()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(ArrayOfIntegers::class, (new ArrayOfIntegers([1,2,3,4,5,6,7,8,9,0])));
    }

    /**
     * Test new instance with valid argument and check values.
     */
    public function testNewInstanceWithValidArgumentAndCheck(): void
    {
        $intArray = new ArrayOfIntegers([10,20,30,40,50,60,70,80,90,100]);

        $this->assertSame(10, $intArray[0]);
        $this->assertSame(20, $intArray[1]);
        $this->assertSame(30, $intArray[2]);
        $this->assertSame(40, $intArray[3]);
        $this->assertSame(50, $intArray[4]);
        $this->assertSame(60, $intArray[5]);
        $this->assertSame(70, $intArray[6]);
        $this->assertSame(80, $intArray[7]);
        $this->assertSame(90, $intArray[8]);
        $this->assertSame(100, $intArray[9]);
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $intArray = new ArrayOfIntegers();
        $intArray[] = 1;

        $this->assertSame(1, $this->count($intArray));
        $this->assertSame(1, $intArray[0]);
    }

    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $intArray = new ArrayOfIntegers();
        $intArray->append(1);

        $this->assertSame(1, $this->count($intArray));
        $this->assertSame(1, $intArray[0]);
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
            [[function () {
            }, function () {
            }]], //callable
            [[1.1, 2.2]], //float
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

        (new ArrayOfIntegers($array));
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
            [function () {
            }], //callable
            [1.1], //float
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

        $intArray = new ArrayOfIntegers();
        $intArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfIntegers())->append($value);
    }
}
