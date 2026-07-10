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

            // BSTI Food Standards Seeder
            BdsFoodStandardSeeder::class,

            // BSTI Employees
            BstiEmployeeSeeder::class,

            // Demo Certifications and Workflows Seeder
            DemoCertificationSeeder::class,
        ]);

        // Standard applicant user (FirstOrCreate to avoid duplication with DemoCertificationSeeder)
        User::firstOrCreate(
            ['email' => 'shashidas95@gmail.com'],
            [
                'name' => 'Shashi',
                'password' => bcrypt('password'),
            ]
        );
    }
}
