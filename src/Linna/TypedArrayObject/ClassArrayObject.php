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
class ClassArrayObject extends ArrayObject
{
    /**
     * @var string Current type for array
     */
    protected $type = '';

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
    public function __construct(string $class, array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        $this->type = $class;

        if (!\class_exists($class)) {
            throw new InvalidArgumentException("Type <{$this->type}> provided isn't a class.");
        }

        //to avoid foreach, compare sizes of array
        //before and after apply a filter :)
        if (\count($input) > \count(\array_filter($input, function ($e) use ($class) {
            return $e instanceof $class;
        }))) {
            throw new InvalidArgumentException("Elements passed must be of the type <{$this->type}>.");
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
     * @param object $newval
     *
     * @throws InvalidArgumentException If value passed with $newval are not of the expected type
     *
     * @return void
     */
    public function offsetSet($index, $newval): void
    {
        if ($newval instanceof $this->type) {
            parent::offsetSet($index, $newval);

            return;
        }

        throw new InvalidArgumentException("Elements passed must be of the type <{$this->type}>.");
    }

    /**
     * Append a value at the end of the array.
     *
     * @param object $value
     * @return void
     *
     * @throws InvalidArgumentException  If value passed with $value are not of the expected type
     */
    public function append($value): void
    {
        if ($value instanceof $this->type) {
            parent::append($value);

            return;
        }

        throw new InvalidArgumentException("Elements passed must be of the type <{$this->type}>.");
    }
}
