<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('major')->nullable();
            $table->string('university')->nullable();
            $table->string('gpa')->nullable();
            $table->string('year_of_graduation')->nullable();
            $table->boolean('is_high_school')->default(0);
            $table->boolean('is_associate')->default(0);
            $table->boolean('is_bachelor')->default(0);
            $table->boolean('is_master')->default(0);
            $table->boolean('is_phd')->default(0);
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_backgrounds');
    }
};
