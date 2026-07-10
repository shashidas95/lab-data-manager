<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\EmployeeProfile;
use App\Models\LeaveRequest;
use App\Models\CertificationApplication;
use App\Models\AuditRecord;

class HrmPayrollCertificationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a test user
        $this->user = User::factory()->create([
            'name' => 'BSTI Admin',
            'email' => 'admin@bsti.gov.bd',
        ]);
    }

    public function test_can_create_and_query_employee_profile()
    {
        $response = $this->postJson('/api/hrm/profiles', [
            'user_id' => $this->user->id,
            'designation' => 'Assistant Director',
            'department' => 'CM Wing',
            'joining_date' => '2026-01-15',
            'basic_salary' => 45000.00,
            'grade' => 'Grade-9',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'designation' => 'Assistant Director',
                'grade' => 'Grade-9',
            ]);

        $this->assertDatabaseHas('employee_profiles', [
            'user_id' => $this->user->id,
            'designation' => 'Assistant Director',
        ]);

        // Query listing endpoint
        $listResponse = $this->getJson('/api/hrm/profiles');
        $listResponse->assertStatus(200)
            ->assertJsonCount(1);
    }

    public function test_can_submit_and_approve_leave_request()
    {
        $profile = EmployeeProfile::create([
            'user_id' => $this->user->id,
            'designation' => 'Inspector',
            'department' => 'Standard Wing',
            'joining_date' => '2026-02-01',
            'basic_salary' => 35000.00,
        ]);

        $response = $this->postJson('/api/hrm/leaves', [
            'employee_id' => $profile->id,
            'leave_type' => 'Casual',
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-05',
            'reason' => 'Family matter',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'leave_type' => 'Casual',
                'status' => 'Pending',
            ]);

        $leaveId = $response->json('id');

        // Approve leave
        $approveResponse = $this->putJson("/api/hrm/leaves/{$leaveId}/status", [
            'status' => 'Approved',
            'approved_by' => $this->user->id,
        ]);

        $approveResponse->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'Approved',
                'approved_by' => $this->user->id,
            ]);

        $this->assertEquals('Approved', LeaveRequest::find($leaveId)->status);
    }

    public function test_can_calculate_net_salary_correctly_on_payroll_processing()
    {
        $profile = EmployeeProfile::create([
            'user_id' => $this->user->id,
            'designation' => 'Deputy Director',
            'department' => 'Administration',
            'joining_date' => '2020-05-10',
            'basic_salary' => 60000.00,
        ]);

        // Formula: net = (basic + allowance + bonus) - deductions
        // Expected: (60000 + 10000 + 5000) - 4000 = 71000
        $response = $this->postJson('/api/payroll/records/process', [
            'employee_id' => $profile->id,
            'salary_month' => '2026-07',
            'allowance' => 10000.00,
            'deductions' => 4000.00,
            'bonus' => 5000.00,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'base_salary' => 60000,
                'net_salary' => 71000,
                'status' => 'Processed',
            ]);

        $this->assertDatabaseHas('payroll_records', [
            'employee_id' => $profile->id,
            'net_salary' => 71000.00,
        ]);
    }

    public function test_can_manage_certification_applications_and_audits()
    {
        // 1. Submit a CM License Application
        $response = $this->postJson('/api/certifications/applications', [
            'applicant_id' => $this->user->id,
            'application_type' => 'CM_License',
            'product_name' => 'Premium Mustard Oil',
            'bds_number' => 'BDS 25:2015',
            'application_fee' => 5000.00,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'product_name' => 'Premium Mustard Oil',
                'status' => 'Received',
            ]);

        $appId = $response->json('id');

        // 2. Pay fee and advance status to Under Review
        $statusResponse = $this->putJson("/api/certifications/applications/{$appId}/status", [
            'status' => 'Under_Review',
            'fee_paid' => true,
        ]);

        $statusResponse->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'Under_Review',
                'fee_paid' => true,
            ]);

        // 3. Record a Passed Stage 1 Audit (which automatically advances application to Under_Review)
        $auditResponse = $this->postJson('/api/certifications/audits', [
            'application_id' => $appId,
            'audit_stage' => 'Stage_1',
            'audit_date' => '2026-07-12',
            'findings' => 'Stage 1 satisfactory compliance.',
            'status' => 'Passed',
            'auditor_id' => $this->user->id,
        ]);

        $auditResponse->assertStatus(201)
            ->assertJsonFragment([
                'status' => 'Passed',
            ]);

        $this->assertEquals('Under_Review', CertificationApplication::find($appId)->status);

        // 4. Record a Passed Stage 2 Audit (which automatically advances application to Approved)
        $auditResponse2 = $this->postJson('/api/certifications/audits', [
            'application_id' => $appId,
            'audit_stage' => 'Stage_2',
            'audit_date' => '2026-07-20',
            'findings' => 'Stage 2 full compliant audit.',
            'status' => 'Passed',
            'auditor_id' => $this->user->id,
        ]);

        $auditResponse2->assertStatus(201);
        $this->assertEquals('Approved', CertificationApplication::find($appId)->status);
    }
}
