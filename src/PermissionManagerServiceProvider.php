<?php

namespace Backpack\PermissionManager;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class PermissionManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/laravel-permission.php', 'laravel-permission'
        );
        $this->mergeConfigFrom(
            __DIR__.'/config/backpack/permissionmanager.php', 'backpack.permissionmanager'
        );

        // publish config file
        $this->publishes([__DIR__.'/config' => config_path()], 'config');

        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');

        // publish translation files
        $this->publishes([__DIR__.'/resources/lang' => resource_path('lang/vendor/backpack')], 'lang');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Backpack\PermissionManager\app\Http\Controllers'], function ($router) {
            \Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'admin']], function () {
                \CRUD::resource('permission', 'PermissionCrudController');
                \CRUD::resource('role', 'RoleCrudController');
                \CRUD::resource('user', 'UserCrudController');
            });
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes($this->app->router);

        $this->app->register(PermissionServiceProvider::class);
    }
}
