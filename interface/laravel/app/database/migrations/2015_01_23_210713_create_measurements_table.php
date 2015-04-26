<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('measurements', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('fume_hood_name', 100);
            $table->foreign('fume_hood_name')    
                ->references('name')->on('fume_hoods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('sash_up');
            $table->float('velocity');
            $table->dateTime('measurement_time');
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
		Schema::drop('measurements');
	}

}
