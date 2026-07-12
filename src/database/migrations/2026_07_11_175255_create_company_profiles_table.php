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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();

            // General Info
            $table->string('name_bn')->nullable();
            $table->string('name_en')->nullable();
            $table->string('type_bn')->nullable();
            $table->string('type_en')->nullable();

            // Head Office Address
            $table->string('head_division')->nullable();
            $table->string('head_district')->nullable();
            $table->string('head_thana')->nullable();
            $table->string('head_post_code')->nullable();
            $table->text('head_address')->nullable();
            $table->string('head_email')->nullable();
            $table->string('head_mobile')->nullable();
            $table->string('head_phone')->nullable();

            // Factory Address
            $table->string('factory_division')->nullable();
            $table->string('factory_district')->nullable();
            $table->string('factory_thana')->nullable();
            $table->string('factory_post_code')->nullable();
            $table->text('factory_address')->nullable();
            $table->string('factory_email')->nullable();
            $table->string('factory_mobile')->nullable();
            $table->boolean('same_as_head')->default(false);

            // Chairman/MD/CEO Details
            $table->string('ceo_name')->nullable();
            $table->string('ceo_father_name')->nullable();
            $table->string('ceo_nationality')->nullable();
            $table->date('ceo_dob')->nullable();
            $table->string('ceo_designation')->nullable();
            $table->string('ceo_email')->nullable();
            $table->string('ceo_mobile')->nullable();
            $table->string('ceo_signature_path')->nullable();

            // Standard attachments JSON store to persist attachments list
            $table->json('attachments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
