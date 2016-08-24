<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_team_id')->unsigned();
            $table->foreign('home_team_id')->references('id')->on('teams');

            $table->integer('vis_team_id')->unsigned();
            $table->foreign('vis_team_id')->references('id')->on('teams');

            $table->integer('league_id')->unsigned();
            $table->foreign('league_id')->references('id')->on('leagues');

            $table->integer('home_team_erg')->nullable();
            $table->integer('vis_team_erg')->nullable();

            $table->integer('matchday');
            $table->string('status');
            $table->dateTime('date');

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
        Schema::drop('matches');

    }
}
