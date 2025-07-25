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
        Schema::table('job_backgrounds', function (Blueprint $table) {
            $table->string('teaching_exp')->nullable()->after('payeh');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_backgrounds', function (Blueprint $table) {
           $table->dropColumn('teaching_exp');
        });
    }
};
