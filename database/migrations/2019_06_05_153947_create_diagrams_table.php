<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateDiagramsTable.
 */
class CreateDiagramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagrams', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->string('row_of_seats');
            $table->Integer('amount_chairs_of_row');
            $table->string('chairs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('diagrams');
    }
}
