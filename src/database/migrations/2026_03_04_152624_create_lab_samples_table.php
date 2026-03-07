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
        Schema::create('lab_samples', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Keep this as UUID for the sample itself
            $table->string('sample_number')->unique();

            // FIXED: Changed foreignUuid to foreignId to match parent tables
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_id')->constrained()->onDelete('cascade');
            $table->foreignId('manufacturer_id')->constrained()->onDelete('cascade');

            // Production Details
            $table->string('batch_number')->index();
            $table->date('production_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('brand')->nullable();

            // Product Attributes
            $table->string('variant')->nullable();
            $table->string('flavour')->nullable();
            $table->string('color')->nullable();
            $table->string('type')->nullable();

            // Quantity and Volume
            $table->integer('sample_quantity')->default(1);
            $table->string('collected_amount')->nullable();

            // Status and Logistics
            $table->string('status')->default('received');
            $table->string('priority')->default('normal');
            $table->timestamp('received_at')->useCurrent();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_samples');
    }
};
