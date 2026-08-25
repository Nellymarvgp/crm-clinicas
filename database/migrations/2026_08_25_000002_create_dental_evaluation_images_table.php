<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_evaluation_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dental_evaluation_id');
            $table->string('path', 255);
            $table->string('original_name', 255)->nullable();
            $table->timestamps();

            $table->foreign('dental_evaluation_id')->references('id')->on('dental_evaluations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_evaluation_images');
    }
};
