<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Auth\Events\Registered;

class EmployeeController extends Controller
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
        $employees = $this->employees->whereHas('roles', function ($q) {
            $q->where('name', 'employee');
        })->get();

        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employee = $this->employees->create($request->all());

        $employee->assignRole('employee');

        $employee->createToken('device_name')->plainTextToken;

        event(new Registered($employee));

        return (new EmployeeResource($employee))
            ->response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if ($employee->getRoleNames()[0] == "employee") {
            return new EmployeeResource($employee);
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
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if ($employee->getRoleNames()[0] == "employee") {
            $employee->update($request->all());

            return (new EmployeeResource($employee))
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
    public function destroy(Employee $employee)
    {
        if ($employee->getRoleNames()[0] == "employee") {
            $employee->delete();

            return response('', 205);
        } else {
            return response('', 404);
        }
    }
}
