<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dental_evaluations', function (Blueprint $table) {
            $table->json('diagnosis_items')->nullable()->after('diagnosis');
        });
    }

    public function down(): void
    {
        Schema::table('dental_evaluations', function (Blueprint $table) {
            $table->dropColumn('diagnosis_items');
        });
    }
};