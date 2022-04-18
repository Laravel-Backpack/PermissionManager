<?php

namespace Backpack\PermissionManager;

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
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/backpack/permissionmanager.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // define the routes for the application
        $this->setupRoutes($this->app->router);

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/backpack/permissionmanager.php',
            'backpack.permissionmanager'
        );

        // publish config file
        $this->publishes([__DIR__.'/config' => config_path()], 'config');

        // publish translation files
        $this->publishes([__DIR__.'/resources/lang' => app()->langPath().'/vendor/backpack'], 'lang');

        // publish route file
        $this->publishes([__DIR__.$this->routeFilePath => base_path($this->routeFilePath)], 'routes');

        // publish migration from Backpack 4.0 to Backpack 4.1
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');
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
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(PermissionServiceProvider::class);
    }
}
