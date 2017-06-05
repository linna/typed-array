<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\stringArray;
use PHPUnit\Framework\TestCase;

class stringArrayTest extends TestCase
{
    public function testCreateInstance()
    {
        $this->assertInstanceOf(stringArray::class, (new stringArray(['a', 'b', 'c', 'd', 'e'])));
    }

    public function BadArgumentsProvider()
    {
        return [
            [[null, null, null]],
            [[true, false, true]],
            [[1, 2, 3]],
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
        (new stringArray($array));
    }

    public function testArrayStyleAssign()
    {
        $intArray = new stringArray(['a', 'b', 'c', 'd']);
        $intArray[] = 'e';

        $this->assertEquals(5, $intArray->count());
    }

    public function BadValueProvider()
    {
        return [
            [null],
            [true],
            [1],
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
        $intArray = new stringArray(['a', 'b', 'c', 'd']);
        $intArray[] = $value;
    }
}
