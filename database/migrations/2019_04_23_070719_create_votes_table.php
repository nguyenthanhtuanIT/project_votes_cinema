<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateVotesTable.
 */
class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_vote');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('status_vote');
            $table->string('detail');
            $table->date('time_start_vote');
            $table->date('time_start_register');
            $table->date('time_end');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::drop('votes');
    }
}
