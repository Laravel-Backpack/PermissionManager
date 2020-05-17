<?php

namespace Backpack\PermissionManager\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
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
        $returnable = [
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email',
            'name'     => 'required',
            'password' => 'required|confirmed',
        ];

        if(config('backpack.base.authentication_column') !== 'email') {
            $returnable[config('backpack.base.authentication_column')] = 'required|unique:'.config('permission.table_names.users', 'users').','.config('backpack.base.authentication_column');
        }

        return $returnable;
    }
}
