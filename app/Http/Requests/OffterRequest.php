<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
            'product_id' => ['required', 'integer', 'exists:products,id',
                Rule::unique('offters')->where(function ($query) {
                    return $query->where([
                        ['status', 1],
                        ['product_id', $this->request->get('product_id')]
                    ]);
                })->ignore($this->route('offter'))
            ],
            'discount' => ['required', 'integer', 'between:1,100'],
            'status' => ['required', 'boolean'],
            'start' => ['required', 'date_format:Y-m-d H:i', 'after:now'],
            'finish' => ['required', 'date_format:Y-m-d H:i', 'after:start']
        ];
    }
}
