<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserCreateRequest extends FormRequest
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
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'address' => 'nullable',
        ];
        return array_merge(
            $rules,
            $this->codeRules(true, 'national_code', 10),
            $this->codeRules(true, 'economical_code', 14),
            $this->codeRules(true, 'register_code', 0),
            $this->codeRules(true, 'phone1', 11),
            $this->codeRules(true, 'phone2', 11),
            $this->codeRules(true, 'phone3', 11),
            $this->passwordRules(true),
            $this->usernameRules(true),
            $this->mobileRules(true),
            $this->mobilesmsRules(true),
            $this->emailRules(true),
            $this->nameRules(true, 'first_name'),
            $this->nameRules(true, 'last_name'),
            $this->nameRules(true, 'corporate_name'),
            $this->typeRules(true),
            $this->sexRules(true),
            $this->postRules(true),
            $this->imageRules(true),
        );
    }
}
