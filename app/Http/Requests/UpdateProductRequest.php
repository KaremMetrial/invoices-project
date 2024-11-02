<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_name' => 'required|max:255|unique:products,product_name,' . $this->id,
            'section_id' => 'required',
            'description' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'يرجي ادخال اسم القسم',
            'product_name.unique' => 'اسم القسم مسجل مسبقا',
            'section_id.required' => 'يرجي اختيار اسم القسم',
            'description.required' => 'يرجي ادخال بيانات الوصف',
        ];
    }
}
