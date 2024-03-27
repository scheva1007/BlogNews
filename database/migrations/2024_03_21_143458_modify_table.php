<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('likes', 'comment_likes');

        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropColumn('likes');
            $table->dropColumn('dislikes');
        });

        Schema::table('comment_likes', function (Blueprint  $table) {
            $table->string('like_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_likes', function (Blueprint  $table) {
            $table->dropColumn('like_status');
        });

        Schema::table('comment_likes', function (Blueprint $table) {
            $table->string('likes');
            $table->string('dislikes');
        });

        Schema::rename('likes', 'comment_likes');
    }
}
