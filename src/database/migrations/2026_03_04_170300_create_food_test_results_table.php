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
        Schema::create('food_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_sample_id')->constrained('food_samples')->onDelete('cascade');
            $table->foreignId('parameter_id')->constrained('food_testing_parameters')->onDelete('cascade');
            $table->decimal('numeric_value', 12, 4)->nullable();
            $table->string('text_value')->nullable();
            $table->boolean('is_compliant')->default(true);
            $table->foreignId('tested_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tested_at')->useCurrent();
            $table->text('chemist_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_test_results');
    }
};
