<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BdsFoodStandard;
use App\Models\CertificationApplication;
use App\Models\AuditRecord;
use App\Models\CmLicenseApplication;

class DemoCertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create applicant user Shashi
        $applicant = User::firstOrCreate(
            ['email' => 'shashidas95@gmail.com'],
            [
                'name' => 'Shashi',
                'password' => bcrypt('password'),
            ]
        );

        // Find or create some officials for assigning/auditing
        $director = User::firstOrCreate(
            ['email' => 'director.cm@bsti.gov.bd'],
            [
                'name' => 'Director CM',
                'password' => bcrypt('password'),
            ]
        );

        $inspector = User::firstOrCreate(
            ['email' => 'inspector.cm@bsti.gov.bd'],
            [
                'name' => 'Inspector CM',
                'password' => bcrypt('password'),
            ]
        );

        // Seed some representative demo applications under general Certification (CM, Halal, MSC, Metrology)
        $app1 = CertificationApplication::create([
            'applicant_id' => $applicant->id,
            'application_type' => 'CM_License',
            'product_name' => 'Demo Ghee Product',
            'bds_number' => 'BDS 907:1980',
            'status' => 'Received',
            'application_fee' => 3000.00,
            'fee_paid' => true,
        ]);

        $app2 = CertificationApplication::create([
            'applicant_id' => $applicant->id,
            'application_type' => 'Halal_Cert',
            'product_name' => 'Pure Mango Chutney',
            'bds_number' => 'BDS 521:2011',
            'status' => 'Pending_Audit',
            'application_fee' => 5000.00,
            'fee_paid' => true,
        ]);

        // Add a pending Stage 1 audit for Mango Chutney Halal application
        AuditRecord::create([
            'application_id' => $app2->id,
            'audit_stage' => 'Stage_1',
            'audit_date' => date('Y-m-d', strtotime('+3 days')),
            'findings' => 'Stage 1 Audit scheduled. Inspector checklist initiated.',
            'status' => 'Pending',
            'auditor_id' => $inspector->id,
        ]);

        $app3 = CertificationApplication::create([
            'applicant_id' => $applicant->id,
            'application_type' => 'MSC_Cert',
            'product_name' => 'Refined Granulated Sugar',
            'bds_number' => 'BDS 138:2006',
            'status' => 'Approved',
            'application_fee' => 12000.00,
            'fee_paid' => true,
        ]);

        // Add passed Stage 1 & Stage 2 audits for the Approved MSC application
        AuditRecord::create([
            'application_id' => $app3->id,
            'audit_stage' => 'Stage_1',
            'audit_date' => date('Y-m-d', strtotime('-10 days')),
            'findings' => 'Satisfactory Stage 1 document check.',
            'status' => 'Passed',
            'auditor_id' => $inspector->id,
        ]);

        AuditRecord::create([
            'application_id' => $app3->id,
            'audit_stage' => 'Stage_2',
            'audit_date' => date('Y-m-d', strtotime('-2 days')),
            'findings' => 'Full site review, GMP requirements completely met.',
            'status' => 'Passed',
            'auditor_id' => $inspector->id,
        ]);

        // Seed a highly detailed demo approval workflow for Certification Marks (CM) wing
        $mustardStandard = BdsFoodStandard::where('bds_number', 'BDS 25:2015')->first();
        if ($mustardStandard) {
            $cmApp = CmLicenseApplication::create([
                'applicant_id' => $applicant->id,
                'bds_standard_id' => $mustardStandard->id,
                'product_name' => 'Demo Premium Mustard Oil',
                'status' => 'Primary_Inspection',
                'current_owner_id' => $inspector->id,
                'questionnaire' => 'Premium cold-pressed mustard oil with organic mustard seeds.',
                'application_fee' => 2000.00,
                'application_fee_paid' => true,
                'man_day_calculation' => 'Calculated 2 inspector man days based on factory size.',
                'primary_inspection_report' => 'Factory floor and manufacturing setup thoroughly reviewed. Satisfies safety requirements.',
            ]);

            // Add historical workflow logs to make the audit trail alive
            $cmApp->logTransition($applicant, 'None', 'Applied', 'CM License application submitted by applicant with fee.');
            $cmApp->logTransition($director, 'Applied', 'Forwarded_To_DD', 'Application received and forwarded to Deputy Director.');
            $cmApp->logTransition($inspector, 'Forwarded_To_DD', 'Primary_Inspection', 'Primary inspection executed and reports logged.');
        }
    }
}
