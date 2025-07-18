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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->unsignedBigInteger('category_id');
            $table->longText('thumbnail')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->unsignedBigInteger('price')->default(0);
            $table->boolean('status')->default(false);
            $table->text('slug')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
