<?php

/*
|--------------------------------------------------------------------------
| Custom Settings Routes
|--------------------------------------------------------------------------
*/

// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {

    // Settings
    Route::resource('permission', 'PermissionCrudController');
    Route::resource('role', 'RoleCrudController');
    Route::resource('user', 'UserCrudController');
});
