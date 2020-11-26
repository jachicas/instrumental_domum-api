<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($max = 20, $min = 1),
            'payment_method' => $this->faker->randomElement($array = array('card', 'cash')),
            'total' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
            'status' => $this->faker->boolean(50)
        ];
    }
}
