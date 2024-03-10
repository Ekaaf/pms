<?php

namespace App\Http\Requests;

// use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
        $rules['password'] = 'required|min:4|confirmed';
        $rules['password_confirmation'] = 'required|min:4';
        if(is_null(\Request::segment(4))){
            $rules['old_password'] = 'required';
        }
        return $rules;
    }

    public function messages(){
        $rules = [
            'password.required' => 'Please enter password',
            'password.min' => 'Password must be at least 4 character',
            'password.confirmed' => 'Password and confirm password do not match',
            'password_confirmation.required' => 'Please enter confirm password',
        ];
        if(is_null(\Request::segment(4))){
            $rules['old_password.required'] = 'Please enter your old password';
        }
        return $rules;
    }
}
