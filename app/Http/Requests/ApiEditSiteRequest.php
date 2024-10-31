<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiEditSiteRequest extends FormRequest
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
        return [
            'domain' => ['required','regex:/^https:\/\/[^\/]+$/', Rule::unique('connect_api')->ignore($this->id, 'id')],
            'api_key' => 'required_if:system,1,2',
            'username' => 'required_if:system,3',
            'password' => 'required_if:system,3',
            'auto_price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'system.required' => 'Hệ thống bắt buộc chọn',
            'domain.required' => 'Domain bắt buộc nhập',
            'api_key.required_if' => 'API_KEY bắt buộc nhập',
            'username.required_if' => 'Username bắt buộc nhập',
            'password.required_if' => 'Password bắt buộc nhập',
        ];
    }
}