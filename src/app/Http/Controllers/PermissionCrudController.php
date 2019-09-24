<?php

namespace Backpack\PermissionManager\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION

class PermissionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        $role_model = config('backpack.permissionmanager.models.role');
        $permission_model = config('backpack.permissionmanager.models.permission');

        $this->crud->setModel($permission_model);
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.permission_singular'), trans('backpack::permissionmanager.permission_plural'));
        $this->crud->setRoute(backpack_url('permission'));

        // deny access according to configuration file
        if (config('backpack.permissionmanager.allow_permission_create') == false) {
            $this->crud->denyAccess('create');
        }
        if (config('backpack.permissionmanager.allow_permission_update') == false) {
            $this->crud->denyAccess('update');
        }
        if (config('backpack.permissionmanager.allow_permission_delete') == false) {
            $this->crud->denyAccess('delete');
        }

        $this->crud->operation('list', function () {
            $this->crud->addColumn([
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ]);

            if (config('backpack.permissionmanager.multiple_guards')) {
                $this->crud->addColumn([
                    'name'  => 'guard_name',
                    'label' => trans('backpack::permissionmanager.guard_type'),
                    'type'  => 'text',
                ]);
            }
        });

        $this->crud->operation(['create', 'update'], function () {
            $this->crud->addField([
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ]);

            if (config('backpack.permissionmanager.multiple_guards')) {
                $this->crud->addField([
                    'name'    => 'guard_name',
                    'label'   => trans('backpack::permissionmanager.guard_type'),
                    'type'    => 'select_from_array',
                    'options' => $this->getGuardTypes(),
                ]);
            }

            //otherwise, changes won't have effect
            \Cache::forget('spatie.permission.cache');
        });
    }

    /*
     * Get an array list of all available guard types
     * that have been defined in app/config/auth.php
     *
     * @return array
     **/
    private function getGuardTypes()
    {
        $guards = config('auth.guards');

        $returnable = [];
        foreach ($guards as $key => $details) {
            $returnable[$key] = $key;
        }

        return $returnable;
    }
}
