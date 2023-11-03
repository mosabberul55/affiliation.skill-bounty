<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
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
//            'user_id' => ['required', 'integer', 'exists:users,id'],
            'customer_phone' => ['required', 'string', 'max:11', 'size:11'],
            'customer_name' => ['nullable', 'string', 'max:100'],
            'sale_price' => ['nullable', 'numeric', 'max:9999999999.99'],
            'percent' => ['nullable', 'numeric', 'max:100'],
            'code' => ['nullable', 'string', 'max:10'],
        ];
    }
}
