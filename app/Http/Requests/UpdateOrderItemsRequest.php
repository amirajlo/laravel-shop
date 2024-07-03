<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemsRequest extends FormRequest
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
            'order_id' => 'nullable',
            'qty' => 'numeric',
            'fee' => 'numeric',
            'total' => 'numeric',
            'discount_id' => 'numeric|exists:discounts,id',
            'discount' => 'numeric',
            'discount_description' => 'nullable',
            'product_id' => 'numeric|exists:products,id',
            'guest_token' => 'nullable',
            'description' => 'nullable',
        ];
        return array_merge(
            $rules,
        );

    }

}
