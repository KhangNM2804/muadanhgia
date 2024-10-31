<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Code2FACodeRequest extends FormRequest
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
            "code" => "required|digits:6",
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'code.required' => 'Vui lòng nhập mã code',
    //         'code.digits' => 'Mã code gồm :digits chữ số'
    //     ];
    // }
}
