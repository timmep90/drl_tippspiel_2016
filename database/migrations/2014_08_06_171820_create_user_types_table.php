<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->smallInteger('value');

            $table->timestamps();
        });

        DB::table('user_types')->insert([
            ['name' => 'admin', 'value' => 255],
            ['name' => 'user', 'value' => 254],
            ['name' => 'guest', 'value' => 0]
        ]);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_types');
    }
}
