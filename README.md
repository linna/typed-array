![Linna Array](logo-array.png)
<br/>
<br/>
<br/>
[![Build Status](https://travis-ci.org/linna/typed-array.svg?branch=master)](https://travis-ci.org/linna/typed-array)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/linna/typed-array/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/linna/typed-array/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/linna/typed-array/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/linna/typed-array/?branch=master)
[![StyleCI](https://styleci.io/repos/93407083/shield?branch=master&style=flat)](https://styleci.io/repos/93407083)


This package provide typed arrays for php as extension of native [ArrayObject](http://php.net/manual/en/class.arrayobject.php).  

## Requirements
This package require php 7.

## Installation
With composer:
```
composer require linna/typed-array
```

## Usage - TypedArray
```php
use Linna\TypedArray;

//correct, only int passed to constructor.
$intArray = new TypedArray('int', [1, 2, 3, 4]);

//correct, int assigned
$intArray[] = 5;

//throw InvalidArgumentException, string assigned.
$intArray[] = 'a';

//throw InvalidArgumentException, mixed array passed to constructor.
$otherIntArray = new TypedArray('int', [1, 'a', 3, 4]);

//correct, only Foo class instances passed to constructor.
$fooArray = new TypedArray(Foo::class, [
    new Foo(),
    new Foo()
]);

//correct, Foo() instance assigned.
$fooArray[] = new Foo();

//throw InvalidArgumentException, Bar() instance assigned.
$fooArray[] = new Bar();

//throw InvalidArgumentException, mixed array of instances passed to constructor.
$otherFooArray = new TypedArray(Foo::class, [
    new Foo(),
    new Bar()
]);
```

> **Note:** Allowed types are: *array*, *bool*, *callable*, *float*, *int*, *object*, *string* and all existing classes.

## Performance consideration for v2.0
Compared to first version of the library, this version is a bit slower because after merging `TypedObjectArray` with `TypedArray`,
there are more code that be executed when new instance is created and on assign operations.

![Array Speed Test](array-speed-test-v2.png)

## Performance consideration
Compared to the parent class [ArrayObject](http://php.net/manual/en/class.arrayobject.php) typed arrays are slower on writing
approximately from 6x to 8x. The slowness is due to not native `__construct()` and not native `offsetSet()`.  
Other operations do not have a speed difference with the native ArrayObject.
```php
use Linna\TypedArray;

//slower from 6x to 8x.
$array = new TypedArray('int', [1, 2, 3, 4]);
$array[] = 5;

//other operations, fast as native.
//for example:
$arrayElement = $array[0];
$elements = $array->count();
```
![Array Speed Test](array-speed-test.png)
View the speed test script on [gist](https://gist.github.com/s3b4stian/9441af5855b795cc1569b3cdb5e7526d).