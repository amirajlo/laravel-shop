<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentsRequest extends FormRequest
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
            'title' => 'nullable|min:3',
            'email' => 'required|email',
            'description' => 'required|min:6',
            'score' => 'required|numeric|between:1,5',
            'positive_points' => 'string',
            'negative_points' => 'string',
            'website' => 'nullable|url:http,https',
            'like' => 'nullable|numeric',
            'dis_like' => 'nullable|numeric',
        ];
        return array_merge(
            $rules,
            $this->mobilesmsRules(true, 'mobile'),
        );

    }
}
