<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'section_id' => 'required|exists:sections,id',

        ];
    }
    public function messages(){
        return [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'description.required' => 'يرجي ادخال الوصف',
            'section_id.required' => 'يرجي ادخال القسم',
            'section_id.exists' => 'القسم غير موجود',
        ];
    }
}
