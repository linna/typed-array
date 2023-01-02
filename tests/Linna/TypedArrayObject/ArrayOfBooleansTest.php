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
 * Bool Array Object Test.
 */
class ArrayOfBooleansTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayOfBooleans::class, (new ArrayOfBooleans()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(ArrayOfBooleans::class, (new ArrayOfBooleans([true,true,true,false])));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $boolArray = new ArrayOfBooleans();
        $boolArray[] = false;

        $this->assertSame(1, $this->count($boolArray));
        $this->assertSame(false, $boolArray[0]);
    }

    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $boolArray = new ArrayOfBooleans();
        $boolArray->append(false);

        $this->assertSame(1, $this->count($boolArray));
        $this->assertSame(false, $boolArray[0]);
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

        (new ArrayOfBooleans($array));
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

        $boolArray = new ArrayOfBooleans();
        $boolArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfBooleans())->append($value);
    }
}
