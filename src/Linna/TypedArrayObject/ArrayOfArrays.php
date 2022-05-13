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
 * Provide a way to create an array of array typed elements with php.
 */
class ArrayOfArrays extends AbstractArray
{
    /**
     * It overrides parent message
     * @var string Exception message
     */
    protected string $exceptionMessage = 'Elements passed must be of the type <array>.';

    /**
     * Class Contructor.
     *
     * @param array<array>  $input
     * @param int           $flags
     * @param string        $iterator_class
     *
     * @throws InvalidArgumentException If elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        // first argument is the php8.1 method to pass function reference as closure.
        // check https://www.php.net/manual/en/functions.first_class_callable_syntax.php
        parent::__construct(is_array(...), $input, $flags, $iterator_class);
    }
}
