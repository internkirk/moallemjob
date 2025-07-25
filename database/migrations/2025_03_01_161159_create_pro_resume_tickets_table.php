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
        Schema::create('pro_resume_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->longText('text');
            $table->longText('file')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('professional_resume_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_resume_tickets');
    }
};
