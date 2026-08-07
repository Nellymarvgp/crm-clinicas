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
        Schema::table('medical_infos', function (Blueprint $table) {
            $table->string('diabetes_status', 10)->nullable()->after('diet');
            $table->string('diabetes_controlled', 10)->nullable()->after('diabetes_status');
            $table->string('hypertension_status', 10)->nullable()->after('diabetes_controlled');
            $table->string('hypertension_controlled', 10)->nullable()->after('hypertension_status');
            $table->string('currently_pregnant', 10)->nullable()->after('hypertension_controlled');
            $table->string('heart_attack_history', 10)->nullable()->after('currently_pregnant');
            $table->string('last_heart_attack', 120)->nullable()->after('heart_attack_history');
            $table->string('takes_medications', 10)->nullable()->after('last_heart_attack');
            $table->string('medications_list', 255)->nullable()->after('takes_medications');
            $table->string('aspirin_last_72h', 10)->nullable()->after('medications_list');
            $table->string('has_disease', 10)->nullable()->after('aspirin_last_72h');
            $table->string('disease_details', 255)->nullable()->after('has_disease');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_infos', function (Blueprint $table) {
            $table->dropColumn([
                'diabetes_status',
                'diabetes_controlled',
                'hypertension_status',
                'hypertension_controlled',
                'currently_pregnant',
                'heart_attack_history',
                'last_heart_attack',
                'takes_medications',
                'medications_list',
                'aspirin_last_72h',
                'has_disease',
                'disease_details',
            ]);
        });
    }
};
