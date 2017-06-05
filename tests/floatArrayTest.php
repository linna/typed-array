<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\floatArray;
use PHPUnit\Framework\TestCase;

class floatArrayTest extends TestCase
{
    public function testCreateInstance()
    {
        $this->assertInstanceOf(floatArray::class, (new floatArray([1.1, 2.2, 3.3, 4.4, 5.5])));
    }

    public function BadArgumentsProvider()
    {
        return [
            [[null, null, null]],
            [[true, false, true]],
            [['a', 'b', 'c']],
            [[1, 2, 3]],
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
        (new floatArray($array));
    }

    public function testArrayStyleAssign()
    {
        $intArray = new floatArray([1.1, 2.2, 3.3, 4.4]);
        $intArray[] = 5.5;

        $this->assertEquals(5, $intArray->count());
    }

    public function BadValueProvider()
    {
        return [
            [null],
            [true],
            ['e'],
            [1],
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
        $intArray = new floatArray([1.1, 2.2, 3.3, 4.4]);
        $intArray[] = $value;
    }
}
