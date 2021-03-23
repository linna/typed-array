<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\TypedArrayObject;

use ArrayObject;
use InvalidArgumentException;

/**
 * Provide a way to create an array of array typed elements with php.
 */
class ArrayArrayObject extends ArrayObject
{
    public const EXC_MESSAGE = 'Elements passed must be of the type <array>.';

    /**
     * Class Contructor.
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iterator_class
     *
     * @throws InvalidArgumentException If elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        //get input array len
        $count = \count($input);
        //check for invalid values inside provided array
        //for is simple than previosu solution
        for ($i = 0; $i < $count; $i++) {
            if (\is_array($input[$i])) {
                continue;
            }
            throw new InvalidArgumentException(self::EXC_MESSAGE);
        }

        //call parent constructor
        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * Array style value assignment.
     *
     * @ignore
     *
     * @param mixed $index
     * @param array $newval
     *
     * @throws InvalidArgumentException If value passed with $newval are not of the array type
     *
     * @return void
     */
    public function offsetSet($index, $newval): void
    {
        if (\is_array($newval)) {
            parent::offsetSet($index, $newval);

            return;
        }

        throw new InvalidArgumentException(self::EXC_MESSAGE);
    }

    /**
     * Append a value at the end of the array.
     *
     * @param array $value
     * @return void
     *
     * @throws InvalidArgumentException  If value passed with $value are not of the array type
     */
    public function append($value): void
    {
        if (\is_array($value)) {
            parent::append($value);

            return;
        }

        throw new InvalidArgumentException(self::EXC_MESSAGE);
    }
}
