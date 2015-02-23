<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('fume_hood_name', 100);
            $table->foreign('fume_hood_name')    
                ->references('name')->on('fume_hoods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('class', array('alert', 'critical'));
            $table->dateTime('measurement_time');
            $table->string('type', 100);
            $table->string('status', 10)->default('new');
            $table->text('note');
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
		Schema::drop('notifications');
	}

}
