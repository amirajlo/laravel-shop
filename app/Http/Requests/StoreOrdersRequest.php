<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrdersRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'title' => 'nullable|min:3',
            'delivery_price' => 'nullable|numeric',
            'delivery_discount' => 'nullable|numeric',
            'delivery_total' => 'nullable|numeric',
            'delivery_description' => 'nullable|numeric',
            'total_price' => 'nullable|numeric',
            'total_discount' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'payment_status' => 'nullable|numeric',
            'email' => 'nullable|email',
            'description' => 'nullable',


        ];
        return array_merge(
            $rules,
            $this->mobilesmsRules(true,'mobile'),
            $this->codeRules(true, 'phone', 11),
        );

    }
}
