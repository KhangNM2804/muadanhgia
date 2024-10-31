<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|max:255',
            'desc' => 'required|max:255',
            'price' => 'required|numeric',
            'type' => 'required|numeric',
            'min_can_buy' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên thể loại',
            'name.max' => 'Tên thể loại tối đa 255 kí tự',
            'desc.required' => 'Vui lòng nhập mô tả thể loại',
            'desc.max' => 'Mô tả thể loại tối đa 255 kí tự',
            'price.required' => 'Vui lòng nhập số tiền bán',
            'price.numeric' => 'Số tiền bán là số',
            'type.required' => 'Vui lòng chọn loại',
            'type.numeric' => 'Loại là số',
            
        ];
    }
}
