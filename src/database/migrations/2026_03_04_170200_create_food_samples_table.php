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
        Schema::create('food_samples', function (Blueprint $table) {
            $table->id();
            $table->string('b_code')->unique();          // Public certificate verification code
            $table->string('lab_blind_code')->unique();  // Anonymized code for lab scientists
            $table->foreignId('bds_standard_id')->constrained('bds_food_standards')->onDelete('cascade');
            $table->string('sample_name');
            $table->integer('sample_quantity')->default(1);
            $table->string('temperature_on_receipt')->default('Ambient');
            $table->enum('status', ['Received', 'Assigned', 'Testing', 'Completed', 'Approved', 'Rejected'])->default('Received');
            $table->timestamp('received_at')->useCurrent();
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_chemist_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_samples');
    }
};
