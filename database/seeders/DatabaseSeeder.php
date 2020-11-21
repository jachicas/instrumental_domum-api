<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([PermissionSeeder::class,
        EmployeeSeeder::class, UserSeeder::class,
        ProductSeeder::class, OffterSeeder::class,
        SaleSeeder::class, SaleDetailSeeder::class]);
    }
}
