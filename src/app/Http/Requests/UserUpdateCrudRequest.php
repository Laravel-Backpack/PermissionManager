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
        $id = $this->get('id') ?? request()->route('id');

        $rules = [
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email,'.$id,
            'name'     => 'required',
        ];

        if (config('backpack.permissionmanager.models.user.is_password_enabled', true)) {
            $rules['password'] = 'confirmed';
        }

        return $rules;
    }
}
