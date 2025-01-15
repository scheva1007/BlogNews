<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->foreign('author_id', 'subscriber_author_fk')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscriber_id', 'subscriber_user_fk')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['subscriber_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
