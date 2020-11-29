<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id',
            Rule::unique('sales')->where(function ($query) {
                return $query->where([
                    ['status', 1],
                    ['user_id', $this->input('user_id')]
                ]);
            })->ignore($this->route('sale'))],
            'payment_method' => ['required', 'string', 'in:card,cash'],
            'status' => ['required', 'bool']
        ];
    }
}
