<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required',
            'password_confirm'      => 'required|same:password',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'first_name.required'           => trans('admin::users.first_name_required'),
            'last_name.required'            => trans('admin::users.last_name_required'),
            'email.required'                => trans('admin::users.email_required'),
            'email.email'                   => trans('admin::users.email_email'),
            'email.unique'                  => trans('admin::users.email_unique'),
            'password.required'             => trans('admin::users.password_required'),
            'password_confirm.required'     => trans('admin::users.password_confirm_required'),
            'password_confirm.same'         => trans('admin::users.password_confirm_same'),
        ];
    }
}
