<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBlogsTable.
 */
class CreateBlogsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('blogs', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name_blog');
			$table->string('img_blog');
			$table->string('detail');
			$table->integer('type_blog');
			$table->integer('id_user')->unsigned();
			$table->foreign('id_user')->references('id')->on('users');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('blogs');
	}
}
