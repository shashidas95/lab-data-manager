<?php

namespace Database\Seeders;

use App\Models\BdsFoodStandard;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class BdsFoodStandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First make sure units exist
        $pct = Unit::firstOrCreate(['name' => '%', 'short_name' => '%']);
        $mg = Unit::firstOrCreate(['name' => 'mg/L', 'short_name' => 'mg/L']);
        $cfu = Unit::firstOrCreate(['name' => 'cfu/g', 'short_name' => 'cfu/g']);

        // Register 10 mandatory BSTI products with BDS standards
        $standards = [
            [
                'bds_number' => 'BDS 233:2019',
                'product_name' => 'Pasteurized Milk',
                'scope_description' => 'Standard for fresh milk pasteurized under strict BSTI specifications.',
                'parameters' => [
                    ['parameter_name' => 'Fat Content', 'test_method' => 'BDS 233 Clause 4.1', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 3.50],
                    ['parameter_name' => 'Solid-Not-Fat (SNF)', 'test_method' => 'BDS 233 Clause 4.2', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 8.00],
                    ['parameter_name' => 'Salmonella', 'test_method' => 'ISO 6579', 'unit_id' => $cfu->id, 'limit_type' => 'absence', 'qualitative_limit' => 'Absent'],
                ]
            ],
            [
                'bds_number' => 'BDS 1586:2020',
                'product_name' => 'Bottled Drinking Water',
                'scope_description' => 'Specification for drinking water packaged in bottles for consumer safety.',
                'parameters' => [
                    ['parameter_name' => 'pH Level', 'test_method' => 'APHA 4500-H+', 'unit_id' => $pct->id, 'limit_type' => 'range', 'min_limit' => 6.50, 'max_limit' => 8.50],
                    ['parameter_name' => 'Arsenic (As)', 'test_method' => 'AAS Method', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 0.05],
                    ['parameter_name' => 'E. Coli', 'test_method' => 'ISO 9308-1', 'unit_id' => $cfu->id, 'limit_type' => 'absence', 'qualitative_limit' => 'Absent'],
                ]
            ],
            [
                'bds_number' => 'BDS 156:2016',
                'product_name' => 'Mustard Oil',
                'scope_description' => 'Specification for mustard oil used primarily for culinary purposes in Bangladesh.',
                'parameters' => [
                    ['parameter_name' => 'Acid Value', 'test_method' => 'BDS 156 Annex A', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 0.60],
                    ['parameter_name' => 'Saponification Value', 'test_method' => 'BDS 156 Annex B', 'unit_id' => $pct->id, 'limit_type' => 'range', 'min_limit' => 168.00, 'max_limit' => 177.00],
                ]
            ],
            [
                'bds_number' => 'BDS 1123:2013',
                'product_name' => 'Carbonated Beverages',
                'scope_description' => 'Standard specification for carbonated soft drinks.',
                'parameters' => [
                    ['parameter_name' => 'Total Soluble Solids (TSS)', 'test_method' => 'Refractometer', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 8.00],
                    ['parameter_name' => 'Saccharin Content', 'test_method' => 'HPLC', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 100.00],
                ]
            ],
            [
                'bds_number' => 'BDS 227:2014',
                'product_name' => 'Fruit Juice',
                'scope_description' => 'Standards regulating fresh fruit juice concentrates and ready-to-serve beverages.',
                'parameters' => [
                    ['parameter_name' => 'Total Acid (as Citric Acid)', 'test_method' => 'BDS 227 Clause 5', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 0.30],
                    ['parameter_name' => 'Preservatives (Benzoic Acid)', 'test_method' => 'HPLC-UV', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 250.00],
                ]
            ]
        ];

        foreach ($standards as $stdData) {
            $standard = BdsFoodStandard::firstOrCreate(
                ['bds_number' => $stdData['bds_number']],
                [
                    'product_name' => $stdData['product_name'],
                    'scope_description' => $stdData['scope_description'],
                    'is_mandatory' => true,
                ]
            );

            foreach ($stdData['parameters'] as $param) {
                $standard->parameters()->updateOrCreate(
                    ['parameter_name' => $param['parameter_name']],
                    $param
                );
            }
        }
    }
}
