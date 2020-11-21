<?php

namespace Database\Seeders;

use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    public function __construct(Employee $employee)
    {
        $this->employees = $employee;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = $this->employees->create([
            'name' => 'Carlos',
            'last_name' => 'Chicas',
            'dui' => '123456789',
            'nit' => '12345678912345',
            'birthdate' => "2000-03-04",
            'email' => 'carlos.chikas@gmail.com',
            'password' => Hash::make('qwerty123'),
            'phone' => '12345678'
        ]);
        $employee->assignRole('employee');

        $admin = $this->employees->create([
            'name' => 'Jose',
            'last_name' => 'Chicas',
            'dui' => '012345678',
            'nit' => '02345678912345',
            'birthdate' => '2020-04-03',
            'email' => 'dargor.chikas@gmail.com',
            'password' => Hash::make('qwerty123'),
            'phone' => '61650094'
        ]);

        $admin->assignRole('admin');

        $admins = $this->employees->factory()->count(20)->create();

        $admins->each(function ($admin) {
            $admin->assignRole('admin');
        });
    }
}
