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
        // First make sure units exist using the correct column "abbreviation"
        $pct = Unit::firstOrCreate(['abbreviation' => '%'], ['name' => 'Percent']);
        $mg = Unit::firstOrCreate(['abbreviation' => 'mg/L'], ['name' => 'mg/L']);
        $cfu = Unit::firstOrCreate(['abbreviation' => 'cfu/g'], ['name' => 'cfu/g']);

        // Register 20 mandatory BSTI products with BDS standards
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
                'bds_number' => 'BDS 25:2015',
                'product_name' => 'Mustard Oil',
                'scope_description' => 'Specification for mustard oil used primarily for culinary purposes in Bangladesh.',
                'parameters' => [
                    ['parameter_name' => 'Acid Value', 'test_method' => 'BDS 25 Annex A', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 0.60],
                    ['parameter_name' => 'Saponification Value', 'test_method' => 'BDS 25 Annex B', 'unit_id' => $pct->id, 'limit_type' => 'range', 'min_limit' => 168.00, 'max_limit' => 177.00],
                ]
            ],
            [
                'bds_number' => 'BDS 138:2006',
                'product_name' => 'Refined Sugar',
                'scope_description' => 'Standards and purity tests for refined granulated sugar.',
                'parameters' => [
                    ['parameter_name' => 'Sucrose Content', 'test_method' => 'Polarimetry', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 99.70],
                    ['parameter_name' => 'Moisture Content', 'test_method' => 'Oven drying', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 0.06],
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
            ],
            [
                'bds_number' => 'BDS 1236:2001',
                'product_name' => 'Iodized Salt',
                'scope_description' => 'Edible salt fortified with potassium iodate for human consumption.',
                'parameters' => [
                    ['parameter_name' => 'Iodine Content', 'test_method' => 'Titration', 'unit_id' => $mg->id, 'limit_type' => 'minimum', 'min_limit' => 15.00],
                    ['parameter_name' => 'Sodium Chloride (NaCl)', 'test_method' => 'BDS 1236 Annex', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 96.00],
                ]
            ],
            [
                'bds_number' => 'BDS 435:2001',
                'product_name' => 'Soyabean Oil',
                'scope_description' => 'Refined soyabean oil suitable for cooking and consumption.',
                'parameters' => [
                    ['parameter_name' => 'Peroxide Value', 'test_method' => 'BDS 435 Annex A', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 10.00],
                    ['parameter_name' => 'Moisture & Volatile Matter', 'test_method' => 'BDS 435 Annex B', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 0.10],
                ]
            ],
            [
                'bds_number' => 'BDS 383:2001',
                'product_name' => 'Biscuit',
                'scope_description' => 'Quality parameters and moisture limits for baked biscuits.',
                'parameters' => [
                    ['parameter_name' => 'Moisture by Mass', 'test_method' => 'BDS 383 Annex C', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 6.00],
                    ['parameter_name' => 'Acid Insoluble Ash', 'test_method' => 'BDS 383 Annex D', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 0.05],
                ]
            ],
            [
                'bds_number' => 'BDS 908:1980',
                'product_name' => 'Butter',
                'scope_description' => 'Specification for butter produced from pasteurized milk.',
                'parameters' => [
                    ['parameter_name' => 'Milk Fat Content', 'test_method' => 'BDS 908 Annex', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 80.00],
                    ['parameter_name' => 'Moisture Limit', 'test_method' => 'BDS 908 Clause 3', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 16.00],
                ]
            ],
            [
                'bds_number' => 'BDS 907:1980',
                'product_name' => 'Ghee',
                'scope_description' => 'Standard for clarified butterfat/ghee derived from cow or buffalo milk.',
                'parameters' => [
                    ['parameter_name' => 'Milk Fat minimum', 'test_method' => 'BDS 907 Clause 4.1', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 99.50],
                    ['parameter_name' => 'Free Fatty Acids (FFA)', 'test_method' => 'BDS 907 Annex A', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 3.00],
                ]
            ],
            [
                'bds_number' => 'BDS 382:2001',
                'product_name' => 'Wheat Flour (Maida)',
                'scope_description' => 'Standard specification for milled wheat flour (Maida).',
                'parameters' => [
                    ['parameter_name' => 'Total Ash (dry basis)', 'test_method' => 'BDS 382 Clause 5', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 0.70],
                    ['parameter_name' => 'Gluten Content', 'test_method' => 'BDS 382 Annex B', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 8.50],
                ]
            ],
            [
                'bds_number' => 'BDS 381:2001',
                'product_name' => 'Suji (Semolina)',
                'scope_description' => 'Standard specification for semolina derived from wheat.',
                'parameters' => [
                    ['parameter_name' => 'Gluten Content (Suji)', 'test_method' => 'BDS 381 Annex B', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 7.00],
                    ['parameter_name' => 'Total Ash (Suji)', 'test_method' => 'BDS 381 Clause 5', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 1.00],
                ]
            ],
            [
                'bds_number' => 'BDS 1017:2001',
                'product_name' => 'Turmeric Powder',
                'scope_description' => 'Spice standards for ground turmeric powder.',
                'parameters' => [
                    ['parameter_name' => 'Curcumin Content', 'test_method' => 'Spectrophotometry', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 3.00],
                    ['parameter_name' => 'Moisture in Turmeric', 'test_method' => 'BDS 1017 Annex A', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 10.00],
                ]
            ],
            [
                'bds_number' => 'BDS 1016:2001',
                'product_name' => 'Chilli Powder',
                'scope_description' => 'Spice standards for ground red chilli powder.',
                'parameters' => [
                    ['parameter_name' => 'Crude Fiber', 'test_method' => 'BDS 1016 Annex A', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 30.00],
                    ['parameter_name' => 'Moisture in Chilli', 'test_method' => 'BDS 1016 Clause 3', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 11.00],
                ]
            ],
            [
                'bds_number' => 'BDS 1018:2001',
                'product_name' => 'Coriander Powder',
                'scope_description' => 'Spice standards for ground coriander powder.',
                'parameters' => [
                    ['parameter_name' => 'Acid Insoluble Ash in Coriander', 'test_method' => 'BDS 1018 Annex', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 1.50],
                    ['parameter_name' => 'Moisture in Coriander', 'test_method' => 'BDS 1018 Clause 3', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 12.00],
                ]
            ],
            [
                'bds_number' => 'BDS 1110:1984',
                'product_name' => 'Honey',
                'scope_description' => 'Standards of identity, moisture, and reducing sugars in natural honey.',
                'parameters' => [
                    ['parameter_name' => 'Reducing Sugar', 'test_method' => 'BDS 1110 Annex A', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 65.00],
                    ['parameter_name' => 'Moisture in Honey', 'test_method' => 'BDS 1110 Clause 4', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 20.00],
                ]
            ],
            [
                'bds_number' => 'BDS 1543:2006',
                'product_name' => 'Tomato Paste',
                'scope_description' => 'Specifications for canned tomato paste.',
                'parameters' => [
                    ['parameter_name' => 'Soluble Solids (TSS for Tomato Paste)', 'test_method' => 'Refractometer', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 24.00],
                    ['parameter_name' => 'Acidity as Citric Acid', 'test_method' => 'Titration', 'unit_id' => $pct->id, 'limit_type' => 'range', 'min_limit' => 0.80, 'max_limit' => 2.00],
                ]
            ],
            [
                'bds_number' => 'BDS 523:2015',
                'product_name' => 'Tomato Ketchup',
                'scope_description' => 'Specifications for tomato ketchup and tomato sauce.',
                'parameters' => [
                    ['parameter_name' => 'TSS in Ketchup', 'test_method' => 'Refractometer', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 25.00],
                    ['parameter_name' => 'Preservative (Sodium Benzoate)', 'test_method' => 'HPLC', 'unit_id' => $mg->id, 'limit_type' => 'maximum', 'max_limit' => 750.00],
                ]
            ],
            [
                'bds_number' => 'BDS 521:2011',
                'product_name' => 'Mango Chutney',
                'scope_description' => 'Quality parameters for prepared sweet and sour mango chutney.',
                'parameters' => [
                    ['parameter_name' => 'Acidity of Chutney', 'test_method' => 'BDS 521 Clause 4', 'unit_id' => $pct->id, 'limit_type' => 'minimum', 'min_limit' => 0.75],
                    ['parameter_name' => 'Total Ash in Chutney', 'test_method' => 'BDS 521 Clause 5', 'unit_id' => $pct->id, 'limit_type' => 'maximum', 'max_limit' => 5.00],
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
