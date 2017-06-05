![Linna Framework](logo-array.png)
<br/>
<br/>
<br/>
[![Build Status](https://travis-ci.org/s3b4stian/linna-array.svg?branch=master)](https://travis-ci.org/s3b4stian/linna-array)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/s3b4stian/linna-array/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-array/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/s3b4stian/linna-array/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-array/?branch=master)
[![StyleCI](https://styleci.io/repos/93407083/shield?branch=master&style=flat)](https://styleci.io/repos/93407083)

## Typed arrays for php
Provide typed arrays for php as extension of native [ArrayObject](http://php.net/manual/en/class.arrayobject.php)

## Requirements
This package require php 7.

## Installation
With composer:
```
composer require s3b4stian/linna-array
```

## Usage
Valid for intArray, stringArray and floatArray classes
```php
use Linna\intArray;

//int array
//correct, only int passed to array.
$intArray = new intArray([1, 2, 3, 4]);
$intArray[] = 5;

//throw TypeError.
$intArray = new intArray([1, 'a', 3, 4]);
$intArray[] = 'a';
```

### Performance consideration
Compared to the parent class [ArrayObject](http://php.net/manual/en/class.arrayobject.php) typed arrays are slower on writing
approximately from 15x to 20x. The slowness due to not native `__construct()` and not native `offsetSet()`.  
Other operations do not have a speed difference with the native ArrayObject.
```php
use Linna\intArray;

//slower from 15x to 20x.
$intArray = new intArray([1, 2, 3, 4]);
$intArray[] = 5;

//other operations, fast as native.
//for example:
$arrayElement = $intArray[0];
$elements = $intArray->count();
$array = (array) $intArray;
```

