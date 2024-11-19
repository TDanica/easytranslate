<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class ConversionRequest extends FormRequest
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
            'from' => 'required|integer|exists:currencies,id',
            'to' => 'required|integer|exists:currencies,id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'from.required' => 'The source currency is required.',
            'from.size' => 'The source currency must be a 3-letter code.',
            'from.exists' => 'The source currency must exist in the database.',
            'to.required' => 'The target currency is required.',
            'to.size' => 'The target currency must be a 3-letter code.',
            'to.exists' => 'The target currency must exist in the database.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a numeric value.',
            'amount.min' => 'The amount must be at least 0.01.',
        ];
    }
}
