<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cm_license_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bds_standard_id')->constrained('bds_food_standards')->onDelete('cascade');
            $table->string('product_name');
            $table->string('status')->default('Applied'); // Applied, Forwarded_To_DD, Forwarded_To_AD, Forwarded_To_Inspector, Shortfall, Primary_Inspection, Observations, Formal_Inspection, Lab_Testing, Evaluation_Report, Verified_By_DD, Ready_For_Committee, Committee_Approved, Committee_Approved_Conditionally, Conditionally_Rectified, Re_Inspection, Payment_Requested, License_Issued, Rejected, Refused

            // Workflow Owners
            $table->foreignId('current_owner_id')->nullable()->constrained('users')->onDelete('set null');

            // Business Fields
            $table->text('questionnaire')->nullable();
            $table->decimal('application_fee', 15, 2)->default(0.00);
            $table->boolean('application_fee_paid')->default(false);
            $table->decimal('license_fee', 15, 2)->default(0.00);
            $table->boolean('license_fee_paid')->default(false);

            // Calculation and Inspection reports
            $table->text('man_day_calculation')->nullable();
            $table->text('primary_inspection_report')->nullable();
            $table->text('observation_feedback')->nullable();
            $table->text('observation_evidence')->nullable();
            $table->date('formal_inspection_date')->nullable();
            $table->text('formal_inspection_report')->nullable();
            $table->boolean('resampling_required')->default(false);
            $table->boolean('test_report_passed')->nullable();
            $table->text('evaluation_report')->nullable();
            $table->text('checklist')->nullable();
            $table->text('committee_conditions')->nullable();
            $table->text('refuse_letter')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cm_license_applications');
    }
};
