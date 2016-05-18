# Backpack\PermissionManager
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An interface for the administrator to easily change application users, roles adn permissions. Uses Laravel Backpack. On Laravel 5.2.

## Install

1) In your terminal:

``` bash
$ composer require backpack/permissionManager
$ php artisan migrate --path=vendor/backpack/permissions/src/database/migrations
```

2) Add the service provider to your config/app.php file:
```php
Backpack\PermissionManager\PermissionsServiceProvider::class,
```

3) [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li><a href="{{ url('admin/permission') }}"><i class="fa fa-cog"></i> <span>Permissions</span></a></li>
<li><a href="{{ url('admin/role') }}"><i class="fa fa-cog"></i> <span>Roles</span></a></li>
<li><a href="{{ url('admin/user') }}"><i class="fa fa-cog"></i> <span>Users</span></a></li>
```


## Usage

### Using permissions

A permission can be given to a user:

``` bash
$user->givePermissionTo('edit articles');
```
A permission can be revoked from a user:
``` bash
$user->revokePermissionTo('edit articles');
```
``` bash
You can test if a user has a permission:
``` bash
$user->hasPermissionTo('edit articles');
```

Saved permissions will be registered with the Illuminate\Auth\Access\Gate-class. So you can test if a user has a permission with Laravel's default can-function.
``` bash
$user->can('edit articles');
```
### Using roles and permissions

A role can be assigned to a user:
``` bash
$user->assignRole('writer');
```
A role can be removed from a user:
``` bash
$user->removeRole('writer');
```
You can determine if a user has a certain role:
``` bash
$user->hasRole('writer');
```
You can also determine if a user has any of a given list of roles:
``` bash
$user->hasAnyRole(Role::all());
```
You can also determine if a user has all of a given list of roles:
``` bash
$user->hasAllRoles(Role::all());
```
The assignRole, hasRole, hasAnyRole, hasAllRoles and removeRole-functions can accept a string, a Role-object or an \Illuminate\Support\Collection-object.

A permission can be given to a role:
``` bash
$role->givePermissionTo('edit articles');
``
You can determine if a role has a certain permission:
``` bash
$role->hasPermissionTo('edit articles');
```
A permission can be revoked from a role:
``` bash
$role->revokePermissionTo('edit articles');
```
The givePermissionTo and revokePermissionTo-functions can accept a string or a Permission-object.

Saved permission and roles are also registered with the Illuminate\Auth\Access\Gate-class.
``` bash
$user->can('edit articles');
```
### Using blade directives

This package also adds Blade directives to verify whether the currently logged in user has all or any of a given list of roles.
``` bash
@role('writer')
I'm a writer!
@else
I'm not a writer...
@endrole
@hasrole('writer')
I'm a writer!
@else
I'm not a writer...
@endhasrole
@hasanyrole(Role::all())
I have one or more of these roles!
@else
I have none of these roles...
@endhasanyrole
@hasallroles(Role::all())
I have all of these roles!
@else
I don't have all of these roles...
@endhasallroles
You can use Laravel's native @can directive to check if a user has a certain permission.
```



## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

## Credits

- [Cristian Tabacitu][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/backpack/settings.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laravel-backpack/settings/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/settings.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laravel-backpack/settings.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/backpack/settings.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/backpack/settings
[link-travis]: https://travis-ci.org/laravel-backpack/settings
[link-scrutinizer]: https://scrutinizer-ci.com/g/laravel-backpack/settings/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laravel-backpack/settings
[link-downloads]: https://packagist.org/packages/backpack/settings
[link-author]: http://tabacitu.ro
[link-contributors]: ../../contributors
