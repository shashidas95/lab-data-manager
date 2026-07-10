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
        Schema::create('cm_workflow_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('cm_license_applications')->onDelete('cascade');
            $table->string('from_status');
            $table->string('to_status');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cm_workflow_logs');
    }
};
