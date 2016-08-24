<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('isActive');

            $table->integer('league_id')->unsigned();
            $table->foreign('league_id')->references('id')->on('leagues');

            $table->integer('kt_points')->unsigned();
            $table->integer('tt_points')->unsigned();
            $table->integer('st_points')->unsigned();
            $table->integer('m_points');

            $table->timestamps();
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('kt')->unsigned();
            $table->integer('tt')->unsigned();
            $table->integer('st')->unsigned();
            $table->integer('m')->unsigned();
            $table->integer('points')->unsigned();
            $table->boolean('isAdmin');
            $table->boolean('pending');


            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('group_user');
        Schema::drop('groups');

    }
}
