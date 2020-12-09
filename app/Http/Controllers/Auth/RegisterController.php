<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
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
    public function registerEmployee(EmployeeRequest $data)
    {
        $employee = Employee::create([
            'name' => $data->name,
            'last_name' => $data->last_name,
            'dui' => $data->dui,
            'nit' => $data->nit,
            'birthdate' => $data->birthdate,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'phone' => $data->phone
        ]);

        $employee->assignRole('employee');

        $employee->createToken('device_name')->plainTextToken;

        event(new Registered($employee));

        return $employee;
    }

}
