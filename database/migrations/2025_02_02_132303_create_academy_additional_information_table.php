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
        Schema::create('academy_additional_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academy_id');
            $table->string('establishment_year');
            $table->text('establishment_license_image')->nullable();
            $table->text('startup_license_image')->nullable();
            $table->text('profile_image')->nullable();
            $table->text('benefits')->nullable();
            $table->text('school_image')->nullable();
            $table->timestamps();

            $table->foreign('academy_id')->references('id')->on('academies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_additional_information');
    }
};
