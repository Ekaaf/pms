<?php

namespace App\Http\Requests\RoomCategory;

use Illuminate\Foundation\Http\FormRequest;

class RoomCategorySaveRequest extends FormRequest
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
            'category' => 'required|unique:room_categories',
            'size'    => 'required|numeric',
            'people_adult' => 'required|numeric',
            'people_child' => 'required|numeric',
            'bed' => 'required',
            'price' => 'required|numeric',
            'thumb_image' => 'required|image',
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
