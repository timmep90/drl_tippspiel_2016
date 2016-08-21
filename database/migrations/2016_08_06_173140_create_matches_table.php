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
            $table->bigInteger('ext_id')->unique();

            $table->integer('club1_nr')->unsigned();
            $table->foreign('club1_nr')->references('id')->on('clubs');

            $table->integer('club2_nr')->unsigned();
            $table->foreign('club2_nr')->references('id')->on('clubs');

            $table->integer('erg1');
            $table->integer('erg2');
            $table->dateTime('match_datetime');
            $table->integer('matchday');

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
