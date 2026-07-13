<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDayOfWeekToDoctorAvailableTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_available_times', function (Blueprint $table) {
            $table->string('day_of_week')->after('doctor_id'); // monday, tuesday, etc.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_available_times', function (Blueprint $table) {
            $table->dropColumn('day_of_week');
        });
    }
}
