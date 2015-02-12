<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->float('critical_max_velocity')->default(110);
			$table->float('critical_min_velocity')->default(10);
			$table->float('alert_max_velocity')->default(100);
			$table->float('alert_min_velocity')->default(20);
			$table->float('critical_resend_hours')->default(24);
			$table->float('alert_resend_hours')->default(6);
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
		Schema::drop('system_settings');
	}

}
