<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticlesRequest extends FormRequest
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
            'canonical' => 'nullable|url:http,https',
            'is_commentable' => 'nullable',
            'gallery_images' => 'nullable|array|min:1|max:5',
            'gallery_images.*' => 'image|mimes:svg,jpeg,png,jpg,gif,webp|max:4048',

        ];
        return array_merge(
            $rules,
            $this->columnUniqueRules(false, $this->model->id,'articles','title'),
            $this->columnImageRules(true,null,'products','main_image'),
        );
    }
}
