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
        Schema::create('tmakon_users', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->foreignIdFor(\App\Models\TmakonCategory::class);
            $table->text('job');
            $table->text('email');
            $table->text('phone');
            $table->text('cv');
            $table->text('social_media_links');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmakon_users');
    }
};
