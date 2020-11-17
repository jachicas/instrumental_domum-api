<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffterRequest extends FormRequest
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
            'product_id' => ['required', 'unique:offters,product_id', 'integer', 'exists:products,id'],
            'discount' => ['required', 'integer', 'between:1,100'],
            'status' => ['required', 'boolean'],
            'finish' => ['required', 'date_format:Y-m-d H:i']
        ];
    }
}
