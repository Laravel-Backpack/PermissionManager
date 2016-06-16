<?php

namespace Backpack\PermissionManager\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION
use Backpack\PermissionManager\app\Http\Requests\PermissionCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\PermissionCrudRequest as UpdateRequest;

class PermissionCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel("Backpack\PermissionManager\app\Models\Permission");
        $this->crud->setEntityNameStrings('permission', 'permissions');
        $this->crud->setRoute('admin/permission');


        $this->crud->addColumn([
                    'name'  => 'name',
                    'label' => 'Name',
                    'type'  => 'text',
                ]);
        $this->crud->addColumn([ // n-n relationship (with pivot table)
                    'label'     => 'Roles that have this permission',
                    'type'      => 'select_multiple',
                    'name'      => 'roles',
                    'entity'    => 'roles',
                    'attribute' => 'name',
                    'model'     => "Backpack\PermissionManager\app\Models\Role",
                    'pivot'     => true,
                ]);

        $this->crud->addField([
                                'name'  => 'name',
                                'label' => 'Name',
                                'type'  => 'text',
                            ]);
        $this->crud->addField([
                                'label'     => 'Roles',
                                'type'      => 'checklist',
                                'name'      => 'roles',
                                'entity'    => 'roles',
                                'attribute' => 'name',
                                'model'     => "Backpack\PermissionManager\app\Models\Role",
                                'pivot'     => true,
                            ]);

        if (!config('backpack.permissionmanager.allow_permission_create')) {
            $this->crud->denyAccess('create');
        }
        if (!config('backpack.permissionmanager.allow_permission_update')) {
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
