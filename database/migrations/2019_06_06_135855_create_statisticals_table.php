<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateStatisticalsTable.
 */
class CreateStatisticalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statisticals', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('vote_id')->unsigned();
            $table->foreign('vote_id')->references('id')->on('votes')->onDelete('cascade');
            $table->Integer('films_id')->unsigned();
            $table->foreign('films_id')->references('id')->on('films')->onDelete('cascade');
            $table->Integer('amount_votes')->default(0);
            $table->integer('movie_selected')->default(0);
            $table->Integer('amount_registers')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statisticals');
    }
}
