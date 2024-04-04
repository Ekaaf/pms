<?php

namespace App\Http\Requests\RoomCategory;

use Illuminate\Foundation\Http\FormRequest;

class RoomCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'required|unique:room_categories,category,'.$this->id,
            'size'    => 'required|numeric',
            'people_adult' => 'required|numeric',
            'people_child' => 'required|numeric',
            'bed' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'package' => 'required',
            'facilities' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'check_in_instruction' => 'required',
            'cancellation_policy' => 'required'
        ];
    }
}
