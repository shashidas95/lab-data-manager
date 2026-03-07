<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Level 1: Independent Tables
            OfficeSeeder::class,
            UnitSeeder::class,
            ManufacturerSeeder::class,

            // Level 2: Depend on Level 1
            LabSeeder::class,        // Needs Office
            ProductSeeder::class,    // Needs Manufacturer
            ParameterSeeder::class,  // Needs Unit

            // Level 3: Depend on Level 2
            TestSeeder::class,       // Needs Parameters
            SampleSeeder::class,     // Needs Product, Lab, Manufacturer

        ]);

        User::factory()->create([
            'name' => 'Shashi',
            'email' => 'shashidas95@gmail.com',
        ]);
    }
}
