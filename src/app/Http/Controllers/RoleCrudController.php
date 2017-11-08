<?php

namespace Backpack\PermissionManager\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION
use Backpack\PermissionManager\app\Http\Requests\RoleCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\RoleCrudRequest as UpdateRequest;

class RoleCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(config('permission.models.role'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.role'), trans('backpack::permissionmanager.roles'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/role');

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                // n-n relationship (with pivot table)
                'label'     => ucfirst(trans('backpack::permissionmanager.permission_plural')),
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            ],
        ]);

        $this->crud->addField([
            'name'  => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type'  => 'text',
        ]);
        $this->crud->addField([
            'label'     => ucfirst(trans('backpack::permissionmanager.permission_plural')),
            'type'      => 'checklist',
            'name'      => 'permissions',
            'entity'    => 'permissions',
            'attribute' => 'name',
            'model'     => "Backpack\PermissionManager\app\Models\Permission",
            'pivot'     => true,
        ]);

        if (config('backpack.permissionmanager.allow_role_create') == false) {
            $this->crud->denyAccess('create');
        }
        if (config('backpack.permissionmanager.allow_role_update') == false) {
            $this->crud->denyAccess('update');
        }
        if (config('backpack.permissionmanager.allow_role_delete') == false) {
            $this->crud->denyAccess('delete');
        }
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
