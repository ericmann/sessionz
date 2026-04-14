# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## 0.5.0 - 2026-04-14
### Changed
- Bumped minimum PHP version to 7.4
- Upgraded `defuse/php-encryption` to `^2.4`
- Upgraded PHPUnit to `^9.6` (replaces abandoned `^5.6`)
- Replaced abandoned `satooshi/php-coveralls` with `php-coveralls/php-coveralls ^2.7`
- Rewrote CI workflow as a PHP 7.4–8.5 matrix using `shivammathur/setup-php`; CI now actually runs PHPUnit in addition to PHPStan
- Annotated `Manager` session-handler methods with `#[\ReturnTypeWillChange]` so PHP 8.1+ no longer emits tentative-return-type deprecations

### Added
- Committed `composer.lock` so Dependabot can raise dependency PRs
- `composer test` / `composer test-coverage` scripts

### Removed
- `.travis.yml` (superseded by GitHub Actions)
- `version` field from `composer.json` (versions are defined by git tags)

## 0.4.0 - 2021-07-21
### Changed
- Add PHPStan static code analysis
- Check the header hasn't been sent for calling `session_set_save_handler()`. Props @pbearne

## 0.3.1 - 2018-01-16
### Changed
- Fix a PHP error during `BaseHandler` wireup. Props @sayful1

## 0.3.0 - 2018-01-15
### Changed
- Updated encryption handler to use a specific `Key` type from Defuse's library
- Updated documentation
- Updated Travis test matrix for modern PHP

## 0.2.1 - 2017-04-25
### Changed
- Fixed a naming issue affecting internal object storage

## 0.2.0 - 2017-04-25
### Changed
- Switched from the PHP doc's crypto example to the Defuse Crypto library

## 0.1.0 - 2016-11-26
### Added
- README explaining the purpose and use of the project
- Tests to verify adequate functionality
- This CHANGELOG file
