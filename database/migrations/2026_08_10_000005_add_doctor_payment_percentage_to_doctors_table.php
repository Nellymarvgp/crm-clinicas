<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoctorPaymentPercentageToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->decimal('doctor_payment_percentage', 5, 2)->default(0)->after('fees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('doctor_payment_percentage');
        });
    }
}
