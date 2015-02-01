<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notification_settings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->boolean('critical');
            $table->boolean('alert');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')    
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')    
                ->references('id')->on('rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
		Schema::drop('notification_settings');
	}

}
