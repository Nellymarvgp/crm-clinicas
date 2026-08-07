<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE medical_infos MODIFY height VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY b_group VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY pulse VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY allergy VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY weight VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY b_pressure VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY respiration VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY diet VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE medical_infos MODIFY height VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY b_group VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY pulse VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY allergy VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY weight VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY b_pressure VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY respiration VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medical_infos MODIFY diet VARCHAR(255) NOT NULL');
    }
};
