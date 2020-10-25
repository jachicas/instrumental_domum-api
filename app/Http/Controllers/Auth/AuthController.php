<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function me()
    {
        $name_guard = $this->nameGuard();
        if ($name_guard == 'employee') {
            return new EmployeeResource(auth()->user());
        } elseif ($name_guard == 'user') {
            return response('', 200);
        } else {
            return response('', 404);
        }
    }

    protected function nameGuard()
    {
        if (Auth::guard('employees')->check()) {
            return 'employee';
        } elseif (Auth::guard('user')->check()) {
            return 'user';
        }
    }
}
