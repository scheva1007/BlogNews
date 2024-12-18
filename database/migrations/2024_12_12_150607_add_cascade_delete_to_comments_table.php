<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comment_news_fk');
            $table->dropForeign('comment_user_fk');

            $table->foreign('news_id', 'comment_news_fk')
                ->references('id')->on('news')->onDelete('cascade');
            $table->foreign('user_id', 'comment_user_id')
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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comment_news_fk');
            $table->dropForeign('comment_user_fk');
            $table->foreign('news_id', 'comment_news_fk')
                ->references('id')->on('news');
            $table->foreign('user_id', 'comment_user_fk')
                ->references('id')->on('users');
        });
    }
}
