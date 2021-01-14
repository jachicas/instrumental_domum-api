<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
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
    public function registerUser(UserRequest $data)
    {
        $employee = User::create([
            'name' => $data->name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'password' => Hash::make($data->password)
        ]);

        $employee->assignRole('user');

        //$employee->createToken('device_name')->plainTextToken;

        //event(new Registered($employee));

        return $employee;
    }
}
