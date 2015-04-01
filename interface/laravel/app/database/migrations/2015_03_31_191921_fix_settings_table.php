<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('system_settings', function($table)
        {
            $table->dropColumn('critical_resend_hours');
            $table->dropColumn('alert_resend_hours');
        });
		Schema::table('system_settings', function($table)
        {
			$table->float('critical_resend_hours')->default(8);
			$table->float('alert_resend_hours')->default(24);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('system_settings', function($table)
        {
            $table->dropColumn('critical_resend_hours');
            $table->dropColumn('alert_resend_hours');
        });
		Schema::table('system_settings', function($table)
        {
			$table->float('critical_resend_hours')->default(24);
			$table->float('alert_resend_hours')->default(6);
        });
	}

}
