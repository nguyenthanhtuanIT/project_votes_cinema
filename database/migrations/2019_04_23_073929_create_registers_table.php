<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateRegistersTable.
 */
class CreateRegistersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('registers', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name_register');
			$table->integer('user_id')->unsigned();
			$table->integer('vote_id')->unsigned();
			$table->integer('film_id')->unsigned();
			$table->foreign('vote_id')->references('id')->on('votes');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('film_id')->references('id')->on('films');
			$table->integer('ticket_number');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('registers');
	}
}
