<?php

namespace App\Http\Requests\RoomCategoryRent;

use Illuminate\Foundation\Http\FormRequest;

class RoomCategoryRentSaveRequest extends FormRequest
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
            'room_category_id' => 'required',
            'from_date'    => 'required|date_format:Y-m-d|after:today',
            'to_date' => 'required|date_format:Y-m-d|after_or_equal:from_date',
            'price' => 'required|numeric',
            'discount' => 'required|numeric'
        ];
    }
}
