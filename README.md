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

This package is just a user interface for [spatie/laravel-permission](https://github.com/spatie/laravel-permission). It will install it, and let you use its API in code. Please refer to their README for more information on how to use in code.

![Edit a user in Backpack/PermissionManager](https://backpackforlaravel.com/uploads/screenshots/permissions_users_edit.png)



> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.


## Install

1) In your terminal:

``` bash
composer require backpack/permissionmanager
```

2) Publish the config file & run the migrations
```bash
php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider" #publish config files and migrations
php artisan migrate #create the role and permission tables
```

3) Use the following traits on your User model:
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

4) Change your ```config/auth.php``` to use ```Backpack\Base\app\Models\BackpackUser::class```:

```diff
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
-            'model' => App\User::class,
+            'model' => Backpack\Base\app\Models\BackpackUser::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
```

5) [Optional] Add a menu item for it in ```resources/views/vendor/backpack/base/inc/sidebar_content.blade.php``` or ```menu.blade.php```:

```html
<!-- Users, Roles Permissions -->
  <li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>
```

6) [Optional] Disallow create/update on your roles or permissions after you define them, using the config file in **config/backpack/permissionmanager.php**. Please note permissions and roles are referenced in code using their name. If you let your admins edit these strings and they do, your permission and role checks will stop working.


## API Usage

Because the package requires [spatie/laravel-permission](https://github.com/spatie/laravel-permission), the API will be the same. Please refer to their README file for a complete API. Here's a summary though:

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

## Upgrade guide

On June 7th 2018 we've upgraded from using ```spatie/laravel-permission``` 1.4 to 2.12. The changes in our package have been minor. But in their package they have been massive - including a different database schema. They have provided no upgrade guide for going from 1.x to 2.x. We have not developed such a guide either. If/when we do, we'll link it here. Our 2 cents: use the 1.x version if it works for you, and you don't need any new features. The hassle of changing all you database structure is not worth it.

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

When creating your own controllers, seeders, make sure you use the ```BackpackUser``` model, instead of the ```User``` model in your app. The easiest would be to use ```config('backpack.base.user_model_fqn')``` which pulls in the User model fully qualified namespace, as defined in your ```config/backpack/base.php```. You might need to instantiate it using ```$model = config('backpack.base.user_model_fqn'); $model = new $model;``` in order to do things like ```$model->where(...)```.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.

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
