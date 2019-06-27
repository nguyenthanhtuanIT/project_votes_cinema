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
            $table->foreign('vote_id')->references('id')->on('votes')->onDelete('cascade');
            $table->string('seats');
            $table->string('viewers')->nullable();
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
