<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\Tests;

use ArrayObject;
use InvalidArgumentException;
use Linna\TypedArrayObject\TypedArray;
use PHPUnit\Framework\TestCase;
use SplStack;

/**
 * Typed Array Test.
 */
class TypedArrayTest extends TestCase
{
    /**
     * Provide allowed types.
     *
     * @return array
     */
    public function allowedTypeProvider()
    {
        return [
            ['array'],
            ['bool'],
            ['callable'],
            ['float'],
            ['int'],
            ['object'],
            ['string'],
        ];
    }

    /**
     * Test new instance.
     *
     * @dataProvider allowedTypeProvider
     */
    public function testNewInstance($type)
    {
        $this->assertInstanceOf(TypedArray::class, (new TypedArray($type)));
    }

    /**
     * Test new instance with not allowed type.
     */
    public function testNewInstanceWithNotAllowedType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertInstanceOf(TypedArray::class, (new TypedArray('notAllowedType')));
    }

    /**
     * Provide arrays of right typed values.
     *
     * @return array
     */
    public function rightTypedArrayProvider()
    {
        return [
            ['array', [[1], [2]]],
            ['bool', [true, false]],
            ['callable', [function () {
            }, function () {
            }]],
            ['float', [1.1, 2.2]],
            ['int', [1, 2]],
            ['object', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
            ['string', ['a', 'b']],
        ];
    }

    /**
     * Test new instance passing right typed array to constructor.
     *
     * @dataProvider rightTypedArrayProvider
     */
    public function testCreateInstanceWithRightTypedArray($type, $array)
    {
        $this->assertInstanceOf(TypedArray::class, (new TypedArray($type, $array)));
    }

    /**
     * Provide arrays of wrong typed values.
     *
     * @return array
     */
    public function wrongTypedArrayProvider()
    {
        return [
            ['array', [true, false]],
            ['array', [function () {
            }, function () {
            }]],
            ['array', [1.1, 2.2]],
            ['array', [1, 2]],
            ['array', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
            ['array', ['a', 'b']],

            ['bool', [[1], [2]]],
            ['bool', [function () {
            }, function () {
            }]],
            ['bool', [1.1, 2.2]],
            ['bool', [1, 2]],
            ['bool', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
            ['bool', ['a', 'b']],

            ['callable', [[1], [2]]],
            ['callable', [true, false]],
            ['callable', [1.1, 2.2]],
            ['callable', [1, 2]],
            ['callable', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
            ['callable', ['a', 'b']],

            ['float', [[1], [2]]],
            ['float', [true, false]],
            ['float', [function () {
            }, function () {
            }]],
            ['float', [1, 2]],
            ['float', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
            ['float', ['a', 'b']],

            ['int', [[1], [2]]],
            ['int', [true, false]],
            ['int', [function () {
            }, function () {
            }]],
            ['int', [1.1, 2.2]],
            ['int', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
            ['int', ['a', 'b']],

            ['object', [[1], [2]]],
            ['object', [true, false]],
            //skip this because closure pass as object
            //['object', [function(){}, function(){}]],
            ['object', [1.1, 2.2]],
            ['object', [1, 2]],
            ['object', ['a', 'b']],

            ['string', [[1], [2]]],
            ['string', [true, false]],
            ['string', [function () {
            }, function () {
            }]],
            ['string', [1.1, 2.2]],
            ['string', [1, 2]],
            ['string', [(object) ['name' => 'foo'], (object) ['name' => 'bar']]],
        ];
    }

    /**
     * Test new instance passing array with invalid element to constructor.
     *
     * @dataProvider wrongTypedArrayProvider
     */
    public function testCreateInstanceWithWrongTypedArray($type, $array)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertInstanceOf(TypedArray::class, (new TypedArray($type, $array)));
    }

    /**
     * Provide values of right types.
     *
     * @return array
     */
    public function rightTypedValueProvider()
    {
        return [
            ['array', [1]],
            ['bool', true],
            ['callable', function () {
            }],
            ['float', 1.1],
            ['int', 1],
            ['object', (object) ['name' => 'foo']],
            ['string', 'a'],
        ];
    }

    /**
     * Test assign to array a right typed value.
     *
     * @dataProvider rightTypedValueProvider
     */
    public function testAssignrRightTypedValueToArray($type, $value)
    {
        $array = new TypedArray($type);
        $array[] = $value;

        $this->assertEquals(1, $array->count());
    }

    /**
     * Provide values of wrong types.
     *
     * @return array
     */
    public function wrongTypedValueProvider()
    {
        return [
            ['array', true],
            ['array', function () {
            }],
            ['array', 1.1],
            ['array', 1],
            ['array', (object) ['name' => 'foo']],
            ['array', 'a'],

            ['bool', [1]],
            ['bool', function () {
            }],
            ['bool', 1.1],
            ['bool', 1],
            ['bool', (object) ['name' => 'foo']],
            ['bool', 'a'],

            ['callable', [1]],
            ['callable', true],
            ['callable', 1.1],
            ['callable', 1],
            ['callable', (object) ['name' => 'foo']],
            ['callable', 'a'],

            ['float', [1]],
            ['float', true],
            ['float', function () {
            }],
            ['float', 1],
            ['float', (object) ['name' => 'foo']],
            ['float', 'a'],

            ['int', [1]],
            ['int', true],
            ['int', function () {
            }],
            ['int', 1.1],
            ['int', (object) ['name' => 'foo']],
            ['int', 'a', 'b'],

            ['object', [1]],
            ['object', true],
            //skip this because closure pass as object
            //['object',[function(){}, function(){}]],
            ['object', 1.1],
            ['object', 1],
            ['object', 'a'],

            ['string', [1]],
            ['string', true],
            ['string', function () {
            }],
            ['string', 1.1],
            ['string', 1],
            ['string', (object) ['name' => 'foo']],
        ];
    }

    /**
     * Test assign to array a wrong typed value.
     *
     * @dataProvider wrongTypedValueProvider
     */
    public function testAssignWrongTypedValueToArray($type, $value)
    {
        $this->expectException(InvalidArgumentException::class);

        $array = new TypedArray($type);
        $array[] = $value;
    }

    /**
     * Test iterator.
     */
    public function testIteratorClass()
    {
        $arrayAsParam = ['a','b','c','d','e','f','g','h','i'];
        $array = new TypedArray('string', $arrayAsParam);

        $this->assertEquals($arrayAsParam, \iterator_to_array($array));
    }

    /**
     * Test new instance with not existent class.
     */
    public function testCreateInstanceWithNotExistentClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertInstanceOf(TypedArray::class, (new TypedArray(ArrayBadObject::class)));
    }

    /**
     * Test new instance passing right typed array to constructor.
     */
    public function testCreateInstanceWithRightObjectTypedArray()
    {
        $this->assertInstanceOf(
            TypedArray::class,
            (
                new TypedArray(
                    ArrayObject::class,
                    [
                    new ArrayObject([1, 2, 3]),
                    new ArrayObject([1.1, 2.2, 3.3]),
                    new ArrayObject(['a', 'b', 'c']),
                ]
                )
            )
        );
    }

    /**
     * Test new instance passing array with invalid element to constructor.
     */
    public function testCreateInstanceWithWrongObjectTypedArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertInstanceOf(
            TypedArray::class,
            (
                new TypedArray(
                    ArrayObject::class,
                    [
                    new ArrayObject([1, 2, 3]),
                    new ArrayObject([1.1, 2.2, 3.3]),
                    new SplStack(),
                ]
                )
            )
        );
    }

    /**
     * Test assign to array a right typed value.
     */
    public function testAssignrRightTypedObjectValueToArray()
    {
        $array = new TypedArray(ArrayObject::class);
        $array[] = new ArrayObject([1, 2, 3]);

        $this->assertEquals(1, $array->count());
    }

    /**
     * Test assign to array a wrong typed value.
     */
    public function testAssignWrongTypedObjectValueToArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $array = new TypedArray(ArrayObject::class);
        $array[] = new SplStack();
    }

    /**
     * Test iterator.
     */
    public function testObjectIteratorClass()
    {
        $arrayAsParam = [
            new ArrayObject([1, 2, 3]),
            new ArrayObject(['1', '2', '3']),
            new ArrayObject([true, false, null]),
            new ArrayObject([1.0, 2.0, 3.0])
        ];

        $array = new TypedArray(ArrayObject::class, $arrayAsParam);

        foreach ($array as $key => $value) {
            $this->assertEquals($value, $arrayAsParam[$key]);
        }
    }
}
