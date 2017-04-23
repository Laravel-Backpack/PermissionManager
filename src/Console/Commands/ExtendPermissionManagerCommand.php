<?php

namespace Backpack\PermissionManager\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class ExtendPermissionManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:crud-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extend CRUD permissions: Controllers, Models, Requests';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Extend the PermissionCrudController and show output
        Artisan::call('backpack:crud-permission-controller', ['name' => 'Permission']);
        echo Artisan::output();
        // Extend the RoleCrudController and show output
        Artisan::call('backpack:crud-permission-controller', ['name' => 'Role']);
        echo Artisan::output();
        // Extend the UserCrudController and show output
        Artisan::call('backpack:crud-permission-controller', ['name' => 'User', '--user' => 'default']);
        echo Artisan::output();

        // Extend the PermissionCrudRequest and show output
        Artisan::call('backpack:crud-permission-request', ['name' => 'Permission']);
        echo Artisan::output();
        // Extend the RoleCrudRequest and show output
        Artisan::call('backpack:crud-permission-request', ['name' => 'Role']);
        echo Artisan::output();
        // Extend the UserStoreCrudRequest and show output
        Artisan::call('backpack:crud-permission-request', ['name' => 'UserStore']);
        echo Artisan::output();
        // Extend the UserUpdateCrudRequest and show output
        Artisan::call('backpack:crud-permission-request', ['name' => 'UserUpdate']);
        echo Artisan::output();

        // Extend the Permission model and show output
        Artisan::call('backpack:crud-permission-model', ['name' => 'Permission']);
        echo Artisan::output();
        // Extend the Role model and show output
        Artisan::call('backpack:crud-permission-model', ['name' => 'Role']);
        echo Artisan::output();
    }
}
