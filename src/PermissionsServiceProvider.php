<?php namespace Backpack\Permissions;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Config;

class PermissionsServiceProvider extends ServiceProvider
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
        // publish the migrations
        $this->publishes([ __DIR__.'/database/migrations/' => database_path('migrations') ], 'migrations');
    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Backpack\Permissions\app\Http\Controllers'], function($router)
        {
            require __DIR__.'/app/Http/routes.php';
        });
    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerPermissions();
        $this->setupRoutes($this->app->router);

        // use this if your package has a config file
         config([
                 'config/laravel-permission.php',
         ]);
    }
    
}