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
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(\App\Models\ContractorField::class)->constrained();
            $table->foreignIdFor(\App\Models\ContractorCategory::class)->constrained();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('cr_number')->nullable();
            $table->string('owner_fullname')->nullable();
            $table->string('owner_phone_number')->nullable();
            $table->string('owner_phone_email')->nullable();
            $table->string('owner_civil_id')->nullable();
            $table->string('owner_civil_copy')->nullable();
            $table->string('cr_document')->nullable();
            $table->string('chamber_ceritifcate_document')->nullable();
            $table->string('VAT_ceritifcate_document')->nullable();
            $table->string('readah_ceritifcate_document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractors');
    }
};
