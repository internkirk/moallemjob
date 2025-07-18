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
        Schema::table('prime_teacher_responses', function (Blueprint $table) {
             $table->unsignedBigInteger('request_id')->after('teacher_id');

            $table->foreign('request_id')->references('id')->on('prime_teacher_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prime_teacher_responses', function (Blueprint $table) {
            $table->dropForeign('request_id');
        });
    }
};
