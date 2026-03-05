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
            $table->id();

            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('collection_place');
            $table->date('sample_submission_date');

            $table->integer('total_sample_submitted');
            $table->integer('pass_sample_count')->default(0);
            $table->integer('fail_sample_count')->default(0);
            $table->integer('pending_sample_count')->default(0);

            $table->enum('status', ['pass', 'fail', 'pending'])->default('pending');

            $table->text('action_taken')->nullable();

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
