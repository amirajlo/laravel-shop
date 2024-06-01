<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriesRequest extends FormRequest
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
            'redirect' => 'nullable|url:http,https',
            'parent_id' => 'nullable|exists:categories,id',
            'canonical' => 'nullable|url:http,https',
        ];
        return array_merge(
            $rules,
            $this->columnUniqueRules(false, $this->model->id,'categories','title'),
            $this->CategoriesTypeRules(false),
        );
    }
}
