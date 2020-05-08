# Changelog

All Notable changes to `Backpack PermissionManager` will be documented in this file

----------
IMPORTANT
----------

Since version 6.0.0, we no longer use this file to track changes. Please see our Releases tab on Github:
https://github.com/Laravel-Backpack/PermissionManager/releases

----------

## 5.0.7 - 2020-03-05

### Fixed
- upgraded PHPUnit to 9/7;


## 5.0.6 - 2020-01-15

### Fixed
- merged #216 - translated labels for filters in UserCrudController;


## 5.0.5 - 2020-01-14

### Fixed
- packagist merge issue;


## 5.0.4 - 2020-01-14

### Added
- merged #218 - added Indonesian language file;


## 5.0.3 - 2019-12-24

### Added
- Added filters to the Users CRUD: Role and Extra Permission

### Fixed
- Refactored Roles and Permissions CRUDs to use methods for setting up operations, instead of on() closures;
- Added validation and required asterisks to Create and Update operations on Roles and Permissions CRUDs;


## 5.0.2 - 2019-10-19

### Added
- Arabic translation;


## 5.0.1 - 2019-10-04

### Fixed
- User update operation works when route prefix is set to empty string;


## 5.0.0 - 2019-09-24

### Added
- support for Backpack v4;

### Removed
- support for Backpack v3;


-----


## [4.0.6] - 2019-09-04

### Added
- upgraded to spatie/laravel-permission version 3.x, that provides support for Laravel 6;


## [4.0.5] - 2019-08-14

### Fixed
- UserUpdateCrudRequest had a theoretical vulnerability by not validating the ID before using it in the rule; it's now double-checked beforehand;
- Fixes #126 - array to string conversion;
- Fixes #196 - allows uses of other encryption mechanisms beside bcrypt;


## [4.0.4] - 2019-03-12

### Fixed
- can be installed with point versions of spatie/laravel-permission;



## [4.0.3] - 2019-03-12

### Added
- merged #185 - added Serbian language;


## [4.0.2] - 2019-03-12

### Added
- proper validation messages when trying to add a role or permission that exists;


## [4.0.1] - 2019-02-27

### Added
- support for the ```upgrade``` branch for Backpack\CRUD, so it can be installed temporarily with Laravel 5.8;
- requirement for latest version of spatie/laravel-permission, 2.34;


## [4.0.0] - 2018-12-12

### Added
- support for spatie/laravel-permission version 2.28.1;
- ability to specify guards when creating/updating roles and permissions; config option to turn that on and off (default: false);

### Removed
- config file for spatie/laravel-permission; models being used in CRUDs are now defined in ```config/backpack/permissionmanager.php```;
- migrations, since they are provided by spatie/laravel-permission;


## [3.12.6] - 2018-10-16

### Fixed
- validation for unique email when updating a user;


## [3.12.5] - 2018-09-29

### Added
- #171 - French Canadian translation;


## [3.12.4] - 2018-06-26

### Fixed
- #162 - use Request for changing password instead of deprecated CrudRequest;


## [3.12.2] - 2018-06-21

### Added
- #160 - use custom Backpack guard as per Backpack\Base 0.9.x;

## [3.12.1] - 2018-06-19

### Added
- #159 - Italian translation, thanks to [Roberto Butti](https://github.com/roberto-butti);


## [3.12.0] - 2018-06-07

### Added
- support for ```spatie/laravel-permission``` v2.12;

### Removed
- support for ```spatie/laravel-permission``` v2.12;

### Notes
- the db structure has changed; because that's what spatie did between v1.4 and v2.12;
- there is no upgrade guide from spatie v1 to spatie v2; and after spending a lot of time on this, I understand why; it would have been way to difficult to create migrations for such an upgrade; especially for big projects, that might have other foreign keys to/from the old tables;
- as such, we didn't provide an upgrade guide either; people who use v1 will continue to use v1; people who start now will be using v2;
- if we do go through the upgrade ourselves at one point, we might provide an upgrade guide; if anybody, ever, creates an upgrade guide, please link to it on the README;
- since spatie/laravel-permission pushes breaking changes like crazy, and this package is pretty simple and does not need regular updates, I've decided to track spatie/laravel-permission's version; starting now; this new version will be 3.12 because it uses spatie/laravel-permission v2.12;

