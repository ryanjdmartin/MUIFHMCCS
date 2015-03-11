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
            $table->enum('status', array('new', 'acknowledged', 'resolved'))->default('new');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')    
                ->references('id')->on('users');
            $table->dateTime('updated_time');
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
