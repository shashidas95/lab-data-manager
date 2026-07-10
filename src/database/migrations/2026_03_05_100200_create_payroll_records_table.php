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
        Schema::create('payroll_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employee_profiles')->onDelete('cascade');
            $table->string('salary_month'); // e.g. "2026-07"
            $table->decimal('base_salary', 15, 2);
            $table->decimal('allowance', 15, 2)->default(0.00);
            $table->decimal('deductions', 15, 2)->default(0.00);
            $table->decimal('net_salary', 15, 2);
            $table->decimal('bonus', 15, 2)->default(0.00);
            $table->boolean('bank_advice_generated')->default(false);
            $table->string('status')->default('Processed'); // Processed, Paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_records');
    }
};
