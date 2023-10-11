# Backpack\PermissionManager

[![Latest Version on Packagist][ico-version]](link-packagist)
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Style CI](https://styleci.io/repos/58740020/shield)](https://styleci.io/repos/58740020)
[![Total Downloads][ico-downloads]][link-downloads]

Admin interface for [spatie/laravel-permission](https://github.com/spatie/laravel-permission). It allows admins to easily add/edit/remove users, roles and permissions, using [Laravel Backpack](https://laravelbackpack.com).

As opposed to some other packages:
- a user can have multiple roles;
- a user can have extra permissions, in addition to the permissions on the roles he has;

This package is just a user interface for [spatie/laravel-permission](https://github.com/spatie/laravel-permission). It will install it, and let you use its API in code. Please refer to their README for more information on how to use in code.

![Edit a user in Backpack/PermissionManager](https://backpackforlaravel.com/uploads/screenshots/permissions_users_edit.png)



> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.


## Install

0) This package assumes you've already installed [Backpack for Laravel](https://backpackforlaravel.com). If you haven't, please [install Backpack first](https://backpackforlaravel.com/docs/3.5/installation).

1) In your terminal:

``` bash
composer require backpack/permissionmanager
```

2) Finish all installation steps for [spatie/laravel-permission](https://github.com/spatie/laravel-permission#installation), which as been pulled as a dependency. Run its migrations. Publish its config files. Most likely it's:
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
// then First, add the Spatie\Permission\Traits\HasRoles trait to your User model(s)
```

3) Publish the config file & run the migrations
```bash
php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider"
```

4) The package assumes it's ok to use ```App\Models\BackpackUser``` to administer Users. Use a different one if you'd like by changing the user model in the ```config/backpack/permissionmanager.php``` file. Any model you're using, make sure it's using the ```CrudTrait``` and ```HasRoles``` traits:
```php
<?php namespace App;

use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
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

5) [Optional] Add a menu item for it in ```resources/views/vendor/backpack/base/inc/sidebar_content.blade.php``` or ```menu.blade.php```:

```html
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
	</ul>
</li>
```

6) [Optional] If you want to use the ```@can``` handler inside Backpack routes, you can:

(6.A.) Change Backpack to use the default ```web``` guard instead of its own guard. Inside ```config/backpack/base.php``` change:
```diff
    // The guard that protects the Backpack admin panel.
    // If null, the config.auth.defaults.guard value will be used.
-   'guard' => 'backpack',
+   'guard' => null,
```
Note:
- when you add new roles and permissions, the guard that gets saved in the database will be "web";

OR

(6.B.) Add a middleware to all your Backpack routes by adding this to your ```config/backpack/base.php``` file:
```diff
    // The classes for the middleware to check if the visitor is an admin
    // Can be a single class or an array of clases
    'middleware_class' => [
        App\Http\Middleware\CheckIfAdmin::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
+       Backpack\Base\app\Http\Middleware\UseBackpackAuthGuardInsteadOfDefaultAuthGuard::class,
    ],
```

Why? spatie/laravel-permission uses the ```Auth``` facade for determining permissions with ```@can```. The ```Auth``` facade uses the default guard defined in ```config/auth.php```, NOT our backpack guard.

Please note:
- this will make ```auth()``` return the exact same thing as ```backpack_auth()``` on Backpack routes;
- you only need this if you want to use ```@can```; you can just as well use ```@if(backpack_user()->can('read'))```, which does the exact same thing, but works 100% of the time;
- when you add new roles and permissions, the guard that gets saved in the database will be "backpack";


7) [Optional] Disallow create/update on your roles or permissions after you define them, using the config file in **config/backpack/permissionmanager.php**. Please note permissions and roles are referenced in code using their name. If you let your admins edit these strings and they do, your permission and role checks will stop working.


## Customize UserCrudController

If you would like to add more fields to the default user controller provided by this package, you can bind your own controller to overwrite the one provided in this package:

```php
// in some ServiceProvider, AppServiceProvider for example

$this->app->bind(
    \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, //this is package controller
    \App\Http\Controllers\Admin\UserCrudController::class //this should be your own controller
);

// this tells Laravel that when UserCrudController is requested, your own UserCrudController should be served.
```


## API Usage

