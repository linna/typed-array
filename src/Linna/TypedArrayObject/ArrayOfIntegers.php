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
 * Provide a way to create an array of integer typed elements with php.
 */
class ArrayOfIntegers extends AbstractArray
{
    /**
     * It overrides parent message
     * @var string Exception message
     */
    protected string $exceptionMessage = 'Elements passed must be of the type <int>.';

    /**
     * Class Contructor.
     *
     * @param array<int>    $input
     * @param int           $flags
     * @param string        $iterator_class
     *
     * @throws InvalidArgumentException If elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(array $input = [], int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        parent::__construct('is_int', $input, $flags, $iterator_class);
    }
}
