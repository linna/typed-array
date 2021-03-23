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

use InvalidArgumentException;
use Linna\TypedArrayObject\ArrayArrayObject;
use PHPUnit\Framework\TestCase;

/**
 * Array Array Object Test.
 */
class ArrayArrayObjectTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(ArrayArrayObject::class, (new ArrayArrayObject()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(ArrayArrayObject::class, (new ArrayArrayObject([[1,2,3],[4,5,6],[7,8,9]])));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $arrayArray = new ArrayArrayObject();
        $arrayArray[] = [1,2,3];
        
        $this->assertSame(1, $this->count($arrayArray));
        $this->assertSame([1,2,3], $arrayArray[0]);
    }
    
    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $arrayArray = new ArrayArrayObject();
        $arrayArray->append([1,2,3]);
        
        $this->assertSame(1, $this->count($arrayArray));
        $this->assertSame([1,2,3], $arrayArray[0]);
    }
    
    /**
     * Provide invalid typed arrays.
     *
     * @return array
     */
    public function invalidArrayProvider(): array
    {
        return [
            //[[[1], [2]]], //array
            [[true, false]], //bool
            [[function () {}, function () {}]], //callable
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
        
        $arrayArray = new ArrayArrayObject($array);
    }

    /**
     * Provide invalid values.
     *
     * @return array
     */
    public function invalidValueProvider(): array
    {
        return [
            //[[1]], //array
            [true], //bool
            [function () {}], //callable
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
     
        $arrayArray = new ArrayArrayObject();
        $arrayArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     * 
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $arrayArray = new ArrayArrayObject();
        $arrayArray->append($value);
    }
}
