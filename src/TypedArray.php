<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna;

use ArrayObject;
use InvalidArgumentException;
use TypeError;

/**
 * Create an array of typed elements.
 */
class TypedArray extends ArrayObject
{
    /**
     * @var array Types supported by class
     */
    protected $allowedTypes = [
        'array',
        'bool',
        'callable',
        'float',
        'int',
        'object',
        'string',
    ];

    /**
     * @var string Current type for array
     */
    protected $type = '';

    /**
     * Contructor.
     * 
     * @param string $type
     * @param array  $array
     * @throws InvalidArgumentException If type is not supported
     * @throws TypeError                If elements of passed with $array
     *                                  are not of the configured type
     */
    public function __construct(string $type, array $array = [])
    {
        //single class, multi type support :)
        //if (!isset($this->allowedTypes[$type])){
        if (!in_array($type, $this->allowedTypes)) {
            throw new InvalidArgumentException($type.' type passed to '.__CLASS__.' not supported');
        }

        //for not utilize foreach, compare sizes of array
        //before and after apply a filter :)
        if (count($array) > count(array_filter($array, 'is_'.$type))) {
            throw new TypeError('Elements passed to '.__CLASS__.' must be of the type '.$type);
        }

        //call parent constructor
        parent::__construct($array, 0, 'ArrayIterator');

        //store array type
        $this->type = $type;
    }

    /**
     * Array style value assignment.
     *
     * @param mixed $index
     * @param mixed $newval
     *
     * @throws TypeError If value passed with $newval are not of the configured type
     *
     * @return void
     */
    public function offsetSet($index, $newval)
    {
        $is_ = 'is_'.$this->type;

        if ($is_($newval)) {
            parent::offsetSet($index, $newval);

            return;
        }
        throw new TypeError('Elements passed to '.__CLASS__.' must be of the type '.$this->type);
    }
}
