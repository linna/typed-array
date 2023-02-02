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
 * Provide a way to create an array of float typed elements with php.
 *
 * @link https://www.php.net/manual/en/functions.first_class_callable_syntax.php
 */
class ArrayOfFloats extends AbstractArray
{
    /**
     * It overrides parent message.
     *
     * @var string Exception message.
     */
    protected string $exceptionMessage = 'Elements passed must be of the type <float>.';

    /**
     * Class Contructor.
     *
     * @param array<float> $input          Array of values, every value must be a <code>float</code>.
     * @param int          $flags          Flags to control the behaviour of the <code>ArrayObject</code> object,
     *                                     see <code>ArrayObject</code> on php site.
     * @param class-string $iterator_class Specify the class that will be used for iteration of the <code>ArrayObject</code>
     *                                     object, the class must implement <code>ArrayIterator</code>.
     *
     * @throws InvalidArgumentException If elements in the optional array parameter aren't of the configured type.
     */
    public function __construct(array $input = [], int $flags = AbstractArray::NO_FLAGS, string $iterator_class = ArrayIterator::class)
    {
        // first argument is the php8.1 method to pass function reference as closure.
        // check https://www.php.net/manual/en/functions.first_class_callable_syntax.php
        parent::__construct(is_float(...), $input, $flags, $iterator_class);
    }
}
