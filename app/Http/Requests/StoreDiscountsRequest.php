<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use App\Models\Main;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountsRequest extends FormRequest
{
    use CommonValidationRules;
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
        $rules = [
            'type' => 'required|numeric',
            'title' => 'required|min:3',
            'description' => 'nullable',
            'discount_code' => 'nullable|min:3|unique:discounts,discount_code',
            'percent' => 'nullable|numeric',
            'qty' => 'nullable|numeric',
            'fee' => 'nullable|numeric',
            'min_order' => 'nullable|numeric',
            'min_qty' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'cat_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
        ];
        return array_merge(
            $rules,
        );
    }
}