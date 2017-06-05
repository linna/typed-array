<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\intArray;
use PHPUnit\Framework\TestCase;

class intArrayTest extends TestCase
{
    public function testCreateInstance()
    {
        $this->assertInstanceOf(intArray::class, (new intArray([1, 2, 3, 4, 5])));
    }

    public function BadArgumentsProvider()
    {
        return [
            [[null, null, null]],
            [[true, false, true]],
            [['a', 'b', 'c']],
            [[1.1, 2.1, 3.1]],
            [[[1], [2], [3]]],
            [[(object) [1], (object) [2], (object) [3]]],
            [[function () {
            }, function () {
            }]],
        ];
    }

    /**
     * @dataProvider BadArgumentsProvider
     * @expectedException TypeError
     */
    public function testCreateInstanceWithBadArray($array)
    {
        (new intArray($array));
    }

    public function testArrayStyleAssign()
    {
        $intArray = new intArray([1, 2, 3, 4]);
        $intArray[] = 6;

        $this->assertEquals(5, $intArray->count());
    }

    public function BadValueProvider()
    {
        return [
            [null],
            [true],
            ['e'],
            [1.1],
            [[1]],
            [(object) [1]],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider BadArgumentsProvider
     * @expectedException TypeError
     */
    public function testArrayStyleAssignBadValue($value)
    {
        $intArray = new intArray([1, 2, 3, 4]);
        $intArray[] = $value;
    }
}
