<?php

namespace App\Http\Requests;

// use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserAddRequest extends FormRequest
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
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4',
            'role_id' => 'required'
        ];
    }

    public function messages(){
        return [
            'email' => 'Please enter a valid email address',
            // 'username.required' => 'Please enter username',
            // 'password.required' => 'Please enter password',
            // 'password.min' => 'Password must be at least 4 character',
            // 'password.confirmed' => 'Password and confirm password do not match',
            // 'password_confirmation.required' => 'Please enter confirm password',
            // 'role_id.required' => 'Please select role',
            // 'department.required' => 'Please select department',
            // 'email.required' => 'Please enter a valid email address',
            // 'email.email' => 'Please enter a valid email address',
            // 'emp_id.required' => 'Please enter 9 digit employee ID'
        ];
    }
}
