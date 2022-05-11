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
 * Provide a way for create an array of typed elements with php.
 */
class ArrayOfClasses extends ArrayObject
{
    /**
     * @var string Current type for array
     */
    protected string $class;
    protected string $exceptionMessage;


    /**
     * Class Contructor.
     *
     * @param array<object> $input
     * @param int           $flags
     * @param string        $iterator_class
     *
     * @throws InvalidArgumentException If elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(string $class, array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        $this->class = $class;
        $this->exceptionMessage = "Elements passed must be of the type <{$class}>.";

        if (!\class_exists($class)) {
            throw new InvalidArgumentException("Type <{$this->class}> provided isn't a class.");
        }

        if (!\array_product(\array_map(function ($x) use ($class) {
            return $x instanceof $class;
        }, $input))) {
            throw new InvalidArgumentException($this->exceptionMessage);
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * Array style value assignment.
     *
     * @ignore
     *
     * @param mixed $index
     * @param object $newval
     *
     * @throws InvalidArgumentException If value passed with $newval are not of the expected type
     *
     * @return void
     */
    public function offsetSet($index, $newval): void
    {
        if (!($newval instanceof $this->class)) {
            throw new InvalidArgumentException($this->exceptionMessage);
        }

        parent::offsetSet($index, $newval);
    }

    /**
     * Append a value at the end of the array.
     *
     * @param object $value
     *
     * @return void
     *
     * @throws InvalidArgumentException  If value passed with $value are not of the expected type
     */
    public function append($value): void
    {
        if (!($value instanceof $this->class)) {
            throw new InvalidArgumentException($this->exceptionMessage);
        }

        parent::append($value);
    }
}
