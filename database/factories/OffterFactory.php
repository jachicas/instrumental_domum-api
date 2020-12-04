<?php

namespace Database\Factories;

use App\Models\Offter;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween($max = 20, $min = 1),
            'discount' => $this->faker->numberBetween($max = 10, $min = 60),
            'start' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'finish' => $this->faker->date($format = 'Y-m-d', $min = 'now')
        ];
    }
}
