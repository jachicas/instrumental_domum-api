<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Employee;
use App\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPSTORM_META\map;

class AddItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_employee_can_add_products()
    {
        $employee = Employee::factory()->create();
        ProductType::factory()->create();
        Brand::factory()->create();

        $this->actingAs($employee);

        $this->post(
            route('products.store'),
            [
                'name' => "test",
                'product_type_id' => 1,
                'brand_id' => 1,
                'status' => 1,
                'quantity' => 100,
                'price' => 150,
                'image' => "test"
            ]
        );

        $this->assertDatabaseHas('products', [
            'name' => "test",
            'product_type_id' => 1,
            'brand_id' => 1,
            'status' => 1,
            'quantity' => 100,
            'price' => 150,
            'image' => "test"
        ]);
    }
}
