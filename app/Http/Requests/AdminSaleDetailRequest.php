<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class AdminSaleDetailRequest extends FormRequest
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
            'sale_id' => ['required', 'integer', 'exists:sales,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer',
                function ($attribute, $value, $fail) {
                    $instance = Product::find($this->input('product_id'));

                    if ($instance->getAttribute('quantity') < $value) {
                        $fail($attribute. ' must be less than or equal to the quantity of the products');
                    }
                }
            ]
        ];
    }
}
