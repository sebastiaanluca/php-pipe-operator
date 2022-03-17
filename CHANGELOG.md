# Changelog

All notable changes to `sebastiaanluca/php-pipe-operator` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## 5.0.0 (2022-03-17)

### Added

- Added support for PHP 8.1
- Added support for first class callable syntax (PHP 8.1)

### Changed

- Cleaned up internals

## 4.0.0 (2021-06-22)

### Added

- Added support for PHP 8
- Added static constructor

### Changed

- Internal PHP 8 code updates

### Removed

- Removed support for PHP 7

## 3.0.0 (2019-02-27)

### Changed

- Upgraded to PHPUnit 8

### Removed

- Dropped support for PHP 7.1 and lower

## 2.1.1 (2018-03-18)

### Fixed

- Fix class method example in readme

## 2.1.0 (2018-03-18)

### Added

- Add proxy for private instance methods

## 2.0.0 (2018-02-26)

### Added

- Added the `PIPED_VALUE` constant as the new identifier

### Removed

- Removed the default `'$$'` identifier
- Removed the option to set a custom identifier

## 1.0.0 (2018-02-24)

### Added

- Added custom pipe operator
- Allow using direct method calls instead of using pipe operator
- Add shorthand take method
- Allow setting custom pipe operator
- Add test to use class methods as pipe processors
