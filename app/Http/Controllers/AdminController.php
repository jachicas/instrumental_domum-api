<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{

    /**
     * The admin model instance
     */
    protected $admin;

    /**
     * Create a new controller instance
     * @param Employee $employee
     * @return void
     */

    public function __construct(Employee $employee)
    {
        $this->employees = $employee;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = $this->employees->whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

        return EmployeeResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $admin = $this->employees->create($request->all());

        $admin->assignRole('admin');

        $admin->createToken('device_name')->plainTextToken;

        event(new Registered($admin));

        return (new EmployeeResource($admin))
            ->response('Admin Created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $admin)
    {
        if ($admin->getRoleNames()[0] == "admin") {
            return new EmployeeResource($admin);
        } else {
            return response('', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Employee $admin)
    {
        if ($admin->getRoleNames()[0] == "admin") {
            $admin->update($request->all());

            return (new EmployeeResource($admin))
                ->response('Employe Updated', 205);
        } else {
            return response('', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $admin)
    {
        if ($admin->getRoleNames()[0] == "admin") {
            if (auth()->id() != $admin->id) {
                $admin->delete();

                return response('', 205);
            } else {
                return response('', 422);
            }
        } else {
            return response('', 404);
        }
    }

    public function adminFirstExist()
    {
        return $this->employees->role('admin')->exists() ? response('Admin exist', 401) : response('Create a new admin', 200);
    }
}
