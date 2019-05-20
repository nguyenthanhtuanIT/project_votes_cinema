<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateChairsTable.
 */
class CreateChairsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('chairs', function (Blueprint $table) {
			$table->increments('id');
			$table->string('code_chair');
			$table->integer('vote_id')->unsigned();
			$table->foreign('vote_id')->references('id')->on('votes');
			$table->string('row_of_seats');
			$table->integer('number_start');
			$table->integer('number_end');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('chairs');
	}
}
