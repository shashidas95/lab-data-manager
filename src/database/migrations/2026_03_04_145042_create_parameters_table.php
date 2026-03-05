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

        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->string('data_type')->default('decimal'); // decimal, integer, string, boolean
            $table->integer('decimal_places')->default(2);
            $table->decimal('lower_spec_limit', 15, 4)->nullable();
            $table->decimal('upper_spec_limit', 15, 4)->nullable();
            $table->decimal('target_value', 15, 4)->nullable();
            $table->decimal('lod', 15, 4)->nullable(); // Limit of Detection
            $table->decimal('loq', 15, 4)->nullable(); // Limit of Quantitation
            $table->boolean('is_quantitative')->default(true);
            $table->boolean('is_critical')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
