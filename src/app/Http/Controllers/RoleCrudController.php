<?php

namespace Backpack\PermissionManager\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION
use Backpack\PermissionManager\app\Http\Requests\RoleCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\RoleCrudRequest as UpdateRequest;

class RoleCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel("Backpack\PermissionManager\app\Models\Role");
        $this->crud->setEntityNameStrings(trans('permissionmanager.role'), trans('permissionmanager.roles'));
        $this->crud->setRoute('admin/role');
        $this->crud->setColumns([
                [
                    'name'  => 'name',
                    'label' => trans('permissionmanager.name'),
                    'type'  => 'text',
                ],
                [
                    // n-n relationship (with pivot table)
                    'label'     =>  ucfirst(trans('permissionmanager.permission_plural')),
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
                                'label' => trans('permissionmanager.name'),
                                'type'  => 'text',
                            ]);
        $this->crud->addField([
                                'label'     => ucfirst(trans('permissionmanager.permission_plural')),
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
