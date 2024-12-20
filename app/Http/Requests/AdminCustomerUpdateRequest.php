<?php

namespace App\Http\Requests;

use App\CommonValidationRules;
use App\Models\Main;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminCustomerUpdateRequest extends FormRequest
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
                $this->nationalRules(false, 10, $this->model->id),
                $this->economicalRules(false, 14, $this->model->id),
                $this->codeRules(false, 'register_code', 0),
                $this->codeRules(false, 'phone1', 11),
                $this->codeRules(false, 'phone2', 11),
                $this->codeRules(false, 'phone3', 11),
                $this->passwordRules(false),
                $this->usernameRules(false, $this->model->id),
                $this->mobileRules(false, $this->model->id),
                $this->mobilesmsRules(false),
                $this->emailRules(false, $this->model->id),
                $this->nameRules(false, 'first_name'),
                $this->nameRules(false, 'last_name'),
                $this->nameRules(false, 'corporate_name'),
                $this->typeRules(false),
                $this->sexRules(false),
                $this->postRules(false),
                $this->imageRules(false),
            );
    }
}
