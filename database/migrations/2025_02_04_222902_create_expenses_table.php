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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expenses_id');
            $table->string('expenses_date');
            $table->string('cr_civil_id');
            $table->foreignIdFor(\App\Models\Contractor::class)->constrained();
            $table->text('amount');
            $table->foreignIdFor(\App\Models\ContractorCategory::class)->constrained();
            $table->foreignIdFor(\App\Models\Term::class)->constrained();
            $table->foreignIdFor(\App\Models\Department::class)->constrained();
            $table->foreignIdFor(\App\Models\Source::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
