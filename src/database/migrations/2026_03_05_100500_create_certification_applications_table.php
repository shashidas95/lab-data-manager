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
        Schema::create('certification_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->string('application_type'); // CM_License, MSC_Cert, Halal_Cert, Metrology_License
            $table->string('product_name');
            $table->string('bds_number')->nullable();
            $table->string('status')->default('Received'); // Received, Under_Review, Pending_Audit, Approved, Rejected
            $table->decimal('application_fee', 15, 2)->default(0.00);
            $table->boolean('fee_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_applications');
    }
};
