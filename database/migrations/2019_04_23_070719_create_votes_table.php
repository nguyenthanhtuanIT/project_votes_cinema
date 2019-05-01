<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateVotesTable.
 */
class CreateVotesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('votes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name_vote');
			$table->integer('id_user')->unsigned();
			$table->foreign('id_user')->references('id')->on('users');
			$table->integer('status_vote');
			$table->string('detail');
			$table->date('dead_line');
			$table->timestamps();
		});
	}
	public function down() {
		Schema::drop('votes');
	}
}
