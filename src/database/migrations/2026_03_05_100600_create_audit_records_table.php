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
        Schema::create('audit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('certification_applications')->onDelete('cascade');
            $table->string('audit_stage'); // Stage_1, Stage_2, Re_Inspection
            $table->date('audit_date');
            $table->text('findings')->nullable();
            $table->string('status')->default('Pending'); // Pending, Passed, Failed
            $table->foreignId('auditor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_records');
    }
};
