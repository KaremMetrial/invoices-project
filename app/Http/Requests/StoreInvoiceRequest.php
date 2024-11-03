<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|max:255',
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date|after_or_equal:invoice_Date',
            'product' => 'required',
            'Section' => 'required|exists:sections,id',
            'Amount_collection' => 'required|numeric',
            'Amount_Commission' => 'required|numeric',
            'Discount' => 'nullable|numeric',
            'Value_VAT' => 'nullable|numeric',
            'Rate_VAT' => 'nullable|string',
            'Total' => 'required|numeric',
            'note' => 'nullable|string',
            'pic' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
