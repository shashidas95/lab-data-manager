<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;      // Added this
use App\Models\Parameter; // Added this

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch parameters (Ensure ParameterSeeder has run first!)
        $phParam = Parameter::where('code', 'PH_VAL')->first();
        $chlorideParam = Parameter::where('code', 'CHL_MG')->first();
        $ecParam = Parameter::where('code', 'EC_VAL')->first();

        // 2. Define the first Test
        $test1 = Test::create([
            'name' => 'Standard Potability Analysis',
            'code' => 'WTR-POT-01',
            'description' => 'Standard analysis for drinking water safety.',
            'sop_reference' => 'SOP-WTR-001',
            'test_category' => 'Chemical',
            'method_validation_status' => 'Validated',
            'estimated_tat_hours' => 24,
            'is_active' => true,
        ]);

        // Link Parameters to Test 1
        if ($phParam) $test1->parameters()->attach($phParam->id, ['sort_order' => 1]);
        if ($chlorideParam) $test1->parameters()->attach($chlorideParam->id, ['sort_order' => 2]);

        // 3. Define the second Test
        $test2 = Test::create([
            'name' => 'Industrial Effluent Screening',
            'code' => 'EFF-IND-05',
            'description' => 'Screening for industrial waste discharge compliance.',
            'sop_reference' => 'SOP-ENV-042',
            'test_category' => 'Environmental',
            'method_validation_status' => 'In Validation',
            'estimated_tat_hours' => 48,
            'is_active' => true,
        ]);

        // Link Parameters to Test 2
        if ($phParam) $test2->parameters()->attach($phParam->id, ['sort_order' => 1]);
        if ($ecParam) $test2->parameters()->attach($ecParam->id, ['sort_order' => 2]);
    }
}
