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

/**
 * Create an array of typed elements.
 */
class TypedArray extends ArrayObject
{
    /**
     * @var array Types supported by class
     */
    protected $allowedTypes = [
        'array' => 1,
        'bool' => 1,
        'callable' => 1,
        'float' => 1,
        'int' => 1,
        'object' => 1,
        'string' => 1
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
     *
     * @throws InvalidArgumentException If type is not supported and if
     *                                  elements of passed with $array
     *                                  are not of the configured type
     */
    public function __construct(string $type, array $array = [])
    {
        //single class, multi type support :)
        if (!isset($this->allowedTypes[$type])) {
            throw new InvalidArgumentException(__CLASS__.': '.$type.' type passed to '.__METHOD__.' not supported.');
        }

        //for not utilize foreach, compare sizes of array
        //before and after apply a filter :)
        if (count($array) > count(array_filter($array, 'is_'.$type))) {
            throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__METHOD__.' must be of the type '.$type.'.');
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
     * @throws InvalidArgumentException If value passed with $newval are not of the configured type
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
        throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__CLASS__.' must be of the type '.$this->type.'.');
    }
}
