<?php

namespace App;

use App\Models\Main;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait CommonValidationRules
{


    public $onlyEnglish = "regex:/^[a-zA-Z]+$/u";
    public $onlyPersianEnglish = "regex:/^[ا-یa-zA-Zء-ي ]+$/u";
    public $postFormat = "regex:/^[1-9]+[1-9]+[1-9]+[1-9]+[1-9]+[1-9]+[1-9]+[1-9]+[1-9]+[1-9]/";
    public $mobileFormat = "regex:/^0+[0-9]+[0-9]+[0-9]+[0-9]+[0-9]+[0-9]+[0-9]+[0-9]+[0-9]+[0-9]/";


    protected function nameRules($is_new = true, $field)
    {

        $result = ['nullable', 'max:255', 'min:3', $this->onlyPersianEnglish];
        return [
            $field => $result
        ];
    }

    protected function passwordRules($is_new = true)
    {
        $next = "required";
        $result = [Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),'confirmed'];
        if (!$is_new) {
            $next = "nullable";
        }
        $result[] = $next;
        return [
            'password' => $result
        ];
    }

    protected function usernameRules($is_new = true)
    {
        $next = Rule::unique('users', 'username');
        $result = ['required', 'min:3', $this->onlyEnglish, 'string'];
        if (!$is_new) {
            $next = Rule::unique('users', 'username')->ignore($this->admin->id);
        }
        $result[] = $next;
        return [
            'username' => $result
        ];
    }

    protected function mobileRules($is_new = true)
    {
        $next = Rule::unique('users', 'mobile');
        $result = ['required', 'digits:11', $this->mobileFormat];
        if (!$is_new) {
            $next = Rule::unique('users', 'mobile')->ignore($this->admin->id);
        }
        $result[] = $next;
        return [
            'mobile' => $result
        ];
    }

    protected function emailRules($is_new = true)
    {
        $next = Rule::unique('users', 'email');
        $result = ['required', 'email', 'string'];
        if (!$is_new) {
            $next = Rule::unique('users', 'email')->ignore($this->admin->id);
        }
        $result[] = $next;
        return [
            'email' => $result
        ];
    }

    protected function typeRules($is_new = true)
    {
        $typeList = implode(',', array_keys(Main::typeList()));
        $result = ['required', "numeric", "in:$typeList"];
        if (!$is_new) {

        }

        return [
            'type' => $result
        ];
    }

    protected function sexRules($is_new = true)
    {
        $sexList = implode(',', array_keys(Main::sexList()));
        $result = ['required', "numeric", "in:$sexList"];
        if (!$is_new) {

        }

        return [
            'type' => $result
        ];
    }

    protected function mobilesmsRules($is_new = true)
    {

        $result = ['nullable', 'digits:11', $this->mobileFormat];
        if (!$is_new) {

        }

        return [
            'mobile_sms' => $result
        ];
    }

    protected function postRules($is_new = true)
    {

        $result = ['nullable', 'digits:10', $this->postFormat];
        if (!$is_new) {

        }

        return [
            'postal_code' => $result
        ];
    }

    protected function imageRules($is_new = true)
    {

        $result = ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,webps'];
        if (!$is_new) {

        }

        return [
            'image' => $result
        ];
    }

    protected function codeRules($is_new = true, $field, $digits = 0)
    {
        $result = ['nullable', 'numeric'];
        if ($digits != 0) {
            $result[] = 'digits:' . $digits;
        }
        return [
            $field => $result
        ];
    }


}
