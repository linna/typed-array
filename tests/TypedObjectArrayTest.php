<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\TypedObjectArray;
use PHPUnit\Framework\TestCase;

/**
 * Typed Object Array Test
 */
class TypedObjectArrayTest extends TestCase
{
    /**
     * Test new instance.
     */
    public function testCreateInstance()
    {
        $this->assertInstanceOf(TypedObjectArray::class, (new TypedObjectArray(ArrayObject::class)));
    }
    
    /**
     * Test new instance with not existent class.
     *
     * @expectedException InvalidArgumentException
     */
    public function testCreateInstanceWithNotExistentClass()
    {
        $this->assertInstanceOf(TypedObjectArray::class, (new TypedObjectArray(ArrayBadObject::class)));
    }
    
    /**
     * Test new instance passing right typed array to constructor.
     */
    public function testCreateInstanceWithRightTypedArray()
    {
        $this->assertInstanceOf(
            TypedObjectArray::class, 
            (new TypedObjectArray(
                ArrayObject::class, [
                    new ArrayObject([1,2,3]),
                    new ArrayObject([1.1,2.2,3.3]),
                    new ArrayObject(['a','b','c'])
                ])
            )
        );
    }
    
    /**
     * Test new instance passing array with invalid element to constructor.
     *
     * @expectedException InvalidArgumentException
     */
    public function testCreateInstanceWithWrongTypedArray()
    {
        $this->assertInstanceOf(
            TypedObjectArray::class, 
            (new TypedObjectArray(
                ArrayObject::class, [
                    new ArrayObject([1,2,3]),
                    new ArrayObject([1.1,2.2,3.3]),
                    new SplStack()
                ])
            )
        );
    }
    
    /**
     * Test assign to array a right typed value.
     */
    public function testAssignrRightTypedValueToArray()
    {
        $array = new TypedObjectArray(ArrayObject::class);
        $array[] = new ArrayObject([1,2,3]);

        $this->assertEquals(1, $array->count());
    }
    
    /**
     * Test assign to array a wrong typed value.
     *
     * @expectedException InvalidArgumentException
     */
    public function testAssignWrongTypedValueToArray()
    {
        $array = new TypedObjectArray(ArrayObject::class);
        $array[] = new SplStack();
    }
}
