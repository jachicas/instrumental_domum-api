<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'product_type_id' => ProductType::factory(),
            'brand_id' => Brand::factory(),
            'status' => $this->faker->boolean(50),
            'quantity' => $this->faker->randomNumber($nbDigits = 3),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 5000),
            'image' => $this->faker->text()
        ];
    }
}
