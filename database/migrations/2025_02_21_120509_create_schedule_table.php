<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('championship_id');
            $table->foreign('championship_id', 'schedule_championship_fk')->on('championships')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('home_team_id');
            $table->foreign('home_team_id', 'schedule_home_team_fk')->on('teams')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('away_team_id');
            $table->foreign('away_team_id', 'schedule_away_team_fk')->on('teams')->references('id')->onDelete('cascade');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->dateTime('match_date');
            $table->enum('status', ['scheduled', 'finished'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
}
