<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\TypedArray;
use PHPUnit\Framework\TestCase;

/**
 * Typed Array Test
 */
class TypedArrayTest extends TestCase
{
    /**
     * Provide allowed types.
     * 
     * @return array
     */
    function allowedTypeProvider()
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
    public function testCreateInstance($type)
    {
        $this->assertInstanceOf(TypedArray::class, (new TypedArray($type)));
    }
    
    /**
     * Test new instance with not allowed type.
     *
     * @expectedException InvalidArgumentException
     */
    public function testCreateInstanceWithNotAllowedType()
    {
        $this->assertInstanceOf(TypedArray::class, (new TypedArray('notAllowedType')));
    }
    
    
    /**
     * Provide arrays of right typed values.
     * 
     * @return array
     */
    function rightTypedArrayProvider()
    {
        return [
            ['array', [[1],[2]]], //array of arrays
            ['bool', [true, false]], //array of bools
            ['callable', [function(){}, function(){}]], //aaray of callables
            ['float', [1.1, 2.2]], //array of floats
            ['int', [1, 2]], //array of integers
            ['object', [(object)['name' => 'foo'], (object)['name' => 'bar']]], //array of objects
            ['string', ['a', 'b']], //array of strings
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
    function wrongTypedArrayProvider()
    {
        return [
            ['array', [true, false]],
            ['array', [function(){}, function(){}]],
            ['array', [1.1, 2.2]],
            ['array', [1, 2]],
            ['array', [(object)['name' => 'foo'], (object)['name' => 'bar']]],
            ['array', ['a', 'b']],
            
            ['bool', [[1],[2]]],
            ['bool', [function(){}, function(){}]],
            ['bool', [1.1, 2.2]],
            ['bool', [1, 2]],
            ['bool', [(object)['name' => 'foo'], (object)['name' => 'bar']]],
            ['bool', ['a', 'b']],
            
            ['callable', [[1],[2]]],
            ['callable', [true, false]],
            ['callable', [1.1, 2.2]],
            ['callable', [1, 2]],
            ['callable', [(object)['name' => 'foo'], (object)['name' => 'bar']]],
            ['callable', ['a', 'b']],        
            
            ['float', [[1],[2]]],
            ['float', [true, false]],
            ['float', [function(){}, function(){}]],
            ['float', [1, 2]],
            ['float', [(object)['name' => 'foo'], (object)['name' => 'bar']]],
            ['float', ['a', 'b']],
            
            ['int', [[1],[2]]],
            ['int', [true, false]],
            ['int', [function(){}, function(){}]],
            ['int', [1.1, 2.2]],
            ['int', [(object)['name' => 'foo'], (object)['name' => 'bar']]],
            ['int', ['a', 'b']],
                    
            ['object', [[1],[2]]],
            ['object', [true, false]],
            //skip this because closure pass as object
            //['object', [function(){}, function(){}]],
            ['object', [1.1, 2.2]],
            ['object', [1, 2]],
            ['object', ['a', 'b']],
                    
            ['string', [[1],[2]]],
            ['string', [true, false]],
            ['string', [function(){}, function(){}]],
            ['string', [1.1, 2.2]],
            ['string', [1, 2]],
            ['string', [(object)['name' => 'foo'], (object)['name' => 'bar']]],
        ];
    }
    
    /**
     * Test new instance passing array with invalid element to constructor.
     *
     * @dataProvider wrongTypedArrayProvider
     * @expectedException InvalidArgumentException
     */
    public function testCreateInstanceWithWrongTypedArray($type, $array)
    {
        $this->assertInstanceOf(TypedArray::class, (new TypedArray($type, $array)));
    }
    
    /**
     * Provide values of right types.
     * 
     * @return array
     */
    function rightTypedValueProvider()
    {
        return [
            ['array',[1]],
            ['bool', true],
            ['callable', function(){}],
            ['float', 1.1],
            ['int', 1],
            ['object',(object)['name' => 'foo']],
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
    function wrongTypedValueProvider()
    {
        return [
            ['array', true],
            ['array', function(){}],
            ['array', 1.1],
            ['array', 1],
            ['array', (object)['name' => 'foo']],
            ['array', 'a'],
            
            ['bool', [1]],
            ['bool', function(){}],
            ['bool', 1.1],
            ['bool', 1],
            ['bool', (object)['name' => 'foo']],
            ['bool', 'a'],
            
            ['callable', [1]],
            ['callable', true],
            ['callable', 1.1],
            ['callable', 1],
            ['callable', (object)['name' => 'foo']],
            ['callable', 'a'],        
            
            ['float', [1]],
            ['float', true],
            ['float', function(){}],
            ['float', 1],
            ['float', (object)['name' => 'foo']],
            ['float', 'a'],
            
            ['int', [1]],
            ['int', true],
            ['int', function(){}],
            ['int', 1.1],
            ['int', (object)['name' => 'foo']],
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
            ['string', function(){}],
            ['string', 1.1],
            ['string', 1],
            ['string', (object)['name' => 'foo']],
        ];
    }
    
    /**
     * Test assign to array a wrong typed value.
     *
     * @dataProvider wrongTypedValueProvider
     * @expectedException InvalidArgumentException
     */
    public function testAssignWrongTypedValueToArray($type, $value)
    {
        $array = new TypedArray($type);
        $array[] = $value;
    }
}
