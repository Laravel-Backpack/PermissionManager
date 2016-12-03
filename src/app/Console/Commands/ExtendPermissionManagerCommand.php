<?php

namespace Backpack\PermissionManager\app\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class ExtendPermissionManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:extend:permission-manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extend Backpack\PermissionManager completely: Controllers, Models, Requests';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // CONTROLLERS
        // Extend the PermissionCrudController and show output
        Artisan::call('backpack:extend:permission-crud-controller', ['name' => 'Permission']);
        echo Artisan::output();
        // Extend the RoleCrudController and show output
        Artisan::call('backpack:extend:permission-crud-controller', ['name' => 'Role']);
        echo Artisan::output();
        // Extend the UserCrudController and show output
        Artisan::call('backpack:extend:permission-crud-controller', ['name' => 'User', '--user' => 'default']);
        echo Artisan::output();

        // REQUESTS
        // Extend the PermissionCrudRequest and show output
        Artisan::call('backpack:extend:permission-crud-request', ['name' => 'Permission']);
        echo Artisan::output();
        // Extend the RoleCrudRequest and show output
        Artisan::call('backpack:extend:permission-crud-request', ['name' => 'Role']);
        echo Artisan::output();
        // Extend the UserStoreCrudRequest and show output
        Artisan::call('backpack:extend:permission-crud-request', ['name' => 'UserStore']);
        echo Artisan::output();
        // Extend the UserUpdateCrudRequest and show output
        Artisan::call('backpack:extend:permission-crud-request', ['name' => 'UserUpdate']);
        echo Artisan::output();

        // MODELS
        // Extend the Permission model and show output
        Artisan::call('backpack:extend:permission-crud-model', ['name' => 'Permission']);
        echo Artisan::output();
        // Extend the Role model and show output
        Artisan::call('backpack:extend:permission-crud-model', ['name' => 'Role']);
        echo Artisan::output();

        $this->info('Please remember to register the appropriate routes in your routes file.');
    }
}
