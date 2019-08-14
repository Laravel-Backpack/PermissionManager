<?php

namespace Backpack\PermissionManager\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userModel = config('backpack.permissionmanager.models.user');
        $user = new $userModel;

        if (!$user->find($this->get('id'))) {
            abort(400, 'Could not find that entry in the database.');
        }

        return [
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email,'.$this->get('id'),
            'name'     => 'required',
            'password' => 'confirmed',
        ];
    }
}
