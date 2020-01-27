<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'fullname' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'gender' => 'required|bool',
            'time_user' => 'required',
            'permissions' => 'required|bool',
            'image_user' => 'image|mimes:jpg,jpeg,png,svg,gif',
            'working_hrs' => 'integer|min:0'
        ];
    }
}
