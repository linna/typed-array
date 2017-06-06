![Linna Framework](logo-array.png)
<br/>
<br/>
<br/>
[![Build Status](https://travis-ci.org/s3b4stian/linna-array.svg?branch=master)](https://travis-ci.org/s3b4stian/linna-array)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/s3b4stian/linna-array/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-array/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/s3b4stian/linna-array/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-array/?branch=master)
[![StyleCI](https://styleci.io/repos/93407083/shield?branch=master&style=flat)](https://styleci.io/repos/93407083)

# Typed arrays for php
Provide typed arrays for php as extension of native [ArrayObject](http://php.net/manual/en/class.arrayobject.php)

## Requirements
This package require php 7.

## Installation
With composer:
```
composer require s3b4stian/linna-array
```

## Usage TypedArray
```php
use Linna\TypedArray;

//correct, only int passed to array.
$array = new TypedArray('int', [1, 2, 3, 4]);
$array[] = 5;

//throw InvalidArgumentException.
$array = new TypedArray([1, 'a', 3, 4]);
$array[] = 'a';
```
Allowed types are: array, bool, callable, float, int, object, string.
```php
use Linna\TypedArray;

$intArray = new TypedArray('int');
$arrayArray = new TypedArray('array');
$boolArray = new TypedArray('bool');
$callableArray = new TypedArray('callable');
$floatArray = new TypedArray('float');
$intArray = new TypedArray('int');
$objectArray = new TypedArray('object');
$stringArray = new TypedArray('string');
```

## Performance consideration
Compared to the parent class [ArrayObject](http://php.net/manual/en/class.arrayobject.php) typed arrays are slower on writing
approximately from 15x to 20x. The slowness is due to not native `__construct()` and not native `offsetSet()`.  
Other operations do not have a speed difference with the native ArrayObject.
```php
use Linna\TypedArray;

//slower from 15x to 20x.
$array = new TypedArray('int', [1, 2, 3, 4]);
$array[] = 5;

//other operations, fast as native.
//for example:
$arrayElement = $array[0];
$elements = $array->count();
```

