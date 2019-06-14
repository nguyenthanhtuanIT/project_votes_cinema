<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateRandomsTable.
 */
class CreateRandomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('randoms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vote_id')->unsigned();
            $table->string('seats');
            $table->integer('viewers')->nullable();
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
        Schema::drop('randoms');
    }
}
