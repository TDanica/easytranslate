<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            'code' => 'required|string|size:3|unique:currencies,code',
            'name' => 'required|string|max:255',  
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'The currency code is required.',
            'code.size' => 'The currency code must be exactly 3 characters.',
            'code.unique' => 'The currency code has already been taken.',
            'name.required' => 'The currency name is required.',
            'name.max' => 'The currency name cannot exceed 255 characters.',
        ];
    }
}
