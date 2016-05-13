<?php namespace Backpack\PermissionManager\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;

class UserCrudController extends CrudController {

	public function __construct() {
		parent::__construct();

        $this->crud->setModel("App\User");
        $this->crud->setEntityNameStrings('user', 'users');
        $this->crud->setRoute('admin/user');
        $this->crud->setColumns([
	        	[
					'name' => 'name',
					'label' => 'Name',
					'type' => 'text',
				],
				[
					'name' => 'email',
					'label' => 'Email',
					'type' => 'email',
				],
        	]);

		$this->crud->fields = [
								[
									'name' => 'name',
									'label' => 'Name',
									'type' => 'text',
								],
								[
									'name' => 'email',
									'label' => 'Email',
									'type' => 'email',
								],
								[
									'name' => 'password',
									'label' => 'Password',
									'type' => 'password',
								],
								[
									'name' => 'password_confirmation',
									'label' => 'Password Confirmation',
									'type' => 'password',
								],
								[
								// n-n relationship (with pivot table)
								'label' => "User Role Permissions",
								'field_unique_name'=>'user_role_permission',
								'type' => 'checklist_dependency',
								'name' => ['roles', 'permissions'], // the methods that defines the relationship in your Model
								'dependencies' =>
								[
									'primary' =>[
										'label' => 'Roles',
										'name' => 'roles', // the method that defines the relationship in your Model
										'entity' => 'roles', // the method that defines the relationship in your Model
										'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
										'attribute' => 'name', // foreign key attribute that is shown to user
										'model' => "Backpack\PermissionManager\app\Models\Role", // foreign key model
										'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
										'number_columns' => 3, //can be 1,2,3,4,6 
									],
									'secondary'=>[
										'label' => 'Permission',
										'name' => 'permissions', // the method that defines the relationship in your Model
										'entity' => 'permissions', // the method that defines the relationship in your Model
										'entity_primary' => 'roles', // the method that defines the relationship in your Model
										'attribute' => 'name', // foreign key attribute that is shown to user
										'model' => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
										'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
										'number_columns' => 3, //can be 1,2,3,4,6 
									],
								],
							],
						];
	}

	/**
	 * Store a newly created resource in the database.
	 *
	 * @param  StoreRequest  $request - type injection used for validation using Requests
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(StoreRequest $request)
	{
		$this->crud->hasAccessOrFail('create');
		
		// insert item in the db
		$item = $this->crud->create(\Request::except(['redirect_after_save', 'password']));

		//encrypt password 
		if($request->input('password')){
			$item->password = bcrypt($request->input('password'));
		}

		// show a success message
		\Alert::success(trans('backpack::crud.insert_success'))->flash();

		// redirect the user where he chose to be redirected
		switch (\Request::input('redirect_after_save')) {
			case 'current_item_edit':
				return \Redirect::to($this->crud->route.'/'.$item->id.'/edit');

			default:
				return \Redirect::to(\Request::input('redirect_after_save'));
		}
	}

	public function update(UpdateRequest $request)
	{
		//encrypt password and set it to request
		$this->crud->hasAccessOrFail('update');
		
		$dataToUpdate = \Request::except(['redirect_after_save', 'password']);
		
		//encrypt password 
		if( $request->input('password') ){
			$dataToUpdate["password"] = bcrypt($request->input('password'));
		}

		// update the row in the db
		$this->crud->update(\Request::get('id'), $dataToUpdate );

		// show a success message
		\Alert::success(trans('backpack::crud.update_success'))->flash();

		return \Redirect::to($this->crud->route);
	}
}
