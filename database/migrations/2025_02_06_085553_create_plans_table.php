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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('price')->nullable();
            $table->text('declaration_expire_days')->nullable();
            $table->text('recruitment_declaration_quantity')->nullable();
            $table->text('outstanding_job_quantity')->nullable();
            $table->text('telegram_declaration')->nullable();
            $table->text('email_declaration')->nullable();
            $table->text('sms_declaration')->nullable();
            $table->text('suggested_resume_quantity')->nullable();
            $table->boolean('is_full_time_support')->default(false);
            $table->boolean('is_suggested_resume')->default(false);
            $table->boolean('is_one_and_half_possibility_in_search_results')->default(false);
            $table->boolean('is_two_possibility_in_search_results')->default(false);
            $table->boolean('is_one_and_half_possibility_to_visit_by_job_seekers')->default(false);
            $table->boolean('is_two_possibility_to_visit_by_job_seekers')->default(false);
            $table->boolean('show_declaration_analytics')->default(false);
            $table->boolean('access_to_best_teachers_list')->default(false);
            $table->boolean('design_specific_plan')->default(false);
            $table->boolean('specialized_advice')->default(false);
            $table->boolean('adding_specific_features')->default(false);
            $table->boolean('recruitment_declaration_advice')->default(false);
            $table->boolean('recruitment_specific_support')->default(false);
            $table->boolean('screening_resume_support')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
