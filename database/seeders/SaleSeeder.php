<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{

    public function __construct(Sale $sale)
    {
        $this->sales = $sale;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->sales->factory()->count(20)->create();
    }
}
