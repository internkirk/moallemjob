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
        Schema::table('professional_resume_requests', function (Blueprint $table) {
            $table->string('request_stage')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_resume_requests', function (Blueprint $table) {
            $table->dropColumn('request_stage');
        });
    }
};
