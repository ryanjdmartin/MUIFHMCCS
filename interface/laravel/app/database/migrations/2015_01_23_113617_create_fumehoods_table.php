<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFumehoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fume_hoods', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100)->unique();
            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')    
                ->references('id')->on('rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('model');
            $table->date('install_date');
            $table->date('maintenance_date');
			$table->text('notes');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fume_hoods');
	}

}
