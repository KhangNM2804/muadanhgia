<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NowPaymentRequest extends FormRequest
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
            'amount' => 'required|numeric'
        ];
    }
    
    public function messages()
    {
        return [
            'amount.required' => 'The amount field is required. '
        ];
    }
}
