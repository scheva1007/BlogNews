<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToCommentLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign('like_comment_fk');
            $table->dropForeign('like_user_fk');

            $table->foreign('comment_id', 'like_comment_fk')
                ->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('user_id', 'like_user_fk')
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
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign('like_comment_fk');
            $table->dropForeign('like_user_fk');

            $table->foreign('comment_id', 'like_comment_fk')
                ->references('id')->on('comments');
            $table->foreign('user_id', 'like_user_fk')
                ->references('id')->on('users');
        });
    }
}
