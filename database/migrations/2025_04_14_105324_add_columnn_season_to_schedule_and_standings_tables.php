<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnnSeasonToScheduleAndStandingsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule', function (Blueprint $table) {
            $table->string('season')->after('championship_id');
        });

        Schema::table('standings', function (Blueprint $table) {
            $table->string('season')->after('championship_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule', function (Blueprint $table) {
            $table->dropColumn('season');
        });

        Schema::table('standings', function (Blueprint $table) {
            $table->dropColumn('season');
        });
    }
}