Because the package requires [spatie/laravel-permission](https://github.com/spatie/laravel-permission), the API will be the same. Please refer to their README file for a complete API. Here's a summary though:


### Using permissions

A permission can be given to a user:

``` bash
backpack_user()->givePermissionTo('edit articles');
```
A permission can be revoked from a user:
``` bash
backpack_user()->revokePermissionTo('edit articles');
```
You can test if a user has a permission:
``` bash
backpack_user()->hasPermissionTo('edit articles');
```

Saved permissions will be registered with the Illuminate\Auth\Access\Gate-class. So you can test if a user has a permission with Laravel's default can-function.
``` bash
backpack_user()->can('edit articles');
```
### Using roles and permissions

A role can be assigned to a user:
``` bash
backpack_user()->assignRole('writer');
```
A role can be removed from a user:
``` bash
backpack_user()->removeRole('writer');
```
You can determine if a user has a certain role:
``` bash
backpack_user()->hasRole('writer');
```
You can also determine if a user has any of a given list of roles:
``` bash
backpack_user()->hasAnyRole(Role::all());
```
You can also determine if a user has all of a given list of roles:
``` bash
backpack_user()->hasAllRoles(Role::all());
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
backpack_user()->can('edit articles');
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

## Use permissions in CRUD controllers

CRUD controllers have methods to [dynamically allow or deny access](https://backpackforlaravel.com/docs/6.x/crud-api#access) to operations. The ```$this->crud->allowAccess()``` and ```$this->crud->denyAccess()``` methods control both:
- the form's navigation buttons display like Add, Edit, Delete and
- the security access guards, returning a 403 forbidden error when no permission.

In most cases, you should use `access` and `permission` separately. But if you want to link them together, so a "permission" gives "access", here is how you can do that too. Reminder: permissions can be assigned to a user either directly or through a role.

1) Define a ```CrudPermissionTrait```
``` php
namespace App\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * CrudPermissionTrait: use Permissions to configure Backpack
 */
trait CrudPermissionTrait
{
    // the operations defined for CRUD controller
    public array $operations = ['list', 'show', 'create', 'update', 'delete'];


    /**
     * set CRUD access using spatie Permissions defined for logged in user
     *
     * @return void
     */
    public function setAccessUsingPermissions()
    {
        // default
        $this->crud->denyAccess($this->operations);

        // get context
        $table = CRUD::getModel()->getTable();
        $user = request()->user();

        // double check if no authenticated user
        if (!$user) {
            return; // allow nothing
        }

        // enable operations depending on permission
        foreach ([
            // permission level => [crud operations]
            'see' => ['list', 'show'], // e.g. permission 'users.see' allows to display users
            'edit' => ['list', 'show', 'create', 'update', 'delete'], // e.g. 'users.edit' permission allows all operations
        ] as $level => $operations) {
            if ($user->can("$table.$level")) {
                $this->crud->allowAccess($operations);
            }
        }
    }
}
```

2) Use the above ```CrudPermissionTrait``` trait in any ````CrudController````, ```UserCrudController``` in this example.

```php
namespace App\Http\Controllers\Admin;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;

class UserCrudController extends BackpackUserCrudController
{
    use \App\Traits\CrudPermissionTrait;

    public function setup()
    {
        parent::setup();
        $this->setAccessUsingPermissions();
    }
}
```

Now make sure the route uses the right controller:

(3.A) by binding the package controller to your controller as explained in [Customize UserCrudController](https://github.com/Laravel-Backpack/PermissionManager#customize-usercrudcontroller)

```php
$this->app->bind(
    \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, // package controller
    \App\Http\Controllers\Admin\UserCrudController::class // the controller using CrudPermissionTrait
);
```

OR

(3.B) by defining the routes in your own ```routes/backpack/permissionmanager.php``` file as explained in [Overwriting fuctionality](https://github.com/Laravel-Backpack/PermissionManager#overwriting-functionality)
```php
Route::group([
    'namespace'  => 'App\Http\Controllers\Admin', // the new namespace
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    // the adapted controllers
    Route::crud('user', 'UserCrudController');
    // Route::crud('role', 'RoleCrudController');
});
Route::group([
    'namespace'  => '\Backpack\PermissionManager\app\Http\Controllers', // the original namespace
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    // to original controllers
    // not modified yet in this example
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
});
```


You may wish to use a ```PermissionSeeder``` to automatically populate the ```permission``` table with permissions corresponding to your code. Here is an example:

```php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database Permission seed.

     * Permissions are fixed in code and are seeded here.
     * use 'php artisan db:seed --class=PermissionSeeder --force' in production
     *
     * @return void
     */
    public function run()
    {
        // create permission for each combination of table.level
        collect([ // tables
            'users',
            'roles',
        ])
            ->crossJoin([ // levels
                'see',
                'edit',
            ])
            ->each(
                fn (array $item) => Permission::firstOrCreate([
                    'name' => implode('.', $item),
                ])
                    ->save()
            )
            //
        ;
        User::first()
            ->givePermissionTo(['users.edit']);
    }
}
```
Use ```php artisan db:seed --class=PermissionSeeder --force``` in production

## Upgrade from 3.x to 4.x

To upgrade from PermissionManager 3.x to 4.x:
- upgrade to spatie/laravel-permission 2.28.2+ - do take note that the DB has changed, and they don't provide a track of the changes;
- require ```backpack/permissionmanager``` version ```4.0.*``` in your ```composer.json``` file;
- delete your old ```config/backpack/permissionmanager.php``` file;
- follow the installation steps above;

If you are upgrading to a Laravel 8 instalation, please note that User Model may have moved from ```App\User::class``` to ```App\Models\User::class```, check if your config is compliant with that change ```config/backpack/permissionmanager.php```.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Screenshots

![Roles table view in Backpack/PermissionManager](https://backpackforlaravel.com/uploads/screenshots/permissions_roles.png)

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
- [Cristian Tabacitu][link-author] - Maintainer
- [All Contributors][link-contributors]

## License

Backpack is free for non-commercial use and 49 EUR/project for commercial use. Please see [License File](LICENSE.md) and [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

## Hire us

We've spend more than 50.000 hours creating, polishing and maintaining administration panels on Laravel. We've developed e-Commerce, e-Learning, ERPs, social networks, payment gateways and much more. We've worked on admin panels _so much_, that we've created one of the most popular software in its niche - just from making public what was repetitive in our projects.

If you are looking for a developer/team to help you build an admin panel on Laravel, look no further. You'll have a difficult time finding someone with more experience & enthusiasm for this. This is _what we do_. [Contact us](https://backpackforlaravel.com/need-freelancer-or-development-team). Let's see if we can work together.


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
