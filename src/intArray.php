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
use TypeError;

/**
 * Create an array of integer elements.
 */
class intArray extends ArrayObject
{
    /**
     * Contructor.
     *
     * @param array $array
     *
     * @throws TypeError
     */
    public function __construct(array $array = [])
    {
        //for not utilize foreach, compare sizes of array
        //before and after apply a filter :)
        if (count($array) > count(array_filter($array, 'is_int'))) {
            throw new TypeError('Elements passed to '.__CLASS__.' must be of the type integer');
        }

        //call parent constructor
        parent::__construct($array, 0, 'ArrayIterator');
    }

    /**
     * Array style value assignment.
     *
     * @param mixed $index
     * @param mixed $newval
     *
     * @throws TypeError If value passed to $newval is not integer
     *
     * @return void
     */
    public function offsetSet($index, $newval)
    {
        if (is_int($newval)) {
            parent::offsetSet($index, $newval);

            return;
        }

        throw new TypeError('Elements passed to '.__CLASS__.' must be of the type integer');
    }
}
