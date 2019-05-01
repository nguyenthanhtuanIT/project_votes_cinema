<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateVoteDetailsTable.
 */
class CreateVoteDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('vote_details', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('id_user')->unsigned();
			$table->foreign('id_user')->references('id')->on('users');
			$table->integer('id_film')->unsigned();
			$table->foreign('id_film')->references('id')->on('films');
			$table->integer('id_vote')->unsigned();
			$table->foreign('id_vote')->references('id')->on('votes');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('vote_details');
	}
}
