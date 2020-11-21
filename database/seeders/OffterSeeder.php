<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offter;

class OffterSeeder extends Seeder
{

    public function __construct(Offter $offter)
    {
        $this->offters = $offter;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->offters->factory()->count(20)->create();
    }
}
