# Changelog

All Notable changes to `Backpack Settings` will be documented in this file

## NEXT - YYYY-MM-DD

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing


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
