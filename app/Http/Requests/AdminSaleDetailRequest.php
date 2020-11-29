<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Sale;
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
            'sale_id' => ['required', 'integer',
            function ($attribute, $value, $fail) {
                $instance = Sale::findOrFail($this->input('sale_id'));
                if (!($instance->getAttribute('status'))) {
                    $fail('This ' . $attribute . ' is not avaible');
                }
            }
            ],
            'product_id' => ['required', 'integer'],
            'quantity' => [
                'required', 'integer',
                function ($attribute, $value, $fail) {
                    $instance = Product::findOrFail($this->input('product_id'));
                    if ($instance->getAttribute('quantity') == 0) {
                        $fail('This product is out of stock!');
                    } elseif ($instance->getAttribute('quantity') < $value) {
                        $fail($attribute . ' must be less than or equal to the quantity of the products');
                    }
                    if (!($instance->getAttribute('status'))) {
                        $fail('This product is not avaible');
                    }
                }
            ]
        ];
    }
}
