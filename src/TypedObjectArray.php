<?php

/**
 * Linna Array.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna;

use ArrayObject;
use InvalidArgumentException;

/**
 * Typed Array.
 *
 * Provide a way for create an array of typed objects with php.
 */
class TypedObjectArray extends ArrayObject
{
    /**
     * @var string Current type for array
     */
    protected $type = '';

    /**
     * Class Contructor.
     *
     * <pre><code class="php">use Linna\TypedObjectArray;
     *
     * //correct, only Foo class instances passed to array.
     * $array = new TypedObjectArray(Foo::class, [
     *     new Foo(),
     *     new Foo()
     * ]);
     * $array[] = new Foo();
     *
     * //throw InvalidArgumentException.
     * $array = new TypedObjectArray(Foo::class, [
     *     new Foo(),
     *     new Bar()
     * ]);
     * //throw InvalidArgumentException.
     * $array[] = new Bar();
     * </code></pre>
     *
     * <b>Note</b>: Allowed types are only <i>existing classes</i>.
     *
     * @param string $type  Type for values inside array.
     * @param array  $array Optional, if you wish initialize object with values.
     *
     * @throws InvalidArgumentException If elements in the optional array parameter
     *                                  aren't of the configured type.
     */
    public function __construct(string $type, array $array = [])
    {
        if (!class_exists($type)) {
            throw new InvalidArgumentException(__CLASS__.': Type passed to '.__METHOD__.' must be an existing class');
        }

        //check elements of passed array
        //I will find another method
        foreach ($array as $element) {
            if ($element instanceof $type) {
                continue;
            }
            throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__METHOD__.' must be of the type '.$type.'.');
        }

        //call parent constructor
        parent::__construct($array, 0, 'ArrayIterator');
        //store array type
        $this->type = $type;
    }

    /**
     * offsetSet.
     *
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
        throw new InvalidArgumentException(__CLASS__.': Elements passed to '.__CLASS__.' must be of the type '.$this->type.'.');
    }
}
