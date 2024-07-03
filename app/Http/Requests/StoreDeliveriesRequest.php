<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use App\Models\Main;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveriesRequest extends FormRequest
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
            'title' => 'required|min:3',
            'description' => 'nullable',
            'fee' => 'required|numeric',

        ];
        return array_merge(
            $rules,
            $this->columnImageRules(true,null,'deliveries','main_image'),

        );
    }
}
