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
        // Run CabangSeeder
        $this->call(CabangSeeder::class);

        // Run AdminUserSeeder
        $this->call(AdminUserSeeder::class);
    }
}
