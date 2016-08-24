<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('ext_id')->unique();

            $table->string('name');
            $table->string('shortcut');
            $table->integer('year');
            $table->integer('current_matchday');

            $table->timestamps();
        });

        Schema::create('league_team', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');

            $table->integer('league_id')->unsigned();
            $table->foreign('league_id')->references('id')->on('leagues');

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
        Schema::drop('league_team');
        Schema::drop('leagues');
    }
}
