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
use Closure;
use InvalidArgumentException;

/**
 * Provide a way to create an array of string typed elements with php.
 */
class AbstractArray extends ArrayObject
{
    protected string $exceptionMessage;
    protected Closure $func;

    /**
     * Class Contructor.
     *
     * @param Closure       $func               function to check the array values
     * @param array<mixed>  $input              array of values
     * @param int           $flags              see array object on php site
     * @param string        $iterator_class     see array object on php site
     *
     * @throws InvalidArgumentException If elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(Closure $func, array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        //check for invalid values inside provided array
        //array_map returns an array of trues or false
        //product of all trues return 1, only one false make result 0
        if (!\array_product(\array_map($func, $input))) {
            throw new InvalidArgumentException($this->exceptionMessage);
        }

        $this->func = $func;

        //call parent constructor
        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * Array style value assignment.
     *
     * @ignore
     *
     * @param mixed $index
     * @param string $newval
     *
     * @throws InvalidArgumentException If value passed with $newval are not of the string type
     *
     * @return void
     */
    public function offsetSet($index, $newval): void
    {
        if (!($this->func)($newval)) {
            throw new InvalidArgumentException($this->exceptionMessage);
        }

        parent::offsetSet($index, $newval);
    }

    /**
     * Append a value at the end of the array.
     *
     * @param string $value
     * @return void
     *
     * @throws InvalidArgumentException  If value passed with $value are not of the string type
     */
    public function append($value): void
    {
        if (!($this->func)($value)) {
            throw new InvalidArgumentException($this->exceptionMessage);
        }

        parent::append($value);
    }
}
