# Backpack\PermissionManager

[![Latest Version on Packagist][ico-version]](link-packagist)
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Style CI](https://styleci.io/repos/58740020/shield)](https://styleci.io/repos/58740020)
[![Total Downloads][ico-downloads]][link-downloads]

An admin interface to easily add/edit/remove users, roles and permissions, using [Laravel Backpack](https://laravelbackpack.com). As opposed to some other packages:
- a user can have multiple roles;
- a user can have extra permissions, in addition to the permissions on the roles he has;

![Edit a user in Backpack/PermissionManager](https://backpackforlaravel.com/uploads/screenshots/permissions_users_edit.png)



> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://eepurl.com/bUEGjf)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.


## Install

1) In your terminal:

``` bash
$ composer require backpack/permissionmanager
```

2) Add the service provider to your config/app.php file:
```php
Backpack\PermissionManager\PermissionManagerServiceProvider::class,
```

3) Publish the config file & run the migrations
```bash
$ php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider" #publish Backpack config file
$ php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations" #publish migration
$ php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config" #publish Laravel-Permission config file
```

4) After the migration has been published you can create the role- and permission-tables by running the migrations (the `config/permission.php` config file allows you to customize the table names):
```bash
$ php artisan migrate
```

5) Change the following lines inside the `config/permission.php` config file:

On `line 16`, change:
```php
$ 'permission' => Spatie\Permission\Models\Permission::class,
```
to:
```php
$ 'permission' => Backpack\PermissionManager\app\Models\Permission::class,
```

On `line 27`, change:
```php
$ 'role' => Spatie\Permission\Models\Role::class,
```
to:
```php
$ 'role' => Backpack\PermissionManager\app\Models\Role::class,
```

6) Use the following traits on your User model:
```php
<?php namespace App;

use Backpack\CRUD\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Foundation\Auth\User as Authenticatable; 

class User extends Authenticatable
{
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this

    /**
     * Your User Model content
     */
```

7) [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<!-- Users, Roles Permissions -->
  <li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>
```

8) [Optional] Disallow create/update on your roles or permissions after you define them, using the config file in **config/backpack/permissionmanager.php**. Please note permissions and roles are referenced in code using their name. If you let your admins edit these strings and they do, your permission and role checks will stop working.


## API Usage

Because the package requires [spatie/laravel-permission](https://github.com/spatie/laravel-permission), the API will be the same: 

### Using permissions

A permission can be given to a user:

``` bash
$user->givePermissionTo('edit articles');
```
A permission can be revoked from a user:
``` bash
$user->revokePermissionTo('edit articles');
```
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
```
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
    I\'m a writer!
@else
    I\'m not a writer...
@endrole
@hasrole('writer')
    I\'m a writer!
@else
    I\'m not a writer...
@endhasrole
@hasanyrole(Role::all())
    I have one or more of these roles!
@else
    I have none of these roles...
@endhasanyrole
@hasallroles(Role::all())
    I have all of these roles!
@else
    I don\'t have all of these roles
@endhasallroles
```

You can use Laravels native @can directive to check if a user has a certain permission.



## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Screenshots

![Roles table view in Backpack/PermissionManager](https://backpackforlaravel.com/uploads/screenshots/permissions_roles.png)

## Testing

``` bash
// TODO
```

## Overwriting functionality

If you need to modify how this works in a project: 
- create a ```routes/backpack/permissionmanager.php``` file; the package will see that, and load _your_ routes file, instead of the one in the package; 
- create controllers/models that extend the ones in the package, and use those in your new routes file;
- modify anything you'd like in the new controllers/models;

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://eepurl.com/bUEGjf)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.

## Credits

- [Marius Constantin][link-author2] - Lead Developer
- [Cristian Tabacitu][link-author] - Chief Architect
- [All Contributors][link-contributors]

## License

Backpack is free for non-commercial use and 39 EUR/project for commercial use. Please see [License File](LICENSE.md) and [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

[ico-version]: https://img.shields.io/packagist/v/backpack/permissionmanager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laravel-backpack/permissionmanager/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/permissionmanager.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laravel-backpack/permissionmanager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/backpack/permissionmanager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/backpack/permissionmanager
[link-travis]: https://travis-ci.org/laravel-backpack/permissionmanager
[link-scrutinizer]: https://scrutinizer-ci.com/g/laravel-backpack/permissionmanager/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laravel-backpack/permissionmanager
[link-downloads]: https://packagist.org/packages/backpack/permissionmanager
[link-author]: http://tabacitu.ro
[link-author2]: http://updivision.com
[link-contributors]: ../../contributors
