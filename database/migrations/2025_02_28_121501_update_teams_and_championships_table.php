<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTeamsAndChampionshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign('team_country_fk');
        });

        Schema::table('championships', function (Blueprint $table) {
            $table->dropForeign('championship_country_fk');
        });

        Schema::table('championships', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('country')->after('name');
        });

        Schema::dropIfExists('countries');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::table('championships', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
}
