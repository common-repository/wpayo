# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [2.1.4] - 2023-03-27

### Commits

- Set Composer type to `wordpress-plugin`. ([9563b8e](https://github.com/pronamic/wp-datetime/commit/9563b8e4f85c3fd935cff82cd7f94ee16e021870))

Full set of changes: [`2.1.3...2.1.4`][2.1.4]

[2.1.4]: https://github.com/pronamic/wp-datetime/compare/v2.1.3...v2.1.4

## [2.1.3] - 2023-03-02
### Added

- Add .gitattributes.

Full set of changes: [`2.1.2...2.1.3`][2.1.3]

[2.1.3]: https://github.com/pronamic/wp-datetime/compare/v2.1.2...v2.1.3

## [2.1.2] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.

Full set of changes: [`2.1.1...2.1.2`][2.1.2]

[2.1.2]: https://github.com/pronamic/wp-datetime/compare/v2.1.1...v2.1.2

## [2.1.1] - 2022-12-28

### Commits

- Improve compatibility with PHP versions < 8.0. ([7842a7f](https://github.com/pronamic/wp-datetime/commit/7842a7f4978595b8341311d315c742ae66e569b8))

Full set of changes: [`2.1.0...2.1.1`][2.1.1]

[2.1.1]: https://github.com/pronamic/wp-datetime/compare/v2.1.0...v2.1.1

## [2.1.0] - 2022-12-19
- Increased minimum PHP version to version `8` or higher.
- Improved support for PHP `8.1` and `8.2`.
- Removed usage of deprecated constant `FILTER_SANITIZE_STRING`.

Full set of changes: [`2.0.3...2.1.0`][2.1.0]

[2.1.0]: https://github.com/pronamic/wp-datetime/compare/2.0.3...2.1.0

## [2.0.3] - 2022-09-27
- Update plugin version.

## [2.0.2] - 2022-09-23
- Coding standards.

## [2.0.1] - 2022-04-11
### Changed
- Coding standards.

## [2.0.0] - 2022-01-10
### Added
- Added `DateTimeTrait::create_from_interface`.

### Removed
- Removed `DateTime::create_from_mutable`.
- Removed `DateTimeImmutable::create_from_mutable`.

## [1.2.2] - 2021-08-26
- Added the character `p` to the date format characters list which was added in PHP 8.

## [1.2.1] - 2021-04-26
- Happy 2021.

## [1.2.0] - 2020-10-08
- Added DateTimeImmutable class.
- Added `DateTime::create_from_immutable( \DateTimeImmutable $object )` method.
- Added `DateTimeImmutable::create_from_mutable( \DateTime $object )` method.
- Override upstream `DateTime::createFromImmutable( $object )` method.
- Override upstream `DateTimeImmutable::createFromMutable( $object )` method.
- Override upstream `DateTimeInterface::createFromFormat( $format, $time, $timezone = null )` method.
- Updated copyright.

## [1.1.1] - 2019-12-17
- Fix for WordPress core trac ticket 48319 (https://core.trac.wordpress.org/ticket/48319).
- Updated PHP compatibility test version to PHP 5.6.
- Updated tests.

## [1.1.0] - 2019-08-26
- Introduced a format translate function, will not switch to local timezone.

## [1.0.2] - 2018-09-12
- Fixed issue on PHP 5.6 or lower.

## [1.0.1] - 2018-08-16
- Override `createFromFormat` method to return WordPress DateTime object.
- Use new `create_from_format` method instead of override, due to method signature Travis errors for different PHP versions.
- Improved support for timezones.

## 1.0.0
- First release.

[unreleased]: https://github.com/pronamic/wp-datetime/compare/2.0.0...HEAD
[2.0.3]: https://github.com/pronamic/wp-datetime/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/pronamic/wp-datetime/compare/2.0.1...2.0.2
[2.0.0]: https://github.com/pronamic/wp-datetime/compare/1.2.2...2.0.0
[1.2.2]: https://github.com/pronamic/wp-datetime/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/pronamic/wp-datetime/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/pronamic/wp-datetime/compare/1.1.1...1.2.0
[1.1.1]: https://github.com/pronamic/wp-datetime/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/pronamic/wp-datetime/compare/1.0.2...1.1.0
[1.0.2]: https://github.com/pronamic/wp-datetime/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/pronamic/wp-datetime/compare/1.0.0...1.0.1
