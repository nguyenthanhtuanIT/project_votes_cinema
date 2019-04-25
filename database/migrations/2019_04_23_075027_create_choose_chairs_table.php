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
			$table->integer('user_vote')->unsigned();
			$table->integer('id_vote')->unsigned();
			$table->integer('id_chair')->unsigned();
			$table->foreign('user_vote')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('id_vote')->references('id')->on('votes')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('id_chair')->references('id')->on('chairs')->onUpdate('cascade')->onDelete('cascade');

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
