<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'required|unique:users|regex:/^[a-zA-Z0-9._-]{3,}$/',
            'password' => 'required',
            'password_confirm' => 'same:password',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
        ];
        if (getSetting('flag_recaptcha') == 'on') {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'username.regex' => __('validation.regex_username'),
            'phone.regex' => __('validation.regex_phone'),
            'g-recaptcha-response.required' => 'Please confirm captcha',
        ];
    }
}