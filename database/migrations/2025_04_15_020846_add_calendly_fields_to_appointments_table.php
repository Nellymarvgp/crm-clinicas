<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalendlyFieldsToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('calendly_event_uri')->nullable()->after('available_slot');
            $table->string('calendly_invitee_uri')->nullable()->after('calendly_event_uri');
            $table->boolean('synced_with_calendly')->default(false)->after('calendly_invitee_uri');
            $table->json('calendly_event_data')->nullable()->after('synced_with_calendly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'calendly_event_uri',
                'calendly_invitee_uri',
                'synced_with_calendly',
                'calendly_event_data'
            ]);
        });
    }
}
