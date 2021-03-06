<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('thread_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longText('code')->nullable();

            $table->longText('message');

            $table->boolean('modification');

            $table->boolean('accepted')->default(false);

            $table->timestamps();
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('replies');
    }
}
