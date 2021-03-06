<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('products')->ignore($this->route('product')), 'max:255'],
            'product_type_id' => ['required', 'integer', 'exists:product_types,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'status' => ['required', 'boolean'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_id' => ['required', 'integer', 'exists:images,id']
        ];
    }
}
