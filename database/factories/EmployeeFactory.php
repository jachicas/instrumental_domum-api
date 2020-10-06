<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'dui' => Str::random(9),
            'nit' => Str::random(14),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('qwerty'),
            'phone' => Str::random(8)
        ];
    }
}
