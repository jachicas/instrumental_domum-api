<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayCarShopRequest extends FormRequest
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
            'card' => [
                'number' => ['required', 'numeric'],
                'exp_month' => ['required', 'numeric'],
                'cvc' => ['required', 'numeric'],
                'exp_year' => ['required', 'numeric']
            ]
        ];
    }
}
