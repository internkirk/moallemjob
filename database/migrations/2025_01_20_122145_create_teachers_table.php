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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_male')->default(1);
            $table->boolean('is_single')->default(1);
            $table->string('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->boolean('is_selected')->default(0);
            $table->text('avatar')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
