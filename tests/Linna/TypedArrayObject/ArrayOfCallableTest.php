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
 * Callable Array Object Test.
 */
class ArrayOfCallableTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayOfCallable::class, (new ArrayOfCallable()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(ArrayOfCallable::class, (new ArrayOfCallable([function ($e) {
            return $e+1;
        }])));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $callableArray = new ArrayOfCallable();
        $callableArray[] = function ($e) {
            return $e+1;
        };

        $this->assertSame(1, $this->count($callableArray));
        $this->assertSame(true, \is_callable($callableArray[0]));
    }

    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $callableArray = new ArrayOfCallable();
        $callableArray->append(function ($e) {
            return $e+1;
        });

        $this->assertSame(1, $this->count($callableArray));
        $this->assertSame(true, \is_callable($callableArray[0]));
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

        (new ArrayOfCallable($array));
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

        $callableArray = new ArrayOfCallable();
        $callableArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfCallable())->append($value);
    }
}
