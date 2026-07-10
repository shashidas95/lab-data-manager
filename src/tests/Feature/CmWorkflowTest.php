<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\BdsFoodStandard;
use App\Models\CmLicenseApplication;
use Database\Seeders\DatabaseSeeder;

class CmWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $applicant;
    protected $director;
    protected $dd;
    protected $ad;
    protected $inspector;
    protected $standard;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->applicant = User::factory()->create(['name' => 'Applicant User', 'email' => 'applicant@gmail.com']);
        $this->director = User::factory()->create(['name' => 'Director CM', 'email' => 'director.cm@bsti.gov.bd']);
        $this->dd = User::factory()->create(['name' => 'DD CM', 'email' => 'dd.cm@bsti.gov.bd']);
        $this->ad = User::factory()->create(['name' => 'AD CM', 'email' => 'ad.cm@bsti.gov.bd']);
        $this->inspector = User::factory()->create(['name' => 'Inspector CM', 'email' => 'inspector.cm@bsti.gov.bd']);

        $this->standard = BdsFoodStandard::first();
    }

    public function test_complete_successful_cm_license_workflow()
    {
        // Step 1: Submit Application
        $response = $this->postJson('/api/cm/applications', [
            'applicant_id' => $this->applicant->id,
            'bds_standard_id' => $this->standard->id,
            'product_name' => 'Super Pure Honey',
            'questionnaire' => 'Standard sweet natural honey.',
            'application_fee' => 1000.00,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'product_name' => 'Super Pure Honey',
                'status' => 'Applied',
            ]);

        $appId = $response->json('id');

        // Step 2: Director forwards to DD
        $response = $this->putJson("/api/cm/applications/{$appId}/forward", [
            'user_id' => $this->director->id,
            'to_status' => 'Forwarded_To_DD',
            'remarks' => 'Review and forward to AD.',
            'current_owner_id' => $this->dd->id,
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Forwarded_To_DD', $response->json('status'));

        // Step 3: DD forwards to AD
        $response = $this->putJson("/api/cm/applications/{$appId}/forward", [
            'user_id' => $this->dd->id,
            'to_status' => 'Forwarded_To_AD',
            'remarks' => 'Forwarded to AD with positive remarks.',
            'current_owner_id' => $this->ad->id,
        ]);
        $response->assertStatus(200);

        // Step 4: AD forwards to Inspector
        $response = $this->putJson("/api/cm/applications/{$appId}/forward", [
            'user_id' => $this->ad->id,
            'to_status' => 'Forwarded_To_Inspector',
            'remarks' => 'Please perform primary inspection.',
            'current_owner_id' => $this->inspector->id,
        ]);
        $response->assertStatus(200);

        // Step 5: Inspector reports a shortfall
        $response = $this->putJson("/api/cm/applications/{$appId}/shortfall", [
            'user_id' => $this->inspector->id,
            'remarks' => 'Missing business trade license.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Shortfall', $response->json('status'));

        // Step 6: Customer rectifies shortfall
        $response = $this->putJson("/api/cm/applications/{$appId}/rectify", [
            'user_id' => $this->applicant->id,
            'remarks' => 'Uploaded renewed trade license.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Forwarded_To_Inspector', $response->json('status'));

        // Step 7: Inspector records primary inspection and calculates man-day
        $response = $this->putJson("/api/cm/applications/{$appId}/inspection", [
            'user_id' => $this->inspector->id,
            'man_day_calculation' => 'Estimated 3 man days.',
            'primary_inspection_report' => 'Factory standards fully compliant. No observations.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Primary_Inspection', $response->json('status'));

        // Step 8: Inspector performs formal inspection and collects lab samples
        $response = $this->putJson("/api/cm/applications/{$appId}/formal-inspection", [
            'user_id' => $this->inspector->id,
            'formal_inspection_date' => '2026-07-15',
            'formal_inspection_report' => 'Formal samples collected and sealed.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Formal_Inspection', $response->json('status'));

        // Step 9: Compile lab test report (PASS scenario)
        $response = $this->putJson("/api/cm/applications/{$appId}/test-compile", [
            'user_id' => $this->ad->id,
            'test_report_passed' => true,
            'evaluation_report' => 'All parameters fully pass reference BDS limits.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Evaluation_Report', $response->json('status'));

        // Step 10: DD verifies and prepares checklist
        $response = $this->putJson("/api/cm/applications/{$appId}/dd-verify", [
            'user_id' => $this->dd->id,
            'checklist' => 'BDS standard compliance checklist finalized.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Verified_By_DD', $response->json('status'));

        // Step 11: Certification Committee reviews and approves
        $response = $this->putJson("/api/cm/applications/{$appId}/committee-review", [
            'user_id' => $this->director->id,
            'decision' => 'Committee_Approved',
            'remarks' => 'Unanimously approved for official certification.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Committee_Approved', $response->json('status'));

        // Step 12: Complete payment and issue official license
        $response = $this->putJson("/api/cm/applications/{$appId}/payment", [
            'user_id' => $this->applicant->id,
            'license_fee' => 15000.00,
        ]);
        $response->assertStatus(200);
        $this->assertEquals('License_Issued', $response->json('status'));
        $this->assertTrue($response->json('license_fee_paid'));

        // Step 13: Verify that audit logs exist for all transitions
        $this->assertDatabaseHas('cm_workflow_logs', [
            'application_id' => $appId,
            'from_status' => 'Shortfall',
            'to_status' => 'Forwarded_To_Inspector',
        ]);
        $this->assertDatabaseHas('cm_workflow_logs', [
            'application_id' => $appId,
            'from_status' => 'Verified_By_DD',
            'to_status' => 'Committee_Approved',
        ]);
    }

    public function test_cm_license_workflow_fail_lab_test()
    {
        // Submit
        $response = $this->postJson('/api/cm/applications', [
            'applicant_id' => $this->applicant->id,
            'bds_standard_id' => $this->standard->id,
            'product_name' => 'Bad Honey',
        ]);
        $appId = $response->json('id');

        // Inspector performs formal inspection
        $this->putJson("/api/cm/applications/{$appId}/formal-inspection", [
            'user_id' => $this->inspector->id,
            'formal_inspection_date' => '2026-07-15',
            'formal_inspection_report' => 'Formal samples collected.',
        ]);

        // Compile test report with FAIL (test_report_passed => false)
        $response = $this->putJson("/api/cm/applications/{$appId}/test-compile", [
            'user_id' => $this->ad->id,
            'test_report_passed' => false,
            'refuse_letter' => 'Moisture content exceeds maximum limit.',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('Refused', $response->json('status'));
        $this->assertFalse($response->json('test_report_passed'));
    }
}
