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

use InvalidArgumentException;

/**
 * Provide a way for create an array of typed elements with php.
 */
class ArrayOfClasses extends AbstractArray
{
    /**
     * @var string Current type for array
     */
    protected string $class;

    /**
     * It overrides parent message
     * @var string Exception message
     */
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
        // first argument is the php8.1 method to pass function reference as closure.
        // check https://www.php.net/manual/en/functions.first_class_callable_syntax.php
        parent::__construct($this->is_class(...), $input, $flags, $iterator_class);
    }

    /**
     * Check if argument is instance of specific class.
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function is_class(mixed $value): bool
    {
        if ($value instanceof $this->class) {
            return true;
        }

        return false;
    }
}
