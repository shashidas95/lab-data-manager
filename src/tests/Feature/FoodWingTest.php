<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\BdsFoodStandard;
use App\Models\FoodSample;
use App\Models\User;

class FoodWingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_database_seeder_runs_successfully()
    {
        $this->assertDatabaseHas('bds_food_standards', [
            'bds_number' => 'BDS 25:2015',
            'product_name' => 'Mustard Oil',
        ]);

        $this->assertDatabaseHas('bds_food_standards', [
            'bds_number' => 'BDS 138:2006',
            'product_name' => 'Refined Sugar',
        ]);

        // Total 20 standards
        $this->assertEquals(20, BdsFoodStandard::count());
    }

    public function test_can_list_food_samples()
    {
        $response = $this->getJson('/api/food-samples');
        $response->assertStatus(200);
    }

    public function test_can_register_new_food_sample()
    {
        $standard = BdsFoodStandard::where('bds_number', 'BDS 25:2015')->first();

        $response = $this->postJson('/api/food-samples', [
            'bds_standard_id' => $standard->id,
            'sample_name' => 'Arosh Mustard Oil',
            'sample_quantity' => 2,
            'temperature_on_receipt' => 'Ambient',
        ]);

        $response->assertStatus(210);
        $this->assertDatabaseHas('food_samples', [
            'sample_name' => 'Arosh Mustard Oil',
            'status' => 'Received',
        ]);
    }

    public function test_can_update_sample_status()
    {
        $standard = BdsFoodStandard::first();
        $sample = FoodSample::create([
            'b_code' => 'BSTI-2026-F-TEST1',
            'lab_blind_code' => 'LAB-CH-99999',
            'bds_standard_id' => $standard->id,
            'sample_name' => 'Test Food Sample',
            'status' => 'Received',
        ]);

        $response = $this->putJson("/api/food-samples/{$sample->id}/status", [
            'status' => 'Testing',
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Testing', $sample->fresh()->status);
    }

    public function test_can_record_results_and_evaluate_compliance()
    {
        // Use Pasteurized Milk (BDS 233:2019)
        $standard = BdsFoodStandard::where('bds_number', 'BDS 233:2019')->first();
        $this->assertNotNull($standard);

        $fatParam = $standard->parameters()->where('parameter_name', 'Fat Content')->first();
        $snfParam = $standard->parameters()->where('parameter_name', 'Solid-Not-Fat (SNF)')->first();
        $salmonellaParam = $standard->parameters()->where('parameter_name', 'Salmonella')->first();

        $sample = FoodSample::create([
            'b_code' => 'BSTI-2026-F-TEST2',
            'lab_blind_code' => 'LAB-CH-88888',
            'bds_standard_id' => $standard->id,
            'sample_name' => 'Pran Pasteurized Milk',
            'status' => 'Testing',
        ]);

        // Record compliant results: Fat (3.6 >= 3.5), SNF (8.2 >= 8.0), Salmonella (Absent == Absent)
        $response = $this->postJson("/api/food-samples/{$sample->id}/results", [
            'results' => [
                [
                    'parameter_id' => $fatParam->id,
                    'numeric_value' => 3.60,
                ],
                [
                    'parameter_id' => $snfParam->id,
                    'numeric_value' => 8.20,
                ],
                [
                    'parameter_id' => $salmonellaParam->id,
                    'text_value' => 'Absent',
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Completed', $sample->fresh()->status);

        // Verify each result's compliance
        $this->assertDatabaseHas('food_test_results', [
            'food_sample_id' => $sample->id,
            'parameter_id' => $fatParam->id,
            'is_compliant' => true,
        ]);
        $this->assertDatabaseHas('food_test_results', [
            'food_sample_id' => $sample->id,
            'parameter_id' => $snfParam->id,
            'is_compliant' => true,
        ]);
        $this->assertDatabaseHas('food_test_results', [
            'food_sample_id' => $sample->id,
            'parameter_id' => $salmonellaParam->id,
            'is_compliant' => true,
        ]);
    }

    public function test_fails_compliance_when_single_parameter_violates_limits()
    {
        $standard = BdsFoodStandard::where('bds_number', 'BDS 233:2019')->first();
        $fatParam = $standard->parameters()->where('parameter_name', 'Fat Content')->first();
        $snfParam = $standard->parameters()->where('parameter_name', 'Solid-Not-Fat (SNF)')->first();
        $salmonellaParam = $standard->parameters()->where('parameter_name', 'Salmonella')->first();

        $sample = FoodSample::create([
            'b_code' => 'BSTI-2026-F-TEST3',
            'lab_blind_code' => 'LAB-CH-77777',
            'bds_standard_id' => $standard->id,
            'sample_name' => 'Bad Pasteurized Milk',
            'status' => 'Testing',
        ]);

        // Record non-compliant results: Fat (3.2 < 3.5), SNF (8.2 >= 8.0), Salmonella (Present != Absent)
        $response = $this->postJson("/api/food-samples/{$sample->id}/results", [
            'results' => [
                [
                    'parameter_id' => $fatParam->id,
                    'numeric_value' => 3.20,
                ],
                [
                    'parameter_id' => $snfParam->id,
                    'numeric_value' => 8.20,
                ],
                [
                    'parameter_id' => $salmonellaParam->id,
                    'text_value' => 'Present',
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Rejected', $sample->fresh()->status);

        $this->assertDatabaseHas('food_test_results', [
            'food_sample_id' => $sample->id,
            'parameter_id' => $fatParam->id,
            'is_compliant' => false,
        ]);
        $this->assertDatabaseHas('food_test_results', [
            'food_sample_id' => $sample->id,
            'parameter_id' => $salmonellaParam->id,
            'is_compliant' => false,
        ]);
    }

    public function test_can_publicly_verify_sample_by_b_code()
    {
        $standard = BdsFoodStandard::first();
        $sample = FoodSample::create([
            'b_code' => 'BSTI-2026-F-VERIFYME',
            'lab_blind_code' => 'LAB-CH-66666',
            'bds_standard_id' => $standard->id,
            'sample_name' => 'Verified Product',
            'status' => 'Approved',
        ]);

        $response = $this->getJson("/api/public/verify/food/BSTI-2026-F-VERIFYME");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'b_code',
                'product_name',
                'standard_specification',
                'testing_status',
                'is_certified',
                'verified_at',
                'analysis',
            ]);
    }
}
