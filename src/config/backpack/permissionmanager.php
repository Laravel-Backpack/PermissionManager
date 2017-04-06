<?php

return [

    /*
    | Backpack/PermissionManager configs.
    */

    /*
    |--------------------------------------------------------------------------
    | User Fully-Qualified Class Name
    |--------------------------------------------------------------------------
    |
    */
    'user_model' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | Set this to false if you would like to use your own AuthController and PasswordController
    | (you then need to setup your auth routes manually in your routes.php file)
     */
    'setup_role_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Disallow the user interface for creating/updating permissions or roles.
    |--------------------------------------------------------------------------
    | Roles and permissions are used in code by their name
    | - ex: $user->hasPermissionTo('edit articles');
    |
    | So after the developer has entered all permissions and roles, the administrator should either:
    | - not have access to the panels
    | or
    | - creating and updating should be disabled
    */

    'allow_permission_create' => true,
    'allow_permission_update' => true,
    'allow_permission_delete' => true,
    'allow_role_create'       => true,
    'allow_role_update'       => true,
    'allow_role_delete'       => true,

];
