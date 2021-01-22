<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaleDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sale_id' => $this->faker->numberBetween($max = 20, $min = 1),
            'product_id' => $this->faker->numberBetween($max = 20, $min = 1),
            'quantity' => $this->faker->randomNumber($nbDigits = 3),
            'with_discount' => $this->faker->boolean(50),
            'total' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000)
        ];
    }
}
