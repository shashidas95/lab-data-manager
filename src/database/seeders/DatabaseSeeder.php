<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OfficeSeeder::class,     // Must be first
            LabSeeder::class,         // Depends on Office
            UnitSeeder::class,        // Foundation
            ParameterSeeder::class,   // Depends on Unit
            TestSeeder::class,        // Independent (for now)
            ManufacturerSeeder::class, // Foundation
            ProductSeeder::class,     // Depends on Manufacturer
        ]);

        // User::factory()->create([
        //     'name' => 'Shashi',
        //     'email' => 'shashidas95@gmail.com',
        // ]);
    }
}
