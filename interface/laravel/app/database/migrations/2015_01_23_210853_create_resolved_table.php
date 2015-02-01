<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolvedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resolved_notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->foreign('user_id')    
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
			$table->integer('notification_id')->unsigned();
            $table->foreign('notification_id')    
                ->references('id')->on('notifications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('resolved_time');
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
		Schema::drop('resolved_notifications');
	}

}
