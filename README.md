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
```php
use Linna\intArray;

//correct, only int passed to array.
$array = new intArray([1,2,3,4]);
$array[] = 5;

//throw TypeError.
$array = new intArray([1,'a',3,4]);
$array[] = 'a';
```