---------------------

## [2.1.27] - 2018-05-02

### Added
- support for Backpack\CRUD 3.4;

### Fixed
- routes are now using the ```backpack_middleware()``` instead of hardcoded ```admin```; merges #151;

### Removed
- support for Backpack\CRUD 3.3 (since we're using the new middleware);


## [2.1.26] - 2018-03-13

## Added
- German translation;
- Latvian translation;
- French translation;


## [2.1.25] - 2018-03-13

## Fixed
- #148 using custom Permission and Role models for fields and columns, as defined in the ```laravel-permission.php``` config file;


## [2.1.24] - 2017-12-13

## Fixed
- Clear cache key spatie.permission.cache, otherwise, changes won't have effect - merged #114;


## [2.1.23] - 2017-12-13

## Fixed
- "Class CRUD not found" when autodiscovery feature got the wrong package order - merged #133;


## [2.1.22] - 2017-12-02

## Added
- removed PHP 5.6 from travis.yml


## [2.1.21] - 2017-12-02

## Added
- CRUD 3.3 requirement in composer;


## [2.1.20] - 2017-12-02

## Added
- package auto-discovery;


## [2.1.19] - 2017-08-11

## Added
- Danish (da_DK) language files, thanks to [Frederik Rabøl](https://github.com/Xayer);
- Russian (ru) language files, thanks to [exotickg1](https://github.com/exotickg1);


## 2.1.18 - 2017-07-06

### Added
- overwritable routes file;


## 2.1.17 - 2017-07-05

### Added
- Spanish translation (thanks to [Hugo Aguirre](https://github.com/bul-ikana) and [Cesar Bretana Glez](https://github.com/bretanac93));
- Portugese translation (thanks to [Toni Almeida](https://github.com/promatik));
- Dutch translation (thanks to [Jelmer Visser](https://github.com/jelmervisser));

### Fixed
- use local request in UserCrudController instead of Facade;
- use the Users table name as defined in the laravel-permission config file;
- correctly extending CrudController now;

## 2.1.16 - 2017-04-21

### Removed
- Backpack\PermissionManager no longer loads translations, as Backpack\Base does it for him.


## 2.1.15 - 2017-02-17

### Removed
- PHP 5.5 compatibility, as Laravel no longer supports it;


## 2.1.14 - 2017-02-17

### Added
- CRUD 3.2 compatibilty;
- updated CONTRIBUTING.md;


## 2.1.13 - 2017-02-13

### Added
- greek translation - thanks to [automat64](https://github.com/automat64);

### Fixed
- allowed for primary keys other than id;


## 2.1.12 - 2017-02-13

### Added
- ajax datatables for users CRUD;


## 2.1.11 - 2017-01-18

### Added
- config options to disable the delete functionality on Permissions and Roles;



## 2.1.10 - 2016-11-28

### Added
- you can use a different permission or role model by changing a config value inside the laravel-permission config file;


## 2.1.9 - 2016-10-23

### Fixed
- route_prefix support for routes;


## 2.1.8 - 2016-10-20

### Fixed
- added translation files, thanks to [Ludio Oliveira](https://github.com/ludioao);
- added route_prefix support, thanks to [reeslo](https://github.com/reeslo);


## 2.1.7 - 2016-09-12

### Fixed
- MySQL strict support;


## 2.1.6 - 2016-08-31

### Added
- Laravel 5.3 support;


## 2.1.5 - 2016-07-31

### Added
- Working bogus unit tests.


## 2.1.3 - 2016-06-30

### Added
- Ability to change user model fqcn in config file.


## 2.1.2 - 2016-06-23

### Added
- Roles and Permissions columns on UserCrudController list view.


## 2.1.1 - 2016-06-16

### Fixed
- When adding users, the password was not saved.


## 2.1.0 - 2016-06-16

### Added
- Database migration is now published, for deployment systems like Laravel Forge;
- Config file to disallow create and update for permissions and roles, after you add them;

### Fixed
- Moved routes declaration in the ServiceProvider;
- Spatie\Permission\PermissionServiceProvider::class is now registered in the ServiceProvider;


## 2.0.0 - 2016-05-20

### Fixed
- Updated controller syntax to use the new Backpack\CRUD API in v2.


## 1.0.4 - 2016-05-18

### Fixed
- Installation process.
