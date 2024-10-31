<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class EditUserRequest extends FormRequest
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
            'email' => ['required','email', Rule::unique('users')->ignore($this->id, 'id')],
            'role' => 'required',
            'chietkhau' => 'required|numeric|min:0|max:100',
            'password' => 'nullable',
            'password_confirm' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'chietkhau.required' => 'Vui lòng nhập chiết khấu',
            'chietkhau.numeric' => 'Chiết khấu phải là một số',
            'chietkhau.min' => 'Chiết khấu nhỏ nhất là 0',
            'chietkhau.max' => 'Chiết khấu lớn nhất là 100',
            'password_confirm.required_with' => 'Vui lòng nhập lại mật khẩu',
            'password_confirm.same' => 'Mật khẩu không khớp',
        ];
    }
}
