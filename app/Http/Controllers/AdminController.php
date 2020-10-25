<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

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
        $admins = $this->employees->all();

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
        return new EmployeeResource($admin);
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
        $admin->update($request->all());

        return (new EmployeeResource($admin))
            ->response('Employe Updated', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response('', 205);
    }

    public function adminFirstExist()
    {
        return $this->employees->role('admin')->exists() ? response('Admin exist', 401) : response('Create a new admin', 200);
    }
}
