<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forget(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = $this->broker($request)->sendResetLink(
            $request->only('email')
        );

        if ($status == 'passwords.sent') {
            return response()->json([
                "message" => "We send you an email to reset your password!"
            ], 200);
        } else {
            return response()->json([
                "message" => "Something went wrong!"
            ], 404);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = $this->broker($request)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                "message" => "Your password has been reset"
            ], 200);
        } else {
            return response()->json([
                "message" => "Something went wrong!"
            ], 404);
        }
    }

    public function broker(Request $request)
    {
        if (User::where('email', $request['email'])->first()) {
            return Password::broker('user');
        }
        if (Employee::where('email', $request['email'])->first()) {
            return Password::broker('employee');
        }
        throw ValidationException::withMessages([
            'email' => __('passwords.user'),
        ]);
    }
}
