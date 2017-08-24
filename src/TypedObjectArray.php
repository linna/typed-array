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
 * Typed Array.
 *
 * Provide a way for create an array of typed objects with php.
 */
class TypedObjectArray extends ArrayObject
{
    /**
     * @var string Current type for array
     */
    protected $type = '';

    /**
     * __construct.
     * 
     * Class Contructor.
     *
     * @param string $type
     * @param array  $array
     *
     * @throws InvalidArgumentException If elements of passed with $array
     *                                  are not of the configured type
     */
    public function __construct(string $type, array $array = [])
    {
        if (!class_exists($type)) {
            throw new InvalidArgumentException(__CLASS__.': Type passed to '.__METHOD__.' must be an existing class');
        }

        //check elements of passed array
        //I will find another method
        foreach ($array as $element) {
            if ($element instanceof $type) {
                continue;
            }
            throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__METHOD__.' must be of the type '.$type.'.');
        }

        //call parent constructor
        parent::__construct($array, 0, 'ArrayIterator');
        //store array type
        $this->type = $type;
    }

    /**
     * offsetSet.
     * 
     * Array style value assignment.
     *
     * @ignore
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
        if ($newval instanceof $this->type) {
            parent::offsetSet($index, $newval);

            return;
        }
        throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__CLASS__.' must be of the type '.$this->type.'.');
    }
}
