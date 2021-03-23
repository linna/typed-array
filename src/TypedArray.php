<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna;

use ArrayObject;
use InvalidArgumentException;

/**
 * Provide a way for create an array of typed elements with php.
 */
class TypedArray extends ArrayObject
{
    /**
     * @var array Types supported by class
     */
    protected $allowedTypes = [
        'array' => 'is_array',
        'bool' => 'is_bool',
        'callable' => 'is_callable',
        'float' => 'is_float',
        'int' => 'is_int',
        'object' => 'is_object',
        'string' => 'is_string'
    ];

    /**
     * @var string Current type for array
     */
    protected $type = '';

    /**
     * Class Contructor.
     *
     * <pre><code class="php">use Linna\TypedArray;
     *
     * //correct, only int passed to array.
     * $array = new TypedArray('int', [1, 2, 3, 4]);
     * $array[] = 5;
     *
     * //throw InvalidArgumentException.
     * $array[] = 'a';
     *
     * //throw InvalidArgumentException.
     * $array = new TypedArray('int', [1, 'a', 3, 4]);
     *
     * //correct, only Foo class instances passed to array.
     * $array = new TypedArray(Foo::class, [
     *     new Foo(),
     *     new Foo()
     * ]);
     *
     * $array[] = new Foo();
     *
     * //throw InvalidArgumentException.
     * $array[] = new Bar();
     *
     * //throw InvalidArgumentException.
     * $array = new TypedArray(Foo::class, [
     *     new Foo(),
     *     new Bar()
     * ]);
     * </code></pre>
     *
     * <b>Note</b>: Allowed types are <i>array</i>, <i>bool</i>, <i>callable</i>,
     * <i>float</i>, <i>int</i>, <i>object</i>, <i>string</i> and all existing classes.
     *
     * @param string $type  Type for values inside array.
     * @param array  $array Optional, if you wish initialize object with values.
     *
     * @throws InvalidArgumentException If type is not supported or if
     *                                  elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(string $type, array $array = [])
    {
        if (\class_exists($type)) {
            //I like lambda functions ;)
            $this->allowedTypes[$type] = function ($a) use ($type) {
                return $a instanceof $type;
            };
        }

        //single class, multi type support :)
        if (empty($this->allowedTypes[$type])) {
            throw new InvalidArgumentException(__CLASS__.': '.$type.' type passed to '.__METHOD__.' not supported.');
        }

        //to avoid foreach, compare sizes of array
        //before and after apply a filter :)
        if (\count($array) > \count(\array_filter($array, $this->allowedTypes[$type]))) {
            throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__METHOD__.' must be of the type '.$type.'.');
        }

        //call parent constructor
        parent::__construct($array);

        //store array type
        $this->type = $type;
    }

    /**
     * Array style value assignment.
     *
     * @ignore
     *
     * @param mixed $index
     * @param mixed $newval
     *
     * @throws InvalidArgumentException If value passed with $newval are not of the configured type
     *
     * @return void
     */
    public function offsetSet($index, $newval)
    {
        if ($newval instanceof $this->type) {
            parent::offsetSet($index, $newval);

            return;
        }

        if ($this->allowedTypes[$this->type]($newval)) {
            parent::offsetSet($index, $newval);

            return;
        }

        throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__CLASS__.' must be of the type '.$this->type.'.');
    }
}
