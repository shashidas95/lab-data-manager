<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a lookup array of all unit IDs keyed by their abbreviation
        // This makes it easy to link parameters to the right unit
        $unitMap = \App\Models\Unit::pluck('id', 'abbreviation')->toArray();

        $parameters = [
            [
                'name' => 'Acidity (pH)',
                'code' => 'PH_VAL',
                'unit_id' => $unitMap['pH'], // Links to pH Units
                'lower_spec_limit' => 6.50,
                'upper_spec_limit' => 8.50,
                'decimal_places' => 2,
                'is_critical' => true
            ],
            [
                'name' => 'Chloride Content',
                'code' => 'CHL_MG',
                'unit_id' => $unitMap['mg/L'], // Links to Milligrams per Liter
                'lower_spec_limit' => 0.00,
                'upper_spec_limit' => 250.00,
                'decimal_places' => 1,
                'is_critical' => false
            ],
            [
                'name' => 'Electrical Conductivity',
                'code' => 'EC_VAL',
                'unit_id' => $unitMap['µS/cm'], // Links to Microsiemens per centimeter
                'lower_spec_limit' => 0.00,
                'upper_spec_limit' => 1500.00,
                'decimal_places' => 0,
                'is_critical' => false
            ],
            [
                'name' => 'Water Temperature',
                'code' => 'TEMP_C',
                'unit_id' => $unitMap['°C'], // Links to Degrees Celsius
                'lower_spec_limit' => 10.00,
                'upper_spec_limit' => 30.00,
                'decimal_places' => 1,
                'is_critical' => false
            ],
            [
                'name' => 'Sample Purity',
                'code' => 'PURITY_PCT',
                'unit_id' => $unitMap['%'], // Links to Percent
                'lower_spec_limit' => 95.00,
                'upper_spec_limit' => 100.00,
                'decimal_places' => 2,
                'is_critical' => true
            ]
        ];

        foreach ($parameters as $param) {
            \App\Models\Parameter::create($param);
        }
    }
}
