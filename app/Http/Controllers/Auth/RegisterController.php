<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'size:8',
                Rule::unique('employees')->ignore($this->route('admin'))
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $data)
    {

        $employee = Employee::create([
            'name' => $data->name,
            'last_name' => $data->last_name,
            'dui' => $data->dui,
            'nit' => $data->nit,
            'email' => $data->email,
            'password' => Hash::make($data['password']),
            'phone' => $data->phone
        ]);

        $employee->assignRole('admin');

        $employee->createToken('device_name')->plainTextToken;

        event(new Registered($employee));

        return $employee;
    }
}
