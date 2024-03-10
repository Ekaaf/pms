<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.$this->id,
            'role_id' => 'required',
            'mobile' => 'required|unique:users,mobile,'.$this->id
        ];
    }

    // public function messages(){
    //     return [
    //         'name.required' => 'Please enter full name',
    //         'username.required' => 'Please enter username',
    //         'username.unique' => 'Username must be unique',
    //         'role_id.required' => 'Please select role',
    //         'department.required' => 'Please select department',
    //         'email.required' => 'Please enter a valid email address',
    //         'email.email' => 'Please enter a valid email address',
    //         'emp_id.required' => 'Please enter 9 digit employee ID'
    //     ];
    // }
}
