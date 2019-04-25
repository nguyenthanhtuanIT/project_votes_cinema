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
			$table->integer('user_vote')->unsigned();
			$table->integer('id_vote')->unsigned();
			$table->integer('id_films')->unsigned();
			$table->foreign('id_vote')->references('id')->on('votes')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('user_vote')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('id_films')->references('id')->on('films')->onUpdate('cascade')->onDelete('cascade');
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
