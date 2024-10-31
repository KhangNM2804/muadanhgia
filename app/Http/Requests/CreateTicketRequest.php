<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateTicketRequest extends FormRequest
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
            'buy_id' => [
                'nullable',
                'numeric',
                Rule::exists('history_buy', 'id')->where('user_id', Auth::user()->id)
            ],
            'priority' => [
                'required',
                'numeric',
                Rule::in([1,2,3])
            ],
            'title' => [
                'required',
                'max:200'
            ],
            'content' => [
                'required',
            ],
        ];
    }
}
