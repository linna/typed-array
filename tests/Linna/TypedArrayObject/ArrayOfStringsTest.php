<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\TypedArrayObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * String Array Object Test.
 */
class ArrayOfStringsTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayOfStrings::class, (new ArrayOfStrings()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(ArrayOfStrings::class, (new ArrayOfStrings(['a','b','c','d','e','f','g','h','i'])));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $stringArray = new ArrayOfStrings();
        $stringArray[] = 'a';

        $this->assertSame(1, $this->count($stringArray));
        $this->assertSame('a', $stringArray[0]);
    }

    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $stringArray = new ArrayOfStrings();
        $stringArray->append('a');

        $this->assertSame(1, $this->count($stringArray));
        $this->assertSame('a', $stringArray[0]);
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
            [[1, 2]], //int
            [[(object) ['name' => 'foo'], (object) ['name' => 'bar']]], //object
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

        (new ArrayOfStrings($array));
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
            [1], //int
            [(object) ['name' => 'foo']], //object
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

        $stringArray = new ArrayOfStrings();
        $stringArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     *
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArrayOfStrings())->append($value);
    }
}
