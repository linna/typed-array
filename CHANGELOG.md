
# Linna Typed Array Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v3.0.1](https://github.com/linna/typed-array/compare/v3.0.0...v3.0.1) - 2023-01-XX

### Added
- `Linna\TypedArrayObject\AbstractArray::NO_FLAGS` constant with value `0`

### Changed
- code comments updated
- composer dev dependencies updated
- Github Actions pipeline updated

## [v3.0.0](https://github.com/linna/typed-array/compare/v2.0.1...v3.0.0) - 2022-05-13

### Added
- php 8.1 support
- `Linna\TypedArrayObject\ArrayOfArrays` class
- `Linna\TypedArrayObject\ArrayOfBooleans` class
- `Linna\TypedArrayObject\ArrayOfCallable` class
- `Linna\TypedArrayObject\ArrayOfClasses` class
- `Linna\TypedArrayObject\ArrayOfFloats` class
- `Linna\TypedArrayObject\ArrayOfIntegers` class
- `Linna\TypedArrayObject\ArrayOfObjects` class
- `Linna\TypedArrayObject\ArrayOfStrings` class

### Changed
- namespace from `Linna` to `Linna\TypedArrayObject`
- type check is performed also on method `ArrayObject->append()`

### Removed
- `Linna\TypedArray` class

## [v2.0.1](https://github.com/linna/typed-array/compare/v2.0.0...v2.0.1) - 2020-03-23

### Added
- php 7.3 support
- php 7.4 support

### Changed
- `.scrutinizer.yml` updated for use phpunit from `vendor` directory
- Merge pull request #14 from peter279k/enhance_stuffs with code enhancements

### Removed
- Travis CI usage for test build.

## [v2.0.0](https://github.com/linna/typed-array/compare/v1.0.5...v2.0.0) - 2018-08-13

### Changed
* `Linna\TypedObjectArray` merged into `Linna\TypedArray`
* Merge pull request #11 from peter279k/test_enhancement with code enhancements

### Removed
* `Linna\TypedObjectArray`

## [v1.0.5](https://github.com/linna/typed-array/compare/v1.0.4...v1.0.5) - 2018-08-13

### Changed
* Merge pull request #11 from peter279k/test_enhancement with code enhancements

## [v1.0.4](https://github.com/linna/typed-array/compare/v1.0.3...v1.0.4) - 2017-10-26

### Changed
* `Linna\TypedArray` default arguments removed from `parent::__construct()` call
* `Linna\TypedObjectArray` default arguments removed from `parent::__construct()` call

## [v1.0.3](https://github.com/linna/typed-array/compare/v1.0.2...v1.0.3) - 2017-08-24

### Changed
* `Linna\TypedArray` exception messages updated
* `Linna\TypedObjectArray` exception messages updated
* Docblocks updated
* Function call for variable handling refactor

### Fixed
* `CHANGELOG.md` links url

## [v1.0.2](https://github.com/linna/typed-array/compare/v1.0.1...v1.0.2) - 2017-06-24

### Changed
* `Linna\TypedArray->__construct()` for better performance when object is created 

## [v1.0.1](https://github.com/linna/typed-array/compare/v1.0.0...v1.0.1) - 2017-06-11

### Fixed
* `composer.json` wrong autoload directory

## [v1.0.0](https://github.com/linna/typed-array/compare/v1.0.0...master) - 2017-06-07

### Added
* `Linna\TypedArray` for create arrays that accept only values of the user defined type
* `Linna\TypedObjectArray` for create arrays that accept only class instances of the user defined type
