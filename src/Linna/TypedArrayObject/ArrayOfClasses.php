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

use ArrayIterator;
use InvalidArgumentException;

/**
 * Provide a way for create an array of typed elements with php.
 * 
 * @link https://www.php.net/manual/en/functions.first_class_callable_syntax.php
 */
class ArrayOfClasses extends AbstractArray
{
    /**
     * @var string Current type for array.
     */
    protected string $class;

    /**
     * It overrides parent message.
     *
     * @var string Exception message.
     */
    protected string $exceptionMessage;


    /**
     * Class Contructor.
     *
     * @param array<object> $input          Array of values, every value must be a <code>object</code>.
     * @param int           $flags          Flags to control the behaviour of the <code>ArrayObject</code> object, 
     *                                      see <code>ArrayObject</code> on php site.
     * @param class-string  $iterator_class Specify the class that will be used for iteration of the <code>ArrayObject</code> 
     *                                      object, the class must implement <code>ArrayIterator</code>.
     *
     * @throws InvalidArgumentException If elements in the optional array parameter aren't of the configured type.
     */
    public function __construct(string $class, array $input = [], int $flags = 0, string $iterator_class = ArrayIterator::class)
    {
        $this->class = $class;
        $this->exceptionMessage = "Elements passed must be of the type <{$class}>.";
        // first argument is the php8.1 method to pass function reference as closure.
        // check https://www.php.net/manual/en/functions.first_class_callable_syntax.php
        parent::__construct($this->is_class(...), $input, $flags, $iterator_class);
    }

    /**
     * Check if the passed value is instance of specific class.
     *
     * @param mixed $value The value will be checked.
     *
     * @return bool True if the value passed is a valid class, false otherwise.
     */
    protected function is_class(mixed $value): bool
    {
        if ($value instanceof $this->class) {
            return true;
        }

        return false;
    }
}
