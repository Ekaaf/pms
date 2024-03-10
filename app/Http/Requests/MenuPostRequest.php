<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MenuPostRequest extends FormRequest
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
            'title' => 'required',
            'path' => 'required_if:is_submenu,==,1',
            'parent_id' => 'required_if:is_submenu,==,1'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Please enter menu title',
            'path.required_if' => 'Please select path',
            'parent_id.required_if' => 'Please select parent menu'
        ];
    }
}
