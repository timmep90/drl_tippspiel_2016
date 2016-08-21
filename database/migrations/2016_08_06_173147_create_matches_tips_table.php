<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('points');
            $table->integer('t1')->nullable();
            $table->integer('t2')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users_groups');

            $table->integer('match_id')->unsigned();
            $table->foreign('match_id')->references('id')->on('matches');

            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');

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
        Schema::drop('matches_tips');
    }
}
