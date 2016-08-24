<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTipsTable extends Migration
{

    public function up()
    {
        Schema::create('match_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('points');
            $table->integer('home_team_bet')->nullable();
            $table->integer('vis_team_bet')->nullable();

            $table->integer('match_id')->unsigned();
            $table->foreign('match_id')->references('id')->on('matches');

            $table->integer('group_user_id')->unsigned();
            $table->foreign('group_user_id')->references('id')->on('group_user');

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
        Schema::drop('match_tips');
    }

}
