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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();

            $table->json('first_name')->nullable();
            $table->json('second_name')->nullable();
            $table->json('third_name')->nullable();
            $table->json('family_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('civil_id')->nullable();
            $table->integer('number_of_yearly_leave')->nullable();
            $table->integer('salary')->nullable();

            $table->string('personal_image');

            $table->foreignIdFor(\App\Models\Department::class)->constrained();
            $table->foreignIdFor(\App\Models\Employee::class, 'direct_manager')->constrained();
            $table->foreignIdFor(\App\Models\EmploymentType::class)->constrained();

            $table->string('contract_start_date')->nullable();
            $table->string('contract_end_date')->nullable();

            $table->string('civil_id_copy');
            $table->string('passport_copy');
            $table->string('contract_copy');

            $table->text('notes');

            $table->integer('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
