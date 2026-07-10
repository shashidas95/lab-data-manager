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
        Schema::create('food_testing_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bds_standard_id')->constrained('bds_food_standards')->onDelete('cascade');
            $table->string('parameter_name');       // e.g., "Total Soluble Solids", "Lead (Pb)"
            $table->string('test_method')->nullable();          // e.g., "ISO 4833-1"
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->string('limit_type');           // 'range', 'maximum', 'minimum', 'absence'
            $table->decimal('min_limit', 12, 4)->nullable();
            $table->decimal('max_limit', 12, 4)->nullable();
            $table->string('qualitative_limit')->nullable(); // For qualitative testing
            $table->boolean('is_critical_for_compliance')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_testing_parameters');
    }
};
