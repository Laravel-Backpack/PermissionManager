<?php namespace Backpack\PermissionManager\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION
use Backpack\PermissionManager\app\Http\Requests\PermissionCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\PermissionCrudRequest as UpdateRequest;

class PermissionCrudController extends CrudController {

	public function __construct() {
		parent::__construct();

        $this->crud->setModel("Backpack\PermissionManager\app\Models\Permission");
        $this->crud->setEntityNameStrings('permission', 'permissions');
        $this->crud->setRoute('admin/permission');
         $this->crud->setColumns([
	        	[
					'name' => 'name',
					'label' => 'Name',
					'type' => 'text',
				],
	        	[
					// n-n relationship (with pivot table)
					'label' => "Roles that have this permission",
					'type' => 'select_multiple',
					'name' => 'roles', // the method that defines the relationship in your Model
					'entity' => 'roles', // the method that defines the relationship in your Model
					'attribute' => 'name', // foreign key attribute that is shown to user
					'model' => "Backpack\PermissionManager\app\Models\Role", // foreign key model
					'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
				],
        	]);

        $this->crud->addField([
								'name' => 'name',
								'label' => 'Name',
								'type' => 'text',
							]);
        $this->crud->addField([
								'label' => "Roles",
								'type' => 'checklist',
								'name' => 'roles',
								'entity' => 'roles',
								'attribute' => 'name',
								'model' => "Backpack\PermissionManager\app\Models\Role",
								'pivot' => true,
							]);
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
