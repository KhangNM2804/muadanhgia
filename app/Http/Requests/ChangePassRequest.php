<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassRequest extends FormRequest
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
            'current_password' => ['required',new MatchOldPassword],
            'password' => 'required',
            'password_confirmation' => 'same:password',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'current_password.required' => 'Vui lòng nhập mật khẩu cũ',
    //         'password.required' => 'Vui lòng nhập mật khẩu mới',
    //         'password_confirmation.same' => 'Nhập lại mật khẩu mới không khớp',
    //     ];
    // }
}
