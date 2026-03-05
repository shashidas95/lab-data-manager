<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Milligrams per Liter', 'abbreviation' => 'mg/L', 'category' => 'Concentration'],
            ['name' => 'Parts per Million', 'abbreviation' => 'ppm', 'category' => 'Concentration'],
            ['name' => 'pH Units', 'abbreviation' => 'pH', 'category' => 'Dimensionless'],
            ['name' => 'Nephelometric Turbidity Units', 'abbreviation' => 'NTU', 'category' => 'Optical'],
            ['name' => 'Degrees Celsius', 'abbreviation' => '°C', 'category' => 'Temperature'],
            ['name' => 'Percent', 'abbreviation' => '%', 'category' => 'Dimensionless'],
            ['name' => 'Microsiemens per centimeter', 'abbreviation' => 'µS/cm', 'category' => 'Electrical'],
        ];

        foreach ($units as $unit) {
            \App\Models\Unit::create($unit);
        }
    }
}
