<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign('rating_news_fk');
            $table->dropForeign('rating_user_fk');

            $table->foreign('news_id', 'rating_news_fk')
                ->references('id')->on('news')->onDelete('cascade');
            $table->foreign('user_id', 'rating_user_fk')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign('rating_news_fk');
            $table->dropForeign('rating_user_fk');

            $table->foreign('news_id', 'rating_news_fk')
                ->references('id')->on('news');
            $table->foreign('user_id', 'rating_user_fk')
                ->references('id')->on('users');
        });
    }
}
