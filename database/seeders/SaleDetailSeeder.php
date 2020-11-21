<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleDetail;

class SaleDetailSeeder extends Seeder
{

    public function __construct(SaleDetail $sale_detail)
    {
        $this->sale_details = $sale_detail;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->sale_details->factory()->count(20)->create();
    }
}
