<?php

namespace App\Http\Requests;

use App\Models\Offter;
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
            'product_id' => [
                'required', 'integer', 'exists:products,id',
                Rule::unique('offters')->where(function ($query) {
                    return $query->where(function ($query) {
                        $query->where('product_id', $this->request->get('product_id'))
                            ->where(function ($query2) {
                                $query2->orWhereBetween('start', [$this->request->get('start'), $this->request->get('finish')])
                                    ->orWhereBetween('finish', [$this->request->get('start'), $this->request->get('finish')]);
                            });
                    });
                })->ignore($this->route('offter'))
            ],
            'discount' => ['required', 'integer', 'between:1,100'],
            'status' => ['required', 'boolean'],
            'start' => ['required', 'date_format:Y-m-d H:i', 'after:now'],
            'finish' => ['required', 'date_format:Y-m-d H:i', 'after:start']
        ];
    }
}
