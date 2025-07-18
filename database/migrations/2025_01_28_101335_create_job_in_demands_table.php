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
        Schema::create('job_in_demands', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('major')->nullable();
            $table->string('city')->nullable();
            $table->string('salary')->nullable();
            $table->string('province')->nullable();

            $table->boolean('is_pre_school')->default(0)->comment('academic_levels');
            $table->boolean('is_elementary')->default(0)->comment('academic_levels');
            $table->boolean('is_middle_school')->default(0)->comment('academic_levels');
            $table->boolean('is_high_school')->default(0)->comment('academic_levels');
            $table->boolean('is_techinical_college')->default(0)->comment('academic_levels');
            $table->boolean('is_foreign_lan_teacher')->default(0)->comment('academic_levels');
            $table->boolean('is_entrance_exam_teacher')->default(0)->comment('academic_levels');
            $table->boolean('is_academic_counsellor')->default(0)->comment('academic_levels');

            $table->boolean('is_manager')->default(0)->comment('school_roles');
            $table->boolean('is_deputy')->default(0)->comment('school_roles');
            $table->boolean('is_couch')->default(0)->comment('school_roles');
            $table->boolean('is_teacher')->default(0)->comment('school_roles');
            $table->boolean('is_dabir')->default(0)->comment('school_roles');
            $table->boolean('is_honar_amouz')->default(0)->comment('school_roles');

            $table->boolean('is_full_time')->default(0)->comment('Type_of_cooperation');
            $table->boolean('is_half_time')->default(0)->comment('Type_of_cooperation');
            $table->boolean('is_part_time')->default(0)->comment('Type_of_cooperation');
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_in_demands');
    }
};
