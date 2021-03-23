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
use Linna\TypedArrayObject\FloatArrayObject;
use PHPUnit\Framework\TestCase;

/**
 * Int Array Object Test.
 */
class FloatArrayObjectTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(FloatArrayObject::class, (new FloatArrayObject()));
    }

    /**
     * Test new instance with valid argument.
     */
    public function testNewInstanceWithValidArgument(): void
    {
        $this->assertInstanceOf(FloatArrayObject::class, (new FloatArrayObject([1.1,2.2,3.3,4.4,5.5])));
    }

    /**
     * Test set value with valid argument.
     */
    public function testSetValueWithValidArgument(): void
    {
        $floatArray = new FloatArrayObject();
        $floatArray[] = 1.1;
        
        $this->assertSame(1, $this->count($floatArray));
        $this->assertSame(1.1, $floatArray[0]);
    }
    
    /**
     * Test append value with valid argument.
     */
    public function testAppendValueWithValidArgument(): void
    {
        $floatArray = new FloatArrayObject();
        $floatArray->append(1.1);
        
        $this->assertSame(1, $this->count($floatArray));
        $this->assertSame(1.1, $floatArray[0]);
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
            [[function () {}, function () {}]], //callable
            //[[1.1, 2.2]], //float
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
        
        $floatArray = new FloatArrayObject($array);
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
            [function () {}], //callable
            //[1.1], //float
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
     
        $floatArray = new FloatArrayObject();
        $floatArray[] = $value;
    }

    /**
     * Test append value with invalid argument.
     * 
     * @dataProvider invalidValueProvider
     */
    public function testAppendValueWithInvalidArgument($value): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $floatArray = new FloatArrayObject();
        $floatArray->append($value);
    }
}
