<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateChooseChairsTable.
 */
class CreateChooseChairsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('choose_chairs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('vote_id')->unsigned();
			$table->integer('chair_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('vote_id')->references('id')->on('votes');
			$table->foreign('chair_id')->references('id')->on('chairs');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('choose_chairs');
	}
}
