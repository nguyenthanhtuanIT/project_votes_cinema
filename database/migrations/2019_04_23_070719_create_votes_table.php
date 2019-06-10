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
            $table->string('list_films');
            $table->string('background');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('status_vote');
            $table->integer('room_id')->default(0);
            $table->string('detail');
            $table->date('time_voting');
            $table->date('time_registing');
            $table->date('time_booking_chair');
            $table->date('time_end');
            $table->Integer('total_ticket')->default(0);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::drop('votes');
    }
}
