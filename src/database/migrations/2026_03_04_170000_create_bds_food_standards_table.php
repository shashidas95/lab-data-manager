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
        Schema::create('bds_food_standards', function (Blueprint $table) {
            $table->id();
            $table->string('bds_number')->unique(); // e.g., "BDS 233:2019"
            $table->string('product_name');         // e.g., "Pasteurized Milk"
            $table->string('governing_wing')->default('Chemical & Food Wing');
            $table->text('scope_description')->nullable();
            $table->boolean('is_mandatory')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bds_food_standards');
    }
};
