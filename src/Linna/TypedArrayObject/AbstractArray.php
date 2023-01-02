<?php

declare(strict_types=1);

/**
 * This file is part of the Linna Typed ArrayObject.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace Linna\TypedArrayObject;

use ArrayObject;
use ArrayIterator;
use Closure;
use InvalidArgumentException;

/**
 * Provide a way to create an array of typed elements with php.
 * 
 * @extends ArrayObject<int|string, mixed>
 * 
 * @link https://www.php.net/manual/en/class.arrayobject.php
 */
class AbstractArray extends ArrayObject
{
    protected string $exceptionMessage;
    protected Closure $func;

    /**
     * Class Contructor.
     *
     * @param Closure       $func           Function to check the array values.
     * @param array<mixed>  $input          Array of values.
     * @param int           $flags          Flags to control the behaviour of the ArrayObject object. See array object on php site.
     * @param class-string  $iterator_class Specify the class that will be used for iteration of the ArrayObject object. The class must implement ArrayIterator.
     *
     * @throws InvalidArgumentException If elements in the optional array parameter aren't of the configured type.
     */
    public function __construct(Closure $func, array $input = [], int $flags = 0, string $iterator_class = ArrayIterator::class)
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
     * @param mixed $value
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
