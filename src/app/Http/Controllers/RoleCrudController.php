<?php

namespace Backpack\PermissionManager\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION

class RoleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        $role_model = config('backpack.permissionmanager.models.role');
        $permission_model = config('backpack.permissionmanager.models.permission');

        $this->crud->setModel($role_model);
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.role'), trans('backpack::permissionmanager.roles'));
        $this->crud->setRoute(backpack_url('role'));

        // deny access according to configuration file
        if (config('backpack.permissionmanager.allow_role_create') == false) {
            $this->crud->denyAccess('create');
        }
        if (config('backpack.permissionmanager.allow_role_update') == false) {
            $this->crud->denyAccess('update');
        }
        if (config('backpack.permissionmanager.allow_role_delete') == false) {
            $this->crud->denyAccess('delete');
        }

        $this->crud->operation('list', function () use ($permission_model) {
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
            $this->crud->addColumn([
                // n-n relationship (with pivot table)
                'label'     => ucfirst(trans('backpack::permissionmanager.permission_plural')),
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => $permission_model, // foreign key model
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            ]);
        });

        $this->crud->operation(['create', 'update'], function () use ($permission_model) {
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

            $this->crud->addField([
                'label'     => ucfirst(trans('backpack::permissionmanager.permission_plural')),
                'type'      => 'checklist',
                'name'      => 'permissions',
                'entity'    => 'permissions',
                'attribute' => 'name',
                'model'     => $permission_model,
                'pivot'     => true,
            ]);

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
