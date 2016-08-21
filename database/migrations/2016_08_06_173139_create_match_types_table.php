<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('shortcut');
            $table->integer('year');

            $table->timestamps();
        });

        DB::table('match_types')->insert([
            ['name' => '1. Bundesliga', 'shortcut' => 'bl1'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match_types');

    }
}
