<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {      
        return [
            'fullname' => 'string',
            'username' => 'string',
            'email' => 'required|email',
            'password' => 'confirmed',
            'phone' => '',
            'gender' => 'bool',
            'time_user' => '',
            'permissions' => 'bool',
            'image_user' => 'image|mimes:jpg,jpeg,png,svg,gif',
            'working_hrs' => 'integer|min:0'
        ];
    }
}
