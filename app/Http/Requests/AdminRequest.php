<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Whoops\Run;

class AdminRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'dui' => [
                'required', 'size:9',
                Rule::unique('employees')->ignore($this->route('admin'))
            ],
            'nit' => ['required', 'size:14',
                Rule::unique('employees')->ignore($this->route('admin'))
            ],
            'email' => ['required', 'email', 'max:255', 'unique:users,email',
                Rule::unique('employees')->ignore($this->route('admin'))
            ],
            'phone' => ['required', 'size:8',
                Rule::unique('employees')->ignore($this->route('admin'))
            ]
        ];
    }
}
