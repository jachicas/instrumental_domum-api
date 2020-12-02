<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class AddItemRequest extends FormRequest
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
            'product_id' => ['required', 'integer'],
            'quantity' => [
                'required', 'integer', 'gt:0',
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
